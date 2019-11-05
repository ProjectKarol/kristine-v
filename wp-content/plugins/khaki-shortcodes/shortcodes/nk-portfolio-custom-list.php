<?php
/**
 * nK Portfolio Custom List.
 *
 * Example:
 * [nk_portfolio_custom_list gap="1" filter="1"]
 *  [nk_portfolio_item id="98" size="vertical-rectangle" style="1-a" hovered="1" hide_title="1"]
 *  [nk_portfolio_item id="97" size="square"]
 *  [nk_portfolio_custom_item data_filter="Testy" size="big-square" style="" image="35"]
 *      [nk_text]Message[/nk_text]
 *  [/nk_portfolio_custom_item]
 *  [nk_portfolio_item id="96" size="square"]
 * [/nk_portfolio_custom_list]
 */
if (!function_exists('nk_theme')) {
    return;
}
add_shortcode('nk_portfolio_custom_list', 'nk_portfolio_custom_list');
if ( ! function_exists( 'nk_portfolio_custom_list' ) ) :
    function nk_portfolio_custom_list($atts, $content = null) {
        extract(shortcode_atts(array(
            "no_image" => "",
            "gap" => "",
            "filter" => "",
            "cross" => "",
            "class" => ""
        ), $atts));

        if( !khaki_nk_check($content) ) {
            return '';
        }
        $result = '';
        $parse_array = array();
        $query_ids = array();
        $filter_values = array();
        $class .= ' nk-isotope ' . khaki_get_css_tab_class($atts);
        $pattern = get_shortcode_regex();

        //parse shordcodes content for get posts ids for set up query
        preg_match_all( "/$pattern/s", $content, $parse_array, PREG_SET_ORDER);
        foreach($parse_array as $key=>&$shortcode){
            $attr = shortcode_parse_atts($shortcode[3]);
            $shortcode[3] = $attr;
            if(isset($attr['id']) && !empty($attr['id']) && $shortcode[2] === 'nk_portfolio_item'){
                $query_ids[$key] = $attr['id'];
            }

            //add filter custom values
            if($filter && isset($attr['data_filter']) && !empty($attr['data_filter']) && $shortcode[2] === 'nk_portfolio_custom_item'){
                $ar_filter = explode(",", $attr['data_filter']);
                $filter_values = array_merge($filter_values, $ar_filter);
            }
        }
        
        /**
         * Set Up Query
         */
        $query_opts = array(
            'post_type' => 'portfolio',
            'post__in' => $query_ids,
            'posts_per_page' => -1,
        );
        $portfolio_query = new WP_Query($query_opts);
        $content_array = array();
        while ($portfolio_query->have_posts()) : $portfolio_query->the_post();

            $current_key = array_search(get_the_ID(), $query_ids);
            $current_post_shortcode = '[nk_portfolio_item';

            //Attachment
            $resolution = 'khaki_600x600';
            $current_size = '';
            if(isset($parse_array[$current_key][3]['size'])){
                $current_size = $parse_array[$current_key][3]['size'];
            }

            if(isset($current_size) && !empty($current_size)){
                switch ($current_size){
                    case 'square':
                        $resolution = 'khaki_600x600_crop';
                        break;
                    case 'big-square':
                        $resolution = 'khaki_1200x1200_crop';
                        break;
                    case 'horizontal-rectangle':
                        $resolution = 'khaki_1200x600_crop';
                        break;
                    case 'vertical-rectangle':
                        $resolution = 'khaki_600x1200_crop';
                        break;
                }
            }

            $attachment = khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $resolution);
            if (!empty($attachment) && is_array($attachment)) {
                if ($attachment['alt']) {
                    $alt = esc_attr($attachment['alt']);
                } else {
                    $alt = esc_attr(get_bloginfo('name'));
                }
                $current_post_shortcode .= ' attachment_src="' . esc_url($attachment['src']) . '" attachment_alt="' . $alt . '"';
            } else {
                if(isset($no_image) && !empty($no_image)){
                    $attachment = khaki_get_attachment($no_image, $resolution);
                    if(!empty($attachment) && is_array($attachment)){
                        $current_post_shortcode .= ' attachment_src="'. esc_url($attachment['src']). '" attachment_alt="'.esc_attr__('No Image', 'khaki-shortcodes').'"';
                    }
                } else{
                    $current_post_shortcode .= ' attachment_src="' . esc_url(get_template_directory_uri() . '/assets/images/no-image.jpg') . '" attachment_alt="'.esc_attr__('No Image', 'khaki-shortcodes').'"';
                }
            }

            //Post link
            $portfolio_url = get_permalink();
            if(isset($portfolio_url) && !empty($portfolio_url)){
                $current_post_shortcode .= ' url="'.$portfolio_url.'"';
            }
            
            //Title
            $title = get_the_title();
            if(isset($title) && !empty($title)){
                $current_post_shortcode .= ' title="'.esc_attr($title).'"';
            }

            //Published Date
            $published_date = get_the_time(esc_html__('F j, Y', 'khaki-shortcodes'));
            if(isset($published_date) && !empty($published_date)){
                $current_post_shortcode .= ' time_string="'.esc_attr($published_date).'"';
            }

            //Filter Matches
            if($filter){
                $category = get_the_terms(get_the_ID(), 'portfolio-category');
                if ($category){
                    $current_post_shortcode .= ' data_filter="';
                    foreach ($category as $key => $cat_item){
                        $filter_values[] = trim($cat_item->name);
                        if($key > 0){
                            $current_post_shortcode .= ', ';
                        }
                        $current_post_shortcode .= esc_attr($cat_item->name);
                    }
                    $current_post_shortcode .= '"';
                }
            }

            //get additional parameters
            if($current_key!==false && $current_key!==null){
                $current_post_shortcode .= ' ';
                foreach($parse_array[$current_key][3] as $key=>$attr){
                    $current_post_shortcode .= $key.'="'.esc_attr($attr).'" ';
                }
            }
            $current_post_shortcode .= ']';

            if($current_key!==false && $current_key!==null){
                $content_array[$current_key] = $current_post_shortcode;
            }
        endwhile;
        wp_reset_postdata();

        $content_str = '';
        $count_shortcodes = count($parse_array);
        for($i = 0; $i < $count_shortcodes; $i++){
            if(!isset($content_array[$i])){
                //add custom portfolio elements
                $content_array[$i] = $parse_array[$i][0];
            }
            $content_str .= $content_array[$i];
        }

        //Set Gap
        if($gap){
            $class .= ' nk-isotope-gap-small';
        }

        //Set Filter
        if($filter && !empty($filter_values) && isset($filter_values) && is_array($filter_values)){
            foreach($filter_values as $key=>$filter_value){
                $filter_values[$key]=trim($filter_value);
            }
            $filter_values = array_unique($filter_values);
            $result .= '<ul class="nk-isotope-filter">';
                $result .= '<li class="active" data-filter="*">All</li>';
                foreach($filter_values as $key=>$filter_value){
                    $result .= '<li data-filter="'.esc_attr(trim($filter_value)).'">'.esc_html(trim($filter_value)).'</li>';
                }
            $result .= '</ul>';
        }

        //Main Content
        if($cross){
            $result .= '<div class="container mnt-60">';
        }
        $result .= '<div class="'.khaki_sanitize_class(trim($class)).'">';
        $result .= do_shortcode($content_str);
        $result .= '</div>';
        if($cross) {
            $result .= '</div>';
        }
        return $result;
    }
