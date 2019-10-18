<?php

/**
 * Menu Extension
 * Add subtitle
 *
 * @package khaki
 */
class nk_walker extends Walker_Nav_Menu
{

private $logo_position;

    public function __construct($logo_position = false) {
        $this->logo_position = $logo_position;
    }
    function isset_item($item)
    {
        return isset($item->title);
    }

    function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array)$item->classes;


        // Add classname if has submenu
        $attributes = '';
        $has_children = in_array('menu-item-has-children', $classes);

        // add mega menu argument
        $mega = $item->mega == 'on';
        $column_labels = $item->column_labels == 'on';
        if ($mega) {
            if ($depth == 0) {
                $args->khaki_image = $item->image;
            }
            $args->khaki_mega = true;
            $classes[] = 'nk-mega-item';

            if($column_labels){
                $args->khaki_column_labels = true;
            }

        }

        if ( ( array_search( 'current-menu-item', $classes ) !== false || array_search( 'current-menu-ancestor', $classes ) !== false ) && ( ! empty( $item->url ) && strpos( $item->url, '#' ) === false ) ) {
            $classes[] = 'active';
        }

        if ($depth == 1 && isset($args->khaki_mega)) {
            $output .= '<li>';
            if(isset($args->khaki_column_labels)){
                $output .= '<label>'.esc_html($item->title).'</label>';
            }
            $output .= '<ul>';

            // return $output for hide $depth == 1 root menu element if set column labels option
            if(isset($args->khaki_column_labels)){
                return $output;
            }
        }


        if ($has_children) {
            //$classes[] = 'dropdown';
            if (!isset($args->khaki_mega) || isset($args->khaki_mega) && $depth == 0) {
                $classes[] = 'nk-drop-item';
            }
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        $class_names = ' class="' . esc_attr($class_names) . '"';

        if ($this->isset_item($item)) {
            $output .= $indent . '<li id="menu-item-' . $item->ID . '-' . $args->theme_location . '"' . $value . $class_names . '>';
        }

        $attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= ' role="button"';
        $attributes .= ' aria-expanded="false"';

        $prepend = '';
        $append = '';
        $subtitle = !empty($item->description) ? '<span class="nk-item-descr">' . esc_attr($item->description) . '</span>' : '';
        

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters('the_title', $item->title, $item->ID);

        /**
         * Filter a menu item's title.
         *
         * @since 4.4.0
         *
         * @param string $title The menu item's title.
         * @param object $item The current menu item.
         * @param array $args An array of {@see wp_nav_menu()} arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = '';
        if (is_object($args)) {
            $item_output .= $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before;
            $item_output .= $prepend . $title . $append;
            $item_output .= $subtitle . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            if (isset($args->khaki_mega) && $depth == 1) {
                $item_output .= '</li>';
            }
        }

        if ($this->isset_item($item)) {
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = array())
    {
        if (isset($args->khaki_mega) && $depth == 1) {
            $output .= '</ul></li>';
        } elseif ($this->isset_item($item)) {
            $output .= '</li>';
            if($this->logo_position!=false && $this->logo_position == $item->ID){
                $output .= '<li>';
                $output .= khaki_get_main_navigation_logo();
                $output .= '</li>';
            }
        }
    }

    // change markup for submenus
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        if (isset($args->khaki_mega)) {
            if ($depth == 0) {
                if (isset($args->khaki_image)) {
                    $arImage = wp_get_attachment_image_src($args->khaki_image, 'khaki_1280x720_crop');
                    $output .= '<div class="dropdown"><div class="bg-image" style="background-image: url(' . "'" . $arImage[0] . "'" . ')"></div><ul>';
                } else {
                    $output .= '<div class="dropdown"><ul>';
                }
            }
        } else {
            $output .= "<ul class='dropdown'>";
        }
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        if (isset($args->khaki_mega)) {
            if ($depth == 0) {
                $output .= '</ul></div>';
                $args->khaki_mega = null;
            }
        } else {
            $output .= '</ul>';
        }
    }
}