<?php

// Check to see if there is an override in the child theme

$child_theme_override =
	get_stylesheet_directory() . '/thirty8/views/sidebars/' . basename(__FILE__);

if (file_exists($child_theme_override)) {
	include $child_theme_override; ?>

<?php
} else {
	$shortcode = get_sub_field('shortcode'); ?>

<aside class="widget inner-padding widget_shortcode">
	
	<?php if (get_sub_field('header_text')) { ?>
	<h2 class="widget-title"><?php the_sub_field('header_text'); ?></h2>
	<?php } ?>
	
	<?php if ($shortcode) {
 	echo do_shortcode($shortcode);
 } ?>
			
</aside>

<?php
} ?>
