<?php
/**
 * nK Tabs
 *
 * Example:
 * [nk_tabs]
 *    [nk_tab title="Home" active="true"]...[/nk_tab]
 *    [nk_tab title="Other"]...[/nk_tab]
 * [/nk_tabs]
 */

add_shortcode('nk_tabs', 'nk_tabs');
if ( ! function_exists( 'nk_tabs' ) ) :
    function nk_tabs($atts, $content = null) {
        global $nk_tabs_id;

        if(!$nk_tabs_id) {
            $nk_tabs_id = 0;
        }
        $nk_tabs_id++;

        extract(shortcode_atts(array(
            "class"  => ""
        ), $atts));

        // Extract tab titles
        preg_match_all( '/nk_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
        $tab_titles = array();
        if ( isset( $matches[1] ) ) {
            $tab_titles = $matches[1];
        }

        // prepare tabs nav
        $tabs_nav = '';
        $tabs_nav .= '<ul class="nav nav-tabs" role="tablist">';
        $activateTab = 0;
        foreach ( $tab_titles as $tab ) {
            $tab_atts = shortcode_parse_atts($tab[0]);
            if(!isset($tab_atts['active'])) {
                $tab_atts['active'] = false;
            }

            if(isset($tab_atts['title'])) {
                $tabID = esc_attr('tab' . '-' . $nk_tabs_id . '-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ));
                $tabs_nav .=
                    '<li role="presentation" class="nav-item">
                        <a href="' . esc_url('#' .  $tabID) . '" class="nav-link ' . (khaki_nk_check($tab_atts['active']) ? 'active' : '') . '" aria-controls="' .  esc_attr($tabID) . '" role="tab" data-toggle="tab" aria-expanded="true">' . esc_html($tab_atts['title']) . '</a>
                    </li>';
            }
        }
        $tabs_nav .= '</ul>';

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div role="tabpanel" class="nk-tabs ' . khaki_sanitize_class($class) . '">'
                   . $tabs_nav .
                   '<div class="tab-content">
                        ' . khaki_remove_wpautop($content, true) . '
                    </div>
                </div>';
    }
endif;

// each tab shortcode
add_shortcode('nk_tab', 'nk_tab');
if ( ! function_exists( 'nk_tab' ) ) :
    function nk_tab($atts, $content = null) {
        global $nk_tabs_id;

        extract(shortcode_atts(array(
            "title"  => "",
            "tab_id" => null,
            "active" => "",
            "class"  => ""
        ), $atts));

        $tab_id = 'tab' . '-' . $nk_tabs_id . '-' . ( isset( $tab_id ) ? $tab_id : sanitize_title( $title ) );

        $result = '';

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        if(isset($title)) {
            $result .= '<div role="tabpanel" class="tab-pane fade ' . (khaki_nk_check($active) ? 'active show' : '') . ' ' . khaki_sanitize_class($class) . '" id="' . esc_attr($tab_id) . '">
                        <div class="nk-gap-1"></div>
                        ' . khaki_remove_wpautop($content, true) . '
                        <div class="nk-gap-1"></div>
                    </div>';
        }

        return $result;
    }
endif;



/* Add VC Shortcode */
add_action( "after_setup_theme", "vc_nk_tabs" );
if ( ! function_exists( 'vc_nk_tabs' ) ) :
    function vc_nk_tabs() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"                    => esc_html__("nK Tabs", 'khaki-shortcodes'),
                "base"                    => "nk_tabs",
                "category"                => "nK",
                "icon"                    => "icon-nk icon-nk-tabs",
                "show_settings_on_create" => false,
                "is_container"            => true,
                "admin_enqueue_js"        => khaki_shortcodes()->plugin_url . "shortcodes/js/nk-tabs-vc-view.js",
                "admin_enqueue_css"       => khaki_shortcodes()->plugin_url . "shortcodes/css/nk-tabs-vc-view.css",
                "params"                  => array_merge(array(
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Custom Classes", 'khaki-shortcodes'),
                        "param_name"  => "class",
                        "value"       => "",
                        "description" => "",
                    ),
                ), khaki_get_css_tab()),
                "custom_markup" => "
                    <div class='wpb_tabs_holder wpb_holder vc_container_for_children'>
                        <ul class='tabs_controls'>
                        </ul>
                        %content%
                    </div>",
                "default_content" => "
                    [nk_tab title='" . esc_html__( 'Tab 1', 'khaki-shortcodes' ) . "' active='true'][/nk_tab]
                    [nk_tab title='" . esc_html__( 'Tab 2', 'khaki-shortcodes' ) . "'][/nk_tab]",
                "js_view" => "nKTabsView"
            ) );
        }
    }
endif;

add_action( "after_setup_theme", "vc_nk_single_tab" );
if ( ! function_exists( 'vc_nk_single_tab' ) ) :
    function vc_nk_single_tab() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"             => esc_html__("nK Single Tab", 'khaki-shortcodes'),
                "base"             => "nk_tab",
                "category"         => "nK",
                "icon"             => "icon-nk icon-nk-tabs",
                "allowed_container_element" => "vc_row",
                "content_element"  => false,
                "is_container"     => true,
                "params"           => array_merge(array(
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Title", 'khaki-shortcodes'),
                        "param_name"  => "title",
                        "description" => "",
                    ),
                    array(
                        "type"       => "checkbox",
                        "heading"    => esc_html__( "Active", 'khaki-shortcodes' ),
                        "param_name" => "active",
                        "value"      => array( "" => true )
                    ),
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Custom Classes", 'khaki-shortcodes'),
                        "param_name"  => "class",
                        "value"       => "",
                        "description" => "",
                    ),
                ), khaki_get_css_tab()),
                "js_view" => "nKTabView"
            ) );
        }
    }
endif;



if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nk_tabs extends WPBakeryShortCodesContainer {
        static $filter_added = false;
        protected $controls_css_settings = 'out-tc vc_controls-content-widget';
        protected $controls_list = array( 'edit', 'clone', 'delete' );

        public function __construct( $settings ) {
            parent::__construct( $settings );
            // WPBakeryVisualComposer::getInstance()->addShortCode( array( 'base' => 'vc_tab' ) );
            if ( ! self::$filter_added ) {
                $this->addFilter( 'vc_inline_template_content', 'setCustomTabId' );
                self::$filter_added = true;
            }
        }

        public function contentAdmin( $atts, $content = null ) {
            $width = $custom_markup = '';
            $shortcode_attributes = array( 'width' => '1/1' );
            foreach ( $this->settings['params'] as $param ) {
                if ( $param['param_name'] != 'content' ) {
                    if ( isset( $param['value'] ) && is_string( $param['value'] ) ) {
                        $shortcode_attributes[ $param['param_name'] ] = $param['value'];
                    } elseif ( isset( $param['value'] ) ) {
                        $shortcode_attributes[ $param['param_name'] ] = $param['value'];
                    }
                } else if ( $param['param_name'] == 'content' && $content == null ) {
                    $content = $param['value'];
                }
            }
            extract( shortcode_atts(
                $shortcode_attributes
                , $atts ) );

            // Extract tab titles

            preg_match_all( '/nk_tab title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );

            $output = '';
            $tab_titles = array();

            if ( isset( $matches[0] ) ) {
                $tab_titles = $matches[0];
            }
            $tmp = '';
            if ( count( $tab_titles ) ) {
                $tmp .= '<ul class="clearfix tabs_controls">';
                foreach ( $tab_titles as $tab ) {
                    preg_match( '/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
                    if ( isset( $tab_matches[1][0] ) ) {
                        $tmp .= '<li><a href="#tab-' . ( isset( $tab_matches[3][0] ) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) . '">' . $tab_matches[1][0] . '</a></li>';

                    }
                }
                $tmp .= '</ul>' . "\n";
            } else {
                $output .= khaki_remove_wpautop( $content, true);
            }

            $elem = $this->getElementHolder( $width );

            $iner = '';
            foreach ( $this->settings['params'] as $param ) {
                $custom_markup = '';
                $param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
                if ( is_array( $param_value ) ) {
                    // Get first element from the array
                    reset( $param_value );
                    $first_key = key( $param_value );
                    $param_value = $param_value[ $first_key ];
                }
                $iner .= $this->singleParamHtmlHolder( $param, $param_value );
            }

            if ( isset( $this->settings["custom_markup"] ) && $this->settings["custom_markup"] != '' ) {
                if ( $content != '' ) {
                    $custom_markup = str_ireplace( "%content%", $tmp . $content, $this->settings["custom_markup"] );
                } else if ( $content == '' && isset( $this->settings["default_content"] ) && $this->settings["default_content"] != '' ) {
                    $custom_markup = str_ireplace( "%content%", $this->settings["default_content"], $this->settings["custom_markup"] );
                } else {
                    $custom_markup = str_ireplace( "%content%", '', $this->settings["custom_markup"] );
                }
                $iner .= do_shortcode( $custom_markup );
            }
            $elem = str_ireplace( '%wpb_element_content%', $iner, $elem );
            $output = $elem;

            return $output;
        }

        public function getTabTemplate() {
            return '<div class="wpb_template">' . do_shortcode( '[nk_tab title="Tab" tab_id=""][/nk_tab]' ) . '</div>';
        }

        public function setCustomTabId( $content ) {
            return preg_replace( '/tab\_id\=\"([^\"]+)\"/', 'tab_id="$1-' . time() . '"', $content );
        }
    }
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

    class WPBakeryShortCode_nk_tab extends WPBakeryShortCodesContainer {
        protected $controls_css_settings = 'tc vc_control-container';
        protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
        protected $predefined_atts = array(
            'tab_id' => TAB_TITLE,
            'title' => ''
        );
        protected $controls_template_file = 'editors/partials/backend_controls_tab.tpl.php';

        public function __construct( $settings ) {
            parent::__construct( $settings );
        }

        public function customAdminBlockParams() {
            return ' id="tab-' . $this->atts['tab_id'] . '"';
        }

        public function mainHtmlBlockParams( $width, $i ) {
            return 'data-element_type="' . $this->settings["base"] . '" class="wpb_' . $this->settings['base'] . ' wpb_sortable wpb_content_holder"' . $this->customAdminBlockParams();
        }

        public function containerHtmlBlockParams( $width, $i ) {
            return 'class="wpb_column_container vc_container_for_children"';
        }

        public function getColumnControls($controls = full, $extended_css = '') {
            return $this->getColumnControlsModular( $extended_css );
        }
    }
}
