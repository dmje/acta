<?php

$timeline_title = get_field('title');
$timeline_headline = get_field('headline');
$timeline_introductory_text = get_field('introductory_text');

$media = get_field('media');

if($media){
	$media_url = $media['url'];
	$media_caption = $media['caption'];
	$media_credit = '';
}


// Create the timeline meta information
$json = array(
    "title" => array(
        "media" => array(
            "url" => $media_url,
            "caption" => $media_caption,
            "credit" => $media_credit
        ),
        "text" => array(
            "headline" => $timeline_headline,
            "text" => $timeline_introductory_text,
        )
    ),
    "events" => array()
);

// Add elements to the "events" array from the repeater

$rows = get_field('events');

if($rows)
{

    foreach($rows as $row)
    {
		
		// Image
		$event_media = $row['event_media'];
		if($event_media){
			$event_media_url = $event_media['url'];
			$event_media_caption = $event_media['caption'];	
			$event_media_credit = '';
		}
		
		// Text
		$event_headline = $row['event_headline'];
		$event_description = $row['event_description'];
		
		// Date
		$event_day = $row['day'];
		$event_month = $row['month'];
		$event_year = $row['year'];
		
		
    	$event = array(
        	"media" => array(
            	"url" => $event_media_url,
            	"caption" => $event_media_caption,
            	"credit" => $event_media_credit
        	),
        	"start_date" => array(
            	"month" => $event_month,
            	"day" => $event_day,
            	"year" => $event_year
        	),
        	"text" => array(
            	"headline" => $event_headline,
            	"text" => $event_description
        	)
    	);
    	array_push($json["events"], $event);		                                          
    }

}    

// Encode the JSON object as a string
$json_string = json_encode($json);


// Create a unique filename for this timeline
$page_id = get_the_id();

$temp = sanitize_title($timeline_title);

// Generated...
$timeline_name = $page_id . '_' . $temp;

$timeline_filename = $timeline_name . '.json';
$timeline_cache_fullpath = dirname(__FILE__) . '/cache/' . $timeline_filename;

// URL if in plugin 
$timeline_cache_url = plugin_dir_url(__FILE__) . '/cache/' . $timeline_filename;
// if in theme --> $timeline_cache_url = get_template_directory_uri() . '/modules/cache/' . $timeline_filename;


$file_modified_time = filemtime($timeline_cache_fullpath);
$page_modified_time = get_post_modified_time('U', false, get_the_ID(), true);

// Create the cache file if it doesn't exist
if(!file_exists($timeline_cache_fullpath)){
	// Cache the json
	$myfile = fopen($timeline_cache_fullpath, "w") or die("Unable to open file!");
	$txt = $json_string;
	fwrite($myfile, $txt);
	fclose($myfile);
}


// Compare the two modified times

if($page_modified_time != $file_modified_time){

	// Write to cache if the page modified time and file modified time are different
	
	// Cache the json
	$myfile = fopen($timeline_cache_fullpath, "w") or die("Unable to open file!");
	$txt = $json_string;
	fwrite($myfile, $txt);
	fclose($myfile);
	
}



?>


<section class="timeline">
			
	<h2><?php echo $timeline_title;?></h2>		
	<div id='timeline-embed' style="width: 100%; height: 600px"></div>
		
</section>

<script type="text/javascript">
    // The TL.Timeline constructor takes at least two arguments:
    // the id of the Timeline container (no '#'), and
    // the URL to your JSON data file or Google spreadsheet.
    // the id must refer to an element "above" this code,
    // and the element must have CSS styling to give it width and height
    // optionally, a third argument with configuration options can be passed.
    // See below for more about options.
    timeline = new TL.Timeline('timeline-embed','<?php echo $timeline_cache_url;?>');
</script>