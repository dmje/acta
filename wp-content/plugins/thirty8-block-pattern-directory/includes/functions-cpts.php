<?php

// Create Block Pattern CPT

add_action( 'init', 'create_thirty8_bp_cpt' );

	function create_thirty8_bp_cpt() 
	{

		register_post_type('thirty8blockpattern', array(
		'labels' => array(
			'name' => __( 'Block Patterns' ),
			'singular_name' => __( 'Block Pattern' ),
			'add_new' => __( 'Add New' ),
			'add_new_item' => __( 'Add New Block Pattern' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit Block Pattern' ),
			'new_item' => __( 'New Block Pattern' ),
			'view' => __( 'View Block Pattern' ),
			'view_item' => __( 'View Block Pattern' ),
			'search_items' => __( 'Search Block Patterns' ),
			'not_found' => __( 'No Block Patterns found' ),
			'not_found_in_trash' => __( 'No Block Patterns found in Trash' ),
		),
		'public' => false,
		'show_ui' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'menu_position' => 24,
		'menu_icon'   => 'dashicons-layout',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'sidebar', 'with_front' => false ),
		'supports' => array( 'title', 'editor'),	
		'show_in_rest' => true,
		'has_archive' => false
		) );	
		
	}
	

// Taxonomies

add_action( 'init', 'create_thirty8_bp_taxonomies', 0 );

	function create_thirty8_bp_taxonomies() 
	{
		
		// Block Pattern Keyword
	
		$labels = array(
			'name'                       => _x( 'Block Pattern Keyword', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Block Pattern Keyword', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Block Pattern Keywords', 'text_domain' ),
			'all_items'                  => __( 'All Block Pattern Keywords', 'text_domain' ),
			'parent_item'                => __( 'Parent Block Pattern Keyword', 'text_domain' ),
			'parent_item_colon'          => __( 'Parent Block Pattern Keyword:', 'text_domain' ),
			'new_item_name'              => __( 'New Block Pattern Keyword Name', 'text_domain' ),
			'add_new_item'               => __( 'Add Block Pattern Keyword', 'text_domain' ),
			'edit_item'                  => __( 'Edit Block Pattern Keyword', 'text_domain' ),
			'update_item'                => __( 'Update Block Pattern Keyword', 'text_domain' ),
			'view_item'                  => __( 'View Block Pattern Keyword', 'text_domain' ),
			'separate_items_with_commas' => __( 'Separate Block Pattern Keywords with commas', 'text_domain' ),
			'add_or_remove_items'        => __( 'Add or remove Block Pattern Keywords', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choose from the most used Block Pattern Keywords', 'text_domain' ),
			'popular_items'              => __( 'Popular Block Pattern Keywords', 'text_domain' ),
			'search_items'               => __( 'Search Block Pattern Keywords', 'text_domain' ),
			'not_found'                  => __( 'Not Found', 'text_domain' ),
			'no_terms'                   => __( 'No Block Pattern Keywords', 'text_domain' ),
			'items_list'                 => __( 'Block Pattern Keyword list', 'text_domain' ),
			'items_list_navigation'      => __( 'Block Pattern Keyword list navigation', 'text_domain' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'show_in_rest'				 => true,
			//'rewrite'                    => array( 'slug' => 'thirty8_bpcategory' ),
		);
		
		register_taxonomy( 'thirty8_bpkeyword', array( 'thirty8blockpattern'), $args );				
		
	}

?>