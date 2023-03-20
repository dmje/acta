<?php

// Register blocks

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
	register_block_type( THIRTY8_GPHELPER_PATH . '/views/blocks/test' );	
	register_block_type( THIRTY8_GPHELPER_PATH . '/views/blocks/carousel' );	
}


// Load all our blocks and use a subset of these to populate Site Settings / Blocks
function thirty8_load_enabled_block_choices( $field ) {
    
    // reset choices
    $field['enabled_blocks'] = array();
 
 	// Get all registered block types
	$block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
		
	$count = 0;

	// Loop through it and grab just the blocks we want 
 	foreach($block_types as $block){
  
  		if($block->title != ''){
			  
			// This is a bit irritating - when we add new custom blocks, either add them into the extra-museum-blocks category or add to the list below
			// AND the list in the thirty8_allowed_block_types function below! 
			// This will enable these to appear on the checkbox ACF pages...
			
  			if($block->category == 'thirty8'){          
  								  
				$value = $block->name;
				$label = $block->title;
				  
				$field['choices'][ $value ] = $label;
				  
          		$count++;
  			}
  		}
  
	}  
	
	return $field;

    
}

add_filter('acf/load_field/name=enabled_blocks', 'thirty8_load_enabled_block_choices');

// Only allow certain blocks

function thirty8_allowed_block_types ( $block_editor_context, $editor_context ) {
	
	$output = array();

	if ( ! empty( $editor_context->post ) ) {
		
 		// Get all registered block types
		$block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
	
		// Loop through it and grab just the blocks we want 
 		foreach($block_types as $block){
			  	
			/*	  
			if($block->category == 'thirty8'){          
  			// Ignore
			} else {  		
		  		$output[] = $block->name;		  
			}
			*/
	
			//$output[] = $block->name;		  
	
		}		
		
		// Get the extra blocks that have been enabled via our Site Settings / Admin Settings / Blocks page
		$enabled_blocks = get_field('enabled_blocks','option');
		
		foreach($enabled_blocks as $enabled_block){  		
	  		$output[] = $enabled_block['value'];	
		}
		
	}

	return $output;
}

//add_filter( 'allowed_block_types_all', 'thirty8_allowed_block_types', 10, 2 );

/**
 * Only allow certain block types
 */
