<?php
/**
 * khaki Core
 */


// Check if $var isset / true / 1
if (!function_exists('khaki_nk_check')) :
    function khaki_nk_check($var)
    {
        return !(!isset($var) || $var === false || $var === 'false' || $var === 0 || $var === "0" || $var === "");
    }
endif;

//get all colors
if (!function_exists('khaki_get_colors')) :
    function khaki_get_colors()
    {
        return array(
            esc_html__('None', 'khaki-core') => false,
            esc_html__('Main 1', 'khaki-core') => "main-1",
            esc_html__('Main 2', 'khaki-core') => "main-2",
            esc_html__('Main 3', 'khaki-core') => "main-3",
            esc_html__('Main 4', 'khaki-core') => "main-4",
            esc_html__('Main 5', 'khaki-core') => "main-5",
            esc_html__('Primary', 'khaki-core') => "primary",
            esc_html__('Success', 'khaki-core') => "success",
            esc_html__('Info', 'khaki-core') => "info",
            esc_html__('Warning', 'khaki-core') => "warning",
            esc_html__('Danger', 'khaki-core') => "danger",
            esc_html__('White', 'khaki-core') => "white",
            esc_html__('Black', 'khaki-core') => "black",
            esc_html__('Dark 1', 'khaki-core') => "dark-1",
            esc_html__('Dark 2', 'khaki-core') => "dark-2",
            esc_html__('Dark 3', 'khaki-core') => "dark-3",
            esc_html__('Dark 4', 'khaki-core') => "dark-4",
            esc_html__('Gray 1', 'khaki-core') => "gray-1",
            esc_html__('Gray 2', 'khaki-core') => "gray-2",
            esc_html__('Gray 3', 'khaki-core') => "gray-3",
            esc_html__('Gray 4', 'khaki-core') => "gray-4",
        );
    }
endif;

// return attributes for shortcode if used mouse parallax
if (!function_exists('khaki_get_mouse_parallax_attrs')) :
    function khaki_get_mouse_parallax_attrs ($atts) {
        $enable = isset($atts['parallax_mouse']) ? $atts['parallax_mouse'] : '';
        $z = isset($atts['parallax_mouse_z']) ? $atts['parallax_mouse_z'] : '';
        $speed = isset($atts['parallax_mouse_speed']) ? $atts['parallax_mouse_speed'] : '';

        $result = ' ';
        if (khaki_nk_check($enable)) {
            if (khaki_nk_check($z)) {
                $result .= ' data-mouse-parallax-z="' . esc_attr($z) . '" ';
            }
            if (khaki_nk_check($speed)) {
                $result .= ' data-mouse-parallax-speed="' . esc_attr($speed / 1000) . '" ';
            }
        }
        return $result;
    }
endif;

// custom CSS tab
if (!function_exists('khaki_get_css_tab')) :
    function khaki_get_css_tab () {
        return array(
            array(
                'type'       => 'css_editor',
                'heading'    => esc_html__( 'CSS', 'khaki-core'),
                'param_name' => 'vc_css',
                'group'      => esc_html__( 'Design Options', 'khaki-core'),
            )
        );
    }
endif;

// return additional class from Visual Composer style tab
if (!function_exists('khaki_get_css_tab_class')) :
    function khaki_get_css_tab_class ($atts = array()) {
        $result = ' ';
        if (function_exists('vc_shortcode_custom_css_class') && isset($atts['vc_css'])) {
            $result = ' ' . vc_shortcode_custom_css_class($atts['vc_css']) . ' ';
        }
        return $result;
    }
endif;

//Add VC attach_audio control
if (!function_exists('vc_control_awb_attach_audio') && function_exists('vc_add_shortcode_param')) :
    vc_add_shortcode_param('awb_attach_audio', 'vc_control_awb_attach_audio', get_template_directory_uri() . '/admin/assets/js/attach-audio.js');
    function vc_control_awb_attach_audio($settings, $value)
    {
        if ($value && is_numeric($value)) {
            if (!$value) {
                $value = '';
            }
        }

        return '<div class="awb_attach_audio">
                        <input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />
                   </div>
                   <button class="awb_attach_audio_btn ' . ($value ? 'awb_attach_audio_btn_selected' : '') . ' button" data-select-title="' . esc_attr__('Select File', 'khaki-core') . '" data-remove-title="' . esc_attr__('&times;', 'khaki-core') . '">' . ($value ? esc_html__('&times;', 'khaki-core') : esc_html__('Select File', 'khaki-core')) . '</button>
                   <small class="awb_attach_audio_label">' . esc_html(basename($value)) . '</small>';
    }
