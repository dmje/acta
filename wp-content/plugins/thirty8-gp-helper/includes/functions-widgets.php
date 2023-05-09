<?php

// Remove block widgets, go back to traditional ones...
function gp_helper_removeblockwidgets()
{
	remove_theme_support('widgets-block-editor');
}
add_action('after_setup_theme', 'gp_helper_removeblockwidgets');

class THIRTY8_Sidebar extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
			'thirty8-sidebar', // Base ID
			'Thirty8 sidebar' // Name
		);

		add_action('widgets_init', function () {
			register_widget('thirty8_Sidebar');
		});
	}

	public $args = [
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
		'before_widget' => '<div class="widget-wrap">',
		'after_widget' => '</div></div>',
	];

	public function widget($args, $instance)
	{
		// Include our TMP sidebar shizzle
		include 'thirty8-sidebar.php';
	}

	public function form($instance)
	{
		echo '<p>This widget includes Thirty8 sidebar functionality...</p>';
	}

	public function update($new_instance, $old_instance)
	{
		$instance = [];

		$instance['title'] = !empty($new_instance['title'])
			? strip_tags($new_instance['title'])
			: '';
		$instance['text'] = !empty($new_instance['text'])
			? $new_instance['text']
			: '';

		return $instance;
	}
}
$thirty8_sidebar_widget = new THIRTY8_Sidebar();
?>
