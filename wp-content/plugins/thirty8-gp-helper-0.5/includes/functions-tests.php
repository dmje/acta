<?php

// Various tests...

// Hide ACF menu if you need
//add_filter('acf/settings/show_admin', '__return_false');

/**
 * Restrict access to the locking UI to Administrators.
 * 
 * @param array $settings Default editor settings.
 * @param WP_Block_Editor_Context $context The current block editor context.
 */
function example_theme_restrict_locking_ui( $settings, $context ) {
    $settings[ 'canLockBlocks' ] = current_user_can( 'activate_plugins' );

	return $settings;
}
add_filter( 'block_editor_settings_all', 'example_theme_restrict_locking_ui', 10, 2 );




// GeneratePress theme options
global $theme_colors;
$theme_colors = get_option( 'generate_settings' );


// Customised login screen

function thirty8_gp_login_logo()
{
	// Get site URL from GP
	// Got this code from generate_construct_logo in GP header.php
		
		$thirty8_gp_logourl = ( function_exists( 'the_custom_logo' ) && get_theme_mod( 'custom_logo' ) ) ? wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ) : false;
		$thirty8_gp_logourl = ( $thirty8_gp_logourl ) ? $thirty8_gp_logourl[0] : generate_get_option( 'logo' );

		$thirty8_gp_logourl = esc_url( apply_filters( 'generate_logo', $thirty8_gp_logourl ) );
			
	
?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url('<?php echo $thirty8_gp_logourl;?>');
            padding-bottom: 30px;
        }
    </style>
<?php
}
add_action('login_enqueue_scripts', 'thirty8_gp_login_logo');



// Block patterns on creation of new page

function myplugin_register_template() {
    $post_type_object = get_post_type_object( 'page' );
    $post_type_object->template = array(
        array( 'core/image' ),
    );
}
add_action( 'init', 'myplugin_register_template' );


// Testing locked block patterns
// from https://make.wordpress.org/core/2022/02/09/core-editor-improvement-curated-experiences-with-locking-apis-theme-json/
// pattern from https://gist.github.com/annezazu/acee30f8b6e8995e1b1a52796e6ef805

function locking_block_patterns() {

	if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {

                $content = '<!-- wp:cover {"dimRatio":70,"customGradient":"linear-gradient(135deg,rgb(255,255,255) 20%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(253,253,253) 80%)","isDark":false,"align":"full","lock":{"remove":false,"move":true}} -->
<div class="wp-block-cover alignfull is-light"><span aria-hidden="true" class="has-background-dim-70 wp-block-cover__gradient-background has-background-dim has-background-gradient" style="background:linear-gradient(135deg,rgb(255,255,255) 20%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(253,253,253) 80%)"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","style":{"typography":{"lineHeight":"1.2"}},"textColor":"grey","lock":{"remove":true,"move":true}} -->
<h2 class="has-text-align-center has-grey-color has-text-color" id="book-your-next-adventure" style="line-height:1.2">Book your next adventure</h2>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"},"lock":{"remove":true,"move":false}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"border":{"radius":"10px"}},"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-white-color has-text-color" href="#0" style="border-radius:10px">Find yours</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontStyle":"italic","fontWeight":"200"}},"textColor":"grey","lock":{"remove":false,"move":true}} -->
<p class="has-text-align-center has-grey-color has-text-color" style="font-style:italic;font-weight:200">Create moments you will remember forever</p>
<!-- /wp:paragraph -->
<!-- /wp:cover -->';

		register_block_pattern(
			'custompattern/call-to-action-adventure',
			array(
				'title'         => __( 'Call to Adventure', 'textdomain' ),
				'description'   => _x( 'A call to adventure.', 'Block pattern description', 'textdomain' ),
				'content'       => trim($content),
				'categories'    => array( 'buttons' ),
				'keywords'      => array( 'cta' ),
                                'viewportWidth' => 1400,
                                'blockTypes'    => array( 'core/buttons' ),
			)
		);

	}

}
add_action( 'init', 'locking_block_patterns' );

// This is really weird
// see https://make.wordpress.org/core/2022/05/03/page-creation-patterns-in-wordpress-6-0/
// basically should give us a modal - which it does but seemingly at random	
// Right, this WORKS but not when you use the new page function in Nested Pages... :-/

function test_register() {
	register_block_pattern(
    	'my-plugin/about-page',
    	array(
        	'title'      => __( 'About page', 'my-plugin' ),
        	'blockTypes' => array( 'core/post-content' ),
        	'content'    => '<!-- wp:paragraph {"backgroundColor":"black","textColor":"white"} -->
        	<p class="has-white-color has-black-background-color has-text-color has-background">Write you about page here, feel free to use any block</p>
        	<!-- /wp:paragraph -->',
    	)
	);
}

add_action( 'init', 'test_register' );



?>