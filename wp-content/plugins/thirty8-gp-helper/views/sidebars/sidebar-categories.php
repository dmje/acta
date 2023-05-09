<?php

// Check to see if there is an override in the child theme

$child_theme_override =
	get_stylesheet_directory() . '/thirty8/views/sidebars/' . basename(__FILE__);

if (file_exists($child_theme_override)) {
	include $child_theme_override; ?>

<?php
} else {
	 ?>

<aside class="widget inner-padding widget_categories">
	
	<?php $widget_title = get_sub_field('widget_title'); ?>
	
	<?php if (get_sub_field('widget_title')) { ?>
		<h2 class="widget-title"><?php echo $widget_title; ?></h2>
	<?php } else { ?>
		<h2 class="widget-title">Categories</h2>
	<?php } ?>
	
	<ul class="widget-menu">
		<?php
  $args = [
  	'hide_empty' => 1,
  	'title_li' => '',
  ];
  wp_list_categories($args);
  ?> 
	</ul>
</aside>

<?php
} ?>
