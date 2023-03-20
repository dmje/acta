<?php

// Create sidebar CPT

add_action( 'init', 'create_thirty8_sidebar_cpt' );

	function create_thirty8_sidebar_cpt() 
	{

		register_post_type('sidebar', array(
		'labels' => array(
			'name' => __( 'Sidebars' ),
			'singular_name' => __( 'Sidebar' ),
			'add_new' => __( 'Add New' ),
			'add_new_item' => __( 'Add New Sidebar' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit Sidebar' ),
			'new_item' => __( 'New Sidebar' ),
			'view' => __( 'View Sidebar' ),
			'view_item' => __( 'View Sidebar' ),
			'search_items' => __( 'Search Sidebars' ),
			'not_found' => __( 'No Sidebars found' ),
			'not_found_in_trash' => __( 'No Sidebars found in Trash' ),
		),
		'public' => false,
		'show_ui' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'menu_position' => 24,
		'menu_icon'   => 'dashicons-layout',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'sidebar', 'with_front' => false ),
		'supports' => array( 'title', 'editor', 'thumbnail' ),	
		'has_archive' => false
		) );	
		
	}
	

?>