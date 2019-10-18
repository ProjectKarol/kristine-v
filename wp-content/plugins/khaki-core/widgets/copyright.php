<?php

/**
 * NK Copyright Widget Class
 */
class NK_Copyright extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'NK_copyright', // Base ID
            esc_html__('(nK) Copyright', 'khaki-core'), // Name
            array('description' => esc_html__('Add custom image', 'khaki-core'),) // Args
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
            $text = get_field('text', 'widget_' . $args['widget_id']);
            if(isset($text) && !empty($text)){
                $result .= '<div class="nk-copyright-2">';
                $result .= '<div class="container">';
                $result .= $text;
                $result .= '</div>';
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
            $plugin_link = '<a href="'.get_home_url().'/wp-admin/admin.php?page=nk-theme-plugins">'.esc_html__('ACF plugin', 'khaki-core').'</a>';
            ?>
            <p>
                <label><?php printf(__('Please install %1$s to use this widget', 'khaki-core'), $plugin_link); ?></label>
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
add_action( 'widgets_init', 'register_nk_copyright_widget' );

if ( ! function_exists('register_nk_copyright_widget') ):
    function register_nk_copyright_widget() {
        register_widget( 'NK_Copyright' );
    }
endif;

// add ACF options
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
        'key' => 'group_58f74d587e9a0',
        'title' => 'nK Copyright',
        'fields' => array (
            array (
                'key' => 'field_58f74d6a170a3',
                'label' => 'Text',
                'name' => 'text',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'widget',
                    'operator' => '==',
                    'value' => 'nk_copyright',
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