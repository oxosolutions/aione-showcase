<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.sgssandhu.com
 * @since             1.0.0
 * @package           Aione_Showcase
 *
 * @wordpress-plugin
 * Plugin Name:       Aione Showcase
 * Plugin URI:        www.oxosolutions.com
 * Description:       All-in-one Showcase for your apps, projects, products, themes and more.
 * Version:           1.0.0.1
 * Author:            SGS Sandhu
 * Author URI:        www.sgssandhu.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       aione-showcase
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-aione-showcase-activator.php
 */
function activate_aione_showcase() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aione-showcase-activator.php';
	Aione_Showcase_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-aione-showcase-deactivator.php
 */
function deactivate_aione_showcase() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aione-showcase-deactivator.php';
	Aione_Showcase_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_aione_showcase' );
register_deactivation_hook( __FILE__, 'deactivate_aione_showcase' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-aione-showcase.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_aione_showcase() {

	$plugin = new Aione_Showcase();
	$plugin->run();

}
run_aione_showcase();
