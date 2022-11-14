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

// Define INT_MIN & INT_MIN for php 5.6 BackCompact.
if ( ! defined( 'AYYASH_ADDONS_INT_MIN' ) ) {
	define( 'AYYASH_ADDONS_INT_MIN', defined( 'PHP_INT_MIN' ) ? PHP_INT_MIN : - 999999 ); // phpcs:ignore PHPCompatibility.Constants.NewConstants.php_int_minFound
}
if ( ! defined( 'AYYASH_ADDONS_INT_MAX' ) ) {
	define( 'AYYASH_ADDONS_INT_MAX', defined( 'PHP_INT_MAX' ) ? PHP_INT_MAX : 999999 ); // phpcs:ignore PHPCompatibility.Constants.NewConstants.php_int_maxFound
}


if ( ! defined( 'AYYASH_ADDONS_ELEMENTOR_PATH' ) ) {
	/**
	 * AYYASH ADDONS ELEMENTOR PATH.
	 *
	 * @var string
	 */
	define( 'AYYASH_ADDONS_ELEMENTOR_PATH', AYYASH_ADDONS_PATH . 'elementor/' );
}

if ( ! defined( 'AYYASH_ADDONS_ELEMENTOR_FILE' ) ) {
	/**
	 * AYYASH ADDONS ELEMENTOR FILE.
	 *
	 * @var string
	 */
	define( 'AYYASH_ADDONS_ELEMENTOR_FILE', __FILE__ );
}

if ( ! defined( 'AYYASH_ADDONS_ELEMENTOR_WIDGETS_PATH' ) ) {
	/** @define "AYYASH_ADDONS_ELEMENTOR_WIDGETS_PATH" "./widgets/" */
	/**
	 * Widgets Dir Ref.
	 *
	 * @var string
	 */
	define( 'AYYASH_ADDONS_ELEMENTOR_WIDGETS_PATH', AYYASH_ADDONS_ELEMENTOR_PATH . 'widgets/' );
}

if ( ! class_exists( 'Ayyash_Addons', false ) ) {
	require_once AYYASH_ADDONS_PATH . 'class-ayyash-addons.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
}

if ( ! class_exists( 'Ayyash_Elementor_Addons', false ) ) {
	require_once AYYASH_ADDONS_ELEMENTOR_PATH . 'ayyash-elementor-addons.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	/**
	 * Instantiate Absolute_Addons.
	 * @return AyyashAddons\Ayyash_Elementor_Addons
	 */
	function ayyash_elementor_addons() {
		return AyyashAddons\Ayyash_Elementor_Addons::instance();
	}

	ayyash_elementor_addons();
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