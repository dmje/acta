<?php

include 'includes/functions-whatson.php';

// Add style.css, checking for cache
function thirty8_enqueue_mainstylesheet()
{
	$main_css_ver = date(
		'ymd-Gis',
		filemtime(get_stylesheet_directory() . '/css/style.css')
	);
	wp_enqueue_style(
		'thirty8-style',
		get_stylesheet_directory_uri() . '/css/style.css',
		false,
		$main_css_ver
	);
}

add_action('wp_enqueue_scripts', 'thirty8_enqueue_mainstylesheet');

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
