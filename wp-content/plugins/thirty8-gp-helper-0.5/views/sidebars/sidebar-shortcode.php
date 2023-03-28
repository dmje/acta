<?php

$shortcode = get_sub_field('shortcode');

?>

<aside class="widget inner-padding widget_shortcode">
	
	<?php if(get_sub_field('header_text')){ ?>
	<h2 class="widget-title"><?php the_sub_field('header_text'); ?></h2>
	<?php } ?>
	
	<?php 
	
		if($shortcode){
			echo do_shortcode( $shortcode);
		}
	
	?>
	
		
			
</div>