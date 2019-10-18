<?php
/**
 * The theme searchform
 *
 * @package khaki
 */
?>
    <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="nk-form nk-form-style-1" novalidate="novalidate">
        <div class="input-group">
            <input type="text" class="form-control" name="s" placeholder="<?php esc_html_e('Type something...', 'khaki'); ?>">
            <button class="nk-btn nk-btn-color-dark-1"><span class="ion-ios-search"></span></button>
        </div>
    </form>
