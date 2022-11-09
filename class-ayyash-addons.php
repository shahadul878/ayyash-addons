<?php
/**
 * The Companion.
 *
 * @package Themeoo/core
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	die();
}

if ( ! class_exists( 'Ayyash_Addons' ) ) {
	class Ayyash_Addons {
		/**
		 * Plugin version
		 *
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * The plugin url
		 *
		 * @var string
		 */
		public $plugin_url;

		/**
		 * The plugin path
		 *
		 * @var string
		 */
		public $plugin_path;

		/**
		 * The theme directory path
		 *
		 * @var string
		 */
		public $theme_dir_path;

		/**
		 * Singleton class instance.
		 *
		 * @var Ayyash_Addons
		 */
		protected static $instance;

		/**
		 * Create & return singleton instance of this class.
		 *
		 * @return Ayyash_Addons
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Ayyash_Addons constructor.
		 *
		 * @return void
		 */
		public function __construct() {
			$this->init();
		}

		/**
		 * Initialize the plugin
		 *
		 * @return void
		 */
		private function init() {

			add_action( 'plugins_loaded', [ $this, 'file_includes' ] );

			// Localize our plugin.
			add_action( 'init', [ $this, 'localization_setup' ] );

			// Loads frontend scripts and styles.
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

			register_activation_hook( __FILE__, [ $this, 'activate' ] );

			add_action( 'widgets_init', [ $this, 'register_widgets' ] );

		}

		/**
		 * Register Widgets.
		 *
		 * @return void
		 */
		public function register_widgets() {

		}


		/**
		 * The plugin activation function
		 *
		 * @return void
		 */
		public function activate() {
		}

		/**
		 * Load the required files
		 *
		 * @return void
		 */
		public function file_includes() {
			// phpcs:disable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

			$author = wp_get_theme()->get( 'Author' );
			if ( in_array( $author, [ 'ThemeRox', 'Themerox', 'themerox', 'ThemeOO', 'Themeoo', 'themeoo' ] ) ) {
				include_once AYYASH_ADDONS_PATH . '/includes';
			} else {
				add_action( 'admin_notices', array( $this, 'admin_notice_error' ) );
			}
			// phpcs:enable
		}

		/**
		 * Initialize plugin for localization
		 *
		 * @uses load_plugin_textdomain()
		 */
		public function localization_setup() {
			load_plugin_textdomain( 'ayyash-addons', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Enqueue admin scripts
		 *
		 * Allows plugin assets to be loaded.
		 *
		 * @uses wp_enqueue_script()
		 * @uses wp_enqueue_style
		 */
		public function enqueue_scripts() {

			/**
			 * All styles goes here
			 */
			// wp_enqueue_style( 'ayyash-pro-style', plugins_url( 'assets/css/frontend.css', __FILE__ ), $this->version, date( 'Ymd' ) );

			/**
			 * All scripts goes here
			 */
			// wp_enqueue_script( 'ayyash-pro-scripts', plugins_url( 'assets/js/frontend.js', __FILE__ ), array( 'jquery' ), $this->version, true );
		}

		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			if ( $this->plugin_url ) {
				$this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
			}

			return $this->plugin_url;
		}


		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			if ( ! $this->plugin_path ) {
				$this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path;
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return $this->plugin_path() . '/templates/';
		}

		/**
		 * Admin notice if current theme is not supported by this plugin.
		 *
		 * @return void;
		 */
		public function admin_notice_error() {
			printf(
				'<div class="notice notice-error is-dismissible"><p>%s</p></div>',
				esc_html__( '“Ayyash Addons Plugin” is enabled but not effective. It requires Ayyash Theme.', 'ayyash-addons' )
			);
		}
	}
}
