<?php

// prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Name: Thirty8 GeneratePress Helper
 * Plugin URI: http://thirty8.co.uk
 * Description: Number of helper functions for working with GP child theme
 * Version: 0.6
 * Author: Mike Ellis / Thirty8 Digital
 */

require 'lib/plugin-update-checker-5.0/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://licensing.thirty8.co.uk/license/thirty8-generatepress-helper',
	__FILE__, //Full path to the main plugin file or functions.php.
	'thirty8-gp-helper'
);

// Include ACF
if (!class_exists('ACF')) {		
	// ACF not installed already
	//echo '<p>ACF PRO is required for the thirty8 gp helper plugin to work!</p>';	
}

// Paths
define( 'THIRTY8_GPHELPER_PATH', plugin_dir_path( __FILE__ ) );
define( 'THIRTY8_GPHELPER_URL', plugin_dir_url( __FILE__ ) );
define( 'THIRTY8_GPHELPER_SITESETTINGSURL', get_admin_url() . 'admin.php?page=site-settings');


// from https://support.advancedcustomfields.com/forums/topic/error-when-creating-new-post/
// this is used to include acf form head on the plugin settings page
add_action( 'init', 'thirty8_gp_helper_acf_form_head' );
function thirty8_gp_helper_acf_form_head(){
	// only load on admin
	if(is_admin()){
		acf_form_head();	
	}
	
}

// Include ACF fields - add more as needed

include_once('data/acf_plugin_general_settings.php');

// Include functions
include_once('includes/functions.php');

//add_filter('acf/settings/show_admin', '__return_false');

class Thirty8GPHelper
{

	public function __construct() 
	{
		// Build the settings pages
		add_action( 'admin_menu', array( $this, 'create_thirty8_gp_helper_settings_pages' ) );
						
	}
		
	
	//---------------------------------------
	//----- Stuff for plugin menu items -----
		
		public function create_thirty8_gp_helper_settings_pages() 
		{
	
			// Add the menu item and page
			$page_title = 'ThePageTitle';	// shown in page title field only 
			$menu_title = 'TheMenuTitle'; 	// visible in menu
			$capability = 'manage_options';
			$slug = 'thirty8-gp-helper';
			$callback = array( $this, 'thirty8_gp_helper_homepage' );
			$icon = 'dashicons-admin-plugins';
			$position = 100;
		
			// Main menu	
			//add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
			
			// Sub menus - add more as needed
			//add_submenu_page('thirty8-gp-helper', 'settings', 'Settings', 'manage_options', 'thirty8-gp-helper_settings_page','thirty8_gp_helper_settings_page');
			
			//add_submenu_page('theslug', 'thepagetitle', 'submenutitle', 'manage_options', 'subpage_name','subpage_name1');		
			//add_submenu_page('theslug', 'thepagetitle2', 'submenutitle2', 'manage_options', 'subpage_name2','subpage_name2');
	
			// Functions to include sub pages - add more as needed
			function thirty8_gp_helper_settings_page()
			{
				include('admin/settings.php');
			}
			
			/*
			// Additional Pages here
			
				function subpage_name1()
				{
					include('admin/page1.php');
				}
		
				function subpage_name2()
				{
					include('admin/page2.php');
				}
			*/
		
	
		}	
		
		public function thirty8_gp_helper_homepage()
		{		
			include('admin/index.php');
		}		
	
	//-------- End menu items ------------
	
		
	
}

new Thirty8GPHelper();




// Save
function thirty8_update_gp_field_group($group) {
  // list of field groups that should be saved to my-plugin/acf-json
  $groups = array(
		//------------------- Global stuff --------------------------//
		'group_63e7f425b969d',			// Site Settings - ACF options page
		'group_5e84c728864ab',			// Content Intro
		'group_5e220bbeecb8e',			// Sidebar Selection
		'group_54d9016a273fd',			// Sidebar Builder
		//------------------- Blocks --------------------------//
		'group_63e904296f264', 	  		// Test block
		'group_63e90b6fdaf05',			// Carousel
  );

  if (in_array($group['key'], $groups)) {
	add_filter('acf/settings/save_json', function() {
	  return plugin_dir_path( __FILE__ ) . '/acf-json';
	});
  }
}
add_action('acf/update_field_group', 'thirty8_update_gp_field_group', 1, 1);

// Load - includes the /acf-json folder in this plugin to the places to look for ACF Local JSON files
add_filter('acf/settings/load_json', function($paths) {
  $paths[] = plugin_dir_path( __FILE__ ) . '/acf-json';
  return $paths;
});




?>