endif;
//add additional icon pack to default Visual Composer set icons
if(!function_exists('khaki_filter_iconpicker')){
    function khaki_filter_iconpicker($icons){
        $custom_icons = array(
            esc_html__('Ionicons', 'khaki-core')=>
                array (
                    0 =>
                        array (
                            'ion-ios-add-circle-outline' => 'Add Circle Outline',
                        ),
                    1 =>
                        array (
                            'ion-md-add-circle-outline' => 'Add Circle Outline',
                        ),
                    2 =>
                        array (
                            'ion-ios-add-circle' => 'Add Circle',
                        ),
                    3 =>
                        array (
                            'ion-md-add-circle' => 'Add Circle',
                        ),
                    4 =>
                        array (
                            'ion-ios-add' => 'Add',
                        ),
                    5 =>
                        array (
                            'ion-md-add' => 'Add',
                        ),
                    6 =>
                        array (
                            'ion-ios-airplane' => 'Airplane',
                        ),
                    7 =>
                        array (
                            'ion-md-airplane' => 'Airplane',
                        ),
                    8 =>
                        array (
                            'ion-ios-alarm' => 'Alarm',
                        ),
                    9 =>
                        array (
                            'ion-md-alarm' => 'Alarm',
                        ),
                    10 =>
                        array (
                            'ion-ios-albums' => 'Albums',
                        ),
                    11 =>
                        array (
                            'ion-md-albums' => 'Albums',
                        ),
                    12 =>
                        array (
                            'ion-ios-alert' => 'Alert',
                        ),
                    13 =>
                        array (
                            'ion-md-alert' => 'Alert',
                        ),
                    14 =>
                        array (
                            'ion-ios-american-football' => 'American Football',
                        ),
                    15 =>
                        array (
                            'ion-md-american-football' => 'American Football',
                        ),
                    16 =>
                        array (
                            'ion-ios-analytics' => 'Analytics',
                        ),
                    17 =>
                        array (
                            'ion-md-analytics' => 'Analytics',
                        ),
                    18 =>
                        array (
                            'ion-ios-aperture' => 'Aperture',
                        ),
                    19 =>
                        array (
                            'ion-md-aperture' => 'Aperture',
                        ),
                    20 =>
                        array (
                            'ion-ios-apps' => 'Apps',
                        ),
                    21 =>
                        array (
                            'ion-md-apps' => 'Apps',
                        ),
                    22 =>
                        array (
                            'ion-ios-appstore' => 'Appstore',
                        ),
                    23 =>
                        array (
                            'ion-md-appstore' => 'Appstore',
                        ),
                    24 =>
                        array (
                            'ion-ios-archive' => 'Archive',
                        ),
                    25 =>
                        array (
                            'ion-md-archive' => 'Archive',
                        ),
                    26 =>
                        array (
                            'ion-ios-arrow-back' => 'Arrow Back',
                        ),
                    27 =>
                        array (
                            'ion-md-arrow-back' => 'Arrow Back',
                        ),
                    28 =>
                        array (
                            'ion-ios-arrow-down' => 'Arrow Down',
                        ),
                    29 =>
                        array (
                            'ion-md-arrow-down' => 'Arrow Down',
                        ),
                    30 =>
                        array (
                            'ion-ios-arrow-dropdown-circle' => 'Arrow Dropdown Circle',
                        ),
                    31 =>
                        array (
                            'ion-md-arrow-dropdown-circle' => 'Arrow Dropdown Circle',
                        ),
                    32 =>
                        array (
                            'ion-ios-arrow-dropdown' => 'Arrow Dropdown',
                        ),
                    33 =>
                        array (
                            'ion-md-arrow-dropdown' => 'Arrow Dropdown',
                        ),
                    34 =>
                        array (
                            'ion-ios-arrow-dropleft-circle' => 'Arrow Dropleft Circle',
                        ),
                    35 =>
                        array (
                            'ion-md-arrow-dropleft-circle' => 'Arrow Dropleft Circle',
                        ),
                    36 =>
                        array (
                            'ion-ios-arrow-dropleft' => 'Arrow Dropleft',
                        ),
                    37 =>
                        array (
                            'ion-md-arrow-dropleft' => 'Arrow Dropleft',
                        ),
                    38 =>
                        array (
                            'ion-ios-arrow-dropright-circle' => 'Arrow Dropright Circle',
                        ),
                    39 =>
                        array (
                            'ion-md-arrow-dropright-circle' => 'Arrow Dropright Circle',
                        ),
                    40 =>
                        array (
                            'ion-ios-arrow-dropright' => 'Arrow Dropright',
                        ),
                    41 =>
                        array (
                            'ion-md-arrow-dropright' => 'Arrow Dropright',
                        ),
                    42 =>
                        array (
                            'ion-ios-arrow-dropup-circle' => 'Arrow Dropup Circle',
                        ),
                    43 =>
                        array (
                            'ion-md-arrow-dropup-circle' => 'Arrow Dropup Circle',
                        ),
                    44 =>
                        array (
                            'ion-ios-arrow-dropup' => 'Arrow Dropup',
                        ),
                    45 =>
                        array (
                            'ion-md-arrow-dropup' => 'Arrow Dropup',
                        ),
                    46 =>
                        array (
                            'ion-ios-arrow-forward' => 'Arrow Forward',
                        ),
                    47 =>
                        array (
                            'ion-md-arrow-forward' => 'Arrow Forward',
                        ),
                    48 =>
                        array (
                            'ion-ios-arrow-round-back' => 'Arrow Round Back',
                        ),
                    49 =>
                        array (
                            'ion-md-arrow-round-back' => 'Arrow Round Back',
                        ),
                    50 =>
                        array (
                            'ion-ios-arrow-round-down' => 'Arrow Round Down',
                        ),
                    51 =>
                        array (
                            'ion-md-arrow-round-down' => 'Arrow Round Down',
                        ),
                    52 =>
                        array (
                            'ion-ios-arrow-round-forward' => 'Arrow Round Forward',
                        ),
                    53 =>
                        array (
                            'ion-md-arrow-round-forward' => 'Arrow Round Forward',
                        ),
                    54 =>
                        array (
                            'ion-ios-arrow-round-up' => 'Arrow Round Up',
                        ),
                    55 =>
                        array (
                            'ion-md-arrow-round-up' => 'Arrow Round Up',
                        ),
                    56 =>
                        array (
                            'ion-ios-arrow-up' => 'Arrow Up',
                        ),
                    57 =>
                        array (
                            'ion-md-arrow-up' => 'Arrow Up',
                        ),
                    58 =>
                        array (
                            'ion-ios-at' => 'At',
                        ),
                    59 =>
                        array (
                            'ion-md-at' => 'At',
                        ),
                    60 =>
                        array (
                            'ion-ios-attach' => 'Attach',
                        ),
                    61 =>
                        array (
                            'ion-md-attach' => 'Attach',
                        ),
                    62 =>
                        array (
                            'ion-ios-backspace' => 'Backspace',
                        ),
                    63 =>
                        array (
                            'ion-md-backspace' => 'Backspace',
                        ),
                    64 =>
                        array (
                            'ion-ios-barcode' => 'Barcode',
                        ),
                    65 =>
                        array (
                            'ion-md-barcode' => 'Barcode',
                        ),
                    66 =>
                        array (
                            'ion-ios-baseball' => 'Baseball',
                        ),
                    67 =>
                        array (
                            'ion-md-baseball' => 'Baseball',
                        ),
                    68 =>
                        array (
                            'ion-ios-basket' => 'Basket',
                        ),
                    69 =>
                        array (
                            'ion-md-basket' => 'Basket',
                        ),
                    70 =>
                        array (
                            'ion-ios-basketball' => 'Basketball',
                        ),
                    71 =>
                        array (
                            'ion-md-basketball' => 'Basketball',
                        ),
                    72 =>
                        array (
                            'ion-ios-battery-charging' => 'Battery Charging',
                        ),
                    73 =>
                        array (
                            'ion-md-battery-charging' => 'Battery Charging',
                        ),
                    74 =>
                        array (
                            'ion-ios-battery-dead' => 'Battery Dead',
                        ),
                    75 =>
                        array (
                            'ion-md-battery-dead' => 'Battery Dead',
                        ),
                    76 =>
                        array (
                            'ion-ios-battery-full' => 'Battery Full',
                        ),
                    77 =>
                        array (
                            'ion-md-battery-full' => 'Battery Full',
                        ),
                    78 =>
                        array (
                            'ion-ios-beaker' => 'Beaker',
                        ),
                    79 =>
                        array (
                            'ion-md-beaker' => 'Beaker',
                        ),
                    80 =>
                        array (
                            'ion-ios-bed' => 'Bed',
                        ),
                    81 =>
                        array (
                            'ion-md-bed' => 'Bed',
                        ),
                    82 =>
                        array (
                            'ion-ios-beer' => 'Beer',
                        ),
                    83 =>
                        array (
                            'ion-md-beer' => 'Beer',
                        ),
                    84 =>
                        array (
                            'ion-ios-bicycle' => 'Bicycle',
                        ),
                    85 =>
                        array (
                            'ion-md-bicycle' => 'Bicycle',
                        ),
                    86 =>
                        array (
                            'ion-ios-bluetooth' => 'Bluetooth',
                        ),
                    87 =>
                        array (
                            'ion-md-bluetooth' => 'Bluetooth',
                        ),
                    88 =>
                        array (
                            'ion-ios-boat' => 'Boat',
                        ),
                    89 =>
                        array (
                            'ion-md-boat' => 'Boat',
                        ),
                    90 =>
                        array (
                            'ion-ios-body' => 'Body',
                        ),
                    91 =>
                        array (
                            'ion-md-body' => 'Body',
                        ),
                    92 =>
                        array (
                            'ion-ios-bonfire' => 'Bonfire',
                        ),
                    93 =>
                        array (
                            'ion-md-bonfire' => 'Bonfire',
                        ),
                    94 =>
                        array (
                            'ion-ios-book' => 'Book',
                        ),
                    95 =>
                        array (
                            'ion-md-book' => 'Book',
                        ),
                    96 =>
                        array (
                            'ion-ios-bookmark' => 'Bookmark',
                        ),
                    97 =>
                        array (
                            'ion-md-bookmark' => 'Bookmark',
                        ),
                    98 =>
                        array (
                            'ion-ios-bookmarks' => 'Bookmarks',
                        ),
                    99 =>
                        array (
                            'ion-md-bookmarks' => 'Bookmarks',
                        ),
                    100 =>
                        array (
                            'ion-ios-bowtie' => 'Bowtie',
                        ),
                    101 =>
                        array (
                            'ion-md-bowtie' => 'Bowtie',
                        ),
                    102 =>
                        array (
                            'ion-ios-briefcase' => 'Briefcase',
                        ),
                    103 =>
                        array (
                            'ion-md-briefcase' => 'Briefcase',
                        ),
                    104 =>
                        array (
                            'ion-ios-browsers' => 'Browsers',
                        ),
                    105 =>
                        array (
                            'ion-md-browsers' => 'Browsers',
                        ),
                    106 =>
                        array (
                            'ion-ios-brush' => 'Brush',
                        ),
                    107 =>
                        array (
                            'ion-md-brush' => 'Brush',
                        ),
                    108 =>
                        array (
                            'ion-ios-bug' => 'Bug',
                        ),
                    109 =>
                        array (
                            'ion-md-bug' => 'Bug',
                        ),
                    110 =>
                        array (
                            'ion-ios-build' => 'Build',
                        ),
                    111 =>
                        array (
                            'ion-md-build' => 'Build',
                        ),
                    112 =>
                        array (
                            'ion-ios-bulb' => 'Bulb',
                        ),
                    113 =>
                        array (
                            'ion-md-bulb' => 'Bulb',
                        ),
                    114 =>
                        array (
                            'ion-ios-bus' => 'Bus',
                        ),
                    115 =>
                        array (
                            'ion-md-bus' => 'Bus',
                        ),
                    116 =>
                        array (
                            'ion-ios-business' => 'Business',
                        ),
                    117 =>
                        array (
                            'ion-md-business' => 'Business',
                        ),
                    118 =>
                        array (
                            'ion-ios-cafe' => 'Cafe',
                        ),
                    119 =>
                        array (
                            'ion-md-cafe' => 'Cafe',
                        ),
                    120 =>
                        array (
                            'ion-ios-calculator' => 'Calculator',
                        ),
                    121 =>
                        array (
                            'ion-md-calculator' => 'Calculator',
                        ),
                    122 =>
                        array (
                            'ion-ios-calendar' => 'Calendar',
                        ),
                    123 =>
                        array (
                            'ion-md-calendar' => 'Calendar',
                        ),
                    124 =>
                        array (
                            'ion-ios-call' => 'Call',
                        ),
                    125 =>
                        array (
                            'ion-md-call' => 'Call',
                        ),
                    126 =>
                        array (
                            'ion-ios-camera' => 'Camera',
                        ),
                    127 =>
                        array (
                            'ion-md-camera' => 'Camera',
                        ),
                    128 =>
                        array (
                            'ion-ios-car' => 'Car',
                        ),
                    129 =>
                        array (
                            'ion-md-car' => 'Car',
                        ),
                    130 =>
                        array (
                            'ion-ios-card' => 'Card',
                        ),
                    131 =>
                        array (
                            'ion-md-card' => 'Card',
                        ),
                    132 =>
                        array (
                            'ion-ios-cart' => 'Cart',
                        ),
                    133 =>
                        array (
                            'ion-md-cart' => 'Cart',
                        ),
                    134 =>
                        array (
                            'ion-ios-cash' => 'Cash',
                        ),
                    135 =>
                        array (
                            'ion-md-cash' => 'Cash',
                        ),
                    136 =>
                        array (
                            'ion-ios-cellular' => 'Cellular',
                        ),
                    137 =>
                        array (
                            'ion-md-cellular' => 'Cellular',
                        ),
                    138 =>
                        array (
                            'ion-ios-chatboxes' => 'Chatboxes',
                        ),
                    139 =>
                        array (
                            'ion-md-chatboxes' => 'Chatboxes',
                        ),
                    140 =>
                        array (
                            'ion-ios-chatbubbles' => 'Chatbubbles',
                        ),
                    141 =>
                        array (
                            'ion-md-chatbubbles' => 'Chatbubbles',
                        ),
                    142 =>
                        array (
                            'ion-ios-checkbox-outline' => 'Checkbox Outline',
                        ),
                    143 =>
                        array (
                            'ion-md-checkbox-outline' => 'Checkbox Outline',
                        ),
                    144 =>
                        array (
                            'ion-ios-checkbox' => 'Checkbox',
                        ),
                    145 =>
                        array (
                            'ion-md-checkbox' => 'Checkbox',
                        ),
                    146 =>
                        array (
                            'ion-ios-checkmark-circle-outline' => 'Checkmark Circle Outline',
                        ),
                    147 =>
                        array (
                            'ion-md-checkmark-circle-outline' => 'Checkmark Circle Outline',
                        ),
                    148 =>
                        array (
                            'ion-ios-checkmark-circle' => 'Checkmark Circle',
                        ),
                    149 =>
                        array (
                            'ion-md-checkmark-circle' => 'Checkmark Circle',
                        ),
                    150 =>
                        array (
                            'ion-ios-checkmark' => 'Checkmark',
                        ),
                    151 =>
                        array (
                            'ion-md-checkmark' => 'Checkmark',
                        ),
                    152 =>
                        array (
                            'ion-ios-clipboard' => 'Clipboard',
                        ),
                    153 =>
                        array (
                            'ion-md-clipboard' => 'Clipboard',
                        ),
                    154 =>
                        array (
                            'ion-ios-clock' => 'Clock',
                        ),
                    155 =>
                        array (
                            'ion-md-clock' => 'Clock',
                        ),
                    156 =>
                        array (
                            'ion-ios-close-circle-outline' => 'Close Circle Outline',
                        ),
                    157 =>
                        array (
                            'ion-md-close-circle-outline' => 'Close Circle Outline',
                        ),
                    158 =>
                        array (
                            'ion-ios-close-circle' => 'Close Circle',
                        ),
                    159 =>
                        array (
                            'ion-md-close-circle' => 'Close Circle',
                        ),
                    160 =>
                        array (
                            'ion-ios-close' => 'Close',
                        ),
                    161 =>
                        array (
                            'ion-md-close' => 'Close',
                        ),
                    162 =>
                        array (
                            'ion-ios-cloud-circle' => 'Cloud Circle',
                        ),
                    163 =>
                        array (
                            'ion-md-cloud-circle' => 'Cloud Circle',
                        ),
                    164 =>
                        array (
                            'ion-ios-cloud-done' => 'Cloud Done',
                        ),
                    165 =>
                        array (
                            'ion-md-cloud-done' => 'Cloud Done',
                        ),
                    166 =>
                        array (
                            'ion-ios-cloud-download' => 'Cloud Download',
                        ),
                    167 =>
                        array (
                            'ion-md-cloud-download' => 'Cloud Download',
                        ),
                    168 =>
                        array (
                            'ion-ios-cloud-outline' => 'Cloud Outline',
                        ),
                    169 =>
                        array (
                            'ion-md-cloud-outline' => 'Cloud Outline',
                        ),
                    170 =>
                        array (
                            'ion-ios-cloud-upload' => 'Cloud Upload',
                        ),
                    171 =>
                        array (
                            'ion-md-cloud-upload' => 'Cloud Upload',
                        ),
                    172 =>
                        array (
                            'ion-ios-cloud' => 'Cloud',
                        ),
                    173 =>
                        array (
                            'ion-md-cloud' => 'Cloud',
                        ),
                    174 =>
                        array (
                            'ion-ios-cloudy-night' => 'Cloudy Night',
                        ),
                    175 =>
                        array (
                            'ion-md-cloudy-night' => 'Cloudy Night',
                        ),
                    176 =>
                        array (
                            'ion-ios-cloudy' => 'Cloudy',
                        ),
                    177 =>
                        array (
                            'ion-md-cloudy' => 'Cloudy',
                        ),
                    178 =>
                        array (
                            'ion-ios-code-download' => 'Code Download',
                        ),
                    179 =>
                        array (
                            'ion-md-code-download' => 'Code Download',
                        ),
                    180 =>
                        array (
                            'ion-ios-code-working' => 'Code Working',
                        ),
                    181 =>
                        array (
                            'ion-md-code-working' => 'Code Working',
                        ),
                    182 =>
                        array (
                            'ion-ios-code' => 'Code',
                        ),
                    183 =>
                        array (
                            'ion-md-code' => 'Code',
                        ),
                    184 =>
                        array (
                            'ion-ios-cog' => 'Cog',
                        ),
                    185 =>
                        array (
                            'ion-md-cog' => 'Cog',
                        ),
                    186 =>
                        array (
                            'ion-ios-color-fill' => 'Color Fill',
                        ),
                    187 =>
                        array (
                            'ion-md-color-fill' => 'Color Fill',
                        ),
                    188 =>
                        array (
                            'ion-ios-color-filter' => 'Color Filter',
                        ),
                    189 =>
                        array (
                            'ion-md-color-filter' => 'Color Filter',
                        ),
                    190 =>
                        array (
                            'ion-ios-color-palette' => 'Color Palette',
                        ),
                    191 =>
                        array (
                            'ion-md-color-palette' => 'Color Palette',
                        ),
                    192 =>
                        array (
                            'ion-ios-color-wand' => 'Color Wand',
                        ),
                    193 =>
                        array (
                            'ion-md-color-wand' => 'Color Wand',
                        ),
                    194 =>
                        array (
                            'ion-ios-compass' => 'Compass',
                        ),
                    195 =>
                        array (
                            'ion-md-compass' => 'Compass',
                        ),
                    196 =>
                        array (
                            'ion-ios-construct' => 'Construct',
                        ),
                    197 =>
                        array (
                            'ion-md-construct' => 'Construct',
                        ),
                    198 =>
                        array (
                            'ion-ios-contact' => 'Contact',
                        ),
                    199 =>
                        array (
                            'ion-md-contact' => 'Contact',
                        ),
                    200 =>
                        array (
                            'ion-ios-contacts' => 'Contacts',
                        ),
                    201 =>
                        array (
                            'ion-md-contacts' => 'Contacts',
                        ),
                    202 =>
                        array (
                            'ion-ios-contract' => 'Contract',
                        ),
                    203 =>
                        array (
                            'ion-md-contract' => 'Contract',
                        ),
                    204 =>
                        array (
                            'ion-ios-contrast' => 'Contrast',
                        ),
                    205 =>
                        array (
                            'ion-md-contrast' => 'Contrast',
                        ),
                    206 =>
                        array (
                            'ion-ios-copy' => 'Copy',
                        ),
                    207 =>
                        array (
                            'ion-md-copy' => 'Copy',
                        ),
                    208 =>
                        array (
                            'ion-ios-create' => 'Create',
                        ),
                    209 =>
                        array (
                            'ion-md-create' => 'Create',
                        ),
                    210 =>
                        array (
                            'ion-ios-crop' => 'Crop',
                        ),
                    211 =>
                        array (
                            'ion-md-crop' => 'Crop',
                        ),
                    212 =>
                        array (
                            'ion-ios-cube' => 'Cube',
                        ),
                    213 =>
                        array (
                            'ion-md-cube' => 'Cube',
                        ),
                    214 =>
                        array (
                            'ion-ios-cut' => 'Cut',
                        ),
                    215 =>
                        array (
                            'ion-md-cut' => 'Cut',
                        ),
                    216 =>
                        array (
                            'ion-ios-desktop' => 'Desktop',
                        ),
                    217 =>
                        array (
                            'ion-md-desktop' => 'Desktop',
                        ),
                    218 =>
                        array (
                            'ion-ios-disc' => 'Disc',
                        ),
                    219 =>
                        array (
                            'ion-md-disc' => 'Disc',
                        ),
                    220 =>
                        array (
                            'ion-ios-document' => 'Document',
                        ),
                    221 =>
                        array (
                            'ion-md-document' => 'Document',
                        ),
                    222 =>
                        array (
                            'ion-ios-done-all' => 'Done All',
                        ),
                    223 =>
                        array (
                            'ion-md-done-all' => 'Done All',
                        ),
                    224 =>
                        array (
                            'ion-ios-download' => 'Download',
                        ),
                    225 =>
                        array (
                            'ion-md-download' => 'Download',
                        ),
                    226 =>
                        array (
                            'ion-ios-easel' => 'Easel',
                        ),
                    227 =>
                        array (
                            'ion-md-easel' => 'Easel',
                        ),
                    228 =>
                        array (
                            'ion-ios-egg' => 'Egg',
                        ),
                    229 =>
                        array (
                            'ion-md-egg' => 'Egg',
                        ),
                    230 =>
                        array (
                            'ion-ios-exit' => 'Exit',
                        ),
                    231 =>
                        array (
                            'ion-md-exit' => 'Exit',
                        ),
                    232 =>
                        array (
                            'ion-ios-expand' => 'Expand',
                        ),
                    233 =>
                        array (
                            'ion-md-expand' => 'Expand',
                        ),
                    234 =>
                        array (
                            'ion-ios-eye-off' => 'Eye Off',
                        ),
                    235 =>
                        array (
                            'ion-md-eye-off' => 'Eye Off',
                        ),
                    236 =>
                        array (
                            'ion-ios-eye' => 'Eye',
                        ),
                    237 =>
                        array (
                            'ion-md-eye' => 'Eye',
                        ),
                    238 =>
                        array (
                            'ion-ios-fastforward' => 'Fastforward',
                        ),
                    239 =>
                        array (
                            'ion-md-fastforward' => 'Fastforward',
                        ),
                    240 =>
                        array (
                            'ion-ios-female' => 'Female',
                        ),
                    241 =>
                        array (
                            'ion-md-female' => 'Female',
                        ),
                    242 =>
                        array (
                            'ion-ios-filing' => 'Filing',
                        ),
                    243 =>
                        array (
                            'ion-md-filing' => 'Filing',
                        ),
                    244 =>
                        array (
                            'ion-ios-film' => 'Film',
                        ),
                    245 =>
                        array (
                            'ion-md-film' => 'Film',
                        ),
                    246 =>
                        array (
                            'ion-ios-finger-print' => 'Finger Print',
                        ),
                    247 =>
                        array (
                            'ion-md-finger-print' => 'Finger Print',
                        ),
                    248 =>
                        array (
                            'ion-ios-fitness' => 'Fitness',
                        ),
                    249 =>
                        array (
                            'ion-md-fitness' => 'Fitness',
                        ),
                    250 =>
                        array (
                            'ion-ios-flag' => 'Flag',
                        ),
                    251 =>
                        array (
                            'ion-md-flag' => 'Flag',
                        ),
                    252 =>
                        array (
                            'ion-ios-flame' => 'Flame',
                        ),
                    253 =>
                        array (
                            'ion-md-flame' => 'Flame',
                        ),
                    254 =>
                        array (
                            'ion-ios-flash-off' => 'Flash Off',
                        ),
                    255 =>
                        array (
                            'ion-md-flash-off' => 'Flash Off',
                        ),
                    256 =>
                        array (
                            'ion-ios-flash' => 'Flash',
                        ),
                    257 =>
                        array (
                            'ion-md-flash' => 'Flash',
                        ),
                    258 =>
                        array (
                            'ion-ios-flashlight' => 'Flashlight',
                        ),
                    259 =>
                        array (
                            'ion-md-flashlight' => 'Flashlight',
                        ),
                    260 =>
                        array (
                            'ion-ios-flask' => 'Flask',
                        ),
                    261 =>
                        array (
                            'ion-md-flask' => 'Flask',
                        ),
                    262 =>
                        array (
                            'ion-ios-flower' => 'Flower',
                        ),
                    263 =>
                        array (
                            'ion-md-flower' => 'Flower',
                        ),
                    264 =>
                        array (
                            'ion-ios-folder-open' => 'Folder Open',
                        ),
                    265 =>
                        array (
                            'ion-md-folder-open' => 'Folder Open',
                        ),
                    266 =>
                        array (
                            'ion-ios-folder' => 'Folder',
                        ),
                    267 =>
                        array (
                            'ion-md-folder' => 'Folder',
                        ),
                    268 =>
                        array (
                            'ion-ios-football' => 'Football',
                        ),
                    269 =>
                        array (
                            'ion-md-football' => 'Football',
                        ),
                    270 =>
                        array (
                            'ion-ios-funnel' => 'Funnel',
                        ),
                    271 =>
                        array (
                            'ion-md-funnel' => 'Funnel',
                        ),
                    272 =>
                        array (
                            'ion-ios-gift' => 'Gift',
                        ),
                    273 =>
                        array (
                            'ion-md-gift' => 'Gift',
                        ),
                    274 =>
                        array (
                            'ion-ios-git-branch' => 'Git Branch',
                        ),
                    275 =>
                        array (
                            'ion-md-git-branch' => 'Git Branch',
                        ),
                    276 =>
                        array (
                            'ion-ios-git-commit' => 'Git Commit',
                        ),
                    277 =>
                        array (
                            'ion-md-git-commit' => 'Git Commit',
                        ),
                    278 =>
                        array (
                            'ion-ios-git-compare' => 'Git Compare',
                        ),
                    279 =>
                        array (
                            'ion-md-git-compare' => 'Git Compare',
                        ),
                    280 =>
                        array (
                            'ion-ios-git-merge' => 'Git Merge',
                        ),
                    281 =>
                        array (
                            'ion-md-git-merge' => 'Git Merge',
                        ),
                    282 =>
                        array (
                            'ion-ios-git-network' => 'Git Network',
                        ),
                    283 =>
                        array (
                            'ion-md-git-network' => 'Git Network',
                        ),
                    284 =>
                        array (
                            'ion-ios-git-pull-request' => 'Git Pull Request',
                        ),
                    285 =>
                        array (
                            'ion-md-git-pull-request' => 'Git Pull Request',
                        ),
                    286 =>
                        array (
                            'ion-ios-glasses' => 'Glasses',
                        ),
                    287 =>
                        array (
                            'ion-md-glasses' => 'Glasses',
                        ),
                    288 =>
                        array (
                            'ion-ios-globe' => 'Globe',
                        ),
                    289 =>
                        array (
                            'ion-md-globe' => 'Globe',
                        ),
                    290 =>
                        array (
                            'ion-ios-grid' => 'Grid',
                        ),
                    291 =>
                        array (
                            'ion-md-grid' => 'Grid',
                        ),
                    292 =>
                        array (
                            'ion-ios-hammer' => 'Hammer',
                        ),
                    293 =>
                        array (
                            'ion-md-hammer' => 'Hammer',
                        ),
                    294 =>
                        array (
                            'ion-ios-hand' => 'Hand',
                        ),
                    295 =>
                        array (
                            'ion-md-hand' => 'Hand',
                        ),
                    296 =>
                        array (
                            'ion-ios-happy' => 'Happy',
                        ),
                    297 =>
                        array (
                            'ion-md-happy' => 'Happy',
                        ),
                    298 =>
                        array (
                            'ion-ios-headset' => 'Headset',
                        ),
                    299 =>
                        array (
                            'ion-md-headset' => 'Headset',
                        ),
                    300 =>
                        array (
                            'ion-ios-heart' => 'Heart',
                        ),
                    301 =>
                        array (
                            'ion-md-heart' => 'Heart',
                        ),
                    302 =>
                        array (
                            'ion-ios-heart-dislike' => 'Heart Dislike',
                        ),
                    303 =>
                        array (
                            'ion-md-heart-dislike' => 'Heart Dislike',
                        ),
                    304 =>
                        array (
                            'ion-ios-heart-empty' => 'Heart Empty',
                        ),
                    305 =>
                        array (
                            'ion-md-heart-empty' => 'Heart Empty',
                        ),
                    306 =>
                        array (
                            'ion-ios-heart-half' => 'Heart Half',
                        ),
                    307 =>
                        array (
                            'ion-md-heart-half' => 'Heart Half',
                        ),
                    308 =>
                        array (
                            'ion-ios-help-buoy' => 'Help Buoy',
                        ),
                    309 =>
                        array (
                            'ion-md-help-buoy' => 'Help Buoy',
                        ),
                    310 =>
                        array (
                            'ion-ios-help-circle-outline' => 'Help Circle Outline',
                        ),
                    311 =>
                        array (
                            'ion-md-help-circle-outline' => 'Help Circle Outline',
                        ),
                    312 =>
                        array (
                            'ion-ios-help-circle' => 'Help Circle',
                        ),
                    313 =>
                        array (
                            'ion-md-help-circle' => 'Help Circle',
                        ),
                    314 =>
                        array (
                            'ion-ios-help' => 'Help',
                        ),
                    315 =>
                        array (
                            'ion-md-help' => 'Help',
                        ),
                    316 =>
                        array (
                            'ion-ios-home' => 'Home',
                        ),
                    317 =>
                        array (
                            'ion-md-home' => 'Home',
                        ),
                    318 =>
                        array (
                            'ion-ios-hourglass' => 'Hourglass',
                        ),
                    319 =>
                        array (
                            'ion-md-hourglass' => 'Hourglass',
                        ),
                    320 =>
                        array (
                            'ion-ios-ice-cream' => 'Ice Cream',
                        ),
                    321 =>
                        array (
                            'ion-md-ice-cream' => 'Ice Cream',
                        ),
                    322 =>
                        array (
                            'ion-ios-image' => 'Image',
                        ),
                    323 =>
                        array (
                            'ion-md-image' => 'Image',
                        ),
                    324 =>
                        array (
                            'ion-ios-images' => 'Images',
                        ),
                    325 =>
                        array (
                            'ion-md-images' => 'Images',
                        ),
                    326 =>
                        array (
                            'ion-ios-infinite' => 'Infinite',
                        ),
                    327 =>
                        array (
                            'ion-md-infinite' => 'Infinite',
                        ),
                    328 =>
                        array (
                            'ion-ios-information-circle-outline' => 'Information Circle Outline',
                        ),
                    329 =>
                        array (
                            'ion-md-information-circle-outline' => 'Information Circle Outline',
                        ),
                    330 =>
                        array (
                            'ion-ios-information-circle' => 'Information Circle',
                        ),
                    331 =>
                        array (
                            'ion-md-information-circle' => 'Information Circle',
                        ),
                    332 =>
                        array (
                            'ion-ios-information' => 'Information',
                        ),
                    333 =>
                        array (
                            'ion-md-information' => 'Information',
                        ),
                    334 =>
                        array (
                            'ion-ios-jet' => 'Jet',
                        ),
                    335 =>
                        array (
                            'ion-md-jet' => 'Jet',
                        ),
                    336 =>
                        array (
                            'ion-ios-journal' => 'Journal',
                        ),
                    337 =>
                        array (
                            'ion-md-journal' => 'Journal',
                        ),
                    338 =>
                        array (
                            'ion-ios-key' => 'Key',
                        ),
                    339 =>
                        array (
                            'ion-md-key' => 'Key',
                        ),
                    340 =>
                        array (
                            'ion-ios-keypad' => 'Keypad',
                        ),
                    341 =>
                        array (
                            'ion-md-keypad' => 'Keypad',
                        ),
                    342 =>
                        array (
                            'ion-ios-laptop' => 'Laptop',
                        ),
                    343 =>
                        array (
                            'ion-md-laptop' => 'Laptop',
                        ),
                    344 =>
                        array (
                            'ion-ios-leaf' => 'Leaf',
                        ),
                    345 =>
                        array (
                            'ion-md-leaf' => 'Leaf',
                        ),
                    346 =>
                        array (
                            'ion-ios-link' => 'Link',
                        ),
                    347 =>
                        array (
                            'ion-md-link' => 'Link',
                        ),
                    348 =>
                        array (
                            'ion-ios-list-box' => 'List Box',
                        ),
                    349 =>
                        array (
                            'ion-md-list-box' => 'List Box',
                        ),
                    350 =>
                        array (
                            'ion-ios-list' => 'List',
                        ),
                    351 =>
                        array (
                            'ion-md-list' => 'List',
                        ),
                    352 =>
                        array (
                            'ion-ios-locate' => 'Locate',
                        ),
                    353 =>
                        array (
                            'ion-md-locate' => 'Locate',
                        ),
                    354 =>
                        array (
                            'ion-ios-lock' => 'Lock',
                        ),
                    355 =>
                        array (
                            'ion-md-lock' => 'Lock',
                        ),
                    356 =>
                        array (
                            'ion-ios-log-in' => 'Log In',
                        ),
                    357 =>
                        array (
                            'ion-md-log-in' => 'Log In',
                        ),
                    358 =>
                        array (
                            'ion-ios-log-out' => 'Log Out',
                        ),
                    359 =>
                        array (
                            'ion-md-log-out' => 'Log Out',
                        ),
                    360 =>
                        array (
                            'ion-ios-magnet' => 'Magnet',
                        ),
                    361 =>
                        array (
                            'ion-md-magnet' => 'Magnet',
                        ),
                    362 =>
                        array (
                            'ion-ios-mail-open' => 'Mail Open',
                        ),
                    363 =>
                        array (
                            'ion-md-mail-open' => 'Mail Open',
                        ),
                    364 =>
                        array (
                            'ion-ios-mail-unread' => 'Mail Unread',
                        ),
                    365 =>
                        array (
                            'ion-md-mail-unread' => 'Mail Unread',
                        ),
                    366 =>
                        array (
                            'ion-ios-mail' => 'Mail',
                        ),
                    367 =>
                        array (
                            'ion-md-mail' => 'Mail',
                        ),
                    368 =>
                        array (
                            'ion-ios-male' => 'Male',
                        ),
                    369 =>
                        array (
                            'ion-md-male' => 'Male',
                        ),
                    370 =>
                        array (
                            'ion-ios-man' => 'Man',
                        ),
                    371 =>
                        array (
                            'ion-md-man' => 'Man',
                        ),
                    372 =>
                        array (
                            'ion-ios-map' => 'Map',
                        ),
                    373 =>
                        array (
                            'ion-md-map' => 'Map',
                        ),
                    374 =>
                        array (
                            'ion-ios-medal' => 'Medal',
                        ),
                    375 =>
                        array (
                            'ion-md-medal' => 'Medal',
                        ),
                    376 =>
                        array (
                            'ion-ios-medical' => 'Medical',
                        ),
                    377 =>
                        array (
                            'ion-md-medical' => 'Medical',
                        ),
                    378 =>
                        array (
                            'ion-ios-medkit' => 'Medkit',
                        ),
                    379 =>
                        array (
                            'ion-md-medkit' => 'Medkit',
                        ),
                    380 =>
                        array (
                            'ion-ios-megaphone' => 'Megaphone',
                        ),
                    381 =>
                        array (
                            'ion-md-megaphone' => 'Megaphone',
                        ),
                    382 =>
                        array (
                            'ion-ios-menu' => 'Menu',
                        ),
                    383 =>
                        array (
                            'ion-md-menu' => 'Menu',
                        ),
                    384 =>
                        array (
                            'ion-ios-mic-off' => 'Mic Off',
                        ),
                    385 =>
                        array (
                            'ion-md-mic-off' => 'Mic Off',
                        ),
                    386 =>
                        array (
                            'ion-ios-mic' => 'Mic',
                        ),
                    387 =>
                        array (
                            'ion-md-mic' => 'Mic',
                        ),
                    388 =>
                        array (
                            'ion-ios-microphone' => 'Microphone',
                        ),
                    389 =>
                        array (
                            'ion-md-microphone' => 'Microphone',
                        ),
                    390 =>
                        array (
                            'ion-ios-moon' => 'Moon',
                        ),
                    391 =>
                        array (
                            'ion-md-moon' => 'Moon',
                        ),
                    392 =>
                        array (
                            'ion-ios-more' => 'More',
                        ),
                    393 =>
                        array (
                            'ion-md-more' => 'More',
                        ),
                    394 =>
                        array (
                            'ion-ios-move' => 'Move',
                        ),
                    395 =>
                        array (
                            'ion-md-move' => 'Move',
                        ),
                    396 =>
                        array (
                            'ion-ios-musical-note' => 'Musical Note',
                        ),
                    397 =>
                        array (
                            'ion-md-musical-note' => 'Musical Note',
                        ),
                    398 =>
                        array (
                            'ion-ios-musical-notes' => 'Musical Notes',
                        ),
                    399 =>
                        array (
                            'ion-md-musical-notes' => 'Musical Notes',
                        ),
                    400 =>
                        array (
                            'ion-ios-navigate' => 'Navigate',
                        ),
                    401 =>
                        array (
                            'ion-md-navigate' => 'Navigate',
                        ),
                    402 =>
                        array (
                            'ion-ios-notifications-off' => 'Notifications Off',
                        ),
                    403 =>
                        array (
                            'ion-md-notifications-off' => 'Notifications Off',
                        ),
                    404 =>
                        array (
                            'ion-ios-notifications-outline' => 'Notifications Outline',
                        ),
                    405 =>
                        array (
                            'ion-md-notifications-outline' => 'Notifications Outline',
                        ),
                    406 =>
                        array (
                            'ion-ios-notifications' => 'Notifications',
                        ),
                    407 =>
                        array (
                            'ion-md-notifications' => 'Notifications',
                        ),
                    408 =>
                        array (
                            'ion-ios-nuclear' => 'Nuclear',
                        ),
                    409 =>
                        array (
                            'ion-md-nuclear' => 'Nuclear',
                        ),
                    410 =>
                        array (
                            'ion-ios-nutrition' => 'Nutrition',
                        ),
                    411 =>
                        array (
                            'ion-md-nutrition' => 'Nutrition',
                        ),
                    412 =>
                        array (
                            'ion-ios-open' => 'Open',
                        ),
                    413 =>
                        array (
                            'ion-md-open' => 'Open',
                        ),
                    414 =>
                        array (
                            'ion-ios-options' => 'Options',
                        ),
                    415 =>
                        array (
                            'ion-md-options' => 'Options',
                        ),
                    416 =>
                        array (
                            'ion-ios-outlet' => 'Outlet',
                        ),
                    417 =>
                        array (
                            'ion-md-outlet' => 'Outlet',
                        ),
                    418 =>
                        array (
                            'ion-ios-paper-plane' => 'Paper Plane',
                        ),
                    419 =>
                        array (
                            'ion-md-paper-plane' => 'Paper Plane',
                        ),
                    420 =>
                        array (
                            'ion-ios-paper' => 'Paper',
                        ),
                    421 =>
                        array (
                            'ion-md-paper' => 'Paper',
                        ),
                    422 =>
                        array (
                            'ion-ios-partly-sunny' => 'Partly Sunny',
                        ),
                    423 =>
                        array (
                            'ion-md-partly-sunny' => 'Partly Sunny',
                        ),
                    424 =>
                        array (
                            'ion-ios-pause' => 'Pause',
                        ),
                    425 =>
                        array (
                            'ion-md-pause' => 'Pause',
                        ),
                    426 =>
                        array (
                            'ion-ios-paw' => 'Paw',
                        ),
                    427 =>
                        array (
                            'ion-md-paw' => 'Paw',
                        ),
                    428 =>
                        array (
                            'ion-ios-people' => 'People',
                        ),
                    429 =>
                        array (
                            'ion-md-people' => 'People',
                        ),
                    430 =>
                        array (
                            'ion-ios-person-add' => 'Person Add',
                        ),
                    431 =>
                        array (
                            'ion-md-person-add' => 'Person Add',
                        ),
                    432 =>
                        array (
                            'ion-ios-person' => 'Person',
                        ),
                    433 =>
                        array (
                            'ion-md-person' => 'Person',
                        ),
                    434 =>
                        array (
                            'ion-ios-phone-landscape' => 'Phone Landscape',
                        ),
                    435 =>
                        array (
                            'ion-md-phone-landscape' => 'Phone Landscape',
                        ),
                    436 =>
                        array (
                            'ion-ios-phone-portrait' => 'Phone Portrait',
                        ),
                    437 =>
                        array (
                            'ion-md-phone-portrait' => 'Phone Portrait',
                        ),
                    438 =>
                        array (
                            'ion-ios-photos' => 'Photos',
                        ),
                    439 =>
                        array (
                            'ion-md-photos' => 'Photos',
                        ),
                    440 =>
                        array (
                            'ion-ios-pie' => 'Pie',
                        ),
                    441 =>
                        array (
                            'ion-md-pie' => 'Pie',
                        ),
                    442 =>
                        array (
                            'ion-ios-pin' => 'Pin',
                        ),
                    443 =>
                        array (
                            'ion-md-pin' => 'Pin',
                        ),
                    444 =>
                        array (
                            'ion-ios-pint' => 'Pint',
                        ),
                    445 =>
                        array (
                            'ion-md-pint' => 'Pint',
                        ),
                    446 =>
                        array (
                            'ion-ios-pizza' => 'Pizza',
                        ),
                    447 =>
                        array (
                            'ion-md-pizza' => 'Pizza',
                        ),
                    448 =>
                        array (
                            'ion-ios-planet' => 'Planet',
                        ),
                    449 =>
                        array (
                            'ion-md-planet' => 'Planet',
                        ),
                    450 =>
                        array (
                            'ion-ios-play-circle' => 'Play Circle',
                        ),
                    451 =>
                        array (
                            'ion-md-play-circle' => 'Play Circle',
                        ),
                    452 =>
                        array (
                            'ion-ios-play' => 'Play',
                        ),
                    453 =>
                        array (
                            'ion-md-play' => 'Play',
                        ),
                    454 =>
                        array (
                            'ion-ios-podium' => 'Podium',
                        ),
                    455 =>
                        array (
                            'ion-md-podium' => 'Podium',
                        ),
                    456 =>
                        array (
                            'ion-ios-power' => 'Power',
                        ),
                    457 =>
                        array (
                            'ion-md-power' => 'Power',
                        ),
                    458 =>
                        array (
                            'ion-ios-pricetag' => 'Pricetag',
                        ),
                    459 =>
                        array (
                            'ion-md-pricetag' => 'Pricetag',
                        ),
                    460 =>
                        array (
                            'ion-ios-pricetags' => 'Pricetags',
                        ),
                    461 =>
                        array (
                            'ion-md-pricetags' => 'Pricetags',
                        ),
                    462 =>
                        array (
                            'ion-ios-print' => 'Print',
                        ),
                    463 =>
                        array (
                            'ion-md-print' => 'Print',
                        ),
                    464 =>
                        array (
                            'ion-ios-pulse' => 'Pulse',
                        ),
                    465 =>
                        array (
                            'ion-md-pulse' => 'Pulse',
                        ),
                    466 =>
                        array (
                            'ion-ios-qr-scanner' => 'Qr Scanner',
                        ),
                    467 =>
                        array (
                            'ion-md-qr-scanner' => 'Qr Scanner',
                        ),
                    468 =>
                        array (
                            'ion-ios-quote' => 'Quote',
                        ),
                    469 =>
                        array (
                            'ion-md-quote' => 'Quote',
                        ),
                    470 =>
                        array (
                            'ion-ios-radio-button-off' => 'Radio Button Off',
                        ),
                    471 =>
                        array (
                            'ion-md-radio-button-off' => 'Radio Button Off',
                        ),
                    472 =>
                        array (
                            'ion-ios-radio-button-on' => 'Radio Button On',
                        ),
                    473 =>
                        array (
                            'ion-md-radio-button-on' => 'Radio Button On',
                        ),
                    474 =>
                        array (
                            'ion-ios-radio' => 'Radio',
                        ),
                    475 =>
                        array (
                            'ion-md-radio' => 'Radio',
                        ),
                    476 =>
                        array (
                            'ion-ios-rainy' => 'Rainy',
                        ),
                    477 =>
                        array (
                            'ion-md-rainy' => 'Rainy',
                        ),
                    478 =>
                        array (
                            'ion-ios-recording' => 'Recording',
                        ),
                    479 =>
                        array (
                            'ion-md-recording' => 'Recording',
                        ),
                    480 =>
                        array (
                            'ion-ios-redo' => 'Redo',
                        ),
                    481 =>
                        array (
                            'ion-md-redo' => 'Redo',
                        ),
                    482 =>
                        array (
                            'ion-ios-refresh-circle' => 'Refresh Circle',
                        ),
                    483 =>
                        array (
                            'ion-md-refresh-circle' => 'Refresh Circle',
                        ),
                    484 =>
                        array (
                            'ion-ios-refresh' => 'Refresh',
                        ),
                    485 =>
                        array (
                            'ion-md-refresh' => 'Refresh',
                        ),
                    486 =>
                        array (
                            'ion-ios-remove-circle-outline' => 'Remove Circle Outline',
                        ),
                    487 =>
                        array (
                            'ion-md-remove-circle-outline' => 'Remove Circle Outline',
                        ),
                    488 =>
                        array (
                            'ion-ios-remove-circle' => 'Remove Circle',
                        ),
                    489 =>
                        array (
                            'ion-md-remove-circle' => 'Remove Circle',
                        ),
                    490 =>
                        array (
                            'ion-ios-remove' => 'Remove',
                        ),
                    491 =>
                        array (
                            'ion-md-remove' => 'Remove',
                        ),
                    492 =>
                        array (
                            'ion-ios-reorder' => 'Reorder',
                        ),
                    493 =>
                        array (
                            'ion-md-reorder' => 'Reorder',
                        ),
                    494 =>
                        array (
                            'ion-ios-repeat' => 'Repeat',
                        ),
                    495 =>
                        array (
                            'ion-md-repeat' => 'Repeat',
                        ),
                    496 =>
                        array (
                            'ion-ios-resize' => 'Resize',
                        ),
                    497 =>
                        array (
                            'ion-md-resize' => 'Resize',
                        ),
                    498 =>
                        array (
                            'ion-ios-restaurant' => 'Restaurant',
                        ),
                    499 =>
                        array (
                            'ion-md-restaurant' => 'Restaurant',
                        ),
                    500 =>
                        array (
                            'ion-ios-return-left' => 'Return Left',
                        ),
                    501 =>
                        array (
                            'ion-md-return-left' => 'Return Left',
                        ),
                    502 =>
                        array (
                            'ion-ios-return-right' => 'Return Right',
                        ),
                    503 =>
                        array (
                            'ion-md-return-right' => 'Return Right',
                        ),
                    504 =>
                        array (
                            'ion-ios-reverse-camera' => 'Reverse Camera',
                        ),
                    505 =>
                        array (
                            'ion-md-reverse-camera' => 'Reverse Camera',
                        ),
                    506 =>
                        array (
                            'ion-ios-rewind' => 'Rewind',
                        ),
                    507 =>
                        array (
                            'ion-md-rewind' => 'Rewind',
                        ),
                    508 =>
                        array (
                            'ion-ios-ribbon' => 'Ribbon',
                        ),
                    509 =>
                        array (
                            'ion-md-ribbon' => 'Ribbon',
                        ),
                    510 =>
                        array (
                            'ion-ios-rocket' => 'Rocket',
                        ),
                    511 =>
                        array (
                            'ion-md-rocket' => 'Rocket',
                        ),
                    512 =>
                        array (
                            'ion-ios-rose' => 'Rose',
                        ),
                    513 =>
                        array (
                            'ion-md-rose' => 'Rose',
                        ),
                    514 =>
                        array (
                            'ion-ios-sad' => 'Sad',
                        ),
                    515 =>
                        array (
                            'ion-md-sad' => 'Sad',
                        ),
                    516 =>
                        array (
                            'ion-ios-save' => 'Save',
                        ),
                    517 =>
                        array (
                            'ion-md-save' => 'Save',
                        ),
                    518 =>
                        array (
                            'ion-ios-school' => 'School',
                        ),
                    519 =>
                        array (
                            'ion-md-school' => 'School',
                        ),
                    520 =>
                        array (
                            'ion-ios-search' => 'Search',
                        ),
                    521 =>
                        array (
                            'ion-md-search' => 'Search',
                        ),
                    522 =>
                        array (
                            'ion-ios-send' => 'Send',
                        ),
                    523 =>
                        array (
                            'ion-md-send' => 'Send',
                        ),
                    524 =>
                        array (
                            'ion-ios-settings' => 'Settings',
                        ),
                    525 =>
                        array (
                            'ion-md-settings' => 'Settings',
                        ),
                    526 =>
                        array (
                            'ion-ios-share-alt' => 'Share Alt',
                        ),
                    527 =>
                        array (
                            'ion-md-share-alt' => 'Share Alt',
                        ),
                    528 =>
                        array (
                            'ion-ios-share' => 'Share',
                        ),
                    529 =>
                        array (
                            'ion-md-share' => 'Share',
                        ),
                    530 =>
                        array (
                            'ion-ios-shirt' => 'Shirt',
                        ),
                    531 =>
                        array (
                            'ion-md-shirt' => 'Shirt',
                        ),
                    532 =>
                        array (
                            'ion-ios-shuffle' => 'Shuffle',
                        ),
                    533 =>
                        array (
                            'ion-md-shuffle' => 'Shuffle',
                        ),
                    534 =>
                        array (
                            'ion-ios-skip-backward' => 'Skip Backward',
                        ),
                    535 =>
                        array (
                            'ion-md-skip-backward' => 'Skip Backward',
                        ),
                    536 =>
                        array (
                            'ion-ios-skip-forward' => 'Skip Forward',
                        ),
                    537 =>
                        array (
                            'ion-md-skip-forward' => 'Skip Forward',
                        ),
                    538 =>
                        array (
                            'ion-ios-snow' => 'Snow',
                        ),
                    539 =>
                        array (
                            'ion-md-snow' => 'Snow',
                        ),
                    540 =>
                        array (
                            'ion-ios-speedometer' => 'Speedometer',
                        ),
                    541 =>
                        array (
                            'ion-md-speedometer' => 'Speedometer',
                        ),
                    542 =>
                        array (
                            'ion-ios-square-outline' => 'Square Outline',
                        ),
                    543 =>
                        array (
                            'ion-md-square-outline' => 'Square Outline',
                        ),
                    544 =>
                        array (
                            'ion-ios-square' => 'Square',
                        ),
                    545 =>
                        array (
                            'ion-md-square' => 'Square',
                        ),
                    546 =>
                        array (
                            'ion-ios-star-half' => 'Star Half',
                        ),
                    547 =>
                        array (
                            'ion-md-star-half' => 'Star Half',
                        ),
                    548 =>
                        array (
                            'ion-ios-star-outline' => 'Star Outline',
                        ),
                    549 =>
                        array (
                            'ion-md-star-outline' => 'Star Outline',
                        ),
                    550 =>
                        array (
                            'ion-ios-star' => 'Star',
                        ),
                    551 =>
                        array (
                            'ion-md-star' => 'Star',
                        ),
                    552 =>
                        array (
                            'ion-ios-stats' => 'Stats',
                        ),
                    553 =>
                        array (
                            'ion-md-stats' => 'Stats',
                        ),
                    554 =>
                        array (
                            'ion-ios-stopwatch' => 'Stopwatch',
                        ),
                    555 =>
                        array (
                            'ion-md-stopwatch' => 'Stopwatch',
                        ),
                    556 =>
                        array (
                            'ion-ios-subway' => 'Subway',
                        ),
                    557 =>
                        array (
                            'ion-md-subway' => 'Subway',
                        ),
                    558 =>
                        array (
                            'ion-ios-sunny' => 'Sunny',
                        ),
                    559 =>
                        array (
                            'ion-md-sunny' => 'Sunny',
                        ),
                    560 =>
                        array (
                            'ion-ios-swap' => 'Swap',
                        ),
                    561 =>
                        array (
                            'ion-md-swap' => 'Swap',
                        ),
                    562 =>
                        array (
                            'ion-ios-switch' => 'Switch',
                        ),
                    563 =>
                        array (
                            'ion-md-switch' => 'Switch',
                        ),
                    564 =>
                        array (
                            'ion-ios-sync' => 'Sync',
                        ),
                    565 =>
                        array (
                            'ion-md-sync' => 'Sync',
                        ),
                    566 =>
                        array (
                            'ion-ios-tablet-landscape' => 'Tablet Landscape',
                        ),
                    567 =>
                        array (
                            'ion-md-tablet-landscape' => 'Tablet Landscape',
                        ),
                    568 =>
                        array (
                            'ion-ios-tablet-portrait' => 'Tablet Portrait',
                        ),
                    569 =>
                        array (
                            'ion-md-tablet-portrait' => 'Tablet Portrait',
                        ),
                    570 =>
                        array (
                            'ion-ios-tennisball' => 'Tennisball',
                        ),
                    571 =>
                        array (
                            'ion-md-tennisball' => 'Tennisball',
                        ),
                    572 =>
                        array (
                            'ion-ios-text' => 'Text',
                        ),
                    573 =>
                        array (
                            'ion-md-text' => 'Text',
                        ),
                    574 =>
                        array (
                            'ion-ios-thermometer' => 'Thermometer',
                        ),
                    575 =>
                        array (
                            'ion-md-thermometer' => 'Thermometer',
                        ),
                    576 =>
                        array (
                            'ion-ios-thumbs-down' => 'Thumbs Down',
                        ),
                    577 =>
                        array (
                            'ion-md-thumbs-down' => 'Thumbs Down',
                        ),
                    578 =>
                        array (
                            'ion-ios-thumbs-up' => 'Thumbs Up',
                        ),
                    579 =>
                        array (
                            'ion-md-thumbs-up' => 'Thumbs Up',
                        ),
                    580 =>
                        array (
                            'ion-ios-thunderstorm' => 'Thunderstorm',
                        ),
                    581 =>
                        array (
                            'ion-md-thunderstorm' => 'Thunderstorm',
                        ),
                    582 =>
                        array (
                            'ion-ios-time' => 'Time',
                        ),
                    583 =>
                        array (
                            'ion-md-time' => 'Time',
                        ),
                    584 =>
                        array (
                            'ion-ios-timer' => 'Timer',
                        ),
                    585 =>
                        array (
                            'ion-md-timer' => 'Timer',
                        ),
                    586 =>
                        array (
                            'ion-ios-today' => 'Today',
                        ),
                    587 =>
                        array (
                            'ion-md-today' => 'Today',
                        ),
                    588 =>
                        array (
                            'ion-ios-train' => 'Train',
                        ),
                    589 =>
                        array (
                            'ion-md-train' => 'Train',
                        ),
                    590 =>
                        array (
                            'ion-ios-transgender' => 'Transgender',
                        ),
                    591 =>
                        array (
                            'ion-md-transgender' => 'Transgender',
                        ),
                    592 =>
                        array (
                            'ion-ios-trash' => 'Trash',
                        ),
                    593 =>
                        array (
                            'ion-md-trash' => 'Trash',
                        ),
                    594 =>
                        array (
                            'ion-ios-trending-down' => 'Trending Down',
                        ),
                    595 =>
                        array (
                            'ion-md-trending-down' => 'Trending Down',
                        ),
                    596 =>
                        array (
                            'ion-ios-trending-up' => 'Trending Up',
                        ),
                    597 =>
                        array (
                            'ion-md-trending-up' => 'Trending Up',
                        ),
                    598 =>
                        array (
                            'ion-ios-trophy' => 'Trophy',
                        ),
                    599 =>
                        array (
                            'ion-md-trophy' => 'Trophy',
                        ),
                    600 =>
                        array (
                            'ion-ios-tv' => 'Tv',
                        ),
                    601 =>
                        array (
                            'ion-md-tv' => 'Tv',
                        ),
                    602 =>
                        array (
                            'ion-ios-umbrella' => 'Umbrella',
                        ),
                    603 =>
                        array (
                            'ion-md-umbrella' => 'Umbrella',
                        ),
                    604 =>
                        array (
                            'ion-ios-undo' => 'Undo',
                        ),
                    605 =>
                        array (
                            'ion-md-undo' => 'Undo',
                        ),
                    606 =>
                        array (
                            'ion-ios-unlock' => 'Unlock',
                        ),
                    607 =>
                        array (
                            'ion-md-unlock' => 'Unlock',
                        ),
                    608 =>
                        array (
                            'ion-ios-videocam' => 'Videocam',
                        ),
                    609 =>
                        array (
                            'ion-md-videocam' => 'Videocam',
                        ),
                    610 =>
                        array (
                            'ion-ios-volume-high' => 'Volume High',
                        ),
                    611 =>
                        array (
                            'ion-md-volume-high' => 'Volume High',
                        ),
                    612 =>
                        array (
                            'ion-ios-volume-low' => 'Volume Low',
                        ),
                    613 =>
                        array (
                            'ion-md-volume-low' => 'Volume Low',
                        ),
                    614 =>
                        array (
                            'ion-ios-volume-mute' => 'Volume Mute',
                        ),
                    615 =>
                        array (
                            'ion-md-volume-mute' => 'Volume Mute',
                        ),
                    616 =>
                        array (
                            'ion-ios-volume-off' => 'Volume Off',
                        ),
                    617 =>
                        array (
                            'ion-md-volume-off' => 'Volume Off',
                        ),
                    618 =>
                        array (
                            'ion-ios-wallet' => 'Wallet',
                        ),
                    619 =>
                        array (
                            'ion-md-wallet' => 'Wallet',
                        ),
                    620 =>
                        array (
                            'ion-ios-walk' => 'Walk',
                        ),
                    621 =>
                        array (
                            'ion-md-walk' => 'Walk',
                        ),
                    622 =>
                        array (
                            'ion-ios-warning' => 'Warning',
                        ),
                    623 =>
                        array (
                            'ion-md-warning' => 'Warning',
                        ),
                    624 =>
                        array (
                            'ion-ios-watch' => 'Watch',
                        ),
                    625 =>
                        array (
                            'ion-md-watch' => 'Watch',
                        ),
                    626 =>
                        array (
                            'ion-ios-water' => 'Water',
                        ),
                    627 =>
                        array (
                            'ion-md-water' => 'Water',
                        ),
                    628 =>
                        array (
                            'ion-ios-wifi' => 'Wifi',
                        ),
                    629 =>
                        array (
                            'ion-md-wifi' => 'Wifi',
                        ),
                    630 =>
                        array (
                            'ion-ios-wine' => 'Wine',
                        ),
                    631 =>
                        array (
                            'ion-md-wine' => 'Wine',
                        ),
                    632 =>
                        array (
                            'ion-ios-woman' => 'Woman',
                        ),
                    633 =>
                        array (
                            'ion-md-woman' => 'Woman',
                        ),
                    634 =>
                        array (
                            'ion-logo-android' => 'Logo Android',
                        ),
                    635 =>
                        array (
                            'ion-logo-angular' => 'Logo Angular',
                        ),
                    636 =>
                        array (
                            'ion-logo-apple' => 'Logo Apple',
                        ),
                    637 =>
                        array (
                            'ion-logo-bitbucket' => 'Logo Bitbucket',
                        ),
                    638 =>
                        array (
                            'ion-logo-bitcoin' => 'Logo Bitcoin',
                        ),
                    639 =>
                        array (
                            'ion-logo-buffer' => 'Logo Buffer',
                        ),
                    640 =>
                        array (
                            'ion-logo-chrome' => 'Logo Chrome',
                        ),
                    641 =>
                        array (
                            'ion-logo-closed-captioning' => 'Logo Closed Captioning',
                        ),
                    642 =>
                        array (
                            'ion-logo-codepen' => 'Logo Codepen',
                        ),
                    643 =>
                        array (
                            'ion-logo-css3' => 'Logo Css3',
                        ),
                    644 =>
                        array (
                            'ion-logo-designernews' => 'Logo Designernews',
                        ),
                    645 =>
                        array (
                            'ion-logo-dribbble' => 'Logo Dribbble',
                        ),
                    646 =>
                        array (
                            'ion-logo-dropbox' => 'Logo Dropbox',
                        ),
                    647 =>
                        array (
                            'ion-logo-euro' => 'Logo Euro',
                        ),
                    648 =>
                        array (
                            'ion-logo-facebook' => 'Logo Facebook',
                        ),
                    649 =>
                        array (
                            'ion-logo-flickr' => 'Logo Flickr',
                        ),
                    650 =>
                        array (
                            'ion-logo-foursquare' => 'Logo Foursquare',
                        ),
                    651 =>
                        array (
                            'ion-logo-freebsd-devil' => 'Logo Freebsd Devil',
                        ),
                    652 =>
                        array (
                            'ion-logo-game-controller-a' => 'Logo Game Controller A',
                        ),
                    653 =>
                        array (
                            'ion-logo-game-controller-b' => 'Logo Game Controller B',
                        ),
                    654 =>
                        array (
                            'ion-logo-github' => 'Logo Github',
                        ),
                    655 =>
                        array (
                            'ion-logo-google' => 'Logo Google',
                        ),
                    656 =>
                        array (
                            'ion-logo-googleplus' => 'Logo Googleplus',
                        ),
                    657 =>
                        array (
                            'ion-logo-hackernews' => 'Logo Hackernews',
                        ),
                    658 =>
                        array (
                            'ion-logo-html5' => 'Logo Html5',
                        ),
                    659 =>
                        array (
                            'ion-logo-instagram' => 'Logo Instagram',
                        ),
                    660 =>
                        array (
                            'ion-logo-ionic' => 'Logo Ionic',
                        ),
                    661 =>
                        array (
                            'ion-logo-ionitron' => 'Logo Ionitron',
                        ),
                    662 =>
                        array (
                            'ion-logo-javascript' => 'Logo Javascript',
                        ),
                    663 =>
                        array (
                            'ion-logo-linkedin' => 'Logo Linkedin',
                        ),
                    664 =>
                        array (
                            'ion-logo-markdown' => 'Logo Markdown',
                        ),
                    665 =>
                        array (
                            'ion-logo-model-s' => 'Logo Model S',
                        ),
                    666 =>
                        array (
                            'ion-logo-no-smoking' => 'Logo No Smoking',
                        ),
                    667 =>
                        array (
                            'ion-logo-nodejs' => 'Logo Nodejs',
                        ),
                    668 =>
                        array (
                            'ion-logo-npm' => 'Logo Npm',
                        ),
                    669 =>
                        array (
                            'ion-logo-octocat' => 'Logo Octocat',
                        ),
                    670 =>
                        array (
                            'ion-logo-pinterest' => 'Logo Pinterest',
                        ),
                    671 =>
                        array (
                            'ion-logo-playstation' => 'Logo Playstation',
                        ),
                    672 =>
                        array (
                            'ion-logo-polymer' => 'Logo Polymer',
                        ),
                    673 =>
                        array (
                            'ion-logo-python' => 'Logo Python',
                        ),
                    674 =>
                        array (
                            'ion-logo-reddit' => 'Logo Reddit',
                        ),
                    675 =>
                        array (
                            'ion-logo-rss' => 'Logo Rss',
                        ),
                    676 =>
                        array (
                            'ion-logo-sass' => 'Logo Sass',
                        ),
                    677 =>
                        array (
                            'ion-logo-skype' => 'Logo Skype',
                        ),
                    678 =>
                        array (
                            'ion-logo-slack' => 'Logo Slack',
                        ),
                    679 =>
                        array (
                            'ion-logo-snapchat' => 'Logo Snapchat',
                        ),
                    680 =>
                        array (
                            'ion-logo-steam' => 'Logo Steam',
                        ),
                    681 =>
                        array (
                            'ion-logo-tumblr' => 'Logo Tumblr',
                        ),
                    682 =>
                        array (
                            'ion-logo-tux' => 'Logo Tux',
                        ),
                    683 =>
                        array (
                            'ion-logo-twitch' => 'Logo Twitch',
                        ),
                    684 =>
                        array (
                            'ion-logo-twitter' => 'Logo Twitter',
                        ),
                    685 =>
                        array (
                            'ion-logo-usd' => 'Logo Usd',
                        ),
                    686 =>
                        array (
                            'ion-logo-vimeo' => 'Logo Vimeo',
                        ),
                    687 =>
                        array (
                            'ion-logo-vk' => 'Logo Vk',
                        ),
                    688 =>
                        array (
                            'ion-logo-whatsapp' => 'Logo Whatsapp',
                        ),
                    689 =>
                        array (
                            'ion-logo-windows' => 'Logo Windows',
                        ),
                    690 =>
                        array (
                            'ion-logo-wordpress' => 'Logo Wordpress',
                        ),
                    691 =>
                        array (
                            'ion-logo-xbox' => 'Logo Xbox',
                        ),
                    692 =>
                        array (
                            'ion-logo-xing' => 'Logo Xing',
                        ),
                    693 =>
                        array (
                            'ion-logo-yahoo' => 'Logo Yahoo',
                        ),
                    694 =>
                        array (
                            'ion-logo-yen' => 'Logo Yen',
                        ),
                    695 =>
                        array (
                            'ion-logo-youtube' => 'Logo Youtube',
                        ),
                ),

        );
        return array_merge( $icons, $custom_icons );
    }
}
add_filter( 'vc_iconpicker-type-fontawesome', 'khaki_filter_iconpicker');

if (!function_exists('khaki_get_portfolio_terms')) :
    function khaki_get_portfolio_terms()
    {
        $terms_list_vc = array();
        $terms_list = get_terms(get_object_taxonomies(get_post_types(array(
            'public' => false,
            'name' => 'attachment'
        ), 'names', 'NOT')));

        foreach ($terms_list as $term) {
            if($term->taxonomy == 'portfolio-category'){
                $terms_list_vc[] = array(
                    "value" => $term->term_id,
                    "label" => $term->name,
                    "group" => $term->taxonomy
                );
            }
        }

        return $terms_list_vc;
    }
endif;
