<?php
/*
Active: true
UUID: tmp-search-form
Title: TMP collections search form
Description: Displays a collections search form
Keywords: search,collection,collections
CSS: assets/css/block.css
JS: assets/js/block.js
Version: 1.0
Post Types: page
Allow Multiple: true
*/




if(is_plugin_active('mp-es-objects/mp-es-objects.php') || is_plugin_active('mp-es7-objects/mp-es7-objects.php')){

// Only show stuff if collections is actually being used

// Fetch the selected homepage from the ES settings plugin
$coll_homepage_id = get_option('es_objects_presentation_hook_page');
$coll_homepage_url = get_permalink($coll_homepage_id);


?>


<form class="hero-search" action="<?php echo $coll_homepage_url;?>" method="get">
	<input type="text" name="s" placeholder="Search for objects:" id="searchBox">
	<button type="submit">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M13.5 6C10.5 6 8 8.5 8 11.5c0 1.1.3 2.1.9 3l-3.4 3 1 1.1 3.4-2.9c1 .9 2.2 1.4 3.6 1.4 3 0 5.5-2.5 5.5-5.5C19 8.5 16.5 6 13.5 6zm0 9.5c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"></path></svg>
	</button>
</form>
	
<?php 

} else {
	
echo '<p>Your site doesn\'t have active collections functionality - this block won\'t work for you!</p>';
	
}
?>