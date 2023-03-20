<aside class="widget inner-padding widget_cta">

	<?php if(get_sub_field('header_text')){ ?>
	<h2 class="widget-title"><?php the_sub_field('header_text'); ?></h2>
	<?php } ?>

	<?php 
		$cta_link = '';
		if(get_sub_field( 'internal_or_external_link' ) == 'internal'){
			$cta_link = get_sub_field( 'internal_link' );	
		} else {
			$cta_link = get_sub_field( 'external_link' );
		}
	?>
	<a href="<?php echo $cta_link; ?>"><?php the_sub_field( 'link_text' ); ?></a>
		
</aside>
