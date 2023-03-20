<?php

// Generic logging function
function thirty8log($msg){
	
	$myfile = fopen(THIRTY8_GPHELPER_PATH . "/log/log.htm", "a") or die("Unable to open log file!");
	fwrite($myfile, $msg . '<br/>');
	fclose($myfile);	
		
}

// Enqueues 
function thirty8_enqueue_gpstylesheets(){

	// Styles for blocks
	$thirty8_gpblocks_css_ver = date("ymd-Gis", filemtime( THIRTY8_GPHELPER_PATH .'/css/blocks.css' ));
    wp_enqueue_style( 'thirty8-gp-blocks', THIRTY8_GPHELPER_URL . '/css/blocks.css',false, $thirty8_gpblocks_css_ver );

}

add_action( 'wp_enqueue_scripts', 'thirty8_enqueue_gpstylesheets' );

// Include external scripts

function thirty8_gp_external_scripts() {
	
	// Swiper
		wp_register_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', '', true);
		wp_enqueue_script('swiper');	

	// UIKIT
		/*
		wp_register_script('uikit', 'https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit.min.js', '', true);
		wp_register_script('uikiticons', 'https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit-icons.min.js', '', true);
	
		wp_enqueue_script('uikit');
		wp_enqueue_script('uikiticons');
		*/
		
		

}
add_action( 'wp_enqueue_scripts', 'thirty8_gp_external_scripts' );

function thirty8_gp_external_styles(){
	
	// Swiper
		wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');		

	// UIKIT
		/*
		wp_enqueue_style('uikit', 'https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/css/uikit.min.css');
		*/

}
add_action('wp_enqueue_scripts','thirty8_gp_external_styles');


// Default Copyright message
add_filter( 'generate_copyright','thirty8_gp_custom_copyright' );
function thirty8_gp_custom_copyright() {
	
	$sitename = get_bloginfo('name');
	
	
    ?>
    <p>All content &copy; <?php echo date("Y") . ' ' . $sitename;?> | Website by <a target="_blank" href="https://thirty8.co.uk">Thirty8 Digital</a></p>
    <?php
}


// Function to amend CultureObject permalink
function thirty8_gp_cultureobject_permalink( $args, $post_type ) 
{

	// If not objects CPT, bail.
	if ( 'object' !== $post_type ) 
	{
		return $args;
	}
	
	// If no override specified, bail.
	if(!get_field('cultureobject_rewrite','option'))
	{
		return $args;
	} else {
		$cultureobject_rewrite = get_field('cultureobject_rewrite','option');
	}

	// Add additional CPT options.
	$object_args = array(
		//'has_archive' => true,
		//'supports'    => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
		'rewrite' => array('slug' => $cultureobject_rewrite),
	);

	// Merge args together.
	return array_merge( $args, $object_args );
}
add_filter( 'register_post_type_args', 'thirty8_gp_cultureobject_permalink', 10, 2 );

?>

