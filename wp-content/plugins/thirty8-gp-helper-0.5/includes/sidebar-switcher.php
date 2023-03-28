
<?php

$sidebar_filename = '';	
$sidebar_row_layout = '';

$sidebar_row_layout = get_row_layout();

switch($sidebar_row_layout)
{
	
	case 'cta_block':
		$sidebar_filename = 'sidebar-cta.php';
	break;

	case 'featured_page':
		$sidebar_filename = 'sidebar-featured-page.php';
	break;

	case 'latest_posts':
		$sidebar_filename = 'sidebar-latest-posts.php';
	break;

	case 'news_categories':
		$sidebar_filename = 'sidebar-categories.php';
	break;

	case 'news_tags':
		$sidebar_filename = 'sidebar-post-tags.php';
	break;

	case 'related_links':
		$sidebar_filename = 'sidebar-related-links.php';
	break;

	case 'section_menu':
		$sidebar_filename = 'sidebar-section-menu.php';
	break;

	case 'social_sharing':
		$sidebar_filename = 'sidebar-share.php';
	break;

	case 'searchbox':
		$sidebar_filename = 'sidebar-search.php';
	break;

	case 'shortcode_include':
		$sidebar_filename = 'sidebar-shortcode.php';
	break;

	
}
	
include(THIRTY8_GPHELPER_PATH . '/views/sidebars/' . $sidebar_filename);

?>
