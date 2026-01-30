<?php
/**
 * Plugin Name: SatDesign Vertical Carousel
 * Description: Elementor widget voor een verticale afbeeldingen carousel met oneindige loop
 * Version: 1.0.0
 * Author: SatDesign
 * Requires Plugins: elementor
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SATDESIGN_VC_VERSION', '1.0.0');
define('SATDESIGN_VC_PATH', plugin_dir_path(__FILE__));
define('SATDESIGN_VC_URL', plugin_dir_url(__FILE__));

class SatDesign_Vertical_Carousel {

    private static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {
        // Controleer of Elementor is geactiveerd
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }

        // Registreer de widget
        add_action('elementor/widgets/register', [$this, 'register_widgets']);

        // Registreer scripts en styles voor Elementor frontend
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_scripts']);
        add_action('elementor/frontend/after_register_styles', [$this, 'register_styles']);

        // Enqueue op frontend als de widget wordt gebruikt
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_styles']);
        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_scripts']);

        // Registreer editor scripts
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'editor_scripts']);

        // Preview mode
        add_action('elementor/preview/enqueue_styles', [$this, 'editor_scripts']);
    }

    public function admin_notice_missing_elementor() {
        $message = sprintf(
            esc_html__('%1$s vereist %2$s om geïnstalleerd en geactiveerd te zijn.', 'satdesign-vc'),
            '<strong>SatDesign Vertical Carousel</strong>',
            '<strong>Elementor</strong>'
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function register_widgets($widgets_manager) {
        require_once SATDESIGN_VC_PATH . 'widgets/vertical-carousel-widget.php';
        $widgets_manager->register(new \SatDesign_Vertical_Carousel_Widget());
    }

    public function register_styles() {
        wp_register_style(
            'satdesign-vertical-carousel',
            SATDESIGN_VC_URL . 'assets/css/vertical-carousel.css',
            [],
            SATDESIGN_VC_VERSION
        );
    }

    public function register_scripts() {
        wp_register_script(
            'satdesign-vertical-carousel',
            SATDESIGN_VC_URL . 'assets/js/vertical-carousel.js',
            ['jquery'],
            SATDESIGN_VC_VERSION,
            true
        );
    }

    public function enqueue_styles() {
        wp_enqueue_style('satdesign-vertical-carousel');
    }

    public function enqueue_scripts() {
        wp_enqueue_script('satdesign-vertical-carousel');
    }

    public function editor_scripts() {
        wp_enqueue_style('satdesign-vertical-carousel');
        wp_enqueue_script('satdesign-vertical-carousel');
    }
}

SatDesign_Vertical_Carousel::instance();