endif;
add_shortcode('nk_portfolio_item', 'nk_portfolio_item');
if ( ! function_exists( 'nk_portfolio_item' ) ) :
    function nk_portfolio_item($atts, $content = null) {
        extract(shortcode_atts(array(
            "id" => "",
            "attachment_src" => "",
            "attachment_alt" => "",
            "data_filter" => "",
            "url" => "",
            "time_string" => "",
            "title" => "",
            "size" => "",
            "style" => 1,
            "content_vertical_align" => "center",
            "no_effect" => "",
            "hovered" => "",
            "hide_title" => "",
            "hide_date" => "",
            "class" => ""
        ), $atts));
        $result = $filter_attr = $image_atts = $class_style = '';
        if(isset($data_filter) && !empty($data_filter)){
            $filter_attr = ' data-filter="'.esc_attr(trim($data_filter)).'"';
        }

        // select layout depending on the size
        $layout = get_template_directory_uri() .'/assets/images/portfolio-0-primary.jpg';
        if(isset($size) && !empty($size)){
            switch ($size){
                case 'square':
                    $layout = get_template_directory_uri() .'/assets/images/portfolio-0-primary.jpg';
                    break;
                case 'big-square':
                    $layout = get_template_directory_uri() .'/assets/images/portfolio-primary-big-square.jpg';
                    $class .= ' nk-isotope-item-x2';
                    break;
                case 'horizontal-rectangle':
                    $layout = get_template_directory_uri() .'/assets/images/portfolio-primary-horizontal-rectangle.jpg';
                    $class .= ' nk-isotope-item-x2';
                    break;
                case 'vertical-rectangle':
                    $layout = get_template_directory_uri() .'/assets/images/portfolio-primary-vertical-rectangle.jpg';
                    break;
            }
        }

        // set style effect
        if(khaki_nk_check($style)){
            if($style == 2) {
                $image_atts = ' data-from="1.1"';
            }
            $class_style .= 'nk-image-box-' . $style;
        } else {
            $class_style .= 'nk-image-box';
        }

        // no effect
        if (khaki_nk_check($no_effect)) {
            $class_style .= ' nk-no-effect';
        }

        // hovered
        if (khaki_nk_check($hovered)) {
            $class_style .= ' hover';
        }

        // set align content
        $overlay_class = 'nk-image-box-overlay';
        if(isset($content_vertical_align)){
            $overlay_class .= ' nk-image-box-'.$content_vertical_align;
        }

        // additional classname for custom styles VC
        $class .= ' nk-portfolio-item nk-isotope-item '.khaki_get_css_tab_class($atts);

        $result .= '<div class="'.khaki_sanitize_class(trim($class)).'"'.$filter_attr.'>';
            $result .= '<div class="'.khaki_sanitize_class($class_style).'">';
                $result .= '<a href="'.esc_url($url).'" class="nk-image-box-link"></a>';
                $result .= '<div class="nk-portfolio-image" style="background-image: url('."'".esc_url($attachment_src)."'".');"></div>';
                $result .= '<img class="nk-portfolio-image" src="'. esc_url($layout) .'" alt="'.esc_attr($attachment_alt).'"'.$image_atts.'>';
                    $result .= '<div class="'.khaki_sanitize_class($overlay_class).'">';
                        $result .= '<div>';
                        if(!$hide_title){
                            $result .= '<h2 class="nk-image-box-title nk-portfolio-title h3">'.esc_html($title).'</h2>';
                        }
                        if(!$hide_date) {
                            $result .= '<div class="nk-image-box-sub-title">' . esc_html($time_string) . '</div>';
                        }
                        $result .= '</div>';
                    $result .= '</div>';
            $result .= '</div>';
        $result .= '</div>';
        return $result;
    }
