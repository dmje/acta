<?php

// Check to see if there is an override in the child theme

$child_theme_override =
	get_stylesheet_directory() . '/thirty8/views/sidebars/' . basename(__FILE__);

if (file_exists($child_theme_override)) {
	include $child_theme_override; ?>

<?php
} else {
	 ?>

<aside class="widget inner-padding widget_pages">

	<h2 class="widget-title">In this section</h2>
		
	<ul class="widget-menu">
		<?php // use wp_list_pages to display parent and all child pages all generations (a tree with parent)
  $parent = get_sub_field('parent_item'); ?>
		<li><a href="<?php the_permalink($parent); ?>"><?php echo get_the_title(
	$parent
); ?></a></li>
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

<?php
} ?>
