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
		return 'ayyash-call-to-action';
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
		return __( 'Call To Action', 'ayyash-addons' );
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
		return 'absp eicon-call-to-action';
	}

	/**
	 * Requires css files.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array(
			'ayyash-addons-custom',
			'absp-call-to-action',
			'absp-pro-call-to-action',
		);
	}

	/**
	 * Requires js files.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array(
			'ayyash-addons-call-to-action',
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


		$this->start_controls_section( 'section_content', [ 'label' => esc_html__( 'Content', 'ayyash-addons' ) ] );

		$this->add_control(
			'c2a_box_icons',
			[
				'label'      => esc_html__( 'Icon or SVG', 'ayyash-addons' ),
				'type'       => Controls_Manager::ICONS,
				'default'    => [
					'value'   => 'fas fa-cloud-download-alt',
					'library' => 'solid',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'one',
						],
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'five',
						],
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'eight',
						],
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'nine',
						],
					],
				],
			]
		);

		$this->add_control(
			'c2a_box_image',
			[
				'label'      => esc_html__( 'Add Image', 'ayyash-addons' ),
				'type'       => Controls_Manager::MEDIA,
				'default'    => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'two',
						],
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'three',
						],
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'four',
						],
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'seven',
						],
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'ten',
						],
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'eleven',
						],
					],
				],
			]
		);

		$this->add_control(
			'c2a_box_title',
			[
				'label'       => esc_html__( 'Title', 'ayyash-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Call To Action Title', 'ayyash-addons' ),
			]
		);

		$this->add_control(
			'c2a_box_sub_title',
			[
				'label'       => esc_html__( 'Sub Title', 'ayyash-addons' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Call To Action Sub Title', 'ayyash-addons' ),
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '!==',
							'value'    => 'five',
						],
					],
				],
			]
		);

		$this->add_control(
			'c2a_box_content',
			[
				'label'      => esc_html__( 'Content', 'ayyash-addons' ),
				'type'       => Controls_Manager::WYSIWYG,
				'default'    => sprintf( '<p>%s</p>', __( 'Call To Action Description Enter Here', 'ayyash-addons' ) ),
				'show_label' => false,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '!==',
							'value'    => 'three',
						],
					],
				],
			]
		);

		//Call to action style four repeator start
		$c2a_repeater_four = new Repeater();

		$c2a_repeater_four->add_control(
			'c2a_box_thumb_four', [
				'label'            => __( 'Add Thumbnail Image', 'ayyash-addons' ),
				'label_block'      => true,
				'fa4compatibility' => 'ayyash-addons',
				'type'             => Controls_Manager::MEDIA,
				'default'          => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$c2a_repeater_four->start_controls_tabs(
			'thumbnail_img'
		);

		$c2a_repeater_four->start_controls_tab(
			'thumbnail_img_normal_tab',
			[
				'label'     => esc_html__( 'Style', 'ayyash-addons' ),
				'condition' => [
					'absolute_call_to_action' => 'four',
				],
			]
		);

		$c2a_repeater_four->add_control(
			'thumbnail_img_size',
			[
				'label'          => esc_html__( 'Image Size', 'ayyash-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'px' ],
				'range'          => [
					'px' => [
						'max' => 1000,
					],
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .absp-wrapper .absp-call-to-action-item .c2a-box .c2a-box-inner .c2a-box-img .thubnail-img-inner {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$c2a_repeater_four->add_control(
			'thumbnail_img_position_lr',
			[
				'label'          => esc_html__( 'Position Left To Right', 'ayyash-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'px' ],
				'range'          => [
					'px' => [
						'max' => 1000,
					],
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .absp-wrapper .absp-call-to-action-item .c2a-box .c2a-box-inner .c2a-box-img .thubnail-img-inner {{CURRENT_ITEM}} img' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$c2a_repeater_four->add_control(
			'thumbnail_img_position_tb',
			[
				'label'          => esc_html__( 'Position Top To Bottom', 'ayyash-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'px' ],
				'range'          => [
					'px' => [
						'max' => 1000,
					],
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .absp-wrapper .absp-call-to-action-item .c2a-box .c2a-box-inner .c2a-box-img .thubnail-img-inner {{CURRENT_ITEM}} img' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$c2a_repeater_four->end_controls_tab();

		$c2a_repeater_four->end_controls_tabs();

		$c2a_repeater_four->end_controls_tabs();
		$this->add_control(
			'c2a_box_thumb_media',
			[
				'label'       => esc_html__( 'Thumbnail Image', 'ayyash-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $c2a_repeater_four->get_controls(),
				'title_field' => '{{{ c2a_box_thumb_four.value }}}',
				'default'     => [
					[
						'c2a_box_thumb_four' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'c2a_box_thumb_four' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'c2a_box_thumb_four' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'c2a_box_thumb_four' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'c2a_box_thumb_four' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
				],
				'condition'   => [
					'absolute_call_to_action' => 'four',
				],
			]
		);
		$this->end_controls_section();
		// Call-to-action button start
		$this->start_controls_section(
			'c2a_box_button_section',
			array(
				'label' => esc_html__( 'Button', 'ayyash-addons' ),
			)
		);
		$this->add_control(
			'enable_button',
			[
				'label'        => esc_html__( 'Enable Button ?', 'ayyash-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'ayyash-addons' ),
				'label_off'    => __( 'No', 'ayyash-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);
		$this->add_control(
			'c2a_box_button_four',
			[
				'label'      => esc_html__( 'Discover Button Text', 'ayyash-addons' ),
				'type'       => Controls_Manager::TEXT,
				'default'    => esc_html__( 'Discover Btn', 'ayyash-addons' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'four',
						],

					],
				],
				'condition'  => [
					'enable_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'c2a_box_button_url_four',
			[
				'label'         => esc_html__( 'Discover Button Link', 'ayyash-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'ayyash-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
				'conditions'    => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'absolute_call_to_action',
							'operator' => '==',
							'value'    => 'four',
						],

					],
				],
				'condition'     => [
					'enable_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'c2a_box_button',
			[
				'label'     => esc_html__( 'Button Text', 'ayyash-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Button Text', 'ayyash-addons' ),
				'condition' => [
					'enable_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'c2a_box_button_url',
			[
				'label'         => esc_html__( 'Button Link', 'ayyash-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'ayyash-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'enable_button' => 'yes',
				],
			]
		);
		// Call-to-action button icon start
		$this->add_control(
			'c2a_box_button_icon_switch',
			[
				'label'        => esc_html__( 'Button Icon', 'ayyash-addons' ),
				'description'  => esc_html__( '(If checked, icon will be show)', 'ayyash-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ayyash-addons' ),
				'label_off'    => esc_html__( 'Hide', 'ayyash-addons' ),
				'return_value' => 'button-icon',
				'default'      => '',
				'separator'    => 'before',
				'condition'    => [
					'enable_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'c2a_box_button_icon',
			[
				'label'      => esc_html__( 'Button Icon', 'ayyash-addons' ),
				'type'       => Controls_Manager::ICONS,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'c2a_box_button_icon_switch',
							'operator' => '==',
							'value'    => 'button-icon',
						],
					],
				],
				'default'    => [
					'value'   => 'fas fa-angle-right',
					'library' => 'solid',
				],
				'condition'  => [
					'enable_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'c2a_box_button_icon_position',
			array(
				'label'      => esc_html__( 'Button Icon Position', 'ayyash-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => array(
					'before' => esc_html__( 'Before', 'ayyash-addons' ),
					'after'  => esc_html__( 'After', 'ayyash-addons' ),

				),
				'conditions' => [
					'terms' => [
						[
							'name'     => 'c2a_box_button_icon_switch',
							'operator' => '==',
							'value'    => 'button-icon',
						],
					],
				],
				'default'    => 'after',
				'condition'  => [
					'enable_button' => 'yes',
				],
			)
		);
		$this->add_control(
			'c2a_box_icon_spacing',
			[
				'label'      => esc_html__( 'Button Icon Spacing', 'ayyash-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'max' => 50,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'c2a_box_button_icon_switch',
							'operator' => '==',
							'value'    => 'button-icon',
						],
					],
				],
				'condition'  => [
					'enable_button' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .absp-wrapper .absp-call-to-action-item .c2a-box-button-icon-after'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .absp-wrapper .absp-call-to-action-item .c2a-box-button-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		//Call-to-action button icon end
		$this->end_controls_section();
		//Call-to-action Button end
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

		$this->add_inline_editing_attributes( 'c2a_box_title' );
		$this->add_render_attribute( 'c2a_box_title', 'class', 'c2a-box-title' );

		//Call to action box sub title inline attribut start
		$this->add_inline_editing_attributes( 'c2a_box_sub_title' );
		$this->add_render_attribute( 'c2a_box_sub_title', 'class', 'c2a-box-sub-title' );

		$this->add_inline_editing_attributes( 'c2a_box_button' );
		$this->add_render_attribute( 'c2a_box_button' );
		if ( ! empty( $settings['c2a_box_button_url']['url'] ) ) {
			$this->add_link_attributes( 'c2a_box_button', $settings['c2a_box_button_url'] );
		}
		//Buy Now Button Style Four
		$this->add_inline_editing_attributes( 'c2a_box_button_four' );
		$this->add_render_attribute( 'c2a_box_button_four', 'class', 'c2a-box-btn-four' );
		if ( ! empty( $settings['c2a_box_button_url_four']['url'] ) ) {
			$this->add_link_attributes( 'c2a_box_button_four', $settings['c2a_box_button_url_four'] );
		}
		?>

        <div class="absp-wrapper absp-widget">
            <div class="absp-wrapper-inside">
                <div class="absp-wrapper-content">
                    <!-- absp-call-to-action-item -->
                    <div class="absp-call-to-action-item element-<?php echo esc_attr( $settings['absolute_call_to_action'] ); ?>">
						<?php $this->render_template(); ?>
                    </div>
                    <!-- absp-call-to-action-item -->
                </div>
            </div>
        </div>
		<?php
	}

	protected function render_c2a_button_icon( $settings ) {
		if ( 'svg' === $settings['c2a_box_button_icon']['library'] ) {
			if ( ! empty( $settings['c2a_box_button_icon']['value']['id'] ) ) {
				echo '<div class="c2a-box-button-svg-img">';
				echo wp_get_attachment_image( $settings['c2a_box_button_icon']['value']['id'] );
				echo '</div>';

			} else { ?>
                <img src="<?php echo esc_url( $settings['c2a_box_button_icon']['value']['url'] ); ?>"
                     alt="Placeholder Image">
				<?php
			}
		} else { ?>
            <div class="c2a-box-button-icon">
                <i class="<?php echo esc_attr( $settings['c2a_box_button_icon']['value'] ); ?>" aria-hidden="true"></i>
            </div>
			<?php
		}
	}

	protected function render_c2a_button( $settings, $only_icon = false ) {
		if ( isset( $settings['enable_button'] ) && 'yes' === $settings['enable_button'] ) {
			$class = 'c2a-box-btn';
			if ( $only_icon ) {
				$class .= ' c2a-icon-only-btn';
			}
			$this->add_render_attribute( 'c2a_box_button', 'class', $class );
			?>
            <a <?php $this->print_render_attribute_string( 'c2a_box_button' ); ?> >
				<?php
				if ( $only_icon ) {
					if ( 'svg' === $settings['c2a_box_button_icon_only']['library'] ) {
						if ( ! empty( $settings['c2a_box_button_icon_only']['value']['id'] ) ) {
							echo '<div class="c2a-box-button-svg-img">';
							echo wp_get_attachment_image( $settings['c2a_box_button_icon_only']['value']['id'] );
							echo '</div>';
						} else { ?>
                            <img src="<?php echo esc_url( $settings['c2a_box_button_icon_only']['value']['url'] ); ?>"
                                 alt="Placeholder Image">
							<?php
						}
					} else {
						?>
                        <div class="c2a-box-button-icon">
                            <i class="<?php echo esc_attr( $settings['c2a_box_button_icon_only']['value'] ); ?>"
                               aria-hidden="true"></i>
                        </div>
						<?php
					}
				} else {
					if ( 'before' === $settings['c2a_box_button_icon_position'] ) { ?>
                        <div class="c2a-box-button-icon-before">
							<?php $this->render_c2a_button_icon( $settings ); ?>
                        </div>
					<?php }
					absp_render_title( $settings['c2a_box_button'] );
					if ( 'after' === $settings['c2a_box_button_icon_position'] ) { ?>
                        <div class="c2a-box-button-icon-after">
							<?php $this->render_c2a_button_icon( $settings ); ?>
                        </div>
					<?php }
				}
				?>
            </a>
			<?php

		}
	}
}
