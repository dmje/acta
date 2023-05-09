<?php

/**
 * @link              https://wpvivid.com
 * @since             0.9.1
 * @package           wpvivid
 *
 * @wordpress-plugin
 * Plugin Name:       WPvivid Database Snapshots
 * Description:       Create snapshots of a WordPress database quickly.
 * Version:           0.9.4
 * Author:            wpvivid.com
 * Author URI:        https://wpvivid.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/copyleft/gpl.html
 * Text Domain:       wpvivid
 * Domain Path:       /languages
 */

define('WPVIVID_SNAPSHOT_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('WPVIVID_SNAPSHOT_PLUGIN_URL', plugins_url('/',__FILE__));
define('WPVIVID_SNAPSHOT_VERSION','0.9.4');

if ( ! defined( 'WPINC' ) )
{
    die;
}

require WPVIVID_SNAPSHOT_PLUGIN_DIR . 'includes/class-wpvivid-snapshot.php';

function run_wpvivid_snapshot()
{
    $wpvivid_snapshot=new WPvivid_Snapshot();
    $GLOBALS['wpvivid_snapshot'] = $wpvivid_snapshot;
}
run_wpvivid_snapshot();