<?php

// Add additional image sizes

function new_image_sizes()
{
	add_image_size('800x600', 800, 600, true);
}

add_action('after_setup_theme', 'new_image_sizes');

?>
