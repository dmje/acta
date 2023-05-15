<?php

// Generic logging function
function thirty8log($msg)
{
	($myfile = fopen(THIRTY8_GPHELPER_PATH . '/log/log.htm', 'a')) or
		die('Unable to open log file!');
	fwrite($myfile, $msg . '<br/>');
	fclose($myfile);
}

// Enqueues
function thirty8_enqueue_gpstylesheets()
{
	// Styles for blocks
	$thirty8_gpblocks_css_ver = date(
		'ymd-Gis',
		filemtime(THIRTY8_GPHELPER_PATH . '/css/blocks.css')
	);
	wp_enqueue_style(
		'thirty8-gp-blocks',
		THIRTY8_GPHELPER_URL . '/css/blocks.css',
		false,
		$thirty8_gpblocks_css_ver
	);

	// Misc styles
	$thirty8_gpmisc_css_ver = date(
		'ymd-Gis',
		filemtime(THIRTY8_GPHELPER_PATH . '/css/misc.css')
	);
	wp_enqueue_style(
		'thirty8-gpmisc-blocks',
		THIRTY8_GPHELPER_URL . '/css/misc.css',
		false,
		$thirty8_gpmisc_css_ver
	);
}

add_action('wp_enqueue_scripts', 'thirty8_enqueue_gpstylesheets');

// Include external scripts

function thirty8_gp_external_scripts()
{
	// Swiper
	wp_register_script(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
		'',
		true
	);
	wp_enqueue_script('swiper');

	// Knightlab Timeline js
	wp_register_script(
		'knightlab',
		'https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js',
		'',
		true
	);
	wp_enqueue_script('knightlab');

	// UIKIT
	/*
		wp_register_script('uikit', 'https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit.min.js', '', true);
		wp_register_script('uikiticons', 'https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/js/uikit-icons.min.js', '', true);
	
		wp_enqueue_script('uikit');
		wp_enqueue_script('uikiticons');
		*/
}
add_action('wp_enqueue_scripts', 'thirty8_gp_external_scripts');

function thirty8_gp_external_styles()
{
	// Swiper
	wp_enqueue_style(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css'
	);

	// Knightlab timeline css
	wp_enqueue_style(
		'knightlab',
		'https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css'
	);

	// UIKIT
	/*
		wp_enqueue_style('uikit', 'https://cdn.jsdelivr.net/npm/uikit@3.11.1/dist/css/uikit.min.css');
		*/
}
add_action('wp_enqueue_scripts', 'thirty8_gp_external_styles');

// Default Copyright message
add_filter('generate_copyright', 'thirty8_gp_custom_copyright');
function thirty8_gp_custom_copyright()
{
	$sitename = get_bloginfo('name'); ?>
    <p>All content &copy; <?php echo date('Y') .
    	' ' .
    	$sitename; ?> | Website by <a target="_blank" href="https://thirty8.co.uk">Thirty8 Digital</a></p>
    <?php
}

// Function to amend CultureObject permalink
function thirty8_gp_cultureobject_permalink($args, $post_type)
{
	// If not objects CPT, bail.
	if ('object' !== $post_type) {
		return $args;
	}

	// If no override specified, bail.
	if (!get_field('cultureobject_rewrite', 'option')) {
		return $args;
	} else {
		$cultureobject_rewrite = get_field('cultureobject_rewrite', 'option');
	}

	// Add additional CPT options.
	$object_args = [
		//'has_archive' => true,
		//'supports'    => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
		'rewrite' => ['slug' => $cultureobject_rewrite],
	];

	// Merge args together.
	return array_merge($args, $object_args);
}
add_filter(
	'register_post_type_args',
	'thirty8_gp_cultureobject_permalink',
	10,
	2
);

// Generic function to get item details

// Return item description - used on repeater feature and search

