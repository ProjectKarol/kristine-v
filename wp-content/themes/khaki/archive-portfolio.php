<?php
/**
 * The template for displaying all custom(portfolio) posts list.
 *
 * @link https://codex.wordpress.org/Post_Types
 *
 * @package khaki
 */
get_header();
get_template_part('/template-parts/header/custom');

$acf_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_custom', true);
$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show', $acf_sidebar);
$custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side', $acf_sidebar);

$col_class = 'col-12';

if ($show_custom_sidebar && $custom_sidebar && is_active_sidebar($custom_sidebar)) {
    if (isset($custom_sidebar_side) && $custom_sidebar_side === 'both') {
        $col_class = 'col-lg-6';
    } else {
        $col_class = 'col-lg-8';
    }
}
?>
    <div
        class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('portfolio_inner_boxed') ? 'container' : 'container-fluid'); ?>">
    <div class="row">
        <div class="<?php echo khaki_sanitize_class($col_class); ?>">
            <div class="nk-gap-4"></div>
            <?php if (khaki_get_theme_mod('portfolio_content_show_title')): ?>
                <?php the_archive_title('<h1 class="nk-title">', '</h1>'); ?>
                <div class="nk-gap-4"></div>
            <?php endif; ?>
        <?php
        $pagination = khaki_get_theme_mod('portfolio_pagination');
        $class = '';
        $portfolio_list = $image_atts = $class_style = $result = '';

        $style = khaki_get_theme_mod('portfolio_archive_style');
        $show_date = khaki_get_theme_mod('portfolio_archive_show_date');

        //Masonry options
        $show_likes = khaki_get_theme_mod('portfolio_archive_show_likes');
        $show_title = khaki_get_theme_mod('portfolio_archive_show_title');
        $show_comments_count = khaki_get_theme_mod('portfolio_archive_show_comments_count');
        $show_eye_icon = khaki_get_theme_mod('portfolio_archive_show_eye_icon');
        $show_link_icon = khaki_get_theme_mod('portfolio_archive_show_link_icon');
        $global_link = khaki_get_theme_mod('portfolio_archive_global_link');
        $filter = khaki_get_theme_mod('portfolio_archive_filter');
        $cross = khaki_get_theme_mod('portfolio_archive_cross');
        $no_image = khaki_get_theme_mod('portfolio_no_image');

        if (isset($style)) {
            if($style == 'list'){
                $class .= 'nk-portfolio-list';
            }
            if($style == 'list_2'){
                $class .= 'nk-portfolio-list-2';
            }
            if($style == 'masonry'){

                $columns = khaki_get_theme_mod('portfolio_archive_columns');
                $effect_style = khaki_get_theme_mod('portfolio_archive_effect_style');
                $no_effect = khaki_get_theme_mod('portfolio_archive_no_effect');
                $hovered = khaki_get_theme_mod('portfolio_archive_hovered');
                $content_vertical_align = khaki_get_theme_mod('portfolio_archive_content_vertical_align');

                $class .= 'nk-isotope nk-isotope-gap';

                if($columns>1 && $columns<=3 && is_numeric($columns)){
                    $class .=' nk-isotope-'.$columns.'-cols';
                }

                // set style effect
                if(isset($effect_style)){
                    if($effect_style == 2) {
                        $image_atts = ' data-from="1.1"';
                    }
                    $class_style .= 'nk-image-box-' . $effect_style;
                } else {
                    $class_style .= 'nk-image-box';
                }

                // no effect
                if ($no_effect) {
                    $class_style .= ' nk-no-effect';
                }

                // hovered
                if ($hovered) {
                    $class_style .= ' hover';
                }

                // set align content
                $overlay_class = 'nk-image-box-overlay';
                if(isset($content_vertical_align)){
                    $overlay_class .= ' nk-image-box-'.$content_vertical_align;
                }
            }
        }
        if (isset($pagination) && $pagination === 'infinite') {
            $class .= ' nk-infinite-scroll-container';
        }
        if (isset($pagination) && $pagination === 'load_more') {
            $class .= ' nk-load-more-container';
        }


        if($style == 'list' || $style == 'list_2'):
        $preview_description_type = khaki_get_theme_mod('portfolio_preview_description_type_content');
        $preview_description_trim_cnt = khaki_get_theme_mod('portfolio_preview_description_trim_cnt');
        ?>
        <div
            class="<?php echo khaki_sanitize_class($class); ?>">
            <?php
            if (have_posts()) :
                /* Start the Loop */
                $post_count = 1;
                while (have_posts()) : the_post();
                    ?>
                    <?php
                    $item_class = 'nk-portfolio-item';
                    $item_class .= $post_count % 2 ? '' : ' inverted';
                    $item_class .= ' news-one';
                    ?>
                    <div id="post-<?php the_ID(); ?>" class="<?php echo khaki_sanitize_class($item_class); ?>">
                        <?php echo khaki_portfolio_list_element($style, $preview_description_type, $preview_description_trim_cnt, $show_date); ?>
                    </div>
                    <div class="nk-gap-3"></div>
                    <?php $post_count++; ?>
                <?php endwhile;
            else :
                get_template_part('template-parts/content', 'none');
            endif; ?>
        </div>
            <?php
            if ($pagination) {
                khaki_posts_navigation();

                if ($pagination == 'infinite' || $pagination == 'load_more') {
                    nk_infinite_scroll_init();
                }
            }
            ?>
        <?php
        else:
            if($style == 'masonry'):
                if (have_posts()) :
                while (have_posts()) : the_post();
                    $current_post_atts = $alt = $attachment_src = '';

                    //Filter Matches
                    if($filter){
                        $category = get_the_terms(get_the_ID(), 'portfolio-category');
                        if ($category){
                            $current_post_atts .= ' data-filter="';
                            foreach ($category as $key => $cat_item){
                                $filter_values[] = $cat_item->name;
                                if($key > 0){
                                    $current_post_atts .= ', ';
                                }
                                $current_post_atts .= esc_attr($cat_item->name);
                            }
                            $current_post_atts .= '"';
                        }
                    }
                    //Attachment
                    $resolution = 'khaki_1280x720';
                    $attachment = khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $resolution);
                    if (!empty($attachment) && is_array($attachment)) {
                        if ($attachment['alt']) {
                            $alt = esc_attr($attachment['alt']);
                        } else {
                            $alt = esc_attr(get_bloginfo('name'));
                        }
                        $attachment_src = $attachment['src'];
                    } else {
                        if(isset($no_image) && !empty($no_image)){
                            $attachment = khaki_get_attachment($no_image, $resolution);
                            if(!empty($attachment) && is_array($attachment)){
                                $alt = esc_attr__('No Image', 'khaki');
                                $attachment_src = $attachment['src'];
                            }
                        } else{
                            $alt = esc_attr__('No Image', 'khaki');
                            $attachment_src = esc_url(get_template_directory_uri() . '/assets/images/no-image.jpg');
                        }
                    }

                    //Post link
                    $portfolio_url = get_permalink();

                    //Title
                    $title = get_the_title();

                    //Published Date
                    $published_date = get_the_time(esc_html__('F j, Y', 'khaki'));

                    $portfolio_list .= '<div class="nk-portfolio-item nk-isotope-item"'.$current_post_atts.'>';
                    $portfolio_list .= '<div class="'.khaki_sanitize_class($class_style).'">';
                    if($global_link && isset($portfolio_url) && !empty($portfolio_url)){
                        $portfolio_list .= '<a href="'.esc_url($portfolio_url).'" class="nk-image-box-link"></a>';
                    }
                    $portfolio_list .= '<img class="nk-portfolio-image" src="'.$attachment_src.'" alt="'.$alt.'"'.$image_atts.'>';
                    $portfolio_list .= '<div class="'.khaki_sanitize_class($overlay_class).'">';
                    $portfolio_list .= '<div>';
                    if($show_eye_icon && isset($portfolio_url) && !empty($portfolio_url)) {
                        $portfolio_list .= '<a href="' . esc_url($portfolio_url) . '" class="nk-image-box-icon-btn nk-portfolio-quick-view"><span class="ion-ios-eye"></span></a>';
                    }
                    if($show_link_icon && isset($portfolio_url) && !empty($portfolio_url)) {
                        $portfolio_list .= '<a href="' . esc_url($portfolio_url) . '" class="nk-image-box-icon-btn"><span class="ion-md-link"></span></a>';
                    }
                    $portfolio_list .= '</div>';
                    $portfolio_list .= '</div>';
                    $portfolio_list .= '</div>';
                    $portfolio_list .= '<div class="nk-image-box-bottom-info">';
                    //add meta, heart, title, link, date.
                    if(isset($title) && !empty($title) && isset($portfolio_url) && !empty($portfolio_url) && $show_title){
                        $portfolio_list .= '<h2 class="nk-portfolio-title nk-post-title h4"><a href="'.esc_url($portfolio_url).'">'.esc_html($title).'</a></h2>';
                    }
                    $portfolio_list .= '<div class="nk-post-meta">';
                    $portfolio_list .= '<div class="nk-post-meta-right">';
                    if (get_comments() && $show_comments_count){
                        $portfolio_list .= '<a class="nk-post-comments-count" href="'.esc_url($portfolio_url.'#comments').'">'.number_format_i18n(get_comments_number()).'</a>';
                    }
                    if($show_likes && function_exists('sociality')) {
                        $portfolio_list .= sociality()->likes()->get_likes(get_the_ID(), 'portfolio');
                    }
                    $portfolio_list .= '</div>';
                    if(isset($published_date) && !empty($published_date) && $show_date){
                        $portfolio_list .= '<div class="nk-post-date">'.esc_html($published_date).'</div>';
                    }
                    $portfolio_list .= '</div>';
                    $portfolio_list .= '</div>';
                    $portfolio_list .= '</div>';
                endwhile;
                    wp_reset_postdata();
                    //Set Filter
                    if($filter && !empty($filter_values) && isset($filter_values) && is_array($filter_values)){
                        foreach($filter_values as $key=>$filter_value){
                            $filter_values[$key]=trim($filter_value);
                        }
                        $filter_values = array_unique($filter_values);
                        $result .= '<ul class="nk-isotope-filter">';
                        $result .= '<li class="active" data-filter="*">All</li>';
                        foreach($filter_values as $key=>$filter_value){
                            $result .= '<li data-filter="'.esc_attr(trim($filter_value)).'">'.esc_html(trim($filter_value)).'</li>';
                        }
                        $result .= '</ul>';
                    }
                    /**
                     * Work with printing posts
                     */
                    if($cross){
                        $result .= '<div class="container mnt-60">';
                    }
                    $result .= '<div class="'.khaki_sanitize_class($class).'">';
                    $result .= $portfolio_list;
                    $result .= '</div>';
                    $result .= '<div class="clearfix"></div>';
                    ob_start();
                    if ($pagination) {
                        khaki_posts_navigation();

                        if ($pagination == 'infinite' || $pagination == 'load_more') {
                            nk_infinite_scroll_init();
                        }
                    }
                    $result .= ob_get_contents();
                    ob_end_clean();
                    if($cross) {
                        $result .= '</div>';
                    }
                    echo wp_kses( $result, khaki_allowed_html() );
                else :
                    get_template_part('template-parts/content', 'none');
                endif;
            endif;
        endif;?>
            <div class="nk-gap-4"></div>
        </div>
        <?php get_sidebar(); ?>
    </div>
    </div>
<?php get_footer();
