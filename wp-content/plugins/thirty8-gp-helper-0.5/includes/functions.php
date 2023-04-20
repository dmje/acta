<?php

// Misc
include('functions-misc.php');

// Widgets
include('functions-widgets.php');

// CPTs
include('functions-cpts.php');

// Shortcodes
include('functions-shortcodes.php');

// Blocks
include('functions-blocks.php');

// Tests
//include('functions-tests.php');

// Sugar Calendar
include('functions-sugarcalendar.php');

// Make your plugin options pages here

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Site Settings',
		'menu_title'	=> 'Site Settings',
		'menu_slug' 	=> 'site-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	/*
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Plugin Other Settings',
		'menu_title'	=> 'Plugin Other Settings',
		'parent_slug'	=> 'plugin-general-settings',
	));
	
	*/
	
	// Add more sub pages as needed
	
}
?>