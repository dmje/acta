<?php
/*
Active: false
UUID: random-item
Title: Random item selector
Description: Show a random image from the collection, optionally limited to a subset
Keywords: comma,separated,list,of,keywords
Version: 1.0
Post Types: comma,separated,list,of,post types
Allow Multiple: true
*/

// group_637cde966ea09
// Include our contextual help thing

if(is_admin())
{	
	$this_block = basename(__FILE__, '.php'); 	
	include('_help.php');
}


global $es_objects;
global $iiifPath;
global $mediaPath;
$thisUmi = get_fields();

//get any query to narrow down our set to pick the random item from
//you could get it from some user-set field...
$query_url = (null!==get_field('random_item_search_url'))?get_field('random_item_search_url'):'';
//but I just hard-coded it here
//$query_url = 'http://maap.local/tmp/collections/?s=&filter[category.value.keyword][]=Landscapes+%26+Seascapes';
//then piss around with it to get parameters out
$parm = preg_split("/\?/",$query_url);
if(isset($parm[1])){
	parse_str($parm[1],$query_vars);
}elseif(isset($parm[0])){
	parse_str($parm[0],$query_vars);
}

//currently I'm not doing anything with a max_count field but we could use this to get back multiple randos in one call, if I can be arsed. But we can just call it multiple times instead
//get_field('max_count')<1?$max_count=0:(get_field('max_count')>1024?$max_count=1024:$max_count = get_field('max_count'));

//make sure s and filters are set
$q = isset($query_vars['s'])?$query_vars['s']:"";
$filter = isset($query_vars['filter'])?$es_objects->parse_filters($query_vars['filter']):[];

// pass them into get_random to get a random result for the query (or an empty query)
$esRaw = $es_objects->get_random(['q' => $q, 'from' => 0, 'size' => 1, 'filters' => $filter]);

//You can also just grab it without any search parameters, what the hell
//$esRaw = $es_objects->get_random(null);

//turn the result into a tmpObject
$obj = new tmpObject($esRaw['hits']['hits'][0]);

//in this case we're going to make this into a UMI

$arr = tmp_unifiedModelItem(null,$obj);
/*
 available fields:
 	$arr['item_title'];
	$arr['item_link'];
	$arr['item_link_text'];
	$arr['item_description'];
	$arr['date_parts'];
	$arr['date_display'];
	$arr['item_location'];
	$arr['image_alt'];
	$arr['image_src'];
	$arr['plain_text_date']
	$arr['group']
*/


if(!$arr['image_src'])
{
	$arr['image_src'] = plugin_dir_url( __DIR__ ) . '/img/block-featureditem_image.png';	
}

/* 
Now get the actual markup file 
At this point we could do logic for alternative display preferences 
*/
switch(get_field("random_item_display_options")){
	case "umi"	: 
		include('markup/unified-model-item.php');		
		break;
	case "plain" :
		include('markup/unified-model-item-plain.php');		
		break;
	default :
		include('markup/unified-model-item.php');		
}
?>