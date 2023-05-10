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

/* make gravity forms available to Editor role */
// Per https://community.gravityforms.com/t/best-way-to-allow-the-editors-role-or-other-role-to-access-edit-create-etc-forms/11456

function add_gf_cap()
{
	$role = get_role('editor');
	$role->add_cap('gform_full_access');
}
add_action('admin_init', 'add_gf_cap');

?>
