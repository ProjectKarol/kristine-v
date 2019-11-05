<?php
/**
 * nK Accordion
 *
 * Example:
 * [nk_accordion]
 *    [nk_accordion_tab title="Home" active="true"]...[/nk_accordion_tab]
 *    [nk_accordion_tab title="Other"]...[/nk_accordion_tab]
 * [/nk_accordion]
 */

add_shortcode('nk_accordion', 'nk_accordion');
if ( ! function_exists( 'nk_accordion' ) ) :
    function nk_accordion($atts, $content = null) {
        STATIC $id = 0;
        $id++;

        extract( shortcode_atts( array(
            'class'   => ''
        ), $atts ) );

        // extract tabs content
        $reg = get_shortcode_regex();
        preg_match_all('~'.$reg.'~',$content, $matches);
        $tab_contents = array();
        if ( isset( $matches[5] ) ) {
            $tab_contents = $matches[5];
        }

        // extract tab titles
        preg_match_all( '/nk_accordion_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
        $tab_titles = array();
        if ( isset( $matches[1] ) ) {
            $tab_titles = $matches[1];
        }

        $result = '';
        $tabID = 0;
        foreach ( $tab_titles as $tab ) {
            $tab_atts = shortcode_parse_atts($tab[0]);

            if(!isset($tab_atts['active'])) {
                $tab_atts['active'] = false;
            }
            if(!isset($tab_atts['title'])) {
                $tab_atts['title'] = "";
            }

            $fullTabID = 'tab-' . $id . '-' . $tabID;
            $collaspes_class = !$tab_atts['active'] ? ' class="collapsed"' : '';
            // additional classname for custom styles VC
            $tab_class = khaki_get_css_tab_class($tab_atts);

            $result .=
                '<div class="panel panel-default ' . khaki_sanitize_class($tab_class) . '">
                    <div class="panel-heading" role="tab" id="' . esc_attr('heading-' . $fullTabID) . '">
                        <div class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion' . esc_attr($id) . '" href="' . esc_url('#collapse-'. $fullTabID) . '" aria-expanded="true" aria-controls="' . esc_attr('collapse-'. $fullTabID) . '"'.$collaspes_class.'>
                          ' . esc_html($tab_atts['title']) . '
                            </a>
                        </div>
                    </div>
                    <div id="' . esc_attr('collapse-'. $fullTabID) . '" class="panel-collapse collapse '. (khaki_nk_check($tab_atts['active'])?' show':'') . '" role="tabpanel" aria-labelledby="' . esc_attr('heading-' . $fullTabID) . '">
                        <div class="panel-body">
                            <div class="nk-gap-1"></div>
                            ' . do_shortcode($tab_contents[$tabID]) . '
                            <div class="nk-gap-1"></div>
                        </div>
                    </div>
                 </div>';

            $tabID++;
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div class="panel-group nk-accordion ' . khaki_sanitize_class($class) . '" id="' . esc_attr('accordion' . $id) . '" role="tablist" aria-multiselectable="false">' . $result . '</div>';
    }
endif;

// each tab shortcode
add_shortcode('nk_accordion_tab', 'nk_accordion_tab');
if ( ! function_exists( 'nk_accordion_tab' ) ) :
    function nk_accordion_tab($atts, $content = null) {
        extract( shortcode_atts( array(
            'title'  => "Section",
            'active' => false
        ), $atts ) );

        return '<div class="panel-body">
                  ' . do_shortcode($content) . '
                </div>';
    }
endif;



/* Add VC Shortcode */
add_action( "after_setup_theme", "vc_nk_accordion" );
if ( ! function_exists( 'vc_nk_accordion' ) ) :
    function vc_nk_accordion() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name'               => esc_html__('nK Accordion', 'khaki-shortcodes'),
                'base'               => 'nk_accordion',
                'show_settings_on_create' => false,
                'is_container'       => true,
                'category'           => 'nK',
                'icon'               => 'icon-nk icon-nk-accordion',
                'admin_enqueue_css'  => khaki_shortcodes()->plugin_url . 'shortcodes/css/nk-accordion-vc-view.css',
                'admin_enqueue_js'   => khaki_shortcodes()->plugin_url . 'shortcodes/js/nk-accordion-vc-view.js',
                'params' => array_merge(array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Custom Classes', 'khaki-shortcodes' ),
                        'param_name' => 'class',
                        'description' => ''
                    )
                ), khaki_get_css_tab()),
                'custom_markup' => "
                    <div class='wpb_accordion_holder wpb_holder clearfix vc_container_for_children'>
                    %content%
                    </div>
                    <div class='tab_controls'>
                        <a class='add_tab' title='" . esc_html__( "Add section", 'khaki-shortcodes' ) . "'><span class='vc_icon'></span> <span class='tab-label'>" . esc_html__( "Add section", 'khaki-shortcodes' ) . "</span></a>
                    </div>",
                'default_content' => "
                    [nk_accordion_tab title='" . esc_html__( "Section 1", 'khaki-shortcodes' ) . "'][/nk_accordion_tab]
                    [nk_accordion_tab title='" . esc_html__( "Section 2", 'khaki-shortcodes' ) . "'][/nk_accordion_tab]
                ",
                'js_view' => 'nKAccordionView'
            ) );
        }
    }
