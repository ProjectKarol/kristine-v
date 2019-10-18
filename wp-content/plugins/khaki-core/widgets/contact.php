<?php

/**
 * NK Contact Widget Class
 */
class NK_Contact extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'NK_contact', // Base ID
            esc_html__('(nK) Contact', 'khaki-core'), // Name
            array('description' => esc_html__('List with social links.', 'khaki-core'),) // Args
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

        $result = '';
        $result .= wp_kses_post($args['before_widget']);

        if (function_exists('acf_add_local_field_group')):
            $title = get_field('title', 'widget_' . $args['widget_id']);
            if(isset($title) && !empty($title)){
                $result .= '<h4 class="nk-widget-title">'.esc_html($title).'</h4>';
            }
            
            $contacts = get_field('nk_contact', 'widget_' . $args['widget_id']);
            if(isset($contacts) && !empty($contacts) && is_array($contacts)){
                $result .= '<div>';
                $result .= '<ul class="nk-widget-contact">';
                foreach($contacts as $contact_item){
                    $result .= '<li>';
                    if(isset($contact_item['icon']) && !empty($contact_item['icon'])){
                        $class = $contact_item['icon'];
                        $result .= '<span class="nk-widget-contact-icon">';
                        $result .= '<span class="'.khaki_sanitize_class($class).'"></span>';
                        $result .= '</span>';
                    }
                    if(isset($contact_item['link']) && !empty($contact_item['link'])) {
                        $result .= '<a href="' . esc_url($contact_item['link']) . '">';
                    }
                    if(isset($contact_item['text']) && !empty($contact_item['text'])){
                        $result .= esc_html($contact_item['text']);
                    }
                    if(isset($contact_item['link']) && !empty($contact_item['link'])) {
                        $result .= '</a> ';
                    }
                    $result .= '</li>';
                }
                $result .= '</ul>';
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
add_action( 'widgets_init', 'register_nk_contact_widget' );

if ( ! function_exists('register_nk_contact_widget') ):
    function register_nk_contact_widget() {
        register_widget( 'NK_Contact' );
    }
endif;

// add ACF options
if( function_exists('acf_add_local_field_group') ):
    acf_add_local_field_group(array (
        'key' => 'group_58a6cad3ada48_contact',
        'title' => 'nK Contact',
        'fields' => array (
            array (
                'key' => 'field_58a705f6c9c1a_contact',
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
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
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_58a6cc09b9a13_contact',
                'label' => 'Contact',
                'name' => 'nk_contact',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'row',
                'button_label' => 'Add Contact',
                'sub_fields' => array (
                    array (
                        'key' => 'field_58a6cc7fb9a14_contact',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'text',
                        'instructions' => 'Supported	<a href="http://fontawesome.io/icons/">FontAwesome</a> and <a href="http://ionicons.com/">IonIcons</a>	classes',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_58a6fe1f000ce_contact',
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
                    array (
                        'key' => 'field_58a6fe40000cf_contact',
                        'label' => 'Text',
                        'name' => 'text',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                ),
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'widget',
                    'operator' => '==',
                    'value' => 'nk_contact',
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