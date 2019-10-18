<?php

/**
 * NK Tags Cloud Widget Class
 */
class NK_Tags_Cloud extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'NK_tags_cloud', // Base ID
            esc_html__('(nK) Tags Cloud', 'khaki-core'), // Name
            array('description' => esc_html__('List with recent posts.', 'khaki-core'),) // Args
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
        $smallest = 1;
        $largest = 1;
        $unit = 'rem';
        $cont_class = '';

        if ($instance['style'] == 'khaki-tags') {
            $cont_class = 'nk-widget-tags';
            $smallest = 0.9;
            $largest = 0.9;
        }

        if ($instance['style'] == 'khaki-cats') {
            $cont_class = 'nk-widget-categories';
            $smallest = 0.9;
            $largest = 0.9;
        }

        $tags = wp_tag_cloud(array(
            'smallest' => $smallest,
            'largest' => $largest,
            'unit' => $unit,
            'number' => $instance['number'],
            'format' => 'array',
            'separator' => "\n",
            'orderby' => $instance['order_by'],
            'order' => $instance['order'],
            'exclude' => null,
            'include' => null,
            // 'topic_count_text_callback' => default_topic_count_text,
            'link' => 'view',
            'taxonomy' => $instance['taxonomy'],
            'echo' => false,
            'child_of' => null,
        ));
        echo wp_kses_post($args['before_widget']);
        if (!empty($instance['title'])) {
            echo wp_kses_post($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
        }
        echo '<div>';
        if ($instance['style'] == 'khaki-tags') {
            echo '<div class="' . khaki_sanitize_class($cont_class) . '">';
        }
        if ($instance['style'] == 'khaki-cats') {
            echo '<ul class="' . khaki_sanitize_class($cont_class) . '">';
        }
        if(isset($tags) && !empty($tags) && is_array($tags)){
            foreach ($tags as $tag) {
                if ($instance['style'] == 'khaki-cats') {
                    echo '<li>' . $tag . '</li>';
                } else {
                    $tag = str_replace('<a', '<a data-toggle="tooltip" ', $tag);
                    echo $tag . ' ';
                }
            }
        }
        if ($instance['style'] == 'khaki-cats') {
            echo '</ul>';
        }
        if ($instance['style'] == 'khaki-tags') {
            echo '</div>';
        }
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
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Tags', 'khaki-core');
        $style = !empty($instance['style']) ? $instance['style'] : 'default';
        $number = !empty($instance['number']) ? $instance['number'] : 45;
        $order_by = !empty($instance['order_by']) ? $instance['order_by'] : 'name';
        $order = !empty($instance['order']) ? $instance['order'] : 'ASC';
        $taxonomy = !empty($instance['taxonomy']) ? $instance['taxonomy'] : 'post_tag';
        ?>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'khaki-core'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>" class="widefat">
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php esc_html_e('Style:', 'khaki-core'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('style')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('style')); ?>">
                <option
                    value="default" <?php echo $style == 'default' ? 'selected' : ''; ?>><?php esc_html_e('Default', 'khaki-core'); ?></option>
                <option
                    value="khaki-tags" <?php echo $style == 'khaki-tags' ? 'selected' : ''; ?>><?php esc_html_e('khaki Tags', 'khaki-core'); ?></option>
                <option
                    value="khaki-cats" <?php echo $style == 'khaki-cats' ? 'selected' : ''; ?>><?php esc_html_e('khaki Categories', 'khaki-core'); ?></option>
            </select>
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of actual tags:', 'khaki-core'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('number')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text"
                   value="<?php echo esc_attr($number); ?>" class="widefat">
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('order_by')); ?>"><?php esc_html_e('Order By:', 'khaki-core'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('order_by')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('order_by')); ?>">
                <option
                    value="name" <?php echo $order_by == 'name' ? 'selected' : ''; ?>><?php esc_html_e('Name', 'khaki-core'); ?></option>
                <option
                    value="count" <?php echo $order_by == 'count' ? 'selected' : ''; ?>><?php esc_html_e('Count', 'khaki-core'); ?></option>
            </select>
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('order')); ?>"><?php esc_html_e('Sort Order:', 'khaki-core'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('order')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('order')); ?>">
                <option
                    value="ASC" <?php echo $order == 'ASC' ? 'selected' : ''; ?>><?php esc_html_e('ASC', 'khaki-core'); ?></option>
                <option
                    value="DESC" <?php echo $order == 'DESC' ? 'selected' : ''; ?>><?php esc_html_e('DESC', 'khaki-core'); ?></option>
                <option
                    value="RAND" <?php echo $order == 'RAND' ? 'selected' : ''; ?>><?php esc_html_e('RAND', 'khaki-core'); ?></option>
            </select>
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>"><?php esc_html_e('Taxonomy:', 'khaki-core'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('taxonomy')); ?>">
                <option
                    value="category" <?php echo $taxonomy == 'category' ? 'selected' : ''; ?>><?php esc_html_e('Categories', 'khaki-core'); ?></option>
                <option
                    value="post_tag" <?php echo $taxonomy == 'post_tag' ? 'selected' : ''; ?>><?php esc_html_e('Tags', 'khaki-core'); ?></option>
                <option
                    value="link_category" <?php echo $taxonomy == 'link_category' ? 'selected' : ''; ?>><?php esc_html_e('Link Categories', 'khaki-core'); ?></option>
            </select>
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
        $instance['style'] = (!empty($new_instance['style'])) ? strip_tags($new_instance['style']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? strip_tags($new_instance['number']) : '';
        $instance['order_by'] = (!empty($new_instance['order_by'])) ? strip_tags($new_instance['order_by']) : '';
        $instance['order'] = (!empty($new_instance['order'])) ? strip_tags($new_instance['order']) : '';
        $instance['taxonomy'] = (!empty($new_instance['taxonomy'])) ? strip_tags($new_instance['taxonomy']) : '';

        return $instance;
    }

}

// register Tags Cloud widget
add_action('widgets_init', 'register_nk_tags_cloud_widget');

if ( ! function_exists('register_nk_tags_cloud_widget') ):
    function register_nk_tags_cloud_widget() {
        register_widget( 'NK_Tags_Cloud' );
    }
endif;