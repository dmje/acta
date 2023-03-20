<aside class="widget inner-padding widget_pages">

	<h2 class="widget-title">In this section</h2>
		
	<ul class="widget-menu">
		<?php 
		// use wp_list_pages to display parent and all child pages all generations (a tree with parent)
		$parent = get_sub_field('parent_item'); 
		?>
		<li><a href="<?php the_permalink($parent); ?>"><?php echo get_the_title($parent); ?></a></li>
		<ul class="children">
		<?php
			$args = array(
				'title_li' => '',
				'child_of' => $parent
			);
			wp_list_pages($args);
		?>
		</ul>
	</ul>
			
</div>