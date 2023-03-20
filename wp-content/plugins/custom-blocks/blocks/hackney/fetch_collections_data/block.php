<?php
/*
Active: true
UUID: hackney-fetch-object
Title: Hackney Museum: Display object content
Description: Display object data from Hackney Museum online collection
Keywords: collection,collections,hackney
Post Types: null
Allow Multiple: true
*/


$object_url = get_field('object_url');

// Get the page meta details
$page_meta = get_meta_tags($object_url);

/*
echo '<pre>';
print_r($page_meta);
echo '</pre>';
*/

$object_title = $page_meta['twitter:title'];
$object_image = $page_meta['twitter:image:src'];
$object_caption = get_field('object_caption');


?>

<!-- wp:generateblocks/container {"isDynamic":true,"blockVersion":2} -->
<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large">
	<a href="<?php echo $object_url;?>" target="_blank">
		<img src="<?php echo $object_image;?>" alt="Image of <?php echo $object_title;?>" class="wp-image-297"/>
	</a>
	
	<?php if($object_caption){?>
		<figcaption style="text-align:left">
			<?php echo $object_caption;?>
		</figcaption>
	<?php }?>

</figure>
<!-- /wp:image -->
<!-- /wp:generateblocks/container -->

