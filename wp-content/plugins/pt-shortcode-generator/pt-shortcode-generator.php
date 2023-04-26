<?php
/**
 * Plugin Name: The Little Box Office
 * Plugin URI:
 * Description: Shortcode generator plugin for The Little Box Office Events.
 * Version: 3.0.0
 * Author: The Little Box Office
 * Author URI:
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'PTSG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

include_once plugin_dir_path( __FILE__ ).'shortcodes.php';

function ptsg_admin_menu()
{
	add_menu_page('The Little Box Office', 'The Little Box Office', 'activate_plugins', 'ptsg-general-settings', 'ptsg_page_handler_general_settings');
    add_submenu_page( 'ptsg-general-settings', 'Single Event', 'Single Event', 'activate_plugins', 'ptsg-single-event', 'ptsg_page_handler_single_event');
    add_submenu_page( 'ptsg-general-settings', 'Tabbed Section', 'Tabbed Section', 'activate_plugins', 'ptsg-tabbed-contents', 'ptsg_page_handler_tabbed_contents');
    add_submenu_page( 'ptsg-general-settings', 'Tabbed Search Section', 'Tabbed Search Section', 'activate_plugins', 'ptsg-tabbed-search-contents', 'ptsg_page_handler_tabbed_search_contents');
	add_submenu_page( 'ptsg-general-settings', 'Calendar', 'Calendar', 'activate_plugins', 'ptsg-calendar', 'ptsg_page_handler_calendar');
	add_submenu_page( 'ptsg-general-settings', 'Slider', 'Slider', 'activate_plugins', 'ptsg-slider', 'ptsg_page_handler_slider');
}
add_action('admin_menu', 'ptsg_admin_menu');

function ptsg_page_handler_general_settings() {

	if( isset($_POST['submit']) ) {
		update_option( 'box_office_account_key', $_POST['box_office_account_key'] );
	}
	?>
    <div class="wrap">

        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>
            <?php _e('General Settings', 'ptsg')?>
        </h2>

        <form method="POST">
        	<table class="form-table">
                <tr>
                	<th scope="row"><label>Box Office Account</label></th>
                	<td><input type="text" name="box_office_account_key" class="regular-text" value="<?php echo get_option('box_office_account_key'); ?>" style="width:500px;"><br /><span style="font-size:13px; font-style:italic;">If your box office account is 'myaccount', enter https://thelittleboxoffice.com/myaccount/services/api_event/</span></td>
                </tr>
                <tr>
                	<th scope="row"></th>
                	<td><input type="submit" name="submit" class="button button-primary" value="Save Changes"></td>
                </tr>
            </table>
        </form>

    </div>
    <?php
}

function ptsg_page_handler_single_event() {

	$sc_identifier = 'tlbo_single_event';

	?>
    <script>
    	jQuery( document ).ready(function() {
			jQuery( "#btn_generate_shortocde" ).click(function() {
				var txt_shortcode = '[<?php echo $sc_identifier;?>';

				if(jQuery("#category").val() != '' ) {
					txt_shortcode += ' category="'+jQuery("#category").val()+'"';
				} else {
					txt_shortcode += ' category="0"';
				}

				if (jQuery('#btn_book_visible').is(":checked")) {
					txt_shortcode += ' btn_book_visible="true"';
				} else {
					txt_shortcode += ' btn_book_visible="false"';
				}

				if(jQuery("#btn_book_text").val() != '' ) {
					txt_shortcode += ' btn_book_text="'+jQuery("#btn_book_text").val()+'"';
				} else {
					txt_shortcode += ' btn_book_text="Book Tickets"';
				}

				if (jQuery('#btn_event_details_visible').is(":checked")) {
					txt_shortcode += ' btn_event_details_visible="true"';
				} else {
					txt_shortcode += ' btn_event_details_visible="false"';
				}

				if(jQuery("#btn_event_details_text").val() != '' ) {
					txt_shortcode += ' btn_event_details_text="'+jQuery("#btn_event_details_text").val() +'"';
				} else {
					txt_shortcode += ' btn_event_details_text="More Info"';
				}

				txt_shortcode += ']';

				jQuery('#txt_shortcode').html(txt_shortcode);
			});

		});
    </script>
    <div class="wrap">

        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>
            <?php _e('Single Event', 'ptsg')?>
        </h2>

        <form>
        	<table class="form-table">
                <tr>
                	<th scope="row"><label>Name</label></th>
                	<td><input type="text" name="name" value="<?php echo $sc_identifier; ?>" class="regular-text" readonly="readonly"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Category</label></th>
                	<td><input type="text" id="category" name="category" class="regular-text"><br /><span style="font-size:13px; font-style:italic; font-weight:400;">IDs of categories to include (comma separated); 0 to include all.</span></td>
                </tr>
                <tr>
                	<th colspan="2" scope="row"><label>Button: Book</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_book_visible" name="btn_book_visible" value="1" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_book_text" name="btn_book_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th colspan="2" scope="row"><label>Button: Event Details</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_event_details_visible" name="btn_event_details_visible" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_event_details_text" name="btn_event_details_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"></th>
                	<td><input type="button" id="btn_generate_shortocde" class="button button-primary" value="Generate Shortcode"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Copy Shortcode [/]:</label></th>
                	<td><strong><span id="txt_shortcode"></span></strong></td>
                </tr>
            </table>
        </form>

    </div>
    <?php
}

function ptsg_page_handler_calendar() {

	$sc_identifier = 'tlbo_calendar';

	?>
    <script>
    	jQuery( document ).ready(function() {
			jQuery( "#btn_generate_shortocde" ).click(function() {
				var txt_shortcode = '[<?php echo $sc_identifier;?>';

				if(jQuery("#categories").val() != '' ) {
					txt_shortcode += ' categories="'+jQuery("#categories").val()+'"';
				} else {
					txt_shortcode += ' categories="0"';
				}

				if(jQuery("#style").val() != '' ) {
					txt_shortcode += ' style="'+jQuery("#style").val()+'"';
				}

				if (jQuery('#btn_book_visible').is(":checked")) {
					txt_shortcode += ' btn_book_visible="true"';
				} else {
					txt_shortcode += ' btn_book_visible="false"';
				}

				if(jQuery("#btn_book_text").val() != '' ) {
					txt_shortcode += ' btn_book_text="'+jQuery("#btn_book_text").val()+'"';
				} else {
					txt_shortcode += ' btn_book_text="Book Tickets"';
				}

				if (jQuery('#btn_event_details_visible').is(":checked")) {
					txt_shortcode += ' btn_event_details_visible="true"';
				} else {
					txt_shortcode += ' btn_event_details_visible="false"';
				}

				if(jQuery("#btn_event_details_text").val() != '' ) {
					txt_shortcode += ' btn_event_details_text="'+jQuery("#btn_event_details_text").val() +'"';
				} else {
					txt_shortcode += ' btn_event_details_text="More Info"';
				}

				txt_shortcode += ']';

				jQuery('#txt_shortcode').html(txt_shortcode);
			});

		});
    </script>
    <div class="wrap">

        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>
            <?php _e('Calendar', 'ptsg')?>
        </h2>

        <form>
        	<table class="form-table">
                <tr>
                	<th scope="row"><label>Name</label></th>
                	<td><input type="text" name="name" value="<?php echo $sc_identifier; ?>" class="regular-text" readonly="readonly"></td>
                </tr>
                <!--<tr>
                	<th scope="row"><label>Categories</label></th>
                	<td><input type="text" id="categories" name="categories" class="regular-text"></td>
                </tr>-->
                <tr>
                	<th scope="row"><label>Style</label></th>
                	<td>
                    	<select id="style" name="style" class="regular-text">
                        	<option value="Days">Days</option>
                            <!--<option value="Months">Months</option>-->
                        </select>
                    </td>
                </tr>
                <tr>
                	<th colspan="2" scope="row"><label>Button: Book</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_book_visible" name="btn_book_visible" value="1" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_book_text" name="btn_book_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th colspan="2" scope="row"><label>Button: Event Details</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_event_details_visible" name="btn_event_details_visible" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_event_details_text" name="btn_event_details_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"></th>
                	<td><input type="button" id="btn_generate_shortocde" class="button button-primary" value="Generate Shortcode"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Copy Shortcode [/]:</label></th>
                	<td><strong><span id="txt_shortcode"></span></strong></td>
                </tr>
            </table>
        </form>

    </div>
    <?php
}

function ptsg_page_handler_slider() {

	$sc_identifier = 'tlbo_slider';

	?>
    <script>
    	jQuery( document ).ready(function() {
			jQuery( "#btn_generate_shortocde" ).click(function() {
				var txt_shortcode = '[<?php echo $sc_identifier;?>';

				if(jQuery("#categories").val() != '' ) {
					txt_shortcode += ' categories="'+jQuery("#categories").val()+'"';
				} else {
					txt_shortcode += ' categories="0"';
				}

				if(jQuery("#style").val() != '' ) {
					txt_shortcode += ' style="'+jQuery("#style").val()+'"';
				}

				if (jQuery('#btn_book_visible').is(":checked")) {
					txt_shortcode += ' btn_book_visible="true"';
				} else {
					txt_shortcode += ' btn_book_visible="false"';
				}

				if(jQuery("#btn_book_text").val() != '' ) {
					txt_shortcode += ' btn_book_text="'+jQuery("#btn_book_text").val()+'"';
				} else {
					txt_shortcode += ' btn_book_text="Book Tickets"';
				}

				if (jQuery('#btn_event_details_visible').is(":checked")) {
					txt_shortcode += ' btn_event_details_visible="true"';
				} else {
					txt_shortcode += ' btn_event_details_visible="false"';
				}

				if(jQuery("#btn_event_details_text").val() != '' ) {
					txt_shortcode += ' btn_event_details_text="'+jQuery("#btn_event_details_text").val() +'"';
				} else {
					txt_shortcode += ' btn_event_details_text="More Info"';
				}

				txt_shortcode += ']';

				jQuery('#txt_shortcode').html(txt_shortcode);
			});

		});
    </script>
    <div class="wrap">

        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>
            <?php _e('Slider', 'ptsg')?>
        </h2>

        <form>
        	<table class="form-table">
                <tr>
                	<th scope="row"><label>Name</label></th>
                	<td><input type="text" name="name" value="<?php echo $sc_identifier; ?>" class="regular-text" readonly="readonly"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Categories</label></th>
                	<td><input type="text" id="categories" name="categories" class="regular-text"><br /><span style="font-size:13px; font-style:italic; font-weight:400;">IDs of categories to include (comma separated); 0 to include all.</span></td>
                </tr>
                <tr>
                	<th scope="row"><label>Style</label></th>
                	<td>
                    	<select id="style" name="style" class="regular-text">
                        	<option value="Option 1">Option 1</option>
                        	<option value="Option 2">Option 2</option>
                        </select>
                    </td>
                </tr>
                <tr>
                	<th colspan="2" scope="row"><label>Button: Book</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_book_visible" name="btn_book_visible" value="1" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_book_text" name="btn_book_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th colspan="2" scope="row"><label>Button: Event Details</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_event_details_visible" name="btn_event_details_visible" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_event_details_text" name="btn_event_details_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"></th>
                	<td><input type="button" id="btn_generate_shortocde" class="button button-primary" value="Generate Shortcode"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Copy Shortcode [/]:</label></th>
                	<td><strong><span id="txt_shortcode"></span></strong></td>
                </tr>
            </table>
        </form>

    </div>
    <?php
}

function ptsg_page_handler_tabbed_contents() {

	$sc_identifier = 'tlbo_tabbed_contents';

	?>
    <script>
    	jQuery( document ).ready(function() {

			var counter = 0;
			jQuery( "#addrow" ).click(function() {
				var cols = '<tr>';
				cols += '<td><input type="text" name="titles[]" class="regular-text"></td></td>';
				cols += '<td><input type="text" name="categories[]" class="regular-text"></td>';
				cols += '<td><input type="button" class="ibtnDel button"  value="Delete"></td>';
				cols += '</tr>';

				jQuery( ".dynatable tbody" ).append(cols);

				counter++;
			});

			jQuery("table.dynatable").on("click", ".ibtnDel", function (event) {
				jQuery(this).closest("tr").remove();
				counter -= 1
			});

			jQuery( "#btn_generate_shortocde" ).click(function() {
				var txt_shortcode = '[<?php echo $sc_identifier;?>';

				var titles = $('input[name="titles[]"]').map(function(){
				  return this.value;
				}).get().join('|');

				if(titles != '' ) {
					txt_shortcode += ' titles="'+titles+'"';
				} else {
					txt_shortcode += ' titles=""';
				}

				var categories = $('input[name="categories[]"]').map(function(){
				  return this.value;
				}).get().join('|');

				if(categories != '' ) {
					txt_shortcode += ' categories="'+categories+'"';
				} else {
					txt_shortcode += ' categories=""';
				}

				if (jQuery('#btn_book_visible').is(":checked")) {
					txt_shortcode += ' btn_book_visible="true"';
				} else {
					txt_shortcode += ' btn_book_visible="false"';
				}

				if(jQuery("#btn_book_text").val() != '' ) {
					txt_shortcode += ' btn_book_text="'+jQuery("#btn_book_text").val()+'"';
				} else {
					txt_shortcode += ' btn_book_text="Book Tickets"';
				}

				if (jQuery('#btn_event_details_visible').is(":checked")) {
					txt_shortcode += ' btn_event_details_visible="true"';
				} else {
					txt_shortcode += ' btn_event_details_visible="false"';
				}

				if(jQuery("#btn_event_details_text").val() != '' ) {
					txt_shortcode += ' btn_event_details_text="'+jQuery("#btn_event_details_text").val() +'"';
				} else {
					txt_shortcode += ' btn_event_details_text="More Info"';
				}

				txt_shortcode += ']';

				jQuery('#txt_shortcode').html(txt_shortcode);
			});

		});
    </script>
    <style>
    	.dynatable { border:1px solid #ccc; margin-bottom:10px; }
		.dynatable th { padding:15px 10px; background-color: #d9d9d9; border:1px solid #f9eaea; }
		.dynatable td { border:1px solid #ccc; }
		.dynatable .ibtnDel { background-color:#d9534f; color:#fff;}
    </style>
    <div class="wrap">

        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>
            <?php _e('Tabbed Section', 'ptsg')?>
        </h2>

        <form>
        	<table class="form-table">
                <tr>
                	<th scope="row"><label>Name</label></th>
                	<td><input type="text" name="name" value="<?php echo $sc_identifier; ?>" class="regular-text" readonly="readonly"></td>
                </tr>
                <tr>
                	<td colspan="2" cellpadding="0" cellspaing="0">
                		<table class="dynatable" style="border:1px solid #ccc">
                        	<thead>
                            	<tr>
                                    <th>Title</th>
                                    <th>Categories<br /><span style="font-size:13px; font-style:italic; font-weight:400;">IDs of categories to include (comma separated); 0 to include all. IDs are found in your box office account.</span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        	<tbody>
                                <tr>
                                    <td><input type="text" name="titles[]" class="regular-text"></td>
                                    <td><input type="text" name="categories[]" class="regular-text"></td>
                                    <td><input type="button" class="ibtnDel button"  value="Delete"></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="button" class="button button-primary " id="addrow" value="+ Add Row" />
                    </td>
                </tr>

                <tr>
                	<th colspan="2" scope="row"><label>Button: Book</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_book_visible" name="btn_book_visible" value="1" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_book_text" name="btn_book_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th colspan="2" scope="row"><label>Button: Event Details</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_event_details_visible" name="btn_event_details_visible" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_event_details_text" name="btn_event_details_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"></th>
                	<td><input type="button" id="btn_generate_shortocde" class="button button-primary" value="Generate Shortcode"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Copy Shortcode [/]:</label></th>
                	<td><strong><span id="txt_shortcode"></span></strong></td>
                </tr>
            </table>
        </form>

    </div>

    <!-- Bootstrap & Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

    <script type="text/javascript">
      $('.dynatable tbody').sortable();
    </script>

    <?php
}

function ptsg_page_handler_tabbed_search_contents() {

	$sc_identifier = 'tlbo_tabbed_search_contents';

	?>
    <script>
    	jQuery( document ).ready(function() {

			var counter = 0;
			jQuery( "#addrow" ).click(function() {
				var cols = '<tr>';
				cols += '<td><input type="text" name="titles[]" class="regular-text"></td></td>';
				cols += '<td><input type="text" name="categories[]" class="regular-text"></td>';
				cols += '<td><input type="button" class="ibtnDel button"  value="Delete"></td>';
				cols += '</tr>';

				jQuery( ".dynatable tbody" ).append(cols);

				counter++;
			});

			jQuery("table.dynatable").on("click", ".ibtnDel", function (event) {
				jQuery(this).closest("tr").remove();
				counter -= 1
			});

			jQuery( "#btn_generate_shortocde" ).click(function() {
				var txt_shortcode = '[<?php echo $sc_identifier;?>';

				var titles = $('input[name="titles[]"]').map(function(){
				  return this.value;
				}).get().join('|');

				if(titles != '' ) {
					txt_shortcode += ' titles="'+titles+'"';
				} else {
					txt_shortcode += ' titles=""';
				}

				var categories = $('input[name="categories[]"]').map(function(){
				  return this.value;
				}).get().join('|');

				if(categories != '' ) {
					txt_shortcode += ' categories="'+categories+'"';
				} else {
					txt_shortcode += ' categories=""';
				}

				if (jQuery('#btn_book_visible').is(":checked")) {
					txt_shortcode += ' btn_book_visible="true"';
				} else {
					txt_shortcode += ' btn_book_visible="false"';
				}

				if(jQuery("#btn_book_text").val() != '' ) {
					txt_shortcode += ' btn_book_text="'+jQuery("#btn_book_text").val()+'"';
				} else {
					txt_shortcode += ' btn_book_text="Book Tickets"';
				}

				if (jQuery('#btn_event_details_visible').is(":checked")) {
					txt_shortcode += ' btn_event_details_visible="true"';
				} else {
					txt_shortcode += ' btn_event_details_visible="false"';
				}

				if(jQuery("#btn_event_details_text").val() != '' ) {
					txt_shortcode += ' btn_event_details_text="'+jQuery("#btn_event_details_text").val() +'"';
				} else {
					txt_shortcode += ' btn_event_details_text="More Info"';
				}

				txt_shortcode += ']';

				jQuery('#txt_shortcode').html(txt_shortcode);
			});

		});
    </script>
    <style>
    	.dynatable { border:1px solid #ccc; margin-bottom:10px; }
		.dynatable th { padding:15px 10px; background-color: #d9d9d9; border:1px solid #f9eaea; }
		.dynatable td { border:1px solid #ccc; }
		.dynatable .ibtnDel { background-color:#d9534f; color:#fff;}
    </style>
    <div class="wrap">

        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>
            <?php _e('Tabbed Section', 'ptsg')?>
        </h2>

        <form>
        	<table class="form-table">
                <tr>
                	<th scope="row"><label>Name</label></th>
                	<td><input type="text" name="name" value="<?php echo $sc_identifier; ?>" class="regular-text" readonly="readonly"></td>
                </tr>
                <tr>
                	<td colspan="2" cellpadding="0" cellspaing="0">
                		<table class="dynatable" style="border:1px solid #ccc">
                        	<thead>
                            	<tr>
                                    <th>Title</th>
                                    <th>Categories<br /><span style="font-size:13px; font-style:italic; font-weight:400;">IDs of categories to include (comma separated); 0 to include all. IDs are found in your box office account.</span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        	<tbody>
                                <tr>
                                    <td><input type="text" name="titles[]" class="regular-text"></td>
                                    <td><input type="text" name="categories[]" class="regular-text"></td>
                                    <td><input type="button" class="ibtnDel button"  value="Delete"></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="button" class="button button-primary " id="addrow" value="+ Add Row" />
                    </td>
                </tr>

                <tr>
                	<th colspan="2" scope="row"><label>Button: Book</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_book_visible" name="btn_book_visible" value="1" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_book_text" name="btn_book_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th colspan="2" scope="row"><label>Button: Event Details</label></th>
                </tr>
                <tr>
                	<th scope="row"><label>Visible</label></th>
                	<td><input type="checkbox" id="btn_event_details_visible" name="btn_event_details_visible" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Button Text</label></th>
                	<td><input type="text" id="btn_event_details_text" name="btn_event_details_text" class="regular-text"></td>
                </tr>
                <tr>
                	<th scope="row"></th>
                	<td><input type="button" id="btn_generate_shortocde" class="button button-primary" value="Generate Shortcode"></td>
                </tr>
                <tr>
                	<th scope="row"><label>Copy Shortcode [/]:</label></th>
                	<td><strong><span id="txt_shortcode"></span></strong></td>
                </tr>
            </table>
        </form>

    </div>

    <!-- Bootstrap & Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

    <script type="text/javascript">
      $('.dynatable tbody').sortable();
    </script>

    <?php
}
