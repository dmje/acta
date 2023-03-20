<?php

// Make your plugin options pages here

if( function_exists('acf_add_options_page') ) {
	
	
	acf_add_options_page(array(
		'page_title' 	=> 'Content Helper',
		'menu_title'	=> 'Content Helper',
		'menu_slug' 	=> 'content-helper-settings',
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

// Hide ACF menu if you need

//add_filter('acf/settings/show_admin', '__return_false');



// Function to return the number of pages and posts on the site
// Amend the post_type array to get more post types

function CHContentCount(){

	$contentcount = array();
	
	$content_total = 0;
	$content_status_none = 0;
	$content_status_needsformatting = 0;
	$content_status_draft = 0;
	$content_status_complete = 0;
						
	$chr_query_args=array(
	   'post_type'=>array('page','post'),
	   'posts_per_page' => -1,
	   'order' => 'ASC',
	   'paged' => get_query_var('paged')
	);							

	$chr_query = new WP_Query( $chr_query_args );

	if ($chr_query->have_posts()) : 
						
		while ( $chr_query->have_posts() ) : $chr_query->the_post(); 

			$content_total++;
			$page_id = get_the_id();
			
			$page_status = get_field('content_status',$page_id);			
						
			if($page_status == 'none' || $page_status == '')
			{				
				$content_status_none ++;
			}
			
			if($page_status == 'needsformatting')
			{
				$content_status_needsformatting ++;
			}

			if($page_status == 'draft')
			{
				$content_status_draft ++;
			}

			if($page_status == 'complete')
			{
				$content_status_complete ++;
			}
										
		endwhile;
						
						
	endif; 
	
	$contentcount['total'] = $content_total;
	$contentcount['status_none'] = $content_status_none;
	$contentcount['status_needsformatting'] = $content_status_needsformatting;
	$contentcount['status_draft'] = $content_status_draft;
	$contentcount['status_complete'] = $content_status_complete;
	
	return $contentcount;
	
}

function CHContentArray($id=NULL){
	
	$contentcount = 0;
	$ch_status_array = array();
	
	if($id) // ID has been provided so just get the details for this post ID
	{						
		$chr_query_args=array(
		   'page_id' => $id,
		   'post_type'=>array('page','post'),
		   'posts_per_page' => -1,
		   'order' => 'ASC',
		   'orderby' => 'menu_order',
		   'paged' => get_query_var('paged')
		);							
	} else { // ID has not been provided, so get details for all posts
		$chr_query_args=array(
		   'post_type'=>array('page','post'),
		   'posts_per_page' => -1,
		   'order' => 'ASC',
		   'orderby' => 'menu_order',
		   'paged' => get_query_var('paged')
		);		
	}

	$chr_query = new WP_Query( $chr_query_args );

	if ($chr_query->have_posts()) : 
						
		while ( $chr_query->have_posts() ) : $chr_query->the_post(); 

			$contentcount++;
			$page_title = get_the_title();
			$page_id = get_the_id();
			$page_status = get_field('content_status',$page_id);
			$post_type = get_post_type($page_id);
			$content_notes = get_field('content_notes',$page_id);
			
			if(!$page_status)
			{
				$page_status = 'none';
			};
			
			// Assign to array
			
			$ch_status_array[$contentcount]['id'] = $page_id;
			$ch_status_array[$contentcount]['title'] = $page_title;
			$ch_status_array[$contentcount]['content_status'] = $page_status;
			$ch_status_array[$contentcount]['post_type'] = $post_type;
			$ch_status_array[$contentcount]['content_notes'] = $content_notes;
					
		endwhile;
						
						
	endif; 
	
	return $ch_status_array;
	
}


// Function to display colours and status text for provided status
function CHDisplayStatus($content_status){
	
	$display_icon = '&#9673;';
	$icon_colour = '#000000';
	$display_status = 'WANG';
	
	switch($content_status){
		
		case 'none':
		
			$icon_colour = '#E15759';
			$display_status = 'No content provided yet';
			
		break;

		case 'draft':
		
			$icon_colour = '#F28E2B';
			$display_status = 'Content is in draft form';
			
		break;

		case 'needsformatting':
		
			$icon_colour = '#4E79A7';
			$display_status = 'Content needs formatting';
			
		break;

		case 'complete':
		
			$icon_colour = '#76B7B2';
			$display_status = 'Content is complete';
			
		break;
		
	}
	
	return '<span style="color:' . $icon_colour . '">' . $display_icon . ' ' . $display_status . '</span>';
	
}


// Add front end div

function draftcontent_frontend_view(){
		
	include(CH_PATH . '/frontend/content_status.php');
	
}

add_action('wp_head', 'draftcontent_frontend_view');


?>