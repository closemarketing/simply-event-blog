<?php
/**
 * Plugin Name:       Simply Event Blog
 * Plugin URI:        https://github.com/closemarketing/simply-event-blog
 * Description:       Adds events features to posts.
 * Version:           0.2.0-beta.1
 * Author:            Closemarketing
 * Author URI:        https://www.close.marketing
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simply-event-blog
 * Domain Path:       /languages
 * 
 * @link              https://www.close.marketing
 * @package           Simply_Event_Blog
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'SEB_VERSION', '0.2.0-beta.1' );
define( 'SEB_PLUGIN', __FILE__ );
define( 'SEB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SEB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );


load_plugin_textdomain( 'simply-event-blog', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

if ( is_admin() ) {
	require SEB_PLUGIN_PATH . 'admin/class-metabox-admin.php';
}

require SEB_PLUGIN_PATH . 'public/class-simply-event-blog-public.php';
