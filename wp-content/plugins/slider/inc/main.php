<?php

// Add Shortcode
function flicker_slider()
{
	ob_start(); ?>

<!-- </div>
    </div> -->

<div class="slider-home">
    <div class="desktop">

        <?php
        global $post;

        // arguments, adjust as needed
        $args = array(
        	'post_type' => array('slider_type', 'post'), // change
        	'post_status' => 'publish',
        	'posts_per_page' => -1,
        	'order' => 'DESC',
        	'orderby' => 'date',
        	'meta_query' => array(
        		'relation' => 'OR',
        		array(
        			'key' => 'home-slider', // change
        			'value' => '', //The value of the field.
        			'compare' => '!=' //Conditional statement used on the value.
        		)
        	)
        );

        /* 
   Overwrite $wp_query with our new query.
   The only reason we're doing this is so the pagination functions work,
   since they use $wp_query. If pagination wasn't an issue, 
   use: https://gist.github.com/3218106
   */
        global $wp_query;
        $wp_query = new WP_Query($args);
        ?>

        <!-- Flickity HTML init -->
        <div class="carousel" data-flickity><?php if (have_posts()):
        	while (have_posts()):
        		the_post();
        		$image = get_field('home-slider');
        		$size = 'medium_large'; // (thumbnail, medium, large, full or custom size)

        		if ($image) {
        			$imgtest = $image['sizes']['home-slider'];
        			//  echo '<pre>'; print_r($image); echo '</pre>';
        			?>


            <div class="carousel-cell" style="background-image: url(<?php echo $image[
            	'sizes'
            ]['main-slider']; ?>);">


                <div class="one-half first" style="background-color:<?php the_field(
                	'left_background_color'
                ); ?>">
                    <?php echo get_field('left_text'); ?>
                </div><!-- one-half first -->


                <div class="one-half" style="background-color:<?php the_field(
                	'right_color_piker'
                ); ?>">
                    <?php echo get_field('right_text'); ?>
                </div> <!-- one-half -->
                <div class="bottom-text" style="background-color:<?php the_field(
                	'left_background_color'
                ); ?>">

                    <?php echo get_field('bottom_text'); ?>
                </div><!-- bottom-text -->



            </div><!-- carousel-cell -->

            <?php
        		}
        		//  $loop_counter++;
        	endwhile; /** end of one post **/ /** if no posts exist **/
        else:
        	do_action('genesis_loop_else');
        endif;
	/** end loop **/
	?>
        </div> <!-- carousel -->

        <?php wp_reset_query(); ?>
    </div><!-- desktop -->


    <div class="mobile">

        <?php
        global $post;

        // arguments, adjust as needed
        $args = array(
        	'post_type' => array('slider_type', 'post'), // change
        	'post_status' => 'publish',
        	'posts_per_page' => -1,
        	'order' => 'DESC',
        	'orderby' => 'date',
        	'meta_query' => array(
        		'relation' => 'OR',
        		array(
        			'key' => 'mobile-slider', // change
        			'value' => '', //The value of the field.
        			'compare' => '!=' //Conditional statement used on the value.
        		)
        	)
        );

        /* 
Overwrite $wp_query with our new query.
The only reason we're doing this is so the pagination functions work,
since they use $wp_query. If pagination wasn't an issue, 
use: https://gist.github.com/3218106
*/
        global $wp_query;
        $wp_query = new WP_Query($args);
        ?>

        <!-- Flickity HTML init -->
        <div class="carousel" data-flickity><?php if (have_posts()):
        	while (have_posts()):
        		the_post();
        		$image = get_field('mobile-slider');
        		$size = 'medium_large'; // (thumbnail, medium, large, full or custom size)

        		if ($image) {
        			$imgtest = $image['sizes']['mobile-slider'];
        			//  echo '<pre>'; print_r($image); echo '</pre>';
        			?>


            <div class="carousel-cell" style="background-image: url(<?php echo $image[
            	'sizes'
            ]['mobile-slider']; ?>);">



                <div class="bottom-text" style="background-color:<?php the_field(
                	'mobile_slider_background'
                ); ?>">

                    <?php echo get_field('text__mobile_fone'); ?>
                </div><!-- bottom-text -->



            </div><!-- carousel-cell -->

            <?php
        		}
        		//  $loop_counter++;
        	endwhile; /** end of one post **/ /** if no posts exist **/
        else:
        	do_action('genesis_loop_else');
        endif;
	/** end loop **/
	?>
        </div> <!-- carousel -->

        <?php
        $output_string = ob_get_contents();
        ob_end_clean();
        return $output_string;
        wp_reset_query();?>
    </div><!-- mobile -->

</div><!-- slider-home -->

<?php
}
add_shortcode('flicker-slider', 'flicker_slider');