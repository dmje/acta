*** This is an alpha and may break things ***

To install:

1) Make sure you have ACF installed and active 
2) Add this plugin
3) Activate it
4) In sidebar.php of your site, put this code:

<?php

if ( is_user_logged_in() )
{

// Check to see if the draft content plugin is installed, and include sidebar if so

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'thirty8-draftcontent/thirty8-draftcontent.php' ) ) 
{
	$pluginsidebarpath = ABSPATH . "wp-content/plugins/thirty8-draftcontent/draftcontent-sidebar.php";
	include($pluginsidebarpath);	
} 

}

?>