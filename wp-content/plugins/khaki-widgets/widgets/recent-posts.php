<?php

/**
 * NK Recent Posts Widget Class
 */
class NK_Recent_Posts extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'NK_Recent_Posts', // Base ID
            esc_html__('(nK) Recent Posts', 'khaki-widgets'), // Name
            array('description' => esc_html__('List with recent posts.', 'khaki-widgets'),) // Args
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

        $the_query = new WP_Query('showposts=' . $instance['posts_count']);
        while ($the_query->have_posts()) : $the_query->the_post();
            $title = get_the_title();
            $date = khaki_posted_on(true, $instance['show_date'] ? true : false);
            $img = khaki_post_thumbnail(true);

            echo '
				  <div class="nk-widget-post">
					' . $img . '
				     <h3 class="nk-post-title"><a href="' . esc_url(get_permalink()) . '" title="' . esc_attr($title) . '">' . esc_html($title) . '</a></h3>
				     <div class="nk-post-meta-date">' . $date . '</div>			    
				  </div>';
        endwhile;

        echo '</div>';

        echo wp_kses_post($args['after_widget']);

        wp_reset_postdata();
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
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Recent Posts', 'khaki-widgets');
        $posts_count = !empty($instance['posts_count']) ? $instance['posts_count'] : 3;
        $show_date = !empty($instance['show_date']) ? $instance['show_date'] : '';
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'khaki-widgets'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('posts_count')); ?>"><?php esc_html_e('Posts Count:', 'khaki-widgets'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('posts_count')); ?>" type="text"
                   value="<?php echo esc_attr($posts_count); ?>">
        </p>
        <p>
            <input id="<?php echo esc_attr($this->get_field_id('show_date')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_date')); ?>"
                   type="checkbox" <?php checked($show_date, 'on'); ?>>
            <label
                for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html_e('Show Date', 'khaki-widgets'); ?></label>
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
        $instance['posts_count'] = (!empty($new_instance['posts_count'])) ? strip_tags($new_instance['posts_count']) : '';
        $instance['show_date'] = $new_instance['show_date'];
        $instance['show_author'] = $new_instance['show_author'];

        return $instance;
    }

}

// register Recent Posts widget
add_action('widgets_init',
    create_function('', 'return register_widget("NK_Recent_Posts");')
);
