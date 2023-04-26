<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Style for frontpage
add_action( 'wp_enqueue_scripts', 'lottery_add_styles_and_scripts' );
function lottery_add_styles_and_scripts() {
	wp_enqueue_style( 'pt_sc_generator_front_styles', PTSG_PLUGIN_URL . 'css/front.css' );
}
// End - Style for frontpage


// List Services With Voucher Textbox
function srtcd_tlbo_single_event_handler($attr) {
	if( is_admin() ) {
		return;
	}

	ob_start();
	?>
    <script>
		window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"><\/script>');
	</script>

    <div class="single_event single_evt_detail uid_single_event_<?php echo $attr['category']; ?>">
    </div>

    <script>
    jQuery(document).ready(function() {

		function princessLoadEventsData_sngevtcnt() {

			// ajax the request
			jQuery.ajax({
				dataType: 'json',
				url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
				data : {action: "get_single_events", attr: '<?php echo json_encode($attr);?>' },
				success: function(data) {
					events_data = data;

					princessRender_sngevtcnt(jQuery('.uid_single_event_<?php echo $attr['category']; ?>'), '<?php echo $attr['category']; ?>');
				}
			});
		}

		function princessRender_sngevtcnt(element, category) {

			var data = [];
			var html = '';

			if (category > 0) {
				data = [];
				for (var i = 0; i < events_data.length; i++) {
					var found = false;
					if (events_data[i].categories !== undefined) {
						for (var y = 0; y < events_data[i].categories.length; y++) {
							if (events_data[i].categories[y] == category) {
								found = true;
								break;
							}
						}
					}
					if (found == true) {
						data.push(events_data[i]);
						break;
					}
				}
			}
			else {
				data = events_data;
			}

			jQuery(data).each(function(index, value) {
				html = princessTemplate_sngevtcnt(value);
				jQuery(element).append(html);
			});

		}

		function princessTemplate_sngevtcnt(item) {

			var image = '';

			if (item.image_cache != '') {
				image = item.image_cache_large;
			}

			var template = '<div class="new-box">';
				template += '<div class="image-container">';
					template += '<!--image-->';
				template += '</div>';
				template += '<div class="film-info-wrap">';
					template += '<div class="film-info">';
						template += '<h3><!--title--></h3>';
						template += '<h4><!--teaser--></h4>';
					template += '</div>';
					template += '<div class="book-tkt">';
						<?php if($attr['btn_event_details_visible'] === 'true') { ?>
						template += '<a class="bk-tkt" href="https://thelittleboxoffice.com/acta/event/view/<!--id-->" target="_blank" class="more-info"><strong><?php echo $attr['btn_event_details_text']; ?></strong></a>';
						<?php } ?>
						<?php if($attr['btn_book_visible'] === 'true') { ?>
						template += '<a class="bk-tkt" href="https://thelittleboxoffice.com/acta/book/event/<!--id-->" target="_blank" class="book-tickets"><strong><?php echo $attr['btn_book_text']; ?></strong></a>';
						<?php } ?>
					template += '</div>';
				template += '</div>';
			template += '</div>';

			template = template.replace(/<!--id-->/g, item.id);
			template = template.replace("<!--title-->", item.title);
			template = template.replace("<!--teaser-->", item.teaser);
			template = template.replace("<!--image-->", image);

			return template;
		}

		princessLoadEventsData_sngevtcnt();

	});
    </script>

   	<?php
	return ob_get_clean();
}

add_action("wp_ajax_get_single_events", "get_single_events");
add_action("wp_ajax_nopriv_get_single_events", "get_single_events");

function get_single_events() {

	global $wpdb;

	$json_url = get_option('box_office_account_key').'/getEvents/';
	//$result = file_get_contents($json_url);


    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $json_url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl_handle);
    curl_close($curl_handle);


	echo $result;
	die();
}
add_shortcode('tlbo_single_event', 'srtcd_tlbo_single_event_handler');

