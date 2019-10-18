<?php
/**
 * nK Admin for nK Themes
 * http://themeforest.net/user/_nk/portfolio
 *
 * @package nK
 */
if(!class_exists('nK_Admin')):
class nK_Admin {
    /**
     * The single class instance.
     *
     * @since 1.0.0
     * @access private
     *
     * @var object
     */
    private static $_instance = null;

    /**
    * Main Instance
    * Ensures only one instance of this class exists in memory at any one time.
    *
    */
    public static function instance () {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
            self::$_instance->init_globals();
            self::$_instance->init_includes();
            self::$_instance->init_actions();
        }
        return self::$_instance;
    }

    private function __construct () {
        /* We do nothing here! */
    }

    /**
     * Init Global variables
     */
    private function init_globals () {
        $this->admin_path = get_template_directory() . '/admin';
        $this->admin_uri = get_template_directory_uri() . '/admin';

        // get theme data
        $theme_data = wp_get_theme();
        $theme_parent = $theme_data->parent();
        if(!empty($theme_parent)) {
            $theme_data = $theme_parent;
        }

        $this->theme_slug = $theme_data->get_stylesheet();
        $this->theme_name = $theme_data['Name'];
        $this->theme_version = $theme_data['Version'];
        $this->theme_uri = $theme_data->get('ThemeURI');
        $this->theme_is_child = !empty($theme_parent);

        $extra_headers = get_file_data(get_template_directory() . '/style.css', array(
            'Theme ID' => 'Theme ID'
        ), 'nk_theme');
        $this->theme_id = $extra_headers['Theme ID'];
    }

    /**
     * Init Included Files
     */
    private function init_includes () {
        require $this->admin_path . '/nk-options.php';
        require $this->admin_path . '/theme-options.php';
        require $this->admin_path . '/theme-metaboxes.php';
        require $this->admin_path . '/menu/backend-walker.php';
        require $this->admin_path . '/menu/frontend-walker.php';
        require $this->admin_path . '/menu/frontend-walker-no-mega.php';

        if(is_admin()) {
            require $this->admin_path . '/plugins-activation.php';
        }

        // init dashboard
        require $this->admin_path . '/admin-init.php';
    }

    /**
     * Setup the hooks, actions and filters.
     */
    private function init_actions () {
        if (is_admin()) {
            add_action('admin_print_styles', array($this, 'admin_print_styles'));
        }
    }

    /**
     * Print Styles
     */
    public function admin_print_styles () {
        wp_enqueue_style('fontawesome', $this->admin_uri . '/assets/css/font-awesome.min.css');
        wp_enqueue_style('ionicons', get_template_directory_uri() . '/assets/vendor/ionicons/dist/css/ionicons.min.css');
        wp_enqueue_style('bootstrap-icons', $this->admin_uri . '/assets/css/bootstrap-icons.min.css');
        wp_enqueue_style('nk-admin-style', $this->admin_uri . '/assets/css/style.css');

        wp_enqueue_script('popup-upload-files-script', $this->admin_uri . '/assets/js/popup-upload-files.js', '', '', true);
    }
}
endif;
if ( ! function_exists( 'nk_admin' ) ) :
function nk_admin() {
	return nK_Admin::instance();
}
endif;

nk_admin();
