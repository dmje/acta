<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
	exit(); // Exit if accessed directly.
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata(
 	'article'
 ); ?>>
 
 <div class="acta-whatson-item">
	 
	 <div class="acta-whatson-image">
<?php
$image_id = get_post_thumbnail_id($post->ID);

if ($image_id) {
	$heroimage_url = wp_get_attachment_image_src($image_id, 'medium');
	$heroimage_url = $heroimage_url[0];

	$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
} else {
	$heroimage_url = '';
	$alt_text = '';

	$image = get_field('default_featured_image', 'option');

	$heroimage_url = $image['sizes']['medium'];
	$alt_text = $image['alt'];

	//echo 'hero = ' . $heroimage_url;

}

?>
	<a href="<?php echo get_the_permalink();?>">
		<img src="<?php echo $heroimage_url; ?>" alt="<?php echo $alt_text; ?>"/>
	</a>

	 </div>
	 
	 <div class="acta-whatson-text">
	 
		<h3><?php the_title(); ?></h3>
		
 		<?php echo acta_whatson_times(get_the_ID()); ?>
		
		<?php the_excerpt(); ?>
	  
	 </div>
	 
	 
 
 </div>

	
</article>
