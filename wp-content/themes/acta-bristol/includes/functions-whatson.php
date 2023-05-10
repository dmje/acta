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
	}

	$datetime_html =
		'<div class="acta-whatson-times"><h3>' . $datetime_html . '</h3></div>';

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

?>
