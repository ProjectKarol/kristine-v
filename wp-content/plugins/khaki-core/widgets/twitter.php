<?php

/**
 * NK Twitter Widget Class
 */
class NK_Twitter extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'NK_Twitter', // Base ID
            esc_html__('(nK) Twitter', 'khaki-core'), // Name
            array('description' => esc_html__('Tweetts list.', 'khaki-core'),) // Args
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
        echo do_shortcode('[nk_twitter count="' . $instance['tweets_count'] . '"]');
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
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Twitter', 'khaki-core');
        $tweets_count = !empty($instance['tweets_count']) ? $instance['tweets_count'] : 3;
        ?>
        <p>
            <label><?php echo esc_html__("Before use, you need to configure access to Twitter here - ", 'khaki-core') . '<a target="_blank" href="' . esc_url(admin_url('customize.php?autofocus[section]=khaki_twitter')) . '">' . esc_url(admin_url('customize.php?autofocus[section]=khaki_twitter')) . '</a>'; ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'khaki-core'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('tweets_count')); ?>"><?php esc_html_e('Tweets Count:', 'khaki-core'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tweets_count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('tweets_count')); ?>" type="text"
                   value="<?php echo esc_attr($tweets_count); ?>">
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
        $instance['tweets_count'] = (!empty($new_instance['tweets_count'])) ? strip_tags($new_instance['tweets_count']) : '';

        return $instance;
    }

}

// register Twitter widget
add_action('widgets_init', 'register_nk_twitter_widget');

if ( ! function_exists('register_nk_twitter_widget') ):
    function register_nk_twitter_widget() {
        register_widget( 'NK_Twitter' );
    }
endif;