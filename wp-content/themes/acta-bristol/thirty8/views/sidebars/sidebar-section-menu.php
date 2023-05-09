<!--theme override-->

<aside class="widget inner-padding widget_pages">
	<script>
		jQuery(document).ready(function($) {
			// prevent page from jumping to top from  # href link
			$('.widget-menu li.page_item_has_children > a').click(function(e) {
				e.preventDefault();
			});

			// remove link from menu items that have children
			$(".widget-menu li.page_item_has_children > a").attr("href", "#");

			//  function to open / close menu items
			$(".widget-menu a").click(function() {
					var link = $(this);
					var closest_ul = link.closest("ul");
					var parallel_active_links = closest_ul.find(".active")
					var closest_li = link.closest("li");
					var link_status = closest_li.hasClass("active");
					var count = 0;

					closest_ul.find("ul").slideUp(function() {
							if (++count == closest_ul.find("ul").length)
									parallel_active_links.removeClass("active");
					});

					if (!link_status) {
							closest_li.children("ul").slideDown();
							closest_li.addClass("active");
					}
			})
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