function srtcd_tlbo_tabbed_contents_handler($attr) {
	if( is_admin() ) {
		return;
	}

	ob_start();
	?>
    <script>
		window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"><\/script>');
	</script>
    <script>
	jQuery( document ).ready(function() {
		jQuery( ".tabbed_link" ).click(function() {
			var id = jQuery(this).attr('data-id');

			jQuery('.bookinglist_tab_label').removeClass('Active');
			jQuery('#bookinglist_tab_label_'+id).addClass('Active');

			jQuery('.tc_BookingListBottom').css('display', 'none');
			jQuery('#tc_bookinglist_tab_content_'+id).css('display', 'block');
		});
	});
	</script>

    <div class="tabbed_wrapper">
    	<ul class="tabbed_menu_labels">
        	<?php
            $titles = explode("|", $attr['titles']);

            $k = 0;
            foreach($titles as $title) {
                ?>
                <li class="bookinglist_tab_label <?php if($k==0){?>Active<?php }?>" id="bookinglist_tab_label_<?php echo $k; ?>">
                    <a class="tabbed_link" data-id="<?php echo $k; ?>" style="cursor:pointer;"><?php echo $title; ?></a>
                </li>
                <?php
                $k = $k + 1;
            }
            ?>
        </ul>
        <div class="tabbed_menu_conetents">
			<?php
            $titles = explode("|", $attr['titles']);

            $k = 0;
            foreach($titles as $title) {
                ?>
                <div class="tc_BookingListBottom" id="tc_bookinglist_tab_content_<?php echo $k;?>" <?php if($k!=0){?>style="display:none;"<?php }?>>
                    <div class="tc_BookingListCenter">
                    </div>
                </div>
            	<?php
				$k = $k + 1;
			}
			?>
    	</div>
    </div>

    <script>
    jQuery(document).ready(function() {

		function princessLoadEventsData_tbdcnt() {

			// ajax the request
			jQuery.ajax({
				dataType: 'json',
				url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
				data : {action: "get_tabbed_events", attr: '<?php echo json_encode($attr);?>' },
				success: function(data) {
					events_data = data;

					var params_sc_categories = '<?php echo $attr['categories']; ?>';
					var sc_categories = params_sc_categories.split('|');
					for(var i = 0; i < sc_categories.length; i++)
					{
					   princessRender_tbdcnt(jQuery('#tc_bookinglist_tab_content_'+i+' .tc_BookingListCenter'), sc_categories[i]);
					}
				}
			});
		}

		function princessRender_tbdcnt(element, category) {

			var data = [];
			var html = '';

			if (category > 0) {
				data = [];
				for (var i = 0; i < events_data.length; i++) {
					var found = false;
					if (events_data[i].categories !== undefined) {
						for (var y = 0; y < events_data[i].categories.length; y++) {
							if (events_data[i].categories[y] == category) {
								found = true;
								break;
							}
						}
					}
					if (found == true) {
						data.push(events_data[i]);
					}
				}
			}
			else {
				data = events_data;
			}

			jQuery(data).each(function(index, value) {
				html = princessTemplate_tbdcnt(value);
				jQuery(element).append(html);
			});

		}

		function princessTemplate_tbdcnt(item) {

			var image = '';

			if (item.image_cache != '') {
				image = item.image_cache_large;
			}

			var template = '<div class="tc_ListBox">';
				template += '<div class="tc_ListBoxPhoto"><!--image--></div>';
				template += '<div class="tc_ListBoxText">';
					template += '<h1><!--title--></h1>';
					template += '<div class="tc_ListParabox">';
					template += '<p><!--teaser--></p>';
						template += '<div class="tc_MoreInfoBTN">';
							<?php if($attr['btn_event_details_visible'] === 'true') { ?>
							template += '<a href="https://thelittleboxoffice.com/thespirekingston/event/view/<!--id-->" target="_blank" class="more-info"><?php echo $attr['btn_event_details_text']; ?></a>';
							<?php } ?>
							<?php if($attr['btn_book_visible'] === 'true') { ?>
							template += '<a href="https://thelittleboxoffice.com/thespirekingston/book/event/<!--id-->" target="_blank" class="book-tickets"><?php echo $attr['btn_book_text']; ?></a>';
							<?php } ?>
						template += '</div>';
					template += '</div>';
				template += '</div>';
				template += '<div class="Clear"></div>';
			template += '</div>';


			template = template.replace(/<!--id-->/g, item.id);
			template = template.replace("<!--title-->", item.title);
			template = template.replace("<!--teaser-->", item.teaser);
			template = template.replace("<!--image-->", image);

			return template;
		}

		princessLoadEventsData_tbdcnt();

	});
    </script>

   	<?php
	return ob_get_clean();
}

add_action("wp_ajax_get_tabbed_events", "get_tabbed_events");
add_action("wp_ajax_nopriv_get_tabbed_events", "get_tabbed_events");

function get_tabbed_events() {

	global $wpdb;

	$json_url = get_option('box_office_account_key').'/getEvents/';
	//$result = file_get_contents($json_url);

	$curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $json_url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl_handle);
    curl_close($curl_handle);

	echo $result;
	die();
}

add_shortcode('tlbo_tabbed_contents', 'srtcd_tlbo_tabbed_contents_handler');

function srtcd_tlbo_slider_handler($attr) {
	if( is_admin() ) {
		return;
	}

	ob_start();

	if( $attr['style'] == 'Option 1' ) {
		?>
        <script>
			window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"><\/script>');
		</script>
        <script type="text/javascript" src="<?php echo PTSG_PLUGIN_URL; ?>/js/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo PTSG_PLUGIN_URL; ?>/js/jquery.carousel_001.min.js"></script>
		<script type="text/javascript" src="<?php echo PTSG_PLUGIN_URL; ?>/js/jquery.secondary-carousel.min.js"></script>

        <div class="slider_banner">
			<div id="primary_carousel_sc_handler" class="carousel carousel-type-full" style="float: left; overflow: visible;">
				<div class="carousel-wrapper">
					<ul>
                    </ul>
                </div>
            </div>
        </div>

        <script>
		jQuery(document).ready(function() {

			function princessLoadEventsData_slidercnt() {

				// ajax the request
				jQuery.ajax({
					dataType: 'json',
					url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					data : {action: "get_slider_events", attr: '<?php echo json_encode($attr);?>' },
					success: function(data) {
						events_data = data;

						princessRender_slidercnt(jQuery('#primary_carousel_sc_handler ul'), '<?php echo $attr['categories']; ?>');
						jQuery('#primary_carousel_sc_handler').carousel( { auto: true, delay: 4000, duration: 800 } );
					}
				});
			}

			function princessRender_slidercnt(element, category) {

				var data = [];
				var html = '';

				if (category > 0) {
					data = [];
					for (var i = 0; i < events_data.length; i++) {
						var found = false;
						if (events_data[i].categories !== undefined) {
							for (var y = 0; y < events_data[i].categories.length; y++) {
								if (events_data[i].categories[y] == category) {
									found = true;
									break;
								}
							}
						}
						if (found == true) {
							data.push(events_data[i]);
						}
					}
				}
				else {
					data = events_data;
				}

				jQuery(data).each(function(index, value) {
					html = princessTemplate_slidercnt(value);
					jQuery(element).append(html);
				});

				jQuery('#primary_carousel_sc_handler ul li').first().addClass('carousel-first-visible');
				jQuery('#primary_carousel_sc_handler ul li:nth-child(2)').first().addClass('active');

			}

			function princessTemplate_slidercnt(item) {

				var image = '';

				if (item.image_cache != '') {
					image = item.image_cache_large;
				}

				var template = '<li class="">';
					template += '<!--image-->';
					template += '<div class="BannerCenterText">';
						template += '<h1><!--title--></h1>';
						template += '<!--teaser-->';
						template += '<div class="MoreBTN">';
							<?php if($attr['btn_event_details_visible'] === 'true') { ?>
							template += '<a href="https://thelittleboxoffice.com/thespirekingston/event/view/<!--id-->" target="_blank" class="more-info"><?php echo $attr['btn_event_details_text']; ?></a>';
							<?php } ?>
							<?php if($attr['btn_book_visible'] === 'true') { ?>
							template += '<a href="https://thelittleboxoffice.com/thespirekingston/book/event/<!--id-->" target="_blank" class="book-tickets"><?php echo $attr['btn_book_text']; ?></a>';
							<?php } ?>
						template += '</div>';
					template += '<div class="overlay left"></div>';
				template += '</li>';

				template = template.replace(/<!--id-->/g, item.id);
				template = template.replace("<!--title-->", item.title);
				template = template.replace("<!--teaser-->", item.teaser);
				template = template.replace("<!--image-->", image);

				return template;
			}

			princessLoadEventsData_slidercnt();

		});
		</script>
        <?php
	}
	else if( $attr['style'] == 'Option 2' ) {
		?>
        <script>
			window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"><\/script>');
		</script>
        <link rel="stylesheet" type="text/css" href="<?php echo PTSG_PLUGIN_URL; ?>/css/slick.css" />
		<script type="text/javascript" src="<?php echo PTSG_PLUGIN_URL; ?>/js/slick.min.js"></script>

        <div class="BookingListCenter slideropt_2">
        </div>

        <script>
		jQuery(document).ready(function() {

			function princessLoadEventsData_slidercnt() {

				// ajax the request
				jQuery.ajax({
					dataType: 'json',
					url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					data : {action: "get_slider_events", attr: '<?php echo json_encode($attr);?>' },
					success: function(data) {
						events_data = data;

						princessRender_slidercnt(jQuery('.slideropt_2'), '<?php echo $attr['categories']; ?>');
						jQuery('.slideropt_2').slick({dots: false});
					}
				});
			}

			function princessRender_slidercnt(element, category) {

				var data = [];
				var html = '';

				if (category > 0 || category != '' ) {
					var categories_data = category.split(",");

					data = [];
					for (var i = 0; i < events_data.length; i++) {
						var found = false;
						if (events_data[i].categories !== undefined) {
							for (var y = 0; y < events_data[i].categories.length; y++) {
								if ( categories_data.indexOf(events_data[i].categories[y]) >= 0) {
									found = true;
									break;
								}
							}
						}
						if (found == true) {
							data.push(events_data[i]);
						}
					}
				}
				else {
					data = events_data;
				}

				jQuery(data).each(function(index, value) {
					html = princessTemplate_slidercnt(value);
					jQuery(element).append(html);
				});

			}

			function princessTemplate_slidercnt(item) {

				var image = '';

				if (item.image_cache != '') {
					image = item.image_cache_large;
				}

				var template = '<div class="ListBox">';
						template += '<div class="ListBoxPhoto"><!--image--></div>';
						template += '<div class="ListBoxText">';
						  template += '<h1><!--title--></h1>';
						  template += '<div class="ListParabox">';
							template += '<div class="MoreInfoBTN">';
								<?php if($attr['btn_event_details_visible'] === 'true') { ?>
								template += '<a href="https://thelittleboxoffice.com/thespirekingston/event/view/<!--id-->" target="_blank" class="more-info"><?php echo $attr['btn_event_details_text']; ?></a>';
								<?php } ?>
								<?php if($attr['btn_book_visible'] === 'true') { ?>
								template += '<a href="https://thelittleboxoffice.com/thespirekingston/book/event/<!--id-->" target="_blank" class="book-tickets"><?php echo $attr['btn_book_text']; ?></a>';
								<?php } ?>
							template += '</div>';
							template += '<p><!--teaser--></p>';
						  template += '</div>';
						template += '</div>';
						template += '<div class="Clear"></div>';
					template += '</div>';

				template = template.replace(/<!--id-->/g, item.id);
				template = template.replace("<!--title-->", item.title);
				template = template.replace("<!--teaser-->", item.teaser);
				template = template.replace("<!--image-->", image);

				return template;
			}

			princessLoadEventsData_slidercnt();

		});
		</script>
        <?php
	}

    return ob_get_clean();
}
add_action("wp_ajax_get_slider_events", "get_slider_events");
add_action("wp_ajax_nopriv_get_slider_events", "get_slider_events");

