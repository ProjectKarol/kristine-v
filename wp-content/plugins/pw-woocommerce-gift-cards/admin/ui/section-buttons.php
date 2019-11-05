<?php

defined( 'ABSPATH' ) or exit;

?>
<div>
    <div style="display: inline-block;">
        <div id="pwgc-dashboard" class="pwgc-container">
            <div class="pwgc-dashboard-item pwgc-dashboard-item-selected" data-section="balances">
                <i class="fas fa-credit-card fa-3x"></i>
                <div class="pwgc-dashboard-item-title"><?php _e( 'Balances', 'pw-woocommerce-gift-cards' ); ?></div>
            </div>
            <div class="pwgc-dashboard-item" data-section="create">
                <i class="fas fa-plus-square fa-3x"></i>
                <div class="pwgc-dashboard-item-title"><?php _e( 'Create Gift Cards', 'pw-woocommerce-gift-cards' ); ?></div>
            </div>
            <div class="pwgc-dashboard-item" data-section="import">
                <i class="fas fa-cloud-upload-alt fa-3x"></i>
                <div class="pwgc-dashboard-item-title"><?php _e( 'Import Card Numbers', 'pw-woocommerce-gift-cards' ); ?></div>
            </div>
            <div class="pwgc-dashboard-item" data-section="settings">
                <i class="fas fa-cog fa-3x"></i>
                <div class="pwgc-dashboard-item-title"><?php _e( 'Settings', 'pw-woocommerce-gift-cards' ); ?></div>
            </div>
        </div>
    </div>
</div>
