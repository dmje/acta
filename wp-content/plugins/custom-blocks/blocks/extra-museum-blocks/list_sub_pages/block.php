<?php
/*
Active: true
UUID: list-sub-pages-v1
Title: List sub pages block version 1
Description: Lists all sub pages in a nice looking grid
Keywords: list, gallery, grid, pages, sub-pages, listing
Post Types: null
Allow Multiple: true
*/

?>


<style>
.temp-grid-container {
  display: grid;
  grid-template-columns: auto auto;
  padding: 10px;  
}

.temp-grid-item {
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 20px;
  font-size: 30px;
  text-align: center;
  margin:10px;
}

.temp-grid-item img{
	width:530px;
}
</style>

<?php

$this_post_id = get_the_ID();
$order = 'ASC';
$order_by = 'menu_order';


$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $this_post_id,
    'order'          => $order,
    'orderby'        => $order_by,
 );


$parent = new WP_Query( $args );

$count = 0;

if ( $parent->have_posts() ) : ?>

    <?php while ( $parent->have_posts() ) : $parent->the_post(); 
		
	// Get image
	$image_id = get_post_thumbnail_id($post->ID);	
	$heroimage_url = wp_get_attachment_image_src($image_id,'medium'); 
	$heroimage_url = $heroimage_url[0];
	$alt_text = get_post_meta($image_id , '_wp_attachment_image_alt', true);

	if(!$image_id)
	{
		$heroimage_url = 'https://via.placeholder.com/530x265';

	}			
		
		
	$count++;
	$new_row = false;
	
	if($count %2 != 0)
	{
		$new_row = true;	
	}
	?>


	<?php if($new_row){?>
	<div class="temp-grid-container">
	<?php } ?>

  		<div class="temp-grid-item">
			<img src="<?php echo $heroimage_url;?>" alt="<?php echo $alt_text; ?>"/>
			<h2><?php echo get_the_title();?></h2>
			<p>Body</p>			  			  
		</div>

	<?php if(!$new_row){?>  		
	</div><!--//grid container-->
	<?php }?>



    <?php endwhile; ?>

<?php endif; wp_reset_postdata(); ?>