endif;
add_shortcode('nk_portfolio_custom_item', 'nk_portfolio_custom_item');
if ( ! function_exists( 'nk_portfolio_custom_item' ) ) :
    function nk_portfolio_custom_item($atts, $content = null) {
        extract(shortcode_atts(array(
            "image" => '',
            "data_filter" => "",
            "size" => "",
            "style" => "",
            "content_vertical_align" => "center",
            "no_effect" => "",
            "hovered" => "",
        ), $atts));
        $result = $filter_attr = '';
        $portfolio_item_class = 'nk-portfolio-item nk-isotope-item';
        if(isset($data_filter) && !empty($data_filter)){
            $filter_attr = ' data-filter="'.esc_attr(trim($data_filter)).'"';
        }

        $resolution = 'khaki_600x600';

        // select layout depending on the size
        $layout = get_template_directory_uri() .'/assets/images/portfolio-0-primary.jpg';
        if(isset($size) && !empty($size)){
            switch ($size){
                case 'square':
                    $layout = get_template_directory_uri() .'/assets/images/portfolio-0-primary.jpg';
                    $resolution = 'khaki_600x600_crop';
                    break;
                case 'big-square':
                    $layout = get_template_directory_uri() .'/assets/images/portfolio-primary-big-square.jpg';
                    $resolution = 'khaki_1200x1200_crop';
                    $portfolio_item_class .= ' nk-isotope-item-x2';
                    break;
                case 'horizontal-rectangle':
                    $layout = get_template_directory_uri() .'/assets/images/portfolio-primary-horizontal-rectangle.jpg';
                    $resolution = 'khaki_1200x600_crop';
                    $portfolio_item_class .= ' nk-isotope-item-x2';
                    break;
                case 'vertical-rectangle':
                    $layout = get_template_directory_uri() .'/assets/images/portfolio-primary-vertical-rectangle.jpg';
                    $resolution = 'khaki_600x1200_crop';
                    break;
            }
        }

        // Image
        $image_path = $alt = '';
        if(isset($image) && !empty($image) && is_numeric($image)){
            $attachment = khaki_get_attachment($image, $resolution);
            if (!empty($attachment) && is_array($attachment)) {
                if ($attachment['alt']) {
                    $alt = esc_attr($attachment['alt']);
                } else {
                    $alt = esc_attr(get_bloginfo('name'));
                }
                $image_path = $attachment['src'];
            }
        }

        // set style effect
        $class_style = $image_atts = '';
        if(khaki_nk_check($style)){
            if($style == 2) {
                $image_atts = ' data-from="1.1"';
            }
            $class_style .= 'nk-image-box-' . $style;
        } else {
            $class_style .= 'nk-image-box';
        }
        // no effect
        if (khaki_nk_check($no_effect)) {
            $class_style .= ' nk-no-effect';
        }

        // hovered
        if (khaki_nk_check($hovered)) {
            $class_style .= ' hover';
        }

        // set align content
        $overlay_class = 'nk-image-box-overlay';
        if(isset($content_vertical_align)){
            $overlay_class .= ' nk-image-box-'.$content_vertical_align;
        }

        $result .= '<div class="'.khaki_sanitize_class($portfolio_item_class).'"'.$filter_attr.'>';
            $result .= '<div class="'.khaki_sanitize_class($class_style).'">';
            if(isset($image_path) && !empty($image_path)){
                $result .= '<div class="nk-portfolio-image" style="background-image: url('."'".esc_url($image_path)."'".');"></div>';
            }
             $result .= '<img class="nk-portfolio-image" src="'.esc_url($layout).'" alt="'.esc_attr($alt).'"'.$image_atts.'>';
                $result .= '<div class="'.khaki_sanitize_class($overlay_class).'">';
                $result .= do_shortcode($content);
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</div>';
        return $result;
    }
