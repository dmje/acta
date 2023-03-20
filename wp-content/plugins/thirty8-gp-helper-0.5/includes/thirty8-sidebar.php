<div class="inside-right-sidebar">

<?php 
	
	global $post;
	
	if ($post->post_type == "page"){
	
		$selected = (get_field('sidebar_selection'));		
		$post_object = get_field('choose_sidebar');
		$post = $post_object;
		setup_postdata( $post );
		$post_id = $post->ID;
	
				
		switch($selected){
	
			case 'existing' :
	
				if( have_rows('sidebar_block', $post_id) ):
	
					while ( have_rows('sidebar_block', $post_id) ) : the_row(); 
					
						include('sidebar-switcher.php');
	
					endwhile;
	
				endif;
	
				wp_reset_postdata();
	
			break;
	
			case 'custom' :
						
				if( have_rows('sidebar_block', $post_id) ):
				
					while ( have_rows('sidebar_block', $post_id) ) : the_row(); 
				
					include('sidebar-switcher.php');
				
					endwhile;
					
				endif;
				
				wp_reset_postdata();
	
			break;
	
			case 'default':
			
			
				echo 'Default sidebar! Fetching from global options...';
			
			break;
	
			
			case '' :
			
				// nothing has been selected for the page - show nothing
				break;
		}

	} elseif($post->post_type == "sc_event"){
		
		if(get_field('event_sidebar','option')){
			$post_object = get_field('event_sidebar','option');
			$post = $post_object;
			setup_postdata( $post );
			$post_id = $post->ID;		
	
			if( have_rows('sidebar_block', $post_id) ):
	
				while ( have_rows('sidebar_block', $post_id) ) : the_row(); 
				
					include('sidebar-switcher.php');
	
				endwhile;
	
			endif;
	
			wp_reset_postdata();			
		} else {
			if(is_user_logged_in()){
				echo '<p>You have not specified a sidebar for object records!</p>';
				echo '<p>You can do this in the <a href="' . THIRTY8_GPHELPER_SITESETTINGSURL . '">site settings</a>.</p>';
				
			}
		}		
		
		
	} elseif($post->post_type== 'object'){
		
		if(get_field('object_sidebar','option')){
			$post_object = get_field('object_sidebar','option');
			$post = $post_object;
			setup_postdata( $post );
			$post_id = $post->ID;		
	
			if( have_rows('sidebar_block', $post_id) ):
	
				while ( have_rows('sidebar_block', $post_id) ) : the_row(); 
				
					include('sidebar-switcher.php');
	
				endwhile;
	
			endif;
	
			wp_reset_postdata();			
		} else {
			if(is_user_logged_in()){
				echo '<p>You have not specified a sidebar for object records!</p>';
				echo '<p>You can do this in the <a href="' . THIRTY8_GPHELPER_SITESETTINGSURL . '">site settings</a>.</p>';
				
			}
		}

	}

?>

</div>