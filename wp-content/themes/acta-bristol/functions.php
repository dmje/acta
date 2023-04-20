<?php

include('includes/functions-whatson.php');


// Add style.css, checking for cache
function thirty8_enqueue_mainstylesheet(){

	$main_css_ver = date("ymd-Gis", filemtime( get_stylesheet_directory() .'/css/style.css' ));
    wp_enqueue_style( 'thirty8-style', get_stylesheet_directory_uri() . '/css/style.css',false, $main_css_ver );

}

add_action( 'wp_enqueue_scripts', 'thirty8_enqueue_mainstylesheet' );




?>