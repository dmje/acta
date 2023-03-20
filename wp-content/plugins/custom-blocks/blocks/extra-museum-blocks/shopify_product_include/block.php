<?php
/*
Active: true
UUID: shopify-product-include
Title: Shopify product include
Description: Include Shopify product from URL
Keywords: shop, shopify, product
Post Types: null
Allow Multiple: true
*/

$url = get_field('shopify_url');

$parsed_url = parse_url($url);

$shop_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];


if($url){
	
	$url = $url . '.xml';
		
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
	  'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.1 Safari/605.1.15'
	]);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	$result = curl_exec($ch);
	
	if(curl_errno($ch)) {
	    echo 'Error: '.curl_error($ch);
	} else {
			
		$allok = true;	
				
		$xml = simplexml_load_string($result);
		
		$id = $xml->id;
		$title = $xml->title;
		$image_src = $xml->images->image->src;
		$description = $xml->{"body-html"};
		
		$variant_id = $xml->variants->variant->id;
		
		$buy_link = $shop_url . '/cart/add?id=' . $variant_id;
				
	}
	
	curl_close ($ch);		
	
}


?>


<?php if($allok){?>

	<div class="shopify-buynow">
	
		<h3><?php echo $title;?></h3>
		
		<img style="width:200px;margin-right:20px;margin-bottom:20px;float:left;" src="<?php echo $image_src;?>" alt="Image of <?php echo $title;?>" />
	
		<?php echo $description;?>
	
		<a target="_blank" class="uk-button uk-button-primary shortcode-button" href="<?php echo $buy_link;?>">Add to basket</a>
	
	</div>


<?php } else {?>

	<p>Please provide a product URL..</p>

<?php } ?>

