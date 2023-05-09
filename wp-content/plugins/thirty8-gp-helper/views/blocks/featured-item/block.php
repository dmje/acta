<?php

$selected_item = get_field('selected_item');

$item_id = $selected_item->ID;

$item_details = thirty8_get_item_details($item_id);

/*
echo '<pre>';
print_r($item_details);
echo '</pre>';
*/

$item_title = $item_details['title'];
$item_description = $item_details['short_desc'];


if(isset($item_details['image_src'])){
	
	$item_image_src = $item_details['image_src'];
	$item_image_alt = $item_details['image_alt'];	
	
} else {
	
	$item_image = get_field('default_featured_image','option');
	$item_image_src = $item_image['url'];
	$item_image_alt = $item_image['alt'];
}


$item_permalink = get_the_permalink($item_id);

?>

<div class="featured-item">
	<div class="featured-item-image">
		<a href="<?php echo $item_permalink;?>">
			<img src="<?php echo $item_image_src;?>" alt="<?php echo $item_image_alt;?>" />
		</a>
	</div>	
	<div class="featured-item-text">
		<a href="<?php echo $item_permalink;?>">
			<h3><?php echo $item_title;?></h3>
		</a>
		<p class="featured-item-description"><?php echo $item_description;?></p>
		<p class="featured-item-readmore"><a href="<?php echo $item_permalink;?>">Read more &raquo;</a></p>
	</div>
	
</div>