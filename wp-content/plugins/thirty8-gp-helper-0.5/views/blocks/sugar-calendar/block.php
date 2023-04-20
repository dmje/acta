<?php


if(in_array('sugar-calendar/sugar-calendar.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
	
	// Sugarcalendar is active
	
	$display_type = get_field('display_type');
	
	
	if($display_type == 'list'){
	
		// We're displaying a list
		// See https://docs.sugarcalendar.com/article/196-displaying-event-lists
			
		?>
	
		<style>
		
		.sc_event_title{
			margin-right: 10px;
		}
		
		.sc_event_date{
			margin-right: 10px;
		}	
		
		.sc_event_time{
			margin-right: 10px;
		}	
			
		</style>
		
		
		<?php
	
		$show_date = get_field('show_date');
		$show_time = get_field('show_time');
		// display all, seems most likely
		$number_events = 1000;
		
		$selected_category = get_field('selected_category');
	
		//$selected_category = 'dance-club';
		//$selected_category = 'roxwell-parish-council';
	
		$shortcode = "[sc_events_list show_date='" . $show_date . "' show_time='" . $show_time . "' number='" . $number_events . "' category='" . $selected_category . "']";
		
		// Output it
	
		echo '<div class="thirty8_sugarcalendar">';
			echo do_shortcode($shortcode);
		echo '</div>';
	
	
	} else {
		
		// We're displaying a calendar
		// See https://docs.sugarcalendar.com/article/194-displaying-the-calendar
		
		// Output it
		
		// This should accept parameters but they just simply don't work...
		// $size = 'large'
		// $category = 'id or slug'
		// $type = 'month week 2week'
		// none of these make any difference whatsoever...
		
		
		echo '<div class="thirty8_sugarcalendar">';
			sc_enqueue_scripts();
			sc_enqueue_styles();	
			echo sc_get_events_calendar();
		echo '</div>';
	
		
	}
	
	
} else {
	
	
	echo '<p>Whoops! SugarCalendar needs to be installed and active!</p>';
	
}

?>