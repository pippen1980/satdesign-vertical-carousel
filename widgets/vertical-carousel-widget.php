<?php

if (!defined('ABSPATH')) {
    exit;
}

class SatDesign_Vertical_Carousel_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'satdesign_vertical_carousel';
    }

    public function get_title() {
        return esc_html__('Vertical Carousel', 'satdesign-vc');
    }

    public function get_icon() {
        return 'eicon-slider-vertical';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_keywords() {
        return ['carousel', 'slider', 'vertical', 'images', 'loop', 'satdesign'];
    }

    public function get_style_depends() {
        return ['satdesign-vertical-carousel'];
    }

    public function get_script_depends() {
        return ['satdesign-vertical-carousel'];
    }

    protected function register_controls() {

        // Content Section - Images
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Afbeeldingen', 'satdesign-vc'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'carousel_images',
            [
                'label' => esc_html__('Afbeeldingen toevoegen', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
                'show_label' => true,
            ]
        );

        $this->end_controls_section();

        // Content Section - Settings
        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('Instellingen', 'satdesign-vc'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'scroll_direction',
            [
                'label' => esc_html__('Scroll richting', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'up',
                'options' => [
                    'up' => esc_html__('Omhoog', 'satdesign-vc'),
                    'down' => esc_html__('Omlaag', 'satdesign-vc'),
                ],
            ]
        );

        $this->add_control(
            'scroll_speed',
            [
                'label' => esc_html__('Scroll snelheid', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'description' => esc_html__('Pixels per seconde', 'satdesign-vc'),
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pauzeren bij hover', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Ja', 'satdesign-vc'),
                'label_off' => esc_html__('Nee', 'satdesign-vc'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Section - Container
        $this->start_controls_section(
            'style_container_section',
            [
                'label' => esc_html__('Container', 'satdesign-vc'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'carousel_height',
            [
                'label' => esc_html__('Hoogte', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mvc-carousel-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_width',
            [
                'label' => esc_html__('Breedte', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mvc-carousel-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => esc_html__('Achtergrondkleur', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mvc-carousel-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .mvc-carousel-container',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border radius', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mvc-carousel-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Images
        $this->start_controls_section(
            'style_images_section',
            [
                'label' => esc_html__('Afbeeldingen', 'satdesign-vc'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_spacing',
            [
                'label' => esc_html__('Tussenruimte', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mvc-carousel-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border radius', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mvc-carousel-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .mvc-carousel-item img',
            ]
        );

        $this->add_control(
            'image_object_fit',
            [
                'label' => esc_html__('Object fit', 'satdesign-vc'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover', 'satdesign-vc'),
                    'contain' => esc_html__('Contain', 'satdesign-vc'),
                    'fill' => esc_html__('Fill', 'satdesign-vc'),
                    'none' => esc_html__('None', 'satdesign-vc'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .mvc-carousel-item img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['carousel_images'])) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<div class="mvc-no-images">Selecteer afbeeldingen in het widget panel</div>';
            }
            return;
        }

        $carousel_id = 'mvc-carousel-' . $this->get_id();
        $speed = isset($settings['scroll_speed']['size']) ? $settings['scroll_speed']['size'] : 30;
        $direction = isset($settings['scroll_direction']) ? $settings['scroll_direction'] : 'up';
        $pause_on_hover = isset($settings['pause_on_hover']) && $settings['pause_on_hover'] === 'yes' ? 'true' : 'false';

        ?>
        <div id="<?php echo esc_attr($carousel_id); ?>"
             class="mvc-carousel-container"
             data-speed="<?php echo esc_attr($speed); ?>"
             data-direction="<?php echo esc_attr($direction); ?>"
             data-pause-hover="<?php echo esc_attr($pause_on_hover); ?>">
            <div class="mvc-carousel-track">
                <?php foreach ($settings['carousel_images'] as $image) : ?>
                    <div class="mvc-carousel-item">
                        <?php echo wp_get_attachment_image($image['id'], 'large'); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        if (settings.carousel_images.length === 0) {
            #>
            <div class="mvc-no-images">Selecteer afbeeldingen in het widget panel</div>
            <#
        } else {
            var carouselId = 'mvc-carousel-' + view.getID();
            var speed = settings.scroll_speed.size || 30;
            var direction = settings.scroll_direction || 'up';
            var pauseOnHover = settings.pause_on_hover === 'yes' ? 'true' : 'false';
            #>
            <div id="{{ carouselId }}"
                 class="mvc-carousel-container"
                 data-speed="{{ speed }}"
                 data-direction="{{ direction }}"
                 data-pause-hover="{{ pauseOnHover }}">
                <div class="mvc-carousel-track">
                    <# _.each(settings.carousel_images, function(image) { #>
                        <div class="mvc-carousel-item">
                            <img src="{{ image.url }}" alt="">
                        </div>
                    <# }); #>
                </div>
            </div>
            <#
        }
        #>
        <?php
    }
}
