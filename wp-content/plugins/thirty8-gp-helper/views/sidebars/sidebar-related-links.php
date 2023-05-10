<?php

function TMP_CheckExternalLink($url)
{
	return '';
}

// Check to see if there is an override in the child theme

$child_theme_override =
	get_stylesheet_directory() . '/thirty8/views/sidebars/' . basename(__FILE__);

if (file_exists($child_theme_override)) {
	include $child_theme_override; ?>

<?php
} else {
	 ?>

<aside class="widget inner-padding widget_related_links">

	<h2 class="widget-title">Related Links</h2>

	<?php if (have_rows('link')): ?>
	<ul class="widget-menu">
	<?php while (have_rows('link')):
 	the_row(); ?>
	
	
		<?php $link_title = get_sub_field('link_title'); ?>
		<?php
  $link_url = get_sub_field('link_url');
  $link_target = '';
  $link_target = TMP_CheckExternalLink($link_url);
  if ($link_target == true) {
  	$link_target = 'target="_blank"';
  }
  ?>
		<li><a href="<?php echo $link_url; ?>" <?php echo $link_target; ?>><?php echo $link_title; ?></a></li>
		
	<?php
 endwhile; ?>
	</ul>
	<?php else:endif; ?>
		
	
</aside>


<?php
} ?>
