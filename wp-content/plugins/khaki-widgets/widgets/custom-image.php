<?php

/**
 * NK Custom Image Widget Class
 */
class NK_Custom_Image extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'NK_custom_image', // Base ID
            esc_html__('(nK) Custom Image', 'khaki-widgets'), // Name
            array('description' => esc_html__('Add custom image', 'khaki-widgets'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {

        $result = $social_style_class = '';
        $result .= wp_kses_post($args['before_widget']);

        if (function_exists('acf_add_local_field_group')):
            $custom_image_id = get_field('custom_image', 'widget_' . $args['widget_id']);
            $image_array = khaki_get_attachment($custom_image_id);
            if(isset($image_array) && !empty($image_array) && is_array($image_array)){
                $image_width = get_field('width', 'widget_' . $args['widget_id']);
                $link = get_field('link', 'widget_' . $args['widget_id']);
                $result .= '<div class="nk-footer-logo">';
                if(isset($link) && !empty($link)) {
                    $result .= '<a href="' . esc_url($link) . '">';
                }

                $result .= '<img src="'.esc_url($image_array['src']).'" alt="'.esc_attr($image_array['alt']).'" width="'.esc_attr($image_width).'">';

                if(isset($link) && !empty($link)) {
                    $result .= '</a>';
                }
                $result .= '</div>';
            }
        endif;


        $result .= wp_kses_post($args['after_widget']);
        echo $result;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        if (!function_exists('acf_add_local_field_group')):
            $plugin_link = '<a href="'.get_home_url().'/wp-admin/admin.php?page=nk-theme-plugins">'.esc_html__('ACF plugin', 'khaki-widgets').'</a>';
            ?>
            <p>
                <label><?php printf(__('Please install %1$s to use this widget', 'khaki-widgets'), $plugin_link); ?></label>
            </p>
            <?php
        endif;

    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        return $old_instance;
    }

}

// register Tags Cloud widget
add_action('widgets_init',
    create_function('', 'return register_widget("NK_Custom_Image");')
);

// add ACF options
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
        'key' => 'group_58f745a5c76cd',
        'title' => 'nK Custom Image',
        'fields' => array (
            array (
                'key' => 'field_58f745cda71ad',
                'label' => 'Image',
                'name' => 'custom_image',
                'type' => 'image',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'id',
                'preview_size' => 'full',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array (
                'key' => 'field_58f745e3a71ae',
                'label' => 'Size',
                'name' => 'width',
                'type' => 'number',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 70,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => 20,
                'max' => 250,
                'step' => 1,
            ),
            array (
                'key' => 'field_58f745f2a71af',
                'label' => 'Link',
                'name' => 'link',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'widget',
                    'operator' => '==',
                    'value' => 'nk_custom_image',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

endif;