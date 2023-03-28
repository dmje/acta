<?php

// prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Plugin Name: Thirty8 Draft Content Helper
 * Plugin URI: http://thirty8.co.uk
 * Description: A plugin to help keep track of content migration
 * Version: 1.4.1
 * Author: Mike Ellis / Thirty8 Digital
 */


require 'lib/plugin-update-checker-5.0/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://licensing.thirty8.co.uk/license/thirty8-draft-content-helper',
	__FILE__, //Full path to the main plugin file or functions.php.
	'thirty8-draft-content'
);


// Include ACF
if (!class_exists('ACF')) {		
	// ACF not installed already
	require_once('lib/acf/acf.php');
}

// Include ACF fields - add more as needed
include_once('data/acf_plugin_general_settings.php');

add_action( 'acf/init', 'check_options' );

function check_options() {

	// Determine which ACF fields to use - depends on whether we're using Trello or not
	if(get_field('use_trello','option')){
	
		// we're using Trello to manage comments and stuff, so use the relevant ACF field set without these	
		include_once('data/acf_content_helper_trello.php');	
		
	} else {
		
		// it's "traditional mode" without Trello
		include_once('data/acf_content_helper.php');	
	}

}


// Root path
define( 'CH_PATH', plugin_dir_path( __FILE__ ) );

// Include functions
include_once('includes/functions.php');
//add_filter('acf/settings/show_admin', '__return_false');

// Include CSS for editor - should probably be in the main constructor maybe?
function thirty8_draft_content_styles()
{
	wp_enqueue_style( 'thirty8-draft-content', plugin_dir_url( __FILE__ ) . 'css/main.css' );	
}
add_action('enqueue_block_editor_assets', 'thirty8_draft_content_styles');

// Include the fucking javascript for the fucking popup 
function thirty8_draft_content_scripts()
{
	wp_enqueue_script( "js", plugin_dir_url( __FILE__ ) . 'js/globaljs.js');
}
add_action('wp_enqueue_scripts', 'thirty8_draft_content_scripts');


class Thirty8DraftContent
{

	public function __construct() 
	{
		// Build the settings pages
		add_action( 'admin_menu', array( $this, 'create_thirty8_draft_content_settings_pages' ) );
						
	}
		
	
	//---------------------------------------
	//----- Stuff for plugin menu items -----
		
		public function create_thirty8_draft_content_settings_pages() 
		{
	
			// Add the menu item and page
			$page_title = 'ContentHelper';	// shown in page title field only 
			$menu_title = 'Content Report'; 	// visible in menu
			$capability = 'manage_options';
			$slug = 'thirty8-draft-content';
			$callback = array( $this, 'thirty8_draft_content_homepage' );
			$icon = 'dashicons-welcome-write-blog';
			$position = 100;
		
			// Main menu	
			add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
			
			// Sub menus - add more as needed
			//add_submenu_page('thirty8-draft-content', 'settings', 'Settings', 'manage_options', 'thirty8-draft-content_settings_page','thirty8_draft_content_settings_page');
			
			//add_submenu_page('theslug', 'thepagetitle', 'submenutitle', 'manage_options', 'subpage_name','subpage_name1');		
			//add_submenu_page('theslug', 'thepagetitle2', 'submenutitle2', 'manage_options', 'subpage_name2','subpage_name2');
	
			// Functions to include sub pages - add more as needed
			function thirty8_draft_content_settings_page()
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
		
		public function thirty8_draft_content_homepage()
		{		
			include('admin/index.php');
		}		
	
	//-------- End menu items ------------
	
		
	
}

new Thirty8DraftContent();
?>