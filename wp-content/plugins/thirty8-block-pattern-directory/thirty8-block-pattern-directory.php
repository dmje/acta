<?php
// prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Name: Thirty8 Block Pattern Directory
 * Plugin URI: http://thirty8.co.uk
 * Description: Block Patterns in the WordPress GUI
 * Version: 0.2
 * Author: Mike Ellis / Thirty8 Digital
 */
 
require 'lib/plugin-update-checker-5.0/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://licensing.thirty8.co.uk/license/thirty8-block-pattern-directory',
	__FILE__, //Full path to the main plugin file or functions.php.
	'thirty8-block-pattern-directory'
);
 
 
// Paths
define( 'THIRTY8_BPD_PATH', plugin_dir_path( __FILE__ ) );
define( 'THIRTY8_BPD_URL', plugin_dir_url( __FILE__ ) );



// from https://support.advancedcustomfields.com/forums/topic/error-when-creating-new-post/
// this is used to include acf form head on the plugin settings page
add_action( 'init', 'thirty8_bpd_acf_form_head' );
function thirty8_bpd_acf_form_head(){
	// only load on admin
	if(is_admin()){
		acf_form_head();	
	}
	
}


// Include functions
include_once('includes/functions.php');

class Thirty8BPD
{

	public function __construct() 
	{
		// Settings page	
		//$this->add_settings_page();
						
	}
	
	public function add_settings_page() {
	
		add_action('admin_menu', 'reports_menu');
		
		function reports_menu() {
			add_submenu_page(
				'edit.php?post_type=thirty8blockpattern',
				__( 'Settings' ),
				__( 'Settings' ),
				'manage_options',
				'thirty8_bpd-settings',
				'get_settings_page'
			);
		}
		
		function get_settings_page(){
					
			include_once(THIRTY8_BPD_PATH . '/admin/settings.php');
		
		}
	
	}
		
		
	
	
}

new Thirty8BPD();




add_action('init', function() {
	remove_theme_support('core-block-patterns');
});

/**
 * Get an array of the names of all registered block patterns
 *
 * @return array $pattern_names
 */
function get_block_pattern_names_list() {
    $get_patterns  = WP_Block_Patterns_Registry::get_instance()->get_all_registered();
    $pattern_names = array_map(
        function ( array $pattern ) {
            return $pattern['name'];
        },
        $get_patterns
    );
    return $pattern_names;
}

function remove_all_core_block_patterns() {


    // Remove all Core Patterns
    $registered_patterns = get_block_pattern_names_list();
    foreach ( $registered_patterns as $pattern_name ) {
        // if the name starts with 'core' remove it
        if ( substr( $pattern_name, 0, strlen( 'core' ) ) === 'core' ) {
            unregister_block_pattern( $pattern_name );
        }
    }
}

add_action( 'init', 'remove_all_core_block_patterns' );


function create_block_patterns(){

	$custom_query_args=array(
	   'post_type'=>'thirty8blockpattern',
	   'posts_per_page' => -1,
	);							

	$custom_query = new WP_Query( $custom_query_args );
	
	global $post;

	if ($custom_query->have_posts()) : 
		
		while ( $custom_query->have_posts() ) : $custom_query->the_post();		

			// register block patterns in here
						
			$blockpattern_title = get_the_title();

			$blockpattern_contents = get_the_content();
			
			$blockpattern_slug = $post->post_name;			
			$blockpattern_description = get_field('description');
			
			$block_pattern_keywords = wp_get_post_terms( $post->ID, 'thirty8_bpkeyword', array( 'fields' => 'names' ) );
		
			register_block_pattern(
				$blockpattern_slug,
				array(
                	'title'         => __( $blockpattern_title, 'textdomain' ),
                	'description'   => _x( $blockpattern_description, 'Block pattern description', 'textdomain' ),
                	'content'       => $blockpattern_contents,
                	'categories'    => array(get_bloginfo('name')),
					'keywords'		=> $block_pattern_keywords,
                	'viewportWidth' => 800,
				)
			);		

		endwhile;

	endif;
	
	
}

add_action( 'init', 'create_block_patterns' );


// Set the block pattern category to be the site name - used above when registering block patterns
function wpdocs_block_pattern_category() {
		
	register_block_pattern_category( get_bloginfo('name'), array(
		'label' => __( get_bloginfo('name'), 'text-domain' )
	) );
}

add_action( 'init', 'wpdocs_block_pattern_category' );


// Save
function thirty8_update_bp_field_group($group) {
  // list of field groups that should be saved to my-plugin/acf-json
  $groups = array(
		//------------------- Global stuff --------------------------//
		'group_640b51e085194',			// Block Pattern options
  );

  if (in_array($group['key'], $groups)) {
	add_filter('acf/settings/save_json', function() {
	  return plugin_dir_path( __FILE__ ) . '/acf-json';
	});
  }
}
add_action('acf/update_field_group', 'thirty8_update_bp_field_group', 1, 1);

// Load - includes the /acf-json folder in this plugin to the places to look for ACF Local JSON files
add_filter('acf/settings/load_json', function($paths) {
  $paths[] = plugin_dir_path( __FILE__ ) . '/acf-json';
  return $paths;
});


?>