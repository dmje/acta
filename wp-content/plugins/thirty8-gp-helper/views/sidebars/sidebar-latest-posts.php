<?php

// Check to see if there is an override in the child theme

$child_theme_override =
	get_stylesheet_directory() . '/thirty8/views/sidebars/' . basename(__FILE__);

if (file_exists($child_theme_override)) {
	include $child_theme_override; ?>

<?php
} else {
	 ?>

<aside class="widget inner-padding widget_posts">

	<h2 class="widget-title">Latest Posts</h2>
			
	<ul>				
		<?php
  $numberposts = get_sub_field('number_of_posts');

  if ($numberposts == 0) {
  	$numberposts = 3;
  }
  $args = ['numberposts' => $numberposts, 'post_status' => 'publish'];
  $recent_posts = wp_get_recent_posts($args);

  foreach ($recent_posts as $recent) { ?>
			<li><a href="<?php echo get_permalink($recent['ID']); ?>"><?php echo $recent[
	'post_title'
]; ?></a></li>			
		<?php }
  ?>
	</ul>

</aside>


<?php
} ?>
