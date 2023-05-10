<?php

function acta_whatson_times($postid)
{
	$datetime_html = '';

	$date_format_in = 'd/m/Y';
	$date_format_out = 'jS F Y';

	$pretty_start_date = '';
	$pretty_end_date = '';

	// Start dates
	$start_date = get_field('start_date', $postid);
	if ($start_date) {
		$pretty_start_date = DateTime::createFromFormat(
			$date_format_in,
			$start_date
		);
		$pretty_start_date = $pretty_start_date->format($date_format_out);
	}

	// End dates
	$end_date = get_field('end_date', $postid);
	if ($end_date) {
		$pretty_end_date = DateTime::createFromFormat($date_format_in, $end_date);
		$pretty_end_date = $pretty_end_date->format($date_format_out);
	}

	if ($start_date == $end_date) {
		$datetime_html = $pretty_start_date;
	} else {
		$datetime_html = $pretty_start_date . ' to ' . $pretty_end_date;
	}

	$datetime_html =
		'<div class="acta-whatson-times"><h4>' . $datetime_html . '</h4></div>';

	return $datetime_html;
}

function acta_booking_link($postid)
{
	$bookinglink_html = '';

	// Returns the link to book this event

	$lboid = get_field('little_box_office_id', $postid);

	if ($lboid) {
		// also need to check if date still current

		$lbo_url = 'https://thelittleboxoffice.com/acta/book/event/' . $lboid;

		$bookinglink_html = '<div class="booknow-button-wrapper">';
		$bookinglink_html .= '<button class="booknow-button">';
		$bookinglink_html .=
			'<a target="_blank" href="' . $lbo_url . '">Book now</a>';
		$bookinglink_html .= '</button>';
		$bookinglink_html .= '</div>';
	}

	return $bookinglink_html;
}

// Remove 'archive' from whatson listing title
// per https://generatepress.com/forums/topic/remove-prefix-before-title-on-cpt-archive-pages/#post-1438578

add_filter('get_the_archive_title', function ($title) {
	/*
	if (is_tax()) {
		$title = single_term_title('', false);
	}
	*/

	if (is_post_type_archive('acta_whatson')) {
		$title = 'Productions';
	}

	return $title;
});

?>
