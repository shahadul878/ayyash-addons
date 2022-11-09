<?php
/**
 * Addon elements for Elementor Page Builder & Gutenberg.
 *
 * Plugin Name: Ayyash Addons
 * Description: Addon elements for Elementor Page Builder & Gutenberg.
 * Plugin URI: #
 * Version: 1.0.0
 * Author: Themeoo
 * Author URI: https://themeoo.com
 * Text Domain: ayyash-addons
 * Domain Path: /languages/
 *
 * [PHP]
 * Requires PHP: 7.1
 *
 * [WP]
 * Requires at least: 5.2
 * Tested up to: 6.0
 *
 * [Elementor]
 * Elementor requires at least: 3.2.5
 * Elementor tested up to: 3.6
 *
 * [WC]
 * WC requires at least: 5.9
 * WC tested up to: 6.5
 *
 * @package ayyash-addons
 */


if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	die();
}

if ( ! defined( 'AYYASH_ADDONS_VERSION' ) ) {
	/**
	 * Plugin Version.
	 *
	 * @var string
	 */
	define( 'AYYASH_ADDONS_VERSION', '1.0.0' );
}
if ( ! defined( 'AYYASH_ADDONS_FILE' ) ) {
	/**
	 * Plugin File Ref.
	 *
	 * @var string
	 */
	define( 'AYYASH_ADDONS_FILE', __FILE__ );
}
if ( ! defined( 'AYYASH_ADDONS_BASE' ) ) {
	/**
	 * Plugin Base Name.
	 *
	 * @var string
	 */
	define( 'AYYASH_ADDONS_BASE', plugin_basename( AYYASH_ADDONS_FILE ) );
}
if ( ! defined( 'AYYASH_ADDONS_PATH' ) ) {
	/** @define "AYYASH_ADDONS_PATH" "./" */
	/**
	 * Plugin Dir Ref.
	 *
	 * @var string
	 */
	define( 'AYYASH_ADDONS_PATH', plugin_dir_path( AYYASH_ADDONS_FILE ) );
}

if ( ! defined( 'AYYASH_ADDONS_URL' ) ) {
	/**
	 * Plugin URL.
	 *
	 * @var string
	 */
	define( 'AYYASH_ADDONS_URL', plugin_dir_url( AYYASH_ADDONS_FILE ) );
}

if ( ! class_exists( 'Ayyash_Addons', false ) ) {
	require_once AYYASH_ADDONS_PATH . 'class-ayyash-addons.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
}

/**
 * Initialize the plugin
 *
 * @return Ayyash_Addons
 */
function ayyash_addons() {
	return Ayyash_Addons::get_instance();
}

// Kick it off.
ayyash_addons();
// End of file ayyash-addons.php.