function thirty8_remove_default_blocks($allowed_blocks){
	// Get all registered blocks
	$registered_blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();

    // Core blocks
    unset($registered_blocks['core/archives']);
    unset($registered_blocks['core/audio']);
    // unset($registered_blocks['core/block']);
    unset($registered_blocks['core/button']);
    unset($registered_blocks['core/buttons']);
    unset($registered_blocks['core/calendar']);
    unset($registered_blocks['core/categories']);
    unset($registered_blocks['core/code']);
    unset($registered_blocks['core/column']);
    unset($registered_blocks['core/columns']);
    unset($registered_blocks['core/cover']);
    unset($registered_blocks['core/embed']);
    unset($registered_blocks['core/file']);
    unset($registered_blocks['core/freeform']);
    unset($registered_blocks['core/gallery']);
    unset($registered_blocks['core/group']);
    // unset($registered_blocks['core/heading']);
    unset($registered_blocks['core/html']);
    unset($registered_blocks['core/image']);
    unset($registered_blocks['core/latest-comments']);
    unset($registered_blocks['core/latest-posts']);
    // unset($registered_blocks['core/list']);
    unset($registered_blocks['core/loginout']);
    unset($registered_blocks['core/media-text']);
    unset($registered_blocks['core/missing']);
    unset($registered_blocks['core/more']);
    unset($registered_blocks['core/nextpage']);
    unset($registered_blocks['core/page-list']);
    // unset($registered_blocks['core/paragraph']);
    unset($registered_blocks['core/post-content']);
    unset($registered_blocks['core/post-date']);
    unset($registered_blocks['core/post-excerpt']);
    unset($registered_blocks['core/post-featured-image']);
    unset($registered_blocks['core/post-template']);
    unset($registered_blocks['core/post-terms']);
    unset($registered_blocks['core/post-title']);
    unset($registered_blocks['core/preformatted']);
    unset($registered_blocks['core/pullquote']);
    unset($registered_blocks['core/query']);
    unset($registered_blocks['core/query-pagination']);
    unset($registered_blocks['core/query-pagination-next']);
    unset($registered_blocks['core/query-pagination-numbers']);
    unset($registered_blocks['core/query-pagination-previous']);
    unset($registered_blocks['core/query-title']);
    unset($registered_blocks['core/quote']);
    unset($registered_blocks['core/rss']);
    unset($registered_blocks['core/search']);
    // unset($registered_blocks['core/separator']);
    unset($registered_blocks['core/shortcode']);
    unset($registered_blocks['core/site-logo']);
    unset($registered_blocks['core/site-tagline']);
    unset($registered_blocks['core/site-title']);
    unset($registered_blocks['core/social-link']);
    unset($registered_blocks['core/social-links']);
    unset($registered_blocks['core/spacer']);
    // unset($registered_blocks['core/table']);
    unset($registered_blocks['core/tag-cloud']);
    unset($registered_blocks['core/text-columns']);
    unset($registered_blocks['core/verse']);
    unset($registered_blocks['core/video']);
    unset($registered_blocks['core/navigation']);
    unset($registered_blocks['core/avatar']);
    unset($registered_blocks['core/comments']);
    unset($registered_blocks['core/read-more']);
    unset($registered_blocks['core/post-author']);
    unset($registered_blocks['core/post-comments-form']);
    unset($registered_blocks['core/post-author-biography']);
    unset($registered_blocks['core/post-navigation-link']);
    unset($registered_blocks['core/term-description']);
    unset($registered_blocks['core/button']);
    unset($registered_blocks['core/image']);
    unset($registered_blocks['core/quote']);

    // Plugins
	unset($registered_blocks['yoast/how-to-block']);
	unset($registered_blocks['yoast/faq-block']);
	unset($registered_blocks['yoast-seo/breadcrumbs']);
	unset($registered_blocks['gravityforms/form']);

	// Get keys from array
	$registered_blocks = array_keys($registered_blocks);

	// Merge allowed core blocks with plugins blocks
	return $registered_blocks;
}
//add_filter('allowed_block_types_all', 'thirty8_remove_default_blocks');


function wpdocs_allowed_block_types ( $block_editor_context, $editor_context ) {
	if ( ! empty( $editor_context->post ) ) {
		return array(
			//'core/archives',
			'core/audio',
			'core/block',
			'core/button',
			'core/buttons',
			//'core/calendar',
			'core/categories',
			//'core/code',
			'core/column',
			'core/columns',
			'core/cover',
			'core/embed',
			'core/file',
			//'core/freeform',
			'core/gallery',
			'core/group',
			'core/heading',
			//'core/html',
			'core/image',
			'core/latest-comments',
			'core/latest-posts',
			'core/list',
			//'core/loginout',
			//'core/media-text',
			'core/missing',
			'core/more',
			//'core/nextpage',
			'core/page-list',
			'core/paragraph',
			//'core/post-content',
			//'core/post-date',
			//'core/post-excerpt',
			//'core/post-featured-image',
			//'core/post-template',
			//'core/post-terms',
			//'core/post-title',
			//'core/preformatted',
			'core/pullquote',
			//'core/query',
			//'core/query-pagination',
			//'core/query-pagination-next',
			//'core/query-pagination-numbers',
			//'core/query-pagination-previous',
			//'core/query-title',
			'core/quote',
			'core/rss',
			'core/search',
			'core/separator',
			'core/shortcode',
			//'core/site-logo',
			//'core/site-tagline',
			//'core/site-title',
			'core/social-link',
			'core/social-links',
			'core/spacer',
			'core/table',
			'core/tag-cloud',
			'core/text-columns',
			'core/verse',
			'core/video',
			//'core/navigation',
			//'core/avatar',
			//'core/comments',
			//'core/read-more',
			//'core/post-author',
			//'core/post-comments-form',
			//'core/post-author-biography',
			//'core/post-navigation-link',
			//'core/term-description',
		);
	}

	return $block_editor_context;
}

//add_filter( 'allowed_block_types_all', 'wpdocs_allowed_block_types', 10, 2 );




?>