<?php


function get_sugarcalmeta($post_id){
	
	$sc_array = array();
	
	$sc_array['sc_event_day'] = get_post_meta($post_id, 'sc_event_day', true );
	$sc_array['sc_event_month'] = get_post_meta($post_id, 'sc_event_month', true );
	$sc_array['sc_event_year'] = get_post_meta($post_id, 'sc_event_year', true );
	$sc_array['sc_event_time_hour'] = get_post_meta($post_id, 'sc_event_time_hour', true );
	$sc_array['sc_event_time_minute'] = get_post_meta($post_id, 'sc_event_time_minute', true );
	$sc_array['sc_event_time_am_pm'] = get_post_meta($post_id, 'sc_event_time_am_pm', true );
	$sc_array['sc_event_day_of_week'] = get_post_meta($post_id, 'sc_event_day_of_week', true );
	$sc_array['sc_event_day_of_month'] = get_post_meta($post_id, 'sc_event_day_of_month', true );
	$sc_array['sc_event_day_of_year'] = get_post_meta($post_id, 'sc_event_day_of_year', true );
	$sc_array['sc_event_end_date'] = get_post_meta($post_id, 'sc_event_end_date', true );
	$sc_array['sc_event_end_date_time'] = get_post_meta($post_id, 'sc_event_end_date_time', true );
	$sc_array['sc_event_end_day'] = get_post_meta($post_id, 'sc_event_end_day', true );
	$sc_array['sc_event_end_month'] = get_post_meta($post_id, 'sc_event_end_month', true );
	$sc_array['sc_event_end_year'] = get_post_meta($post_id, 'sc_event_end_year', true );
	$sc_array['sc_event_end_time_hour'] = get_post_meta($post_id, 'sc_event_end_time_hour', true );
	$sc_array['sc_event_end_time_minute'] = get_post_meta($post_id, 'sc_event_end_time_minute', true );
	$sc_array['sc_event_end_time_am_pm'] = get_post_meta($post_id, 'sc_event_end_time_am_pm', true );
	$sc_array['sc_event_end_day_of_week'] = get_post_meta($post_id, 'sc_event_end_day_of_week', true );
	$sc_array['sc_event_end_day_of_month'] = get_post_meta($post_id, 'sc_event_end_day_of_month', true );
	$sc_array['sc_event_end_day_of_year'] = get_post_meta($post_id, 'sc_event_end_day_of_year', true );
	$sc_array['sc_event_recurring'] = get_post_meta($post_id, 'sc_event_recurring', true );
	$sc_array['sc_recur_until'] = get_post_meta($post_id, 'sc_recur_until', true );
	$sc_array['sc_all_recurring'] = get_post_meta($post_id, 'sc_all_recurring', true );
	
	return $sc_array;
	
	
}


?>