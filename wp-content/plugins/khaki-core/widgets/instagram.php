<?php

/**
 * NK Instagram Widget Class
 */
class NK_Instagram extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'NK_Instagram', // Base ID
            esc_html__('(nK) Instagram', 'khaki-core'), // Name
            array('description' => esc_html__('Instagram images list.', 'khaki-core'),) // Args
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
        echo wp_kses_post($args['before_widget']);
        if (!empty($instance['title'])) {
            echo wp_kses_post($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
        }
        echo '<div>';

        // Get the images from Instagram.
        nk_theme()->instagram()->set_data(array(
            'access_token' => khaki_get_theme_mod('instagram_access_token'),
            'user_id' => khaki_get_theme_mod('instagram_user_id'),
            'cachetime' => khaki_get_theme_mod('instagram_cachetime')
        ));
        $instagram = nk_theme()->instagram()->get_instagram($instance['images_count']);
        $result = '';
        if (!nk_theme()->instagram()->has_error() && !empty($instagram)) {
            for ($i = 0; $i < $instance['images_count']; $i++) {
                $item = $instagram[$i];
                if (isset($item)) {
                    $result .= '<div class="col-4">
                            <a href="' . esc_url($item->link) . '" class="db" target="_blank">
                                <img class="nk-img-stretch" src="' . esc_url($item->images->thumbnail->url) . '" alt="">
                            </a>
                        </div>';
                } else break;
            }
        } else if (nk_theme()->instagram()->has_error()) {
            $result = nk_theme()->instagram()->get_error()->message;
        }

        echo '<div class="nk-instagram row sm-gap vertical-gap">' . $result . '</div>';
        echo '</div>';

        echo wp_kses_post($args['after_widget']);
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
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Instagram', 'khaki-core');
        $images_count = !empty($instance['images_count']) ? $instance['images_count'] : 6;
        ?>
        <p>
            <label><?php echo esc_html__("Before use, you need to configure access to Instagram here - ", 'khaki-core') . '<a target="_blank" href="' . esc_url(admin_url('customize.php?autofocus[section]=khaki_instagram')) . '">' . esc_url(admin_url('customize.php?autofocus[section]=khaki_instagram')) . '</a>'; ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'khaki-core'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('images_count')); ?>"><?php esc_html_e('Images Count:', 'khaki-core'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('images_count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('images_count')); ?>" type="text"
                   value="<?php echo esc_attr($images_count); ?>">
        </p>
        <?php
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
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['images_count'] = (!empty($new_instance['images_count'])) ? strip_tags($new_instance['images_count']) : '';

        return $instance;
    }

}

// register Instagram widget
add_action('widgets_init', 'register_nk_instagram_widget');

if ( ! function_exists('register_nk_instagram_widget') ):
    function register_nk_instagram_widget() {
        register_widget( 'NK_Instagram' );
    }
endif;
