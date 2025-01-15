<?php
/**
 * The main theme setup and configuration file for My Theme.
 * Michael Morales
 * @package My_Theme
 */

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Class My_Theme
 * Handles the theme setup, custom post types, theme features, script enqueuing, and more.
 */
class My_Theme {

    /**
     * Constructor to initialize the theme setup.
     */
    public function __construct() {
        // Initialize theme setup
        add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

        // Enqueue styles and scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        // Register custom post types
        add_action( 'init', [ $this, 'register_custom_post_types' ] );

        // Widgets init
        add_action( 'widgets_init', [ $this, 'widgets_init' ] );

        // Customize the WordPress login page
        add_filter( 'login_headerurl', [ $this, 'login_logo_url' ] );
        add_filter( 'login_headertext', [ $this, 'login_logo_url_title' ] );
    }

    /**
     * Setup theme features, including support for various WordPress functions.
     */
    public function setup_theme() {
        // Title tag support
        add_theme_support( 'title-tag' );

        // Custom logo support
        add_theme_support( 'custom-logo' );

        // Post thumbnail support
        add_theme_support( 'post-thumbnails' );

        // Register navigation menus
        register_nav_menus( [
            'primary' => __( 'Primary Menu', 'my-theme' ),
            'footer'  => __( 'Footer Menu', 'my-theme' ),
        ] );

        // HTML5 support for forms and galleries
        add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );

        // Translation support
        load_theme_textdomain( 'my-theme', get_template_directory() . '/languages' );
    }

    /**
     * Enqueue styles and scripts with performance optimizations.
     */
    public function enqueue_scripts() {
        // Load the main stylesheet
        wp_enqueue_style( 'my-theme-style', get_stylesheet_uri(), [], null, 'all' );

        // Load scripts with defer attribute for performance
        wp_enqueue_script( 'my-theme-script', get_template_directory_uri() . '/js/main.js', [], null, true );

        // Load homepage-specific scripts only on the homepage
        if ( is_home() || is_front_page() ) {
            wp_enqueue_script( 'homepage-script', get_template_directory_uri() . '/js/homepage.js', [], null, true );
        }
    }

    /**
     * Register custom post types like "Portfolio".
     */
    public function register_custom_post_types() {
        $args = [
            'public'       => true,
            'label'        => __( 'Portfolio', 'my-theme' ),
            'supports'     => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
            'menu_icon'    => 'dashicons-portfolio',
            'has_archive'  => true,
        ];
        register_post_type( 'portfolio', $args );
    }

    /**
     * Initialize widgets (sidebars).
     */
    public function widgets_init() {
        register_sidebar( [
            'name'          => __( 'Sidebar', 'my-theme' ),
            'id'            => 'sidebar-1',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ] );
    }

    /**
     * Customize the login page URL.
     */
    public function login_logo_url() {
        return home_url();
    }

    /**
     * Customize the login page title.
     */
    public function login_logo_url_title() {
        return get_bloginfo( 'name' );
    }

    /**
     * Sanitize user input to ensure security.
     *
     * @param string $input The raw user input.
     * @return string The sanitized input.
     */
    public function sanitize_input( $input ) {
        return sanitize_text_field( $input );
    }

    /**
     * Generate nonce for security in form handling.
     *
     * @return string The nonce field HTML.
     */
    public function generate_nonce() {
        return wp_nonce_field( 'my_theme_nonce_action', 'my_theme_nonce', true, false );
    }

    /**
     * Example of custom error handling in WordPress.
     * 
     * @param string $error_message The error message to log.
     */
    public function custom_error_handling( $error_message ) {
        // Log error message to the error log
        error_log( '[My_Theme Error]: ' . $error_message );

        // Show a generic message to users
        if ( ! current_user_can( 'administrator' ) ) {
            wp_die( __( 'Something went wrong. Please try again later.', 'my-theme' ) );
        }
    }
}

// Initialize the theme
$my_theme = new My_Theme();

/**
 * Add custom action to prevent direct access to certain pages.
 */
function prevent_direct_access() {
    if ( ! defined( 'ABSPATH' ) ) {
        wp_die( __( 'Unauthorized access attempt.', 'my-theme' ) );
    }
}
add_action( 'template_redirect', 'prevent_direct_access' );

?>
``
