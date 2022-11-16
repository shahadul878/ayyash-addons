<?php

namespace AyyashAddons\Widgets;

use AyyashAddons\Ayyash_Elementor_Widget;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @since 1.1.0
 */
class AyyashAddons_Style_Button extends Ayyash_Elementor_Widget {

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 */
	public function get_name() {
		return 'ayyash-button';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Button', 'ayyash-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Requires css files.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array(
			'ayyash-addons-button'
		);
	}

	/**
	 * Requires js files.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'ayyash-button',
		);
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @return array Widget categories.
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 */
	public function get_categories() {
		return array( 'ayyash-widgets' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function register_controls() {

		/**
		 * Fires after controllers are registered.
		 *
		 * @param Absoluteaddons_Style_Call_To_Action $this Current instance of WP_Network_Query (passed by reference).
		 *
		 * @since 1.0.0
		 *
		 */
		do_action_ref_array( $this->get_prefixed_hook( 'controllers/starts' ), [ &$this ] );


		/**
		 * Fires after controllers are registered.
		 *
		 * @param Absoluteaddons_Style_Call_To_Action $this Current instance of WP_Network_Query (passed by reference).
		 *
		 * @since 1.0.0
		 *
		 */
		do_action_ref_array( $this->get_prefixed_hook( 'controllers/ends' ), [ &$this ] );

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();


		?>

		<div class="ayyash-wrapper ayyash-widget">
			<div class="ayyash-wrapper-inside">
				<div class="ayyash-wrapper-content">
					<button>hello</button>
				</div>
			</div>
		</div>
		<?php
	}


}
