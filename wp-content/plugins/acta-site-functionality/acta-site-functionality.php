<?php
/*
Plugin Name: ACTA Functionality
Plugin URI: https://thirty8.co.uk
Description: Site specific functionality for ACTA Bristol
Version: 0.1
Author: Mike Ellis
Author URI: https://thirty8.co.uk
*/

// Prevent direct access
if( ! defined( 'ABSPATH' ) ) exit;

// Custom Post Types 

function acta_create_post_types() {	

	register_post_type('acta_whatson', array(
	'labels' => array(
		'name' => __( 'What\'s on' ),
		'singular_name' => __( 'What\'s on' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add New What\'s on' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit What\'s on' ),
		'new_item' => __( 'New What\'s on' ),
		'view' => __( 'View What\'s on' ),
		'view_item' => __( 'View What\'s on' ),
		'search_items' => __( 'Search What\'s on' ),
		'not_found' => __( 'Nothing found' ),
		'not_found_in_trash' => __( 'Nothing found in Trash' ),
	),
	'public' => true,
	'show_ui' => true,
	'publicly_queryable' => true,
	'exclude_from_search' => false,
	'menu_position' => 22,
	'menu_icon'   => 'dashicons-text-page',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'whats-on', 'with_front' => false ),
	'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),	
	'show_in_rest' => true,
 	'has_archive' => true
	) );
	
}
	
add_action( 'init', 'acta_create_post_types' );	

// ACF save and load
// Save
function origin_update_gp_field_group($group) {
  // list of field groups that should be saved to my-plugin/acf-json
  $groups = array(
		//------------------- Global stuff --------------------------//
		'group_6418684092743',			// What's on fields		
  );

  if (in_array($group['key'], $groups)) {
	add_filter('acf/settings/save_json', function() {
	  return plugin_dir_path( __FILE__ ) . '/acf-json';
	});
  }
}
add_action('acf/update_field_group', 'origin_update_gp_field_group', 1, 1);

// Load - includes the /acf-json folder in this plugin to the places to look for ACF Local JSON files
add_filter('acf/settings/load_json', function($paths) {
  $paths[] = plugin_dir_path( __FILE__ ) . '/acf-json';
  return $paths;
});

?>
