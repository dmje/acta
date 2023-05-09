<!--theme override-->

<aside class="widget inner-padding widget_pages">
	<script>
		jQuery(document).ready(function($) {
		// In this function every menu which has an active link opens if a link is active. Its ul parent opens itself and adds the class 'open' to its parent (the arrow) so it turns 90 degrees
		$('.widget-menu li').each(function(i, el) {
			if ($(el).hasClass('current_page_item')) {
				$(el).parent().show().parent().addClass('open');
			};
		});

		// This function ensures that a menu pops open when you click on it. All other menu's automatically close if the user clicks on a ul header. All the opened ul's close except the one clicked on
		$('.widget-menu li.page_item_has_children').click(function(event) {
			$('.widget-menu > ul > li > ul:visible').not($(this).nextAll('ul')).stop().hide(200).parent().removeClass('open'); //
				$(this).nextAll('ul').slideToggle(200, function() {
					$(this).parent('.pagenav').toggleClass('open');
				});
			});
		});
	</script>

	<h2 class="widget-title">In this section</h2>
		
	<ul class="widget-menu">
		<?php $parent = get_sub_field('parent_item'); ?>
		<li><a href="<?php the_permalink($parent); ?>"><?php echo get_the_title($parent); ?></a></li>

		<ul class="children">
			<?php
				$args = [
					'title_li' => '',
					'child_of' => $parent,
				];
				wp_list_pages($args);
			?>
		</ul>
	</ul>
			
</div>