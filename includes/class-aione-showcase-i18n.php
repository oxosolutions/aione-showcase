<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.sgssandhu.com
 * @since      1.0.0
 *
 * @package    Aione_Showcase
 * @subpackage Aione_Showcase/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Aione_Showcase
 * @subpackage Aione_Showcase/includes
 * @author     SGS Sandhu <sgs.sandhu@gmail.com>
 */
class Aione_Showcase_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'aione-showcase',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
