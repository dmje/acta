<?php
// Flexible shortcode
add_shortcode('include', 'thirty8_flexible_shortcode');
function thirty8_flexible_shortcode($atts, $content = null)
{
	$return_code = '';

	extract(
		shortcode_atts(
			[
				'id' => 0,
			],
			$atts
		)
	);

	$shortcode_rows = get_field('shortcodes', 'option');

	if ($shortcode_rows) {
		foreach ($shortcode_rows as $shortcode_row) {
			$thirty8_shortcode_id = $shortcode_row['shortcode_id'];
			$thirty8_shortcode_code = $shortcode_row['shortcode_code'];

			if ($id == $thirty8_shortcode_id) {
				$return_code = $thirty8_shortcode_code;
			}
		}

		if ($return_code) {
			return $return_code;
		} else {
			return '<p>ID NOT FOUND!</p>';
		}
	}
}

?>
