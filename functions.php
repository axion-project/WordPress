<?php

/**
 * Class My_Theme_Functions
 * 
 * Handles theme setup, enqueues styles/scripts, and registers various theme features.
 * Michael Morales
 */
class My_Theme_Functions {

    /**
     * Constructor: Initializes the theme's hooks and actions.
     */
    public function __construct() {
        // Theme setup
        add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

        // Enqueue styles and scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        // Register widget areas
        add_action( 'widgets_init', [ $this, 'widgets_init' ] );

        // Register custom post types
        add_action( 'init', [ $this, 'register_custom_post_types' ] );

        // Customize login page
        add_filter( 'login_headerurl', [ $this, 'login_logo_url' ] );
        add_filter( 'login_headertext', [ $this, 'login_logo_url_title' ] );
        
        // Disable admin bar for non-admin users
        add_filter( 'show_admin_bar', [ $this, 'disable_admin_bar' ] );
    }

    /**
     * Theme setup - Enable support for various WordPress features.
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
            'primary' => __( 'Primary Menu', 'your-theme-textdomain' ),
            'footer'  => __( 'Footer Menu', 'your-theme-textdomain' ),
        ] );

        // HTML5 support
        add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );

        // Translation support
        load_theme_textdomain( 'your-theme-textdomain', get_template_directory() . '/languages' );
    }

    /**
     * Enqueue theme styles and scripts.
     */
    public function enqueue_scripts() {
        // Load styles
        wp_enqueue_style( 'my-theme-style', get_stylesheet_uri() );

        // Load script with deferred loading for performance
        wp_enqueue_script( 'my-theme-script', get_template_directory_uri() . '/js/main.js', [ 'jquery' ], null, true );

        // Only load scripts/styles for specific pages
        if ( is_home() || is_front_page() ) {
            wp_enqueue_script( 'home-page-script', get_template_directory_uri() . '/js/home.js', [], null, true );
        }
    }

    /**
     * Register widget areas (sidebars).
     */
    public function widgets_init() {
        register_sidebar( [
            'name'          => __( 'Sidebar', 'your-theme-textdomain' ),
            'id'            => 'sidebar-1',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ] );
    }

    /**
     * Register a custom post type (example: Portfolio).
     */
    public function register_custom_post_types() {
        $args = [
            'public'       => true,
            'label'        => __( 'Portfolios', 'your-theme-textdomain' ),
            'supports'     => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
            'menu_icon'    => 'dashicons-portfolio',
            'has_archive'  => true,
        ];
        register_post_type( 'portfolio', $args );
    }

    /**
     * Disable the admin bar for all users except administrators.
     */
    public function disable_admin_bar( $show_admin_bar ) {
        if ( ! current_user_can( 'administrator' ) ) {
            return false;
        }
        return $show_admin_bar;
    }

    /**
     * Customize the login page logo URL.
     */
    public function login_logo_url() {
        return home_url(); // Link logo to the homepage
    }

    /**
     * Customize the login page logo title.
     */
    public function login_logo_url_title() {
        return get_bloginfo( 'name' ); // Set title to site name
    }

    /**
     * Sanitize and validate user input for form handling and customization.
     *
     * @param string $input The raw input value.
     * @return string The sanitized input.
     */
    public function sanitize_input( $input ) {
        return sanitize_text_field( $input ); // Example of sanitizing a text field
    }

    /**
     * Create a nonce field for form submission security.
     */
    public function create_nonce() {
        return wp_nonce_field( 'my_theme_nonce_action', 'my_theme_nonce' );
    }
}

// Initialize theme functions class
$my_theme_functions = new My_Theme_Functions();

?>
