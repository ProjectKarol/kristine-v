<?php
//template part for output post description
$format = get_post_format();
$preview_description_type = khaki_get_theme_mod('archive_preview_description_type_content', true);
$preview_description_trim_cnt = khaki_get_theme_mod('archive_preview_description_trim_cnt', true);
?>
<?php if ($preview_description_type != 'false' && $format!='quote'): ?>
    <div class="nk-post-text">
        <?php
        if ($preview_description_type == 'excerpt' && $preview_description_trim_cnt > 0) {
            khaki_excerpt_max_charlength($preview_description_trim_cnt);
        } elseif ($preview_description_type == 'more') {
            the_content();
        }
        ?>
    </div>
<?php endif; ?>