endif;

add_action( "after_setup_theme", "vc_nk_accordion_tab" );
if ( ! function_exists( 'vc_nk_accordion_tab' ) ) :
    function vc_nk_accordion_tab() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name'             => esc_html__('nK Accordion Content', 'khaki-shortcodes'),
                'base'             => 'nk_accordion_tab',
                'category'         => 'nK',
                'icon'             => 'icon-nk icon-nk-accordion',
                'allowed_container_element' => 'vc_row',
                'content_element'  => false,
                'is_container'     => true,
                'params'           => array_merge(array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Title', 'khaki-shortcodes'),
                        'param_name'  => 'title',
                        'description' => '',
                    ),
                    array(
                        'type'       => 'checkbox',
                        'heading'    => esc_html__( 'Active', 'khaki-shortcodes' ),
                        'param_name' => 'active',
                        'value'      => array( '' => true )
                    ),
                ), khaki_get_css_tab()),
                'js_view' => 'nKAccordionTabView'
            ) );
        }
    }
endif;



if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nk_accordion extends WPBakeryShortCodesContainer {
        protected $controls_css_settings = 'out-tc vc_controls-content-widget';

        public function __construct( $settings ) {
            parent::__construct( $settings );
        }

        public function contentAdmin($atts, $content = NULL) {
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

            $output = '';

            $elem = $this->getElementHolder( $width );

            $inner = '';
            foreach ( $this->settings['params'] as $param ) {
                $param_value = '';
                $param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
                if ( is_array( $param_value ) ) {
                    // Get first element from the array
                    reset( $param_value );
                    $first_key = key( $param_value );
                    $param_value = $param_value[ $first_key ];
                }
                $inner .= $this->singleParamHtmlHolder( $param, $param_value );
            }
            $tmp = '';

            if ( isset( $this->settings["custom_markup"] ) && $this->settings["custom_markup"] != '' ) {
                if ( $content != '' ) {
                    $custom_markup = str_ireplace( "%content%", $tmp . $content, $this->settings["custom_markup"] );
                } else if ( $content == '' && isset( $this->settings["default_content_in_template"] ) && $this->settings["default_content_in_template"] != '' ) {
                    $custom_markup = str_ireplace( "%content%", $this->settings["default_content_in_template"], $this->settings["custom_markup"] );
                } else {
                    $custom_markup = str_ireplace( "%content%", '', $this->settings["custom_markup"] );
                }
                $inner .= do_shortcode( $custom_markup );
            }
            $elem = str_ireplace( '%wpb_element_content%', $inner, $elem );
            $output = $elem;

            return $output;
        }
    }
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nk_accordion_tab extends WPBakeryShortCodesContainer {
        protected $controls_css_settings = 'tc vc_control-container';
        protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
        protected $predefined_atts = array(
            'class' => '',
            'width' => '',
            'title' => ''
        );
        protected $controls_template_file = 'editors/partials/backend_controls_tab.tpl.php';

        public function contentAdmin( $atts, $content = null ) {
            $width = $class = $title = '';
            extract( shortcode_atts( $this->predefined_atts, $atts ) );

            $column_controls = $this->getColumnControls( $this->settings( 'controls' ) );
            $column_controls_bottom = $this->getColumnControls( 'add', 'bottom-controls' );

            $output = '';

            $output .= '<div class="group wpb_sortable">';
            $output .= '<h3><span class="tab-label"><%= params.title %></span></h3>';

            $output .= $this->getElementHolder('1/1');

            $inner = '';
            $inner .= '<h4 class="wpb_element_title"> <i title="'.$this->settings['name'].'" class="vc_element-icon '.$this->settings['icon'].'"></i> </h4>';

            $inner .= '<div ' . $this->containerHtmlBlockParams( 100, 1 ) . '>';
            $inner .= do_shortcode( shortcode_unautop( $content ) );
            $inner .= '</div>';

            $inner .= $column_controls_bottom;

            $output .= '</div>';

            $output = str_ireplace( '%wpb_element_content%', $inner, $output );

            return $output;
        }

        public function mainHtmlBlockParams( $width, $i ) {
            return 'data-element_type="' . $this->settings["base"] . '" class=" wpb_' . $this->settings['base'] . '"' . $this->customAdminBlockParams();
        }

        public function containerHtmlBlockParams( $width, $i ) {
            return 'class="wpb_column_container vc_container_for_children"';
        }

        public function getColumnControls($controls = 'full', $extended_css = '') {
            return $this->getColumnControlsModular( $extended_css );
        }
    }
}
