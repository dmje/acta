<h2>See...</h2>

<li>https://docs.sugarcalendar.com/article/194-displaying-the-calendar</li>
<li><a href="https://docs.sugarcalendar.com/article/196-displaying-event-lists">https://docs.sugarcalendar.com/article/196-displaying-event-lists</a></li>

<li>https://fullcalendar.io/docs</li>


<?php
						
	$custom_query_args=array(
	   'post_type'=>'sc_event',
	   'posts_per_page' => -1,
	);							

	$custom_query = new WP_Query( $custom_query_args );

	if ($custom_query->have_posts()) : 
?>

	<h2>Events</h2>				 	  
		
		
						
<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

	<?php
	
	$post_id = get_the_ID();
	
	
	?>


	
	
	<div class="test">
		<h1><?php the_title();?></h1>
		
			<?php 

			echo '<h2>Meta</h2>';
			$sugarcal_meta = get_sugarcalmeta($post_id);
			
			echo '<pre>';
			print_r($sugarcal_meta);
			echo '</pre>';
			
			
			echo '<h2>Terms...</h2>';
			$term_obj_list = get_the_terms( $post_id, 'sc_event_category' );
			echo '<pre>';
			print_r($term_obj_list);
			echo '</pre>';


			
			
			?>
		
	</div>
					
<?php endwhile; ?>
						
						
<?php endif; ?>