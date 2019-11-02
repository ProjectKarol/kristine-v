<?php
/**
 * Theme Dashboard
 *
 * @package nk-themes-helper
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class NK_Helper_Theme_Dashboard
 */
class NK_Helper_Theme_Dashboard {
    /**
     * The single class instance.
     *
     * @var object
     */
    private static $_instance = null;

    /**
     * Main Instance
     * Ensures only one instance of this class exists in memory at any one time.
     *
     * @param array $options - options.
     *
     * @return NK_Helper_Theme_Dashboard|object
     */
    public static function instance( $options = array() ) {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
            self::$_instance->init_includes();
            self::$_instance->init_actions();
            self::$_instance->set_options( $options );
            self::$_instance->setup();
        }
        return self::$_instance;
    }

    /**
     * NK_Helper_Theme_Dashboard constructor.
     */
    private function __construct() {
        /* We do nothing here! */
    }

    /**
     * Options
     *
     * @var array
     */
    public $options = array();

    /**
     * Is Envato Hoster
     *
     * @var bool
     */
    public $is_envato_hosted;

    /**
     * Is Envato Elements
     *
     * @var bool
     */
    public $is_envato_elements;

    /**
     * Theme ID
     *
     * @var string
     */
    public $theme_id;

    /**
     * Theme slug
     *
     * @var string
     */
    public $theme_slug;

    /**
     * Theme name
     *
     * @var string
     */
    public $theme_name;

    /**
     * Theme version
     *
     * @var string
     */
    public $theme_version;

    /**
     * Theme url
     *
     * @var string
     */
    public $theme_uri;

    /**
     * Theme changelog
     *
     * @var string
     */
    public $theme_changelog;

    /**
     * Theme documentation
     *
     * @var string
     */
    public $theme_documentation;

    /**
     * Is child
     *
     * @var bool
     */
    public $theme_is_child;

    /**
     * Ask for review
     *
     * @var bool
     */
    public $ask_for_review;

    /**
     * Init Included Files
     */
    public function init_includes() {
        require nk_theme()->plugin_path . '/theme-dashboard/ajax-get-changelog.php';
        require nk_theme()->plugin_path . '/theme-dashboard/ajax-ask-for-activation-disable.php';
        require nk_theme()->plugin_path . '/theme-dashboard/ajax-ask-for-review-disable.php';
        require nk_theme()->plugin_path . '/theme-dashboard/ajax-demo-import.php';
        require nk_theme()->plugin_path . '/theme-dashboard/ajax-activation.php';
        require nk_theme()->plugin_path . '/theme-dashboard/ajax-update-purchase-platform.php';

        require nk_theme()->plugin_path . '/theme-dashboard/class-admin-pages.php';
        require nk_theme()->plugin_path . '/theme-dashboard/class-activation.php';
        require nk_theme()->plugin_path . '/theme-dashboard/class-updater.php';
    }

    /**
     * Setup the hooks, actions and filters.
     */
    public function init_actions() {
        if ( is_admin() ) {
            add_action( 'admin_print_styles', array( $this, 'admin_print_styles' ) );

            $this->prepare_ask_for_review_notice();
        }
    }

    /**
     * Print Styles
     */
    public function admin_print_styles() {
        wp_enqueue_style( 'fontawesome', nk_theme()->plugin_url . 'assets/vendor/fontawesome/css/font-awesome.min.css' );
        wp_enqueue_style( 'tether-drop', nk_theme()->plugin_url . 'assets/vendor/drop/dist/css/drop-theme-twipsy.min.css' );
        wp_enqueue_style( 'nk-theme-dashboard', nk_theme()->plugin_url . 'assets/css/theme-dashboard.min.css', '', '1.6.18' );

        wp_register_script( 'event-source-polyfill', nk_theme()->plugin_url . 'assets/vendor/eventsource/eventsource.min.js' );
        wp_enqueue_script( 'tether', nk_theme()->plugin_url . 'assets/vendor/drop/dist/js/tether.min.js', '', '', true );
        wp_enqueue_script( 'tether-drop', nk_theme()->plugin_url . 'assets/vendor/drop/dist/js/drop.min.js', '', '', true );
        wp_enqueue_script( 'nk-theme-dashboard', nk_theme()->plugin_url . 'assets/js/theme-dashboard.min.js', array( 'jquery' ), '1.6.18', true );

        $data_init = array(
            'demoImportConfirm' => esc_html__( 'This will import data from demo page. Clicking this option will replace your current theme options and widgets. Please, wait before the process end. It may take a while.', 'nk-themes-helper' ),
            'demoImportBeforeUnload' => esc_html__( 'The demo import process is not finished yet...', 'nk-themes-helper' ),
            'deactivateTheme' => esc_html__( 'This will deactivate your copy of theme. You will not be able to get direct theme updates.', 'nk-themes-helper' ),
        );
        wp_localize_script( 'nk-theme-dashboard', 'nkThemeDashboardOptions', $data_init );
    }

    /**
     * Prepare ask for review notice.
     */
    public function prepare_ask_for_review_notice() {
        $status = nk_theme()->get_option( 'ask_for_review_status', 'first' );
        $pending = nk_theme()->get_option( 'ask_for_review_pending', false );

        if ( 'first' === $status ) {
            nk_theme()->update_option( 'ask_for_review_status', 'pending' );
            nk_theme()->update_option( 'ask_for_review_pending', time() + WEEK_IN_SECONDS );
        }

        if ( 'pending' === $status && time() >= $pending ) {
            nk_theme()->update_option( 'ask_for_review_status', 'show' );
            nk_theme()->update_option( 'ask_for_review_pending', false );
        }
    }

    /**
     * Show ask for review notice or nope.
     *
     * @return boolean
     */
    public function is_show_ask_for_review_notice() {
        return (
            nk_theme()->theme_dashboard()->theme_id &&
            nk_theme()->theme_dashboard()->theme_uri &&
            nk_theme()->theme_dashboard()->ask_for_review &&
            'show' === nk_theme()->get_option( 'ask_for_review_status', 'first' )
        );
    }

    /**
     * Set options
     *
     * @param array $options - options.
     */
    public function set_options( $options = array() ) {
        $default = array(
            // theme params.
            'theme_title'         => '',
            'theme_id'            => '',
            'theme_uri'           => '',
            'theme_version'       => '',
            'theme_documentation' => '',
            'theme_changelog'     => '',
            'ask_for_review'      => false,
            'is_envato_elements'  => false,
            'edd_name'            => '',

            // translators: %s - theme name.
            'top_button_text'     => esc_html__( '%s on ThemeForest', 'nk-themes-helper' ),
            'top_button_url'      => $this->theme_uri,
            // translators: %s - theme name.
            'foot_message'        => esc_html__( 'Thank you for choosing %s.', 'nk-themes-helper' ),
            'min_requirements'    => array(
                'php_version'        => '5.4.0',
                'memory_limit'       => '96M',
                'max_execution_time' => 40,
            ),
            'demos'    => array(
                // Example:
                //
                // 'main' => array(
                // 'title'      => esc_html__('Main', 'nk-themes-helper'),
                // 'preview'    => 'https://wp.nkdev.info/khaki/corporate/',
                // 'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/main.png'
                // 'demo_data'  => array(
                // 'woocommerce_options' => array(
                // 'shop_page_title' => 'Our Store',
                // 'cart_page_title' => 'Cart',
                // 'checkout_page_title' => 'Checkout',
                // 'myaccount_page_title' => 'My Account',
                // ),
                // 'navigations' => array(
                // 'Top Menu Icons' => 'top_icons_menu'
                // ),
                // 'demo_data_file' => $theme_demo_path . '/main/content.xml',
                // 'widgets_file' => $theme_demo_path . '/main/widgets.json',
                // 'customizer_file' => $theme_demo_path . '/main/customizer.dat',
                // )
                // ),
                // .
            ),
            'pages'    => array(
                'nk-theme' => array(
                    'title' => esc_html__( 'Dashboard', 'nk-themes-helper' ),
                    'template' => 'dashboard.php',
                ),
                'nk-theme-plugins' => array(
                    'title'    => esc_html__( 'Plugins', 'nk-themes-helper' ),
                    'template' => 'plugins.php',
                ),
                'nk-theme-demos' => array(
                    'title'    => esc_html__( 'Demo Import', 'nk-themes-helper' ),
                    'template' => 'demos.php',
                ),
                admin_url( 'customize.php' ) => array(
                    'external_uri' => true,
                    'title' => esc_html__( 'Customize', 'nk-themes-helper' ),
                ),
                'https://nk.ticksy.com/' => array(
                    'external_uri' => true,
                    'title' => esc_html__( 'Support', 'nk-themes-helper' ),
                ),
            ),
        );

        $this->options = array_merge( $default, $options );

        // set class variables.
        $theme_data = wp_get_theme();
        $theme_parent = $theme_data->parent();
        if ( ! empty( $theme_parent ) ) {
            $theme_data = $theme_parent;
        }

        $this->theme_slug = $theme_data->get_stylesheet();

        $this->theme_name = $this->options['theme_title'] ? : $theme_data->get( 'Name' );
        $this->theme_uri = $this->options['theme_uri'] ? : $theme_data->get( 'ThemeURI' );
        $this->theme_version = $this->options['theme_version'] ? : $theme_data->get( 'Version' );
        $this->theme_documentation = $this->options['theme_documentation'];
        $this->theme_changelog = $this->options['theme_changelog'];
        $this->theme_is_child = ! empty( $theme_parent );

        if ( $this->theme_documentation ) {
            $this->options['pages'][ $this->theme_documentation ] = array(
                'external_uri' => true,
                'title' => esc_html__( 'Documentation', 'nk-themes-helper' ),
            );
        }

        $this->theme_id = $this->options['theme_id'] ? : $this->theme_id;
        if ( ! $this->theme_id ) {
            $extra_headers = get_file_data(
                get_template_directory() . '/style.css', array(
                    'Theme ID' => 'Theme ID',
                ), 'nk_theme'
            );
            $this->theme_id = $extra_headers['Theme ID'];
        }

        $this->is_envato_hosted = defined( 'ENVATO_HOSTED_SITE' );
        if ( $this->is_envato_hosted ) {
            $this->theme_id = false;
        }

        $this->ask_for_review = isset( $this->options['ask_for_review'] ) ? $this->options['ask_for_review'] : $this->ask_for_review;
        $this->is_envato_elements = $this->options['is_envato_elements'];

        /* Hide dashboard page if Envato Hosted */
        if ( $this->is_envato_hosted ) {
            $default['pages']['nk-theme'] = $default['pages']['nk-theme-plugins'];
            unset( $default['pages']['nk-theme-plugins'] );
        }

        // dashboard texts.
        if ( ! isset( $this->options['top_message'] ) ) {
            $this->options['top_message'] = $this->is_envato_hosted || $this->is_envato_elements || $this->activation()->active ?
                // translators: %s - theme name.
                esc_html__( '%s is now installed and ready to use! We hope you enjoy it!', 'nk-themes-helper' )
                // translators: %s - theme name.
                : esc_html__( '%s is now installed and ready to use! Please activate your theme to get automatic updates and demo import. Read below for additional information. We hope you enjoy it!', 'nk-themes-helper' );
        }

        // hide top button for non activated Elements theme.
        if ( $this->is_envato_elements && ! $this->activation()->active ) {
            $this->options['top_button_text'] = '';
            $this->options['top_button_url'] = '';
        }

        $this->options['purchase_platform'] = $this->get_option( 'purchase_platform' );

        // check if the user activated theme and set platform.
        if ( ! $this->options['purchase_platform'] && $this->activation()->active ) {
            if ( $this->activation()->edd_license ) {
                $this->update_option( 'purchase_platform', 'nkdev' );
                $this->options['purchase_platform'] = 'nkdev';
            } else {
                $this->update_option( 'purchase_platform', 'themeforest' );
                $this->options['purchase_platform'] = 'themeforest';
            }
        }
    }

    /**
     * Options Manipulation
     */

    /**
     * Get options
     *
     * @return mixed
     */
    private function get_options() {
        $options_slug = 'nk_theme_' . $this->theme_name . '_options';
        return get_option( $options_slug, array() );
    }

    /**
     * Update option
     *
     * @param string $name - option name.
     * @param mixed  $value - option value.
     */
    public function update_option( $name, $value ) {
        $options_slug = 'nk_theme_' . $this->theme_name . '_options';
        $options = self::get_options();
        $options[ self::sanitize_key( $name ) ] = esc_html( $value );
        update_option( $options_slug, $options );
    }

    /**
     * Get option
     *
     * @param string $name - option name.
     * @param mixed  $default - default value.
     *
     * @return mixed
     */
    public function get_option( $name, $default = null ) {
        $options = self::get_options();
        $name = self::sanitize_key( $name );
        return isset( $options[ $name ] ) ? $options[ $name ] : $default;
    }

    /**
     * Sanitize key
     *
     * @param string $key - key.
     *
     * @return mixed
     */
    private function sanitize_key( $key ) {
        return preg_replace( '/[^A-Za-z0-9\_]/i', '', str_replace( array( '-', ':' ), '_', $key ) );
    }

    /**
     * Classes
     */

    /**
     * Pages
     *
     * @return NK_Helper_Theme_Dashboard_Pages|object
     */
    public function pages() {
        return NK_Helper_Theme_Dashboard_Pages::instance();
    }

    /**
     * Activation
     *
     * @return NK_Helper_Theme_Dashboard_Activation|object
     */
    public function activation() {
        return NK_Helper_Theme_Dashboard_Activation::instance();
    }

    /**
     * Updater
     *
     * @return NK_Helper_Theme_Dashboard_Updater|object
     */
    public function updater() {
        return NK_Helper_Theme_Dashboard_Updater::instance();
    }

    /**
     * Init dashboard code
     */
    public function setup() {
        // init classes.
        $this->updater();
        $this->pages();
        $this->activation();
    }
}
