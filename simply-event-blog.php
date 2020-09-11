<?php
/**
 * Plugin Name:       Simply Event Blog
 * Plugin URI:        https://github.com/closemarketing/simply-event-blog
 * Description:       Adds events features to posts.
 * Version:           1.0.0
 * Author:            Closemarketing
 * Author URI:        https://www.close.marketing
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simply-event-blog
 * Domain Path:       /languages
 * 
 * @link              https://www.close.marketing
 * @since             1.0.0
 * @package           Simply_Event_Blog
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLY_EVENT_BLOG_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simply-event-blog-activator.php
 */
function activate_simply_event_blog() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simply-event-blog-activator.php';
	Simply_Event_Blog_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simply-event-blog-deactivator.php
 */
function deactivate_simply_event_blog() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simply-event-blog-deactivator.php';
	Simply_Event_Blog_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simply_event_blog' );
register_deactivation_hook( __FILE__, 'deactivate_simply_event_blog' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simply-event-blog.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simply_event_blog() {

	$plugin = new Simply_Event_Blog();
	$plugin->run();

}
run_simply_event_blog();
