<?php 

$featuredpage = get_sub_field("featured_page_selection");
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

<div class="featured-page-widget feature-block widget">
	
	<a class="feature-block-image" href="<?php echo $featuredpage_link; ?>"><img class="content-block-featured-image" src="<?php echo $featuredpage_imagesrc; ?>" alt="<?php echo $featuredpage_imagealt; ?>" /></a>
	
	<div class="feature-block-text">
		<h3><a href="<?php echo $featuredpage_link; ?>"><?php echo $featuredpage_title; ?></a></h3>
		<div class="page-summary"><?php echo $featuredpage_blurb;?></div>
		<a class="more-link button" href="<?php echo $featuredpage_link; ?>">
			<?php do_action('thirty8_readmore_text'); ?>
			<i class="fa fa-angle-right"></i>
		</a>
	</div>
	
</div>