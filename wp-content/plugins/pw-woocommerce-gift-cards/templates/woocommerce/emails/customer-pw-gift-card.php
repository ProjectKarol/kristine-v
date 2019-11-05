<?php

/*
Copyright (C) 2016-2017 Pimwick, LLC

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

do_action( 'woocommerce_email_header', $email_heading, $email );

?>

<style type="text/css">
    @font-face {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 400;
        src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v15/CrYjSnGjrRCn0pd9VQsnFOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
    }

    @font-face {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 700;
        src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v15/d-6IYplOFocCacKzxwXSOLO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
    }

    .pwgc-section {
        font-family: 'Roboto', Helvetica, Arial, sans-serif;
        color: #333333;
        margin: 24px 0;
    }

    .pwgc-header {
        font-size: 150%;
        line-height: 1.4;
        text-align: center;
    }

    .pwgc-message {
        margin-top: 0px;
    }

    .pwgc-label {
        font-size: 80%;
        color: #666666;
        line-height: 1.4;
    }

    .pwgc-gift-card-container {
        border-style: solid;
        border-width: 1px;
        border-color: #333;
        border-radius: 16px;
        background-color: #FFFEE0;
        padding: 0px 24px;
    }

    .pwgc-amount {
        font-size: 250%;
        line-height: 1.0;
    }

    .pwgc-card-number {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 600;
        font-size: 125%;
        line-height: 1.0;
    }

    .pwgc-redeem-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 6px;
    }
</style>
<?php
    if ( !empty( $item_data->message ) ) {
        ?>
        <div class="pwgc-section pwgc-message">
            <?php echo nl2br( $item_data->message ); ?>
        </div>
        <?php
    }
?>
<div class="pwgc-gift-card-container">
    <div class="pwgc-section pwgc-header">
        <?php printf( __( '%s Gift Card', 'pw-woocommerce-gift-cards' ), get_option( 'blogname' ) ); ?>
    </div>

    <div class="pwgc-section">
        <div class="pwgc-label"><?php _e( 'Amount', 'pw-woocommerce-gift-cards' ); ?></div>
        <div class="pwgc-amount"><?php echo wc_price( $item_data->amount ); ?></div>
    </div>

    <div class="pwgc-section">
        <div class="pwgc-label"><?php _e( 'Gift Card Number', 'pw-woocommerce-gift-cards' ); ?></div>
        <div class="pwgc-card-number"><?php echo $item_data->gift_card_number; ?></div>
    </div>

    <div class="pwgc-section">
        <a href="<?php echo $item_data->redeem_url; ?>" class="pwgc-redeem-button"><?php _e( 'Redeem', 'pw-woocommerce-gift-cards' ); ?></a>
    </div>
</div>

<?php do_action( 'woocommerce_email_footer' ); ?>