function get_slider_events() {

	global $wpdb;

	$json_url = get_option('box_office_account_key').'/getEvents/';
	//$result = file_get_contents($json_url);


	$curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $json_url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl_handle);
    curl_close($curl_handle);

	echo $result;
	die();
}
add_shortcode('tlbo_slider', 'srtcd_tlbo_slider_handler');

function srtcd_tlbo_calendar_handler($attr) {
	if( is_admin() ) {
		return;
	}

	ob_start();
	?>
	<script>
		window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"><\/script>');
	</script>
    <link rel="stylesheet" href="<?php echo PTSG_PLUGIN_URL; ?>/css/jsDatePick_ltr.min.css">
    <script src="<?php echo PTSG_PLUGIN_URL; ?>/js/jsDatePick.min.1.3.js"></script>
    <div class="WhatWhen">
        <h1>What<span>'</span>s On When<span>...</span></h1>
        <div class="Calendar">
          <div id="days_calendar">
            <!--Calendar Popup -->
            <div class="CalendarPopup_days" id="CalendarPopup_days" style="display:none;">
              <div class="CalendarPopupCloseBTN"><img src="<?php echo PTSG_PLUGIN_URL; ?>/images/popup-close-btn.gif" border="0" align="Close" title="Close" style="cursor:pointer;" class="closediv_1" /></div>
              <div class="Performances"> </div>
            </div>
            <!--Calendar Popup END -->
          </div>
        </div>
    </div>
    <script>
	jQuery(document).ready(function() {

		var g_globalObject_1;
		var calendar_data_1 = [];

		function princessSetupCalendar_1() {

			g_globalObject_1 = new JsDatePick({
				useMode:1,
				isStripped:true,
				target:"days_calendar"
			});

			g_globalObject_1.setOnSelectedDelegate(function(element){

				// clear previous
				jQuery('.CalendarPopup_days .Performances').html('');

				var day_performances = [];
				var current_day = pad_1(g_globalObject_1.getSelectedDay().day.toString(), 2, '0', STR_PAD_LEFT);
				var current_year = pad_1(g_globalObject_1.currentYear.toString(), 2, '0', STR_PAD_LEFT);

				var current_month = pad_1(g_globalObject_1.currentMonth.toString(), 2, '0', STR_PAD_LEFT);
				var current_date = current_year + '-' + current_month + '-' + current_day;

				for (var i = 0; i < calendar_data_1.length; i++) {

					if (current_date == calendar_data_1[i].start_date) {
						day_performances.push(calendar_data_1[i]);
					}
				}

				if (day_performances.length > 0) {
					princessPopulateCalPopup_1(day_performances, element);
				} else {
					closediv_1();
				}
			});

			princessPopulateCalendar_1();

			g_globalObject_1.setRepopulationDelegate(function(){
				princessPopulateCalendar_1();
			});
		}

		jQuery(document).on("click", '.closediv_1', function(event) {
			jQuery('.CalendarPopup_days').css('display', 'none');
		});

		function princessPopulateCalPopup_1(dayPerformances, parentElement) {

			// set the element
			var element = jQuery('.CalendarPopup_days .Performances');
			var element_html = '';

			// clear previous
			element.html('');

			for (var i = 0; i < dayPerformances.length; i++) {
				element_html = princessRenderPopupItem_1(dayPerformances[i]);
				element.append(element_html);
			}

			var pos = jQuery(parentElement).position();

			var left = pos.left - 445;
			var top = pos.top - 7;

			jQuery('.CalendarPopup_days').css('left', left+ "px");
			jQuery('.CalendarPopup_days').css('top', top + "px");
			jQuery('.CalendarPopup_days').css('display', 'block');

		}

		function princessRenderPopupItem_1(data) {

			var template = '<div>';
					template += '<div class="CalendarPopupPhoto"><!--image--></div>';
					template += '<div class="CalendarPopupText">';
						template += '<h1><!--title--></h1>';
						template += '<!--start_date_formatted-->';
						template += '<div class="CalendarPopupMoreBTN">';
							<?php if($attr['btn_event_details_visible'] === 'true') { ?>
							template += '<a href="https://thelittleboxoffice.com/thespirekingston/event/view/<!--parent_event_id-->" target="_blank" class="more-info"><?php echo $attr['btn_event_details_text']; ?></a>';
							<?php } ?>
							<?php if($attr['btn_book_visible'] === 'true') { ?>
							template += '<a href="https://thelittleboxoffice.com/princess/book/event/<!--parent_event_id-->" target="_blank" class="book-tickets"><?php echo $attr['btn_book_text']; ?></a>';
							<?php } ?>
						template += '</div>';
					template += '</div>';
				template += '</div>';

			//template = template.replace("<!--parent_event_id-->", data.parent_event_id);
			//template = template.replace("<!--parent_event_id-->", data.parent_event_id);
			template = template.replace(/<!--parent_event_id-->/g, data.parent_event_id);
			template = template.replace("<!--title-->", data.event_title);
			template = template.replace("<!--image-->", data.image_cache_small);
			template = template.replace("<!--start_date_formatted-->", data.start_date_formatted);
			return template;
		}

		function princessPopulateCalendar_1() {

			var current_year = g_globalObject_1.currentYear;
			var current_month = g_globalObject_1.currentMonth;

			// ajax the request
			jQuery.ajax({
				 dataType : "json",
				 url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
				 data : {action: "get_calendar_events", month:current_month, year:current_year, attr: '<?php echo json_encode($attr);?>' },
				 success: function(data) {
					calendar_data_1 = data;
					princessHighlightCalendar_1();
				 }
			  })
		}

		function princessHighlightCalendar_1() {

			jQuery('.JsDatePickBox .dayNormal').removeClass('hasContent');

			var current_day = null;
			var current_date = null;
			var current_year = pad_1(g_globalObject_1.currentYear.toString(), 2, '0', STR_PAD_LEFT);
			var current_month = pad_1(g_globalObject_1.currentMonth.toString(), 2, '0', STR_PAD_LEFT);

			jQuery('.JsDatePickBox .dayNormal,.dayNormalToday').each(function(index, value) {

				current_day = pad_1(parseInt(jQuery(value).html()).toString(), 2, '0', STR_PAD_LEFT);
				current_date = current_year + '-' + current_month + '-' + current_day;

				if (princessCalenderHasEvent_1(current_date)) {
					jQuery(value).addClass('hasPerformance');
				}
			});


		}

		function princessCalenderHasEvent_1(dateString) {

			out = false;

			for (var i = 0; i < calendar_data_1.length; i++) {
				if (dateString == calendar_data_1[i].start_date) {
					out = true;
					break;
				}
			}

			return out;
		}

		var STR_PAD_LEFT = 1;
		var STR_PAD_RIGHT = 2;
		var STR_PAD_BOTH = 3;

		function pad_1(str, len, pad, dir) {

			if (typeof(len) == "undefined") { var len = 0; }
			if (typeof(pad) == "undefined") { var pad = ' '; }
			if (typeof(dir) == "undefined") { var dir = STR_PAD_RIGHT; }

			if (len + 1 >= str.length) {

				switch (dir){

					case STR_PAD_LEFT:
						str = Array(len + 1 - str.length).join(pad) + str;
					break;

					case STR_PAD_BOTH:
						var right = Math.ceil((padlen = len - str.length) / 2);
						var left = padlen - right;
						str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
					break;

					default:
						str = str + Array(len + 1 - str.length).join(pad);
					break;

				}
			}

			return str;

		}

		//princessLoadEventsData();
		princessSetupCalendar_1();
	});

    </script>
    <?php
	return ob_get_clean();
}

