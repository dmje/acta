<?php


function acta_whatson_times($postid){
	
	$datetime_html = '';
	
	$start_date = get_field('start_date',$postid);
	$start_date = date("jS F Y", strtotime($start_date));
	
	$end_date = get_field('end_date',$postid);
	$end_date = date("jS F Y", strtotime($end_date));
	
	if($start_date && $end_date){
		$datetime_html = $start_date . ' to ' . $end_date;
	}
	
	if($start_date){
		$datetime_html = $start_date;
	}
	
	
	
	
	$datetime_html = '<div class="acta-whatson-times"><h3>' . $datetime_html . '</h3></div>';
	
	
	return $datetime_html;
	
}


?>