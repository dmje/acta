<h2>Calendar</h2>


<?php

$root_path = plugin_dir_url(__FILE__);

$css_root = $root_path . 'fullcalendar/css/main.css';
$js_root = $root_path . 'fullcalendar/js/main.js';


function get_events_json(){
	
	//return '[{"id":"01","title":"Book","start":"2021-04-06","url":"?thing=true"}]';
	
	$event_array = array();	
	$count = 0;	
	
	/*
	$meta_query = array(
		array(
			'key' => 'event_date',
			'value' => date('Ymd'),
			'type' => 'DATE',
			'compare' => '>='
		)
	);
	*/
	
	// 17/05/2023 or yymmdd	
							
	$custom_query_args=array(
	   'post_type'=>'sc_event',
	   'posts_per_page' => -1,
	   //'meta_query' => $meta_query,
	);							

	$custom_query = new WP_Query( $custom_query_args );

	if ($custom_query->have_posts()) : 
								
		while ( $custom_query->have_posts() ) : $custom_query->the_post();
					
			//$tidy_date = DateTime::createFromFormat('Ymd', $start_date);
			//$tidy_date = $tidy_date->format('Y-m-d');
					
			$event_id = get_the_ID();
					
			$sugarcal_meta = get_sugarcalmeta($event_id);
			
			/*
			echo '<pre>';
			print_r($sugarcal_meta);
			echo '</pre>';
			*/
			
			/* EXAMPLE 
			
				Array
				(
    				[sc_event_day] => Sun
    				[sc_event_month] => 04
    				[sc_event_year] => 2023
    				[sc_event_time_hour] => 12
    				[sc_event_time_minute] => 00
    				[sc_event_time_am_pm] => am
    				[sc_event_day_of_week] => 0
    				[sc_event_day_of_month] => 23
    				[sc_event_day_of_year] => 112
    				[sc_event_end_date] => 1682294399
    				[sc_event_end_date_time] => 1682294399
    				[sc_event_end_day] => Sun
    				[sc_event_end_month] => 04
    				[sc_event_end_year] => 2023
    				[sc_event_end_time_hour] => 11
    				[sc_event_end_time_minute] => 59
    				[sc_event_end_time_am_pm] => pm
    				[sc_event_end_day_of_week] => 0
    				[sc_event_end_day_of_month] => 23
    				[sc_event_end_day_of_year] => 112
    				[sc_event_recurring] => 
    				[sc_recur_until] => 
    				[sc_all_recurring] => 
				)			

			*/
						
			$start_date = $sugarcal_meta['sc_event_year'] . '-' . $sugarcal_meta['sc_event_month'] . '-' . $sugarcal_meta['sc_event_day_of_month'];
			
			$temp = DateTime::createFromFormat('Y-m-d', $start_date);
			
			$temp = $temp->format('Y-m-d');
			
			//$temp = strtotime("+7 day", $temp);
			
			if($sugarcal_meta['sc_event_recurring']){
				
				switch($sugarcal_meta['sc_event_recurring']){
					
					case 'daily':
						
					break;
					
					case 'weekly':

						//echo 'TEMP = ' . $temp . '<br/>';			
						//echo 'PLus a week = ' . date( "Y-m-d", strtotime( "$temp +7 day" ) );

						// this is how to do this but fuuuu it's gunna get gnarly....
						
						
					break;
					
					case 'monthly':
						
					break;
					
					case 'yearly':
						
						
					break;
					
					
					
				}
				
				
				
				if($sugarcal_meta['sc_recur_until'] == ''){
					
					
					
					
					
				}
				
				
				
			}
			
			
			$booking_link = get_the_permalink();
							
			$event_title = get_the_title();
			
						
				$event_array[$count]['id'] = $event_id;
				$event_array[$count]['title'] = $event_title;
				$event_array[$count]['start'] = $start_date;
				
				//$event_array[$count]['end'] = '2023-04-24';
	
				$count++;
								
		endwhile;
						
						
	endif;	
	
	return json_encode($event_array);	
	
}

?>




<link href='<?php echo $css_root;?>' rel='stylesheet' />
<script src='<?php echo $js_root;?>'></script>

<style>

#calendar{
	margin-top:20px;
	margin-bottom:40px;
}

.fc-daygrid-event{
	background-color:#F7CC8F;
	border:#F7CC8F;
	text-align:center;				
}

.fc-event-title{
	color:#002344;
}


</style>


<?php 

echo '<pre>';
print_r(get_events_json());
echo '</pre>';

?>

<div id="calendar"></div>


<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
	  events: <?php echo get_events_json();?>,
    });
    calendar.render();
  });

</script>