endif;
/* Add VC Shortcode */
add_action( "after_setup_theme", "vc_nk_portfolio_custom_list" );
if ( ! function_exists( 'vc_nk_portfolio_custom_list' ) ) :
    function vc_nk_portfolio_custom_list() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"     => esc_html__("nK Portfolio Custom List", 'khaki-shortcodes'),
                "base"     => "nk_portfolio_custom_list",
                "controls" => "full",
                "category" => "nK",
                "icon"     => "icon-nk",
                "as_parent" => array('only' => 'nk_portfolio_item, nk_portfolio_custom_item'),
                "content_element" => true,
                "show_settings_on_create" => true,
                "admin_enqueue_css"       => khaki_shortcodes()->plugin_url . "shortcodes/css/nk-carousel-vc-view.css",
                "js_view" => 'VcColumnView',
                "params"   => array_merge(array(
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('No Image', 'khaki-shortcodes'),
                        'param_name' => 'no_image',
                        'description' => ''
                    ),
                    array(
                        'param_name'  => 'gap',
                        'heading'     => esc_html__('Gap', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'cross',
                        'heading'     => esc_html__('Cross', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'filter',
                        'heading'     => esc_html__('Use Filter', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;

add_action( "after_setup_theme", "vc_nk_portfolio_item" );
if ( ! function_exists( 'vc_nk_portfolio_item' ) ) :
    function vc_nk_portfolio_item() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"     => esc_html__("nK Portfolio Item", 'khaki-shortcodes'),
                "base"     => "nk_portfolio_item",
                "category" => "nK",
                "icon"     => "icon-nk",
                "as_child" => array('only' => 'nk_portfolio_custom_list'),
                "content_element" => true,
                "is_container"  => false,
                "params"   => array_merge(array(
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("ID", 'khaki-shortcodes'),
                        "param_name"  => "id",
                        "value"       => "",
                        "description" => "",
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Size', 'khaki-shortcodes'),
                        'param_name' => 'size',
                        'std'        => 'md',
                        'value'      => array(
                            esc_html__('Square', 'khaki-shortcodes')  => 'square',
                            esc_html__('Big Square', 'khaki-shortcodes')  => 'big-square',
                            esc_html__('Horizontal Rectangle', 'khaki-shortcodes')    => 'horizontal-rectangle',
                            esc_html__('Vertical Rectangle', 'khaki-shortcodes')  => 'vertical-rectangle',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-shortcodes'),
                        'param_name' => 'style',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Disabled', 'khaki-shortcodes')  => false,
                            esc_html__('Style 1', 'khaki-shortcodes')  => '1',
                            esc_html__('Style 1a', 'khaki-shortcodes')  => '1-a',
                            esc_html__('Style 2', 'khaki-shortcodes')  => '2',
                            esc_html__('Style 3', 'khaki-shortcodes')  => '3',
                            esc_html__('Style 4', 'khaki-shortcodes')  => '4',
                            esc_html__('Style 5', 'khaki-shortcodes')  => '5',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Content Vertical Align', 'khaki-shortcodes'),
                        'param_name' => 'content_vertical_align',
                        'std'        => 'center',
                        'value'      => array(
                            esc_html__('Top', 'khaki-shortcodes')  => 'top',
                            esc_html__('Center', 'khaki-shortcodes')  => 'center',
                            esc_html__('Bottom', 'khaki-shortcodes')  => 'bottom',
                        ),
                        'description' => ''
                    ),
                    array(
                        'param_name'  => 'no_effect',
                        'heading'     => esc_html__('No Hover Effect', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'hovered',
                        'heading'     => esc_html__('Hovered', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'hide_title',
                        'heading'     => esc_html__('Hide Title', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'hide_date',
                        'heading'     => esc_html__('Hide Date', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    //isotope
                    //image-box (1,2,3,4)
                    //hover
                    //image
                    //link
                    //button
                    //title
                    //date
                    //effect
                    //filter-category
                ))
            ) );
        }
    }
endif;

add_action( "after_setup_theme", "vc_nk_portfolio_custom_item" );
if ( ! function_exists( 'vc_nk_portfolio_custom_item' ) ) :
    function vc_nk_portfolio_custom_item() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"     => esc_html__("nK Portfolio Custom Item", 'khaki-shortcodes'),
                "base"     => "nk_portfolio_custom_item",
                "controls" => "full",
                "category" => "nK",
                "icon"     => "icon-nk",
                "as_child" => array('only' => 'nk_portfolio_custom_list'),
                "content_element" => true,
                "is_container"  => true,
                "js_view"  => 'VcColumnView',
                "params"   => array_merge(array(
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('Background Image', 'khaki-shortcodes'),
                        'param_name' => 'image',
                        'description' => ''
                    ),
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Matching Filter", 'khaki-shortcodes'),
                        "param_name"  => "data_filter",
                        "value"       => "",
                        "description" => esc_html__("Used only if set Filter option for parent nK Portfolio List", 'khaki-shortcodes'),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Size', 'khaki-shortcodes'),
                        'param_name' => 'size',
                        'std'        => 'md',
                        'value'      => array(
                            esc_html__('Square', 'khaki-shortcodes')  => 'square',
                            esc_html__('Big Square', 'khaki-shortcodes')  => 'big-square',
                            esc_html__('Horizontal Rectangle', 'khaki-shortcodes')    => 'horizontal-rectangle',
                            esc_html__('Vertical Rectangle', 'khaki-shortcodes')  => 'vertical-rectangle',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-shortcodes'),
                        'param_name' => 'style',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Disabled', 'khaki-shortcodes')  => false,
                            esc_html__('Style 1', 'khaki-shortcodes')  => '1',
                            esc_html__('Style 1a', 'khaki-shortcodes')  => '1-a',
                            esc_html__('Style 2', 'khaki-shortcodes')  => '2',
                            esc_html__('Style 3', 'khaki-shortcodes')  => '3',
                            esc_html__('Style 4', 'khaki-shortcodes')  => '4',
                            esc_html__('Style 5', 'khaki-shortcodes')  => '5',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Content Vertical Align', 'khaki-shortcodes'),
                        'param_name' => 'content_vertical_align',
                        'std'        => 'center',
                        'value'      => array(
                            esc_html__('Top', 'khaki-shortcodes')  => 'top',
                            esc_html__('Center', 'khaki-shortcodes')  => 'center',
                            esc_html__('Bottom', 'khaki-shortcodes')  => 'bottom',
                        ),
                        'description' => ''
                    ),
                    array(
                        'param_name'  => 'no_effect',
                        'heading'     => esc_html__('No Hover Effect', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'hovered',
                        'heading'     => esc_html__('Hovered', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    )
                ))
            ) );
        }
    }
endif;

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nk_portfolio_custom_list extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nk_portfolio_custom_item extends WPBakeryShortCodesContainer {
    }
}