add_action("wp_ajax_get_calendar_events", "get_calendar_events");
add_action("wp_ajax_nopriv_get_calendar_events", "get_calendar_events");

function get_calendar_events() {

	global $wpdb;

	$json_url = get_option('box_office_account_key').'/getPerformancesByMonth/'.$_GET['month'].'/'.$_GET['year'];
	//$result = file_get_contents($json_url);

	$curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $json_url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl_handle);
    curl_close($curl_handle);

	echo $result;
	die();
}

add_shortcode('tlbo_calendar', 'srtcd_tlbo_calendar_handler');

function srtcd_tlbo_tabbed_search_contents_handler($attr) {
	if( is_admin() ) {
		return;
	}

	ob_start();
	?>
    <script>
		window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"><\/script>');
	</script>

    <div class="tabbed_wrapper">
    	<div class="tabbed_search_wrapper">
        	<select id="category_id" name="category_id">
            	<?php
        		$titles = explode("|", $attr['titles']);
    			$categories = explode("|", $attr['categories']);
                for($m=0; $m<count($titles); $m++) {
                    if( $m == 0 ) {
                        $default_category = $categories[$m];
                    }
                    ?>
                    <option value="<?php echo $categories[$m]; ?>"><?php echo $titles[$m]; ?></option>
                    <?php
                }
                ?>
            </select>
            <div class="btn-go">
                <input type="text" name="search_keyword" id="search_keyword" placeholder="Search..." />
                <?php /* ?><input class="btn_go_search" type="button" value="SEARCH" /><?php */ ?>
            </div>
        </div>
        <div class="tabbed_menu_conetents">
            <div id="tc_bookinglist_tab_search_content" class="tc_BookingListBottom">
                <div class="tc_BookingListCenter">
                </div>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function() {
		var currentRequest = null;
		jQuery(".btn_go_search").click(function(){
			jQuery('#tc_bookinglist_tab_search_content .tc_BookingListCenter').html('<img src="<?php echo PTSG_PLUGIN_URL;?>/images/ajax-loader.gif" style="width:32px;" >');

			var category = jQuery('#category_id').val();
			var search_keyword = jQuery('#search_keyword').val();
			princessLoadEventsData_tbdsearchcnt(category, search_keyword);
		});

		jQuery('#category_id').on('change', function() {
			jQuery('#tc_bookinglist_tab_search_content .tc_BookingListCenter').html('<img src="<?php echo PTSG_PLUGIN_URL;?>/images/ajax-loader.gif" style="width:32px;" >');

			var category = jQuery('#category_id').val();
			var search_keyword = jQuery('#search_keyword').val();
			princessLoadEventsData_tbdsearchcnt(category, search_keyword);
		});

		jQuery('#search_keyword').on('input', function() {
			jQuery('#tc_bookinglist_tab_search_content .tc_BookingListCenter').html('<img src="<?php echo PTSG_PLUGIN_URL;?>/images/ajax-loader.gif" style="width:32px;" >');

			var category = jQuery('#category_id').val();
			var search_keyword = jQuery('#search_keyword').val();
			princessLoadEventsData_tbdsearchcnt(category, search_keyword);
		});

		function princessLoadEventsData_tbdsearchcnt(category, search_keyword) {
			// ajax the request
			currentRequest = jQuery.ajax({
				dataType: 'json',
				url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
				data : {action: "get_tabbed_search_events", attr: '<?php echo json_encode($attr);?>' },
				beforeSend : function()    {
					if(currentRequest != null) {
						currentRequest.abort();
					}
				},
				success: function(data) {
					events_data = data;

					princessRender_tbdsearchcnt(category, search_keyword);
				}
			});
		}

		function princessRender_tbdsearchcnt(category, search_keyword) {

			var data = [];
			var html = '';

			//if (category > 0) {
				data = [];
				for (var i = 0; i < events_data.length; i++) {

					var found = false;

					if( category > 0 ) {
						if (events_data[i].categories !== undefined) {
							for (var y = 0; y < events_data[i].categories.length; y++) {
								if (events_data[i].categories[y] == category) {
									found = true;

									if( found && search_keyword !== '') {
										found = false;

										var pattern = new RegExp(search_keyword, 'gi');
										if( events_data[i].title.match(pattern) != null || events_data[i].teaser.match(pattern) != null ) {
											found = true;
										}
									}

									if( found ) {
										data.push(events_data[i]);
									}
									break;
								}

							}
						}
					} else { // This is for all categories
						found = true;
						if (search_keyword !== '') {
							found = false;

							// keyword search
							var pattern = new RegExp(search_keyword, 'gi');
							if( events_data[i].title.match(pattern) != null || events_data[i].teaser.match(pattern) != null ) {
								found = true;
							}

						}

						if( found ) {
						    data.push(events_data[i]);
						}
					}

				}
			//}
			//else {
				//data = events_data;
			//}

			var html_response = '';
			jQuery(data).each(function(index, value) {
				//html = princessTemplate_tbdsearchcnt(value);
				//jQuery('#tc_bookinglist_tab_search_content .tc_BookingListCenter').append(html);
				html_response += princessTemplate_tbdsearchcnt(value);
			});

			if( html_response ) {
				jQuery('#tc_bookinglist_tab_search_content .tc_BookingListCenter').html(html_response);
			} else {
				jQuery('#tc_bookinglist_tab_search_content .tc_BookingListCenter').html('No Match Found!');
			}

		}

		function princessTemplate_tbdsearchcnt(item) {

			var image = '';

			if (item.image_cache != '') {
				image = item.image_cache_large;
			}

			var template = '<div class="tc_ListBox">';
				template += '<div class="tc_ListBoxPhoto"><!--image--></div>';
				template += '<div class="tc_ListBoxText">';
					template += '<h1><!--title--></h1>';
					template += '<div class="tc_ListParabox">';
					    template += '<p><!--teaser--></p>';
						template += '<div class="tc_MoreInfoBTN">';
							<?php if($attr['btn_event_details_visible'] === 'true') { ?>
							template += '<a href="https://thelittleboxoffice.com/thespirekingston/event/view/<!--id-->" target="_blank" class="more-info"><?php echo $attr['btn_event_details_text']; ?></a>';
							<?php } ?>
							<?php if($attr['btn_book_visible'] === 'true') { ?>
							template += '<a href="https://thelittleboxoffice.com/princess/book/event/<!--id-->" target="_blank" class="book-tickets"><?php echo $attr['btn_book_text']; ?></a>';
							<?php } ?>
						template += '</div>';

					template += '</div>';
				template += '</div>';
				template += '<div class="Clear"></div>';
			template += '</div>';


			template = template.replace(/<!--id-->/g, item.id);
			template = template.replace("<!--title-->", item.title);
			template = template.replace("<!--teaser-->", item.teaser);
			template = template.replace("<!--image-->", image);

			return template;
		}

		var default_category = '<?php echo $default_category;?>';
		var default_search_keyword = '';
		princessLoadEventsData_tbdsearchcnt(default_category, default_search_keyword);

	});
    </script>

   	<?php
	return ob_get_clean();
}

add_action("wp_ajax_get_tabbed_search_events", "get_tabbed_search_events");
add_action("wp_ajax_nopriv_get_tabbed_search_events", "get_tabbed_search_events");

function get_tabbed_search_events() {

	global $wpdb;

	$json_url = get_option('box_office_account_key').'/getEvents/';
	$result = file_get_contents($json_url);
	echo $result;
	die();
}

add_shortcode('tlbo_tabbed_search_contents', 'srtcd_tlbo_tabbed_search_contents_handler');
?>