function thirty8_get_item_details($postid)
{
	$item_details = [];
	$image_size = '800x600';

	// Set defaults

	// Title
	$item_details['title'] = get_the_title($postid);

	// Image
	$attachment_id = get_post_thumbnail_id($postid);

	// Short Description
	$item_details['short_desc'] = 'The short desc';

	if (!$attachment_id) {
		if (get_field('default_thumbnail', 'option')) {
			$image_id = get_field('default_thumbnail', 'option');
			$image = wp_get_attachment_image_src($image_id, $image_size);
			$item_details['image_src'] = $image[0];
			$item_details['image_alt'] = 'Default image';
		}
	} else {
		$imagesrc = wp_get_attachment_image_src($attachment_id, $image_size);
		$item_details['image_src'] = $imagesrc[0];
		$item_details['image_alt'] = get_post_meta(
			$attachment_id,
			'_wp_attachment_image_alt',
			true
		);

		if (!$item_details['image_alt']) {
			$item_details['image_alt'] = get_the_title($postid);
		}
	}

	switch (get_post_type($postid)) {
		case 'page':
			$item_details['post_type_display'] = 'Page';
			$item_details['short_desc'] = get_field('page_summary', $postid);

			break;

		case 'post':
			$item_details['post_type_display'] = 'News article';
			$item_details['short_desc'] = get_the_excerpt();

			break;

		case 'tribe_events':
			$item_details['post_type_display'] = 'Event';
			$item_details['short_desc'] = get_the_excerpt($postid);

			break;
	}

	return $item_details;
}

// ALT text fix
// https://www.billerickson.net/code/wordpress-image-automatic-alt-text/
// Makes sure that "later" ALT text edits are reflected on front end

add_filter(
	'render_block',
	function ($content, $block) {
		if ('core/image' !== $block['blockName']) {
			return $content;
		}

		$alt = get_post_meta(
			$block['attrs']['id'],
			'_wp_attachment_image_alt',
			true
		);
		if (empty($alt)) {
			return $content;
		}

		// Empty alt
		if (false !== strpos($content, 'alt=""')) {
			$content = str_replace('alt=""', 'alt="' . $alt . '"', $content);

			// No alt
		} elseif (false === strpos($content, 'alt="')) {
			$content = str_replace('src="', 'alt="' . $alt . '" src="', $content);
		}

		return $content;
	},
	10,
	2
);

// Dump customiser CSS to file

function save_customiser_css()
{
	$custom_query_args = [
		'post_type' => 'custom_css',
		'posts_per_page' => -1,
		'order' => 'ASC',
	];

	$custom_query = new WP_Query($custom_query_args);

	if ($custom_query->have_posts()):
		while ($custom_query->have_posts()):
			$custom_query->the_post();

			$custom_css = get_the_content();
		endwhile;

		// Dump to file in child theme
		($myfile = fopen(get_stylesheet_directory() . '/customiser.css', 'w')) or
			die('Unable to open file!');
		fwrite($myfile, $custom_css);
		fclose($myfile);
	endif;
}
add_action('customize_save_after', 'save_customiser_css');

// Include CleverSnags

function clever_snags()
{
	if (get_field('use_cleversnags', 'option')) {
		include 'cleversnags.php';
	}
}
add_action('wp_footer', 'clever_snags', 100);

// Sponsor array

function thirty8_sponsorlogos($options = '')
{
	$site_sponsors = get_field('sponsor_details', 'option');

	if ($options == 'equalgrid') {
		$html = '<div class="sponsor-container">';
		$html .= '<div class="sponsor-listing">';
		foreach ($site_sponsors as $sponsor) {
			$html .= '<div class="sponsor-item">';
			$sponsor_logo_src = $sponsor['sponsor_logo']['sizes']['medium'];
			$sponsor_url = $sponsor['sponsor_link'];
			$sponsor_logo_alt = $sponsor['sponsor_logo']['alt'];

			$html .=
				'<a href="' .
				$sponsor_url .
				'"><img src="' .
				$sponsor_logo_src .
				'" alt="' .
				$sponsor_logo_alt .
				'"/></a>';

			$html .= '</div>';
		}

		$html .= '</div>';
		$html .= '</div>';
	}

	return $html;
}

// Customised login screen logo

function thirty8_login_logo()
{
	?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo THIRTY8_GPHELPER_URL; ?>/images/logo.png);            
            padding-bottom: 30px;
        }
    </style>
<?php
}
add_action('login_enqueue_scripts', 'thirty8_login_logo');
?>

