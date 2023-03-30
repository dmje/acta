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
			
  			//if($block->category == 'thirty8'){          
  								  
				$value = $block->name;
				$label = $block->title . ' [' . $value . ']';
				  
				$field['choices'][ $value ] = $label;
				  
          		$count++;
  			//}
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

add_filter( 'allowed_block_types_all', 'thirty8_allowed_block_types', 10, 2 );




?>