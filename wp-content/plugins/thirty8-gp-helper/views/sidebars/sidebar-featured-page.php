<?php

// Check to see if there is an override in the child theme

$child_theme_override =
	get_stylesheet_directory() . '/thirty8/views/sidebars/' . basename(__FILE__);

if (file_exists($child_theme_override)) {
	include $child_theme_override; ?>

<?php
} else {

	$featuredpage = get_sub_field('featured_page_selection');
	$featuredpage_id = $featuredpage->ID;

	// Use global function to get details for the linked item
	$featuredpage_details = thirty8_get_item_details($featuredpage_id);

	// Grab the bits of of the array
	$featuredpage_title = $featuredpage_details['title'];
	$featuredpage_blurb = $featuredpage_details['short_desc'];
	$featuredpage_link = $featuredpage_details['permalink'];
	$featuredpage_imagesrc = $featuredpage_details['image_src'];
	$featuredpage_imagealt = $featuredpage_details['image_alt'];
	?>

<aside class="widget widget_featuredpage">
	
	<a class="feature-block-image" href="<?php echo $featuredpage_link; ?>"><img class="content-block-featured-image" src="<?php echo $featuredpage_imagesrc; ?>" alt="<?php echo $featuredpage_imagealt; ?>" /></a>
	
	<div class="feature-block-text">
		<h2><?php echo $featuredpage_title; ?></h2>
		<div class="page-summary"><?php echo $featuredpage_blurb; ?></div>
		<a class="more-link button" href="<?php echo $featuredpage_link; ?>">
			<?php do_action('thirty8_readmore_text'); ?>
			<i class="fa fa-angle-right"></i>
		</a>
	</div>
	
</aside>

<?php
} ?>
