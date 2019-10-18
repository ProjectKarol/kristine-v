<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
$pagination = khaki_get_theme_mod('woocommerce_pagination');
$class = 'row no-gutters';
if (isset($pagination) && $pagination === 'infinite') {
    $class .= ' nk-infinite-scroll-container';
}
if (isset($pagination) && $pagination === 'load_more') {
    $class .= ' nk-load-more-container';
}
?>
<div class="clearfix"></div>
<div class="<?php echo khaki_sanitize_class($class);?>">
