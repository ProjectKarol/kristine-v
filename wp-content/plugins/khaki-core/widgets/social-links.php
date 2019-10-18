<?php

/**
 * NK Social Links Widget Class
 */
class NK_Social_Links extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'NK_social_links', // Base ID
            esc_html__('(nK) Social Links', 'khaki-core'), // Name
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

        $result = $social_style_class = '';
        $result .= wp_kses_post($args['before_widget']);

        if (function_exists('acf_add_local_field_group')):
            $social_style = get_field('nk_social_style', 'widget_' . $args['widget_id']);

            if($social_style == 'style_1'){
                $social_style_class = 'nk-widget-social';
            }elseif($social_style == 'style_2'){
                $social_style_class = 'nk-widget-social-2';
            }
            $result .= '<div class="'.khaki_sanitize_class($social_style_class).'">';
            $nk_social_items = get_field('nk_social_links', 'widget_' . $args['widget_id']);
            if(isset($nk_social_items) && !empty($nk_social_items) && is_array($nk_social_items)){
                foreach($nk_social_items as $social_item){
                    if(isset($social_item['link']) && !empty($social_item['link'])) {
                        $result .= '<a href="' . esc_url($social_item['link']) . '">';
                    }
                    if(isset($social_item['icon']) && !empty($social_item['icon'])){
                        $class = '';
                        if($social_style == 'style_2') {
                            $class = 'icon ';
                        }
                        $class .= $social_item['icon'];
                        $result .= '<span class="'.khaki_sanitize_class($class).'"></span>';
                    }
                    if(isset($social_item['title']) && !empty($social_item['title'])){
                        $result .= '<span class="h5">'.esc_html($social_item['title']).'</span>';
                    }
                    if(isset($social_item['link']) && !empty($social_item['link'])) {
                        $result .= '</a> ';
                    }
                }
            }
            $result .= '</div>';
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
add_action('widgets_init', 'register_nk_social_links_widget');

if ( ! function_exists('register_nk_social_links_widget') ):
    function register_nk_social_links_widget() {
        register_widget( 'NK_Social_Links' );
    }
endif;

// add ACF options
if( function_exists('acf_add_local_field_group') ):
    acf_add_local_field_group(array (
        'key' => 'group_58a6cad3ada48',
        'title' => 'nK Social Links',
        'fields' => array (
            array (
                'key' => 'field_58a6cc09b9a13',
                'label' => 'Social Links',
                'name' => 'nk_social_links',
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
                'button_label' => 'Add Social Links',
                'sub_fields' => array (
                    array (
                        'key' => 'field_58a6cc7fb9a14',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array (
                            'fa fa-twitch' => 'Twitch (font-awesome)',
                            'ion-social-vimeo-outline' => 'Vimeo',
                            'ion-social-youtube-outline' => 'Youtube',
                            'fab fa-facebook-f' => 'Facebook',
                            'ion-social-googleplus-outline' => 'Google-plus',
                            'fab fa-twitter' => 'Twitter',
                            'fab fa-pinterest' => 'Pinterest',
                            'fab fa-instagram' => 'Instagram',
                            'ion-logo-linkedin' => 'Linkedin',
                            'fa fa-behance' => 'Behance (font-awesome)',
                            'fa fa-odnoklassniki' => 'Odnoklassniki (font-awesome)',
                            'ion-social-skype-outline' => 'Skype',
                            'fa fa-vk' => 'VK',
                            'ion-steam' => 'Steam',
                            'fa fa-bitbucket' => 'Bitbucket (font-awesome)',
                            'ion-social-dropbox-outline' => 'Dropbox',
                            'fab fa-dribbble' => 'Dribbble',
                            'fa fa-deviantart' => 'Deviantart (font-awesome)',
                            'fa fa-flickr' => 'Flickr (font-awesome)',
                            'ion-social-foursquare-outline' => 'Foursquare',
                            'ion-social-github-outline' => 'Github',
                            'fa fa-medium' => 'Medium (font-awesome)',
                            'fa fa-paypal' => 'PayPal (font-awesome)',
                            'ion-social-reddit-outline' => 'Reddit',
                            'fa fa-soundcloud' => 'SoundCloud (font-awesome)',
                            'fa fa-slack' => 'Slack (font-awesome)',
                            'ion-social-tumblr-outline' => 'Tumblr',
                            'ion-social-wordpress-outline' => 'WordPress',
                        ),
                        'default_value' => array (
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'ajax' => 0,
                        'return_format' => 'value',
                        'placeholder' => '',
                    ),
                    array (
                        'key' => 'field_58a6fe1f000ce',
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
                        'key' => 'field_58a6fe40000cf',
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
                ),
            ),
            array (
                'key' => 'field_58a705f6c9c1a',
                'label' => 'Select Style',
                'name' => 'nk_social_style',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array (
                    'style_1' => 'Style 1',
                    'style_2' => 'Style 2',
                ),
                'default_value' => array (
                    0 => 'style_1',
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'widget',
                    'operator' => '==',
                    'value' => 'nk_social_links',
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
