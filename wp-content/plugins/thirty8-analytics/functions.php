<?php

// Add style.css, checking for cache
function thirty8_enqueue_analyticsstylesheet()
{
	$main_css_ver = date('ymd-Gis', filemtime(THIRTY8_AH_PATH . 'css/style.css'));
	wp_enqueue_style(
		'thirty8-analytics_style',
		THIRTY8_AH_URL . 'css/style.css',
		false,
		$main_css_ver
	);
}

add_action('init', 'thirty8_enqueue_analyticsstylesheet');

function cookie_popup()
{
	global $post;
	global $wp;

	// Stuff from ACF settings
	$cookie_popup_location = get_field('cookie_popup_location', 'option');
	$background_colour = get_field('background_colour', 'option');
	$text_colour = get_field('text_colour', 'option');
	$cookie_text = get_field('cookie_text', 'option');

	// Misc links n stuff
	$link = home_url(add_query_arg([], $wp->request));
	$oklink = $link . '?cookies=ok';
	$notoklink = $link . '?cookies=notok';

	switch ($cookie_popup_location) {
		case 'bottombar':
			$popup_styles =
				'position:fixed;bottom:0;left:0;height:100px;width:100%;padding:5px;';
			$popup_styles .= 'background-color:' . $background_colour . ';';
			$popup_styles .= 'color:' . $text_colour . ';';

			break;
	}
	?>

<div class="thirty8-cookiepop" style="<?php echo $popup_styles; ?>">
	<div class="cookie-grid">
		<div class="cookie-grid-item"><?php echo $cookie_text; ?></div>
		<div class="cookie-grid-item">
			<div id="thirty8_cookieprefs"></div>
			<div class="thirty8-cookie-buttons">
				<button class="cookie-choice"><a href="<?php echo $oklink; ?>">Ok</a></button>
				<button class="cookie-choice"><a href="<?php echo $notoklink; ?>">No thanks</a></button>
			</div>
			
		</div>
		
	</div>	
</div>

<?php
}

// Only display the cookie popup if prefs haven't been set
if (!isset($_COOKIE['thirty8_cookie_prefs'])) {
	add_action('wp_footer', 'cookie_popup');
}

function set_cookies($choice)
{
	if ($choice == 'ok') {
		$cookie_name = 'thirty8_cookie_prefs';
		$cookie_value = 'ok';

		$tmp_cookie_prefs = setcookie(
			$cookie_name,
			$cookie_value,
			time() + 86400 * 30,
			'/'
		); // 86400 = 1 day
	}

	if ($choice == 'notok') {
		$cookie_name = 'thirty8_cookie_prefs';
		$cookie_value = 'notok';

		$tmp_cookie_prefs = setcookie(
			$cookie_name,
			$cookie_value,
			time() + 86400 * 30,
			'/'
		); // 86400 = 1 day
	}
}

if (isset($_GET['cookies'])) {
	if ($_GET['cookies'] === 'ok') {
		set_cookies('ok');
	} else {
		set_cookies('notok');
	}
}

// Enqueue stuff
function thirty8_enqueue_cookiescript()
{
	wp_register_script(
		'thirty8_cookies',
		WP_PLUGIN_URL . '/thirty8-analytics/js/cookies.js',
		['jquery']
	);
	wp_enqueue_script('thirty8_cookies');
}

add_action('init', 'thirty8_enqueue_cookiescript');

?>
