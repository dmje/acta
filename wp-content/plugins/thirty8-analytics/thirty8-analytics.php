<?php
// prevent direct access
if (!defined('ABSPATH')) {
	exit();
}

/**
 * Plugin Name: Thirty8 Analytics and cookie popup helper
 * Plugin URI: http://thirty8.co.uk
 * Description: Easy analytics and cookie popup
 * Version: 1.1
 * Author: Mike Ellis / Thirty8 Digital
 */

require 'lib/plugin-update-checker-5.0/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://licensing.thirty8.co.uk/license/thirty8-analytics',
	__FILE__, //Full path to the main plugin file or functions.php.
	'thirty8-analytics'
);

// Paths
define('THIRTY8_AH_PATH', plugin_dir_path(__FILE__));
define('THIRTY8_AH_URL', plugin_dir_url(__FILE__));

// Functions
include 'functions.php';

// Settings page

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init()
{
	// Check function exists.
	if (function_exists('acf_add_options_sub_page')) {
		// Add sub page.
		$child = acf_add_options_sub_page([
			'page_title' => __('Analytics Settings'),
			'menu_title' => __('Analytics'),
			'parent_slug' => 'options-general.php',
		]);
	}
}

// Display analytics, depending on cookies and whether user logged in or not

function thirty8_analytics_head()
{
	$display_analytics = '';

	if (isset($_COOKIE['thirty8_cookie_prefs'])) {
		// Thirty8 cookie preferences have been set and they don't like em

		if ($_COOKIE['thirty8_cookie_prefs'] == 'ok') {
			$display_analytics = true;
		}
		if ($_COOKIE['thirty8_cookie_prefs'] == 'notok') {
			$display_analytics = false;
		}
	}

	if ($display_analytics) {
		if (!is_user_logged_in()) {
			echo get_field('gtm_head', 'options');
		}
	}
}

add_action('wp_head', 'thirty8_analytics_head');

function thirty8_analytics_body()
{
	$display_analytics = '';

	if (isset($_COOKIE['thirty8_cookie_prefs'])) {
		// Thirty8 cookie preferences have been set and they don't like em

		if ($_COOKIE['thirty8_cookie_prefs'] == 'ok') {
			$display_analytics = true;
		}
		if ($_COOKIE['thirty8_cookie_prefs'] == 'notok') {
			$display_analytics = false;
		}
	}

	if ($display_analytics) {
		if (!is_user_logged_in()) {
			echo get_field('gtm_body', 'options');
		}
	}
}

add_action('wp_body_open', 'thirty8_analytics_body');

// Save acf locally
function thirty8_update_analytics_field_group($group)
{
	// list of field groups that should be saved to my-plugin/acf-json
	$groups = [
		//------------------- Global stuff --------------------------//
		'group_645a2fb6b667e', // Analytics settings
	];

	if (in_array($group['key'], $groups)) {
		add_filter('acf/settings/save_json', function () {
			return plugin_dir_path(__FILE__) . '/acf-json';
		});
	}
}
add_action(
	'acf/update_field_group',
	'thirty8_update_analytics_field_group',
	1,
	1
);

// Load - includes the /acf-json folder in this plugin to the places to look for ACF Local JSON files
add_filter('acf/settings/load_json', function ($paths) {
	$paths[] = plugin_dir_path(__FILE__) . '/acf-json';
	return $paths;
});

?>
