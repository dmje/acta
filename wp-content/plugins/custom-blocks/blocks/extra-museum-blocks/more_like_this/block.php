<?php
/*
Active: true
UUID: more-like-this-selector
Title: More like this selector
Description: Display item(s) similar to an item
Keywords: more like this, elasticsearch, suggestions, recommended
Version: 1.0
Post Types: page, post
Allow Multiple: true
*/

//group_5eda46c87f65a
$es_objects = new \ESObjects\ESObjects();
$mediaPath = get_option('es_media_host');
$iiifPath = get_option('es_iiif_host');
$uniqid = uniqid();	//this will ensure that any element gets a unique ID on the page so that we don't get clashes when they are initiated
$thisuuid = get_field('linked_object');
$max_results = get_field('max_results');
$heading = get_field('heading');
$blurb = get_field('blurb');
$post_blurb = get_field('post_blurb');
$display = get_field('display');

//$display_style = get_field('display_style');
if(isset($thisuuid))
$it = $es_objects->get_results_for_single($thisuuid);
$thisdocid = $it['hits']['hits'][0]['_id'];
//var_dump($thisdocid);
//die;
if(null!==$thisdocid){
    $results = $es_objects->get_mlt_for_single($thisdocid,$max_results,0,'object');
    if($results){
        $objs = [];
        foreach($results['hits']['hits'] as $hit) 
        {	        
            $obj = new tmpObject($hit);
            array_push($objs,$obj);
        }
        switch ($display){
            case "slider":
                include('part_slider.php');
                break;
            case "panel":
                include('part_panel.php');
                break;
            default:
                include('part_slider.php');
                break;
            }
    }
}
?>