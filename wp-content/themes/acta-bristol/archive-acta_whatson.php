<?php
/**
 * The template for displaying Archive pages.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
	exit(); // Exit if accessed directly.
}

get_header();
?>

	<div <?php generate_do_attr('content'); ?>>
		<main <?php generate_do_attr('main'); ?>>
			<?php
   /**
    * generate_before_main_content hook.
    *
    * @since 0.1
    */
   do_action('generate_before_main_content');

   if (generate_has_default_loop()) {
   	if (have_posts()):
   		/**
   		 * generate_archive_title hook.
   		 *
   		 * @since 0.1
   		 *
   		 * @hooked generate_archive_title - 10
   		 */
   		do_action('generate_archive_title');

   		/**
   		 * generate_before_loop hook.
   		 *
   		 * @since 3.1.0
   		 */
   		do_action('generate_before_loop', 'archive');

   		// The Loop

   		echo '<div class="whatson-container">';

   		// Get present and future events ----------------------------
   		$today = date('Ymd');

   		echo '<div class="whatson-present">';

   		echo '<h2>Current Productions</h2>';

   		// Set up the query arguments
   		$args = [
   			'post_type' => 'acta_whatson',
   			'meta_query' => [
   				[
   					'key' => 'end_date',
   					'value' => $today,
   					'compare' => '>=',
   					'type' => 'DATE',
   				],
   			],
   		];

   		// Run the query
   		$query = new WP_Query($args);

   		// Check if there are any posts
   		if ($query->have_posts()) {
   			// Loop through the posts
   			while ($query->have_posts()) {
   				$query->the_post();
   				// Display the post content
   				get_template_part('partials/acta_whatson', 'archive');
   			}
   		}

   		// Reset the post data
   		wp_reset_postdata();

   		echo '</div>';

   		// Get past events ----------------------------
   		$today = date('Ymd');

   		echo '<div class="whatson-past">';

   		echo '<h2>Previous Productions</h2>';

   		// Set up the query arguments
   		$args = [
   			'post_type' => 'acta_whatson',
   			'meta_query' => [
   				[
   					'key' => 'end_date',
   					'value' => $today,
   					'compare' => '<',
   					'type' => 'DATE',
   				],
   			],
   		];

   		// Run the query
   		$query = new WP_Query($args);

   		// Check if there are any posts
   		if ($query->have_posts()) {
   			// Loop through the posts
   			while ($query->have_posts()) {
   				$query->the_post();
   				// Display the post content
   				get_template_part('partials/acta_whatson', 'archive');
   			}
   		}

   		// Reset the post data
   		wp_reset_postdata();

   		echo '</div>';

   		echo '</div>'; //container

   		do_action('generate_after_loop', 'archive');
   	else:
   		generate_do_template_part('none');
   	endif;
   }

   /**
    * generate_after_main_content hook.
    *
    * @since 0.1
    */
   do_action('generate_after_main_content');
   ?>
		</main>
	</div>

	<?php
 /**
  * generate_after_primary_content_area hook.
  *
  * @since 2.0
  */
 do_action('generate_after_primary_content_area');

 generate_construct_sidebars();

 get_footer();

