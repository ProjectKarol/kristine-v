<?php
//template part for output post category
$category = get_the_category(); ?>
<?php if ($category): ?>
    <div class="nk-post-category">
        <?php esc_html_e('In ', 'khaki'); ?>
        <?php foreach ($category as $key => $cat_item): ?>
            <a href="<?php echo get_category_link($cat_item->cat_ID); ?>"><?php echo esc_html( $cat_item->name ); ?></a>
            <?php if ($key != count($category) - 1) echo ', '; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>