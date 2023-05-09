<?php

// Check to see if there is an override in the child theme

$child_theme_override =
	get_stylesheet_directory() . '/thirty8/views/sidebars/' . basename(__FILE__);

if (file_exists($child_theme_override)) {
	include $child_theme_override; ?>

<?php
} else {
	 ?>

<aside class="widget inner-padding widget_post_tags">

	<h2 class="widget-title">Post Tags</h2>

	<p>To do</p>
	
</aside>


<?php
} ?>
