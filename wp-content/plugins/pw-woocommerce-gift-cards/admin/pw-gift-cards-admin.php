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

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'PW_Gift_Cards_Admin' ) ) :

final class PW_Gift_Cards_Admin {

    public $settings;

    function __construct() {
        global $pw_gift_cards;

        $this->settings = array(
            array(
                'title' => __( 'PW Gift Cards', 'pw-woocommerce-gift-cards' ),
                'type'  => 'title',
                'desc'  => '',
                'id'    => 'pw_gift_cards_options',
            ),
            array(
                'title'   => __( 'Auto Complete Orders', 'pw-woocommerce-gift-cards' ),
                'desc'    => __( 'When an order only contains gift cards, automatically mark the order as Complete to send the gift cards immediately.', 'pw-woocommerce-gift-cards' ),
                'id'      => 'pwgc_autocomplete_gift_card_orders',
                'default' => 'yes',
                'type'    => 'checkbox',
            ),
            array(
                'title'   => __( 'Buy Gift Cards with Gift Cards', 'pw-woocommerce-gift-cards' ),
                'desc'    => __( 'Allow customers to purchase gift cards using another gift card. Disable this to prevent customers from extending the date on expiring gift cards. Default: Checked.', 'pw-woocommerce-gift-cards' ),
                'id'      => 'pwgc_allow_gift_card_purchasing',
                'default' => 'yes',
                'type'    => 'checkbox',
            ),
            array(
                'title'   => __( 'Use the WooCommerce Transactional Email System', 'pw-woocommerce-gift-cards' ),
                'desc'    => __( 'Enabled by default. If you are not receiving your gift card emails, try disabling this setting.', 'pw-woocommerce-gift-cards' ),
                'id'      => 'pwgc_use_wc_transactional_emails',
                'default' => 'yes',
                'type'    => 'checkbox',
            ),
            array(
                'title'   => __( 'Apply fix for missing fields', 'pw-woocommerce-gift-cards' ),
                'desc'    => __( 'If you do not see the To / From / Message fields on your gift card product page, try checking this box and reloading. Some themes have out of date WooCommerce template files and need to be patched to work with the Gift Card product.', 'pw-woocommerce-gift-cards' ),
                'id'      => 'pwgc_before_add_to_cart_quantity_theme_fix',
                'default' => 'no',
                'type'    => 'checkbox',
            ),
            array(
                'title'   => __( 'Format Prices', 'pw-woocommerce-gift-cards' ),
                'desc'    => __( 'For fixed gift card amounts, format the price with the system currency symbol. This is enabled by default. If you are having trouble with currency switchers, disable this setting. Note: You must remove and re-add your fixed gift card amounts if you change this setting.', 'pw-woocommerce-gift-cards' ),
                'id'      => 'pwgc_format_prices',
                'default' => 'yes',
                'type'    => 'checkbox',
            ),
            array(
                'title'    => __( 'Redeem Location - Cart', 'pw-woocommerce-gift-cards' ),
                'desc'     => __( 'Specifies where the "Apply Gift Card" box appears on the Cart page.', 'pw-woocommerce-gift-cards' ),
                'id'       => 'pwgc_redeem_cart_location',
                'default'  => 'proceed_to_checkout',
                'type'     => 'select',
                'class'    => 'wc-enhanced-select',
                'css'      => 'min-width: 350px;',
                'desc_tip' => false,
                'options'  => array(
                    'proceed_to_checkout' => __( 'Above the "Proceed to Checkout" button.', 'pw-woocommerce-gift-cards' ),
                    'after_cart_contents' => __( 'Below the "Apply Coupon" area.', 'pw-woocommerce-gift-cards' ),
                    'none' => __( 'Do not display gift card field.', 'pw-woocommerce-gift-cards' ),
                ),
            ),
            array(
                'title'    => __( 'Redeem Location - Checkout', 'pw-woocommerce-gift-cards' ),
                'desc'     => __( 'Specifies where the "Apply Gift Card" box appears on the Checkout page.', 'pw-woocommerce-gift-cards' ),
                'id'       => 'pwgc_redeem_checkout_location',
                'default'  => 'review_order_before_submit',
                'type'     => 'select',
                'class'    => 'wc-enhanced-select',
                'css'      => 'min-width: 350px;',
                'desc_tip' => false,
                'options'  => array(
                    'review_order_before_submit' => __( 'Below the "Payment Methods" area.', 'pw-woocommerce-gift-cards' ),
                    'before_checkout_form' => __( 'Below the "Apply Coupon" area.', 'pw-woocommerce-gift-cards' ),
                    'none' => __( 'Do not display gift card field.', 'pw-woocommerce-gift-cards' ),
                ),
            ),
            array(
                'type'  => 'sectionend',
                'id'    => 'pw_gift_cards_options',
            ),
        );

        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_filter( 'woocommerce_product_data_tabs', array( $this, 'woocommerce_product_data_tabs' ) );
        add_action( 'woocommerce_product_data_panels', array( $this, 'woocommerce_product_data_panels' ) );
        add_filter( 'woocommerce_product_filters', array( $this, 'woocommerce_product_filters' ) );
        add_action( 'woocommerce_process_product_meta_' . PWGC_PRODUCT_TYPE_SLUG, array( $this, 'process_pw_gift_card_product_meta_data' ) );
        add_action( 'woocommerce_admin_order_totals_after_tax', array( $this, 'woocommerce_admin_order_totals_after_tax' ) );
        add_filter( 'woocommerce_get_sections_products', array( $this, 'woocommerce_get_sections_products' ) );
        add_filter( 'woocommerce_get_settings_products', array( $this, 'woocommerce_get_settings_products' ), 10, 2 );

        add_action( 'wp_ajax_pw-gift-cards-add_gift_card_amount', array( $this, 'ajax_add_gift_card_amount' ) );
        add_action( 'wp_ajax_pw-gift-cards-remove_gift_card_amount', array( $this, 'ajax_remove_gift_card_amount' ) );
        add_action( 'wp_ajax_pw-gift-cards-search', array( $this, 'ajax_search' ) );
        add_action( 'wp_ajax_pw-gift-cards-balance_summary', array( $this, 'ajax_balance_summary' ) );
        add_action( 'wp_ajax_pw-gift-cards-view_activity', array( $this, 'ajax_view_activity' ) );
        add_action( 'wp_ajax_pw-gift-cards-save_settings', array( $this, 'ajax_save_settings' ) );
        add_action( 'wp_ajax_pw-gift-cards-create_product', array( $this, 'ajax_create_product' ) );
        add_action( 'wp_ajax_pw-gift-cards-delete', array( $this, 'ajax_delete' ) );
        add_action( 'wp_ajax_pw-gift-cards-restore', array( $this, 'ajax_restore' ) );
    }

    function admin_menu() {
        global $pw_gift_cards;

        if ( empty ( $GLOBALS['admin_page_hooks']['pimwick'] ) ) {
            add_menu_page(
                __( 'PW Gift Cards', 'pw-woocommerce-gift-cards' ),
                __( 'Pimwick Plugins', 'pw-woocommerce-gift-cards' ),
                PWGC_REQUIRES_PRIVILEGE,
                'pimwick',
                array( $this, 'index' ),
                $pw_gift_cards->relative_url( '/admin/assets/images/pimwick-icon-120x120.png' ),
                6
            );

            add_submenu_page(
                'pimwick',
                __( 'PW Gift Cards', 'pw-woocommerce-gift-cards' ),
                __( 'Pimwick Plugins', 'pw-woocommerce-gift-cards' ),
                PWGC_REQUIRES_PRIVILEGE,
                'pimwick',
                array( $this, 'index' )
            );

            remove_submenu_page( 'pimwick', 'pimwick' );
        }

        add_submenu_page(
            'pimwick',
            __( 'PW Gift Cards', 'pw-woocommerce-gift-cards' ),
            __( 'PW Gift Cards', 'pw-woocommerce-gift-cards' ),
            PWGC_REQUIRES_PRIVILEGE,
            'pw-gift-cards',
            array( $this, 'index' )
        );

        add_submenu_page(
            'woocommerce',
            __( 'PW Gift Cards', 'pw-woocommerce-gift-cards' ),
            __( 'PW Gift Cards', 'pw-woocommerce-gift-cards' ),
            'manage_woocommerce',
            'wc-pw-gift-cards',
            array( $this, 'index' )
        );
    }

    function index() {
        require( 'ui/index.php' );
    }

    function admin_enqueue_scripts( $hook ) {
        global $wp_scripts;
        global $pw_gift_cards;

        wp_register_style( 'pw-gift-cards-icon', $pw_gift_cards->relative_url( '/admin/assets/css/icon-style.css' ), array( 'admin-menu' ), PWGC_VERSION );
        wp_enqueue_style( 'pw-gift-cards-icon' );

        if ( !empty( $hook ) && substr( $hook, -strlen( 'pw-gift-cards' ) ) === 'pw-gift-cards' ) {
            wp_register_style( 'pw-gift-cards-admin', $pw_gift_cards->relative_url( '/admin/assets/css/pw-gift-cards-admin.css' ), array(), PWGC_VERSION );
            wp_enqueue_style( 'pw-gift-cards-admin' );

            wp_enqueue_script( 'pw-gift-cards-admin', $pw_gift_cards->relative_url( '/admin/assets/js/pw-gift-cards-admin.js' ), array( 'jquery' ), PWGC_VERSION );
            wp_localize_script( 'pw-gift-cards-admin', 'pwgc', array(
                'nonces' => array(
                    'balance_summary' => wp_create_nonce( 'pw-gift-cards-balance-summary' ),
                    'search' => wp_create_nonce( 'pw-gift-cards-search' ),
                    'view_activity' => wp_create_nonce( 'pw-gift-cards-view-activity' ),
                    'create_gift_card' => wp_create_nonce( 'pw-gift-cards-create-gift-card' ),
                    'save_settings' => wp_create_nonce( 'pw-gift-cards-save-settings' ),
                    'create_product' => wp_create_nonce( 'pw-gift-cards-create-product' ),
                    'delete' => wp_create_nonce( 'pw-gift-cards-delete' ),
                    'restore' => wp_create_nonce( 'pw-gift-cards-restore' ),
                )
            ) );

            wp_register_script( 'fontawesome-all', $pw_gift_cards->relative_url( '/assets/js/fontawesome-all.min.js' ), array(), PWGC_FONT_AWESOME_VERSION );
            wp_enqueue_script( 'fontawesome-all' );
        }

        if ( $screen = get_current_screen() ) {
            if ( $screen->id == 'product' ) {
                wp_register_style( 'pw-gift-cards-product-data-panels', $pw_gift_cards->relative_url( '/admin/assets/css/product-data-panels.css' ), array(), PWGC_VERSION );
                wp_enqueue_style( 'pw-gift-cards-product-data-panels' );

                wp_enqueue_script( 'pw-gift-cards-product-data-panels', $pw_gift_cards->relative_url( '/admin/assets/js/product-data-panels.js' ), array(), PWGC_VERSION );

                wp_localize_script( 'pw-gift-cards-product-data-panels', 'pwgc', array(
                    'i18n' => array(
                        'wait'                      => __( 'Wait', 'pw-woocommerce-gift-cards' ),
                        'add'                       => __( 'Add', 'pw-woocommerce-gift-cards' ),
                        'remove'                    => __( 'Remove', 'pw-woocommerce-gift-cards' ),
                        'error_greater_than_zero'   => __( 'Amount must be greater than zero.', 'pw-woocommerce-gift-cards' ),
                        'error_greater_than_min'    => __( 'Amount must be greater than minimum amount.', 'pw-woocommerce-gift-cards' ),
                        'error_less_than_max'       => __( 'Amount must be less than maximum amount.', 'pw-woocommerce-gift-cards' ),
                        'error'                     => __( 'Error', 'pw-woocommerce-gift-cards' ),
                    ),
                    'nonces' => array(
                        'add_gift_card_amount'      => wp_create_nonce( 'pw-gift-cards-add-gift-card-amount' ),
                        'remove_gift_card_amount'   => wp_create_nonce( 'pw-gift-cards-remove-gift-card-amount' ),
                        'view_activity'             => wp_create_nonce( 'pw-gift-cards-view-activity' ),
                    )
                ) );
            }
        }
    }

    function woocommerce_product_data_tabs( $tabs ) {

        $tabs['shipping']['class'][] = 'hide_if_' . PWGC_PRODUCT_TYPE_SLUG;
        $tabs['attribute']['class'][] = 'hide_if_' . PWGC_PRODUCT_TYPE_SLUG;

        $tabs[ PWGC_PRODUCT_TYPE_SLUG . '_cards' ] = array(
            'label'     => __( 'Gift Card', 'pw-woocommerce-gift-cards' ),
            'target'    => PWGC_PRODUCT_TYPE_SLUG . '_cards',
            'class'     => array( 'show_if_' . PWGC_PRODUCT_TYPE_SLUG ),
            'priority'  => 25
        );

        return $tabs;
    }

    function woocommerce_product_data_panels() {
        require( 'ui/product-data-panel-cards.php' );
    }

    function woocommerce_product_filters( $output ) {
        return str_replace( 'Pw-gift-card</option>', PWGC_PRODUCT_TYPE_NAME . '</option>', $output );
    }

    function process_pw_gift_card_product_meta_data( $post_id ) {
        global $pw_gift_cards;

        $product = new WC_Product_PW_Gift_Card( $post_id );

        $new_amount = wc_clean( $_POST['pwgc_new_amount'] );
        if ( !empty( $new_amount ) ) {
            $result = $product->add_amount( $new_amount );
            if ( !is_numeric( $result ) ) {
                wp_die( $result );
            }
        }

        $product->set_tax_status( PWGC_PURCHASE_TAX_STATUS );

        $product->save();
    }

    function woocommerce_admin_order_totals_after_tax( $order_id ) {
        $order = wc_get_order( $order_id );
        require( 'ui/order-gift-card-total.php' );
    }

    function woocommerce_get_sections_products( $sections ) {
        $sections['pw_gift_cards'] = __( 'PW Gift Cards', 'pw-woocommerce-gift-cards' );

        return $sections;
    }

    function woocommerce_get_settings_products( $settings, $current_section ) {
        if ( 'pw_gift_cards' === $current_section ) {
            $settings = $this->settings;
        }

        return $settings;
    }

    function ajax_add_gift_card_amount() {
        global $pw_gift_cards;

        check_ajax_referer( 'pw-gift-cards-add-gift-card-amount', 'security' );

        $pw_gift_cards->set_current_currency_to_default();

        if ( ! current_user_can( 'edit_products' ) ) {
            wp_die( -1 );
        }

        $product_id = absint( $_POST['product_id'] );
        $new_amount = wc_clean( $_POST['amount'] );

        if ( $product = new WC_Product_PW_Gift_Card( $product_id ) ) {
            $result = $product->add_amount( $new_amount );

            if ( is_numeric( $result ) ) {
                wp_send_json_success( array( 'amount' => $pw_gift_cards->pretty_price( $new_amount ), 'variation_id' => $result ) );
            } else {
                wp_send_json_error( array( 'message' => $result ) );
            }
        } else {
            wp_send_json_error( array( 'message' => sprintf( __( 'Could not locate product id %s', 'pw-woocommerce-gift-cards' ), $product_id ) ) );
        }
    }

    function ajax_remove_gift_card_amount() {
        check_ajax_referer( 'pw-gift-cards-remove-gift-card-amount', 'security' );

        if ( ! current_user_can( 'edit_products' ) ) {
            wp_die( -1 );
        }

        $product_id = absint( $_POST['product_id'] );
        $variation_id = absint( $_POST['variation_id'] );

        if ( $product = new WC_Product_PW_Gift_Card( $product_id ) ) {

            $result = $product->delete_amount( $variation_id );
            if ( $result === true ) {
                wp_send_json_success();
            } else {
                wp_send_json_error( array( 'message' => $result ) );
            }

        } else {
            wp_send_json_error( array( 'message' => __( 'Could not locate product using product_id ', 'pw-woocommerce-gift-cards' ) . $variation->get_parent_id() ) );
        }
    }

    function ajax_search() {
        global $wpdb;
        global $pw_gift_cards;

        check_ajax_referer( 'pw-gift-cards-search', 'security' );

        $gift_cards = array();
        $active_sql = '';
        if ( !empty( $_POST['search_terms'] ) ) {
            $search_terms = '%' . wc_clean( $_POST['search_terms'] ) . '%';
        } else {
            $search_terms = '%';
            $active_sql = 'AND gift_card.active = true';
        }

        if ( PWGC_UTF8_SEARCH ) {
            $sql = $wpdb->prepare( "
                SELECT
                    gift_card.*,
                    (SELECT SUM(amount) FROM {$wpdb->pimwick_gift_card_activity} AS a WHERE a.pimwick_gift_card_id = gift_card.pimwick_gift_card_id) AS balance
                FROM
                    `{$wpdb->pimwick_gift_card}` AS gift_card
                LEFT JOIN
                    `{$wpdb->prefix}woocommerce_order_itemmeta` AS order_itemmeta_number ON (order_itemmeta_number.meta_key = 'pw_gift_card_number' AND CONVERT(order_itemmeta_number.meta_value USING utf8) = CONVERT(gift_card.number USING utf8) )
                LEFT JOIN
                    `{$wpdb->prefix}woocommerce_order_itemmeta` AS order_itemmeta_to ON (order_itemmeta_to.meta_key = CONVERT('pw_gift_card_to' USING utf8) AND order_itemmeta_to.order_item_id = order_itemmeta_number.order_item_id)
                WHERE
                    (gift_card.number LIKE %s OR order_itemmeta_to.meta_value LIKE %s)
                    $active_sql
                ORDER BY
                    gift_card.create_date DESC,
                    gift_card.pimwick_gift_card_id DESC
            ", $search_terms, $search_terms );
        } else {
            $sql = $wpdb->prepare( "
                SELECT
                    gift_card.*,
                    (SELECT SUM(amount) FROM {$wpdb->pimwick_gift_card_activity} AS a WHERE a.pimwick_gift_card_id = gift_card.pimwick_gift_card_id) AS balance
                FROM
                    `{$wpdb->pimwick_gift_card}` AS gift_card
                LEFT JOIN
                    `{$wpdb->prefix}woocommerce_order_itemmeta` AS order_itemmeta_number ON (order_itemmeta_number.meta_key = 'pw_gift_card_number' AND order_itemmeta_number.meta_value = gift_card.number )
                LEFT JOIN
                    `{$wpdb->prefix}woocommerce_order_itemmeta` AS order_itemmeta_to ON (order_itemmeta_to.meta_key = 'pw_gift_card_to' AND order_itemmeta_to.order_item_id = order_itemmeta_number.order_item_id)
                WHERE
                    (gift_card.number LIKE %s OR order_itemmeta_to.meta_value LIKE %s)
                    $active_sql
                ORDER BY
                    gift_card.create_date DESC,
                    gift_card.pimwick_gift_card_id DESC
            ", $search_terms, $search_terms );
        }

        $results = $wpdb->get_results( $sql );
        if ( $results !== null ) {
            foreach ( $results as $row ) {
                $gift_cards[] = new PW_Gift_Card( $row );
            }
        }

        $pw_gift_cards->set_current_currency_to_default();

        ob_start();
        require( 'ui/sections/search-results.php' );
        $html = ob_get_clean();

        wp_send_json( array( 'html' => $html ) );
    }

    function ajax_balance_summary() {
        global $pw_gift_cards;

        check_ajax_referer( 'pw-gift-cards-balance-summary', 'security' );

        $pw_gift_cards->set_current_currency_to_default();

        require_once( 'ui/sections/balance-summary.php' );

        wp_die();
    }

    function ajax_view_activity() {
        global $pw_gift_cards;

        check_ajax_referer( 'pw-gift-cards-view-activity', 'security' );

        $pw_gift_cards->set_current_currency_to_default();

        $card_number = wc_clean( $_POST['card_number'] );

        $gift_card = new PW_Gift_Card( $card_number );
        if ( $gift_card->get_id() ) {
            ob_start();
            require( 'ui/sections/activity-records.php' );
            $html = ob_get_clean();

            wp_send_json( array( 'html' => $html ) );
        }

        wp_send_json( array( 'html' => '<div class="pwgc-balance-error">' . $gift_card->get_error_message() . '</div>' ) );
    }

    function ajax_save_settings() {
        check_ajax_referer( 'pw-gift-cards-save-settings', 'security' );

        $form = array();
        parse_str( $_REQUEST['form'], $form );

        WC_Admin_Settings::save_fields( $this->settings, $form );

        $html = '<span style="color: blue;">' . __( 'Settings saved.', 'pw-woocommerce-gift-cards' ) . '</span>';

        wp_send_json_success( array( 'html' => $html ) );
    }

    function ajax_create_product() {
        global $pw_gift_cards;

        check_ajax_referer( 'pw-gift-cards-create-product', 'security' );

        $pw_gift_cards->set_current_currency_to_default();

        $gift_card_product = $pw_gift_cards->get_gift_card_product();
        if ( empty( $gift_card_product ) ) {
            $gift_card_product = new WC_Product_PW_Gift_Card();
            $gift_card_product->set_props( array(
                'name'                      => __( 'Gift Card', 'pw-woocommerce-gift-cards' ),
                'tax_status'                => PWGC_PURCHASE_TAX_STATUS,
            ) );
            $gift_card_product->save();

            $gift_card_product->add_amount( '10' );
            $gift_card_product->add_amount( '25' );
            $gift_card_product->add_amount( '50' );
            $gift_card_product->add_amount( '100' );

            $this->attach_default_image( $gift_card_product->get_id() );
        }

        wp_send_json_success();
    }

    function attach_default_image( $product_id ) {

        // Get the uploads directory, we'll need it in a bit.
        $wp_upload_dir = wp_upload_dir();

        // Copy our generic gift card image from the plugin directory to the uploads directory.
        $source_file = trailingslashit( PWGC_PLUGIN_ROOT ) . 'assets/images/pw-gift-card.png';
        $upload_file = trailingslashit( $wp_upload_dir['path'] ) . basename( 'pw-gift-card.png' );

        if ( !file_exists( $upload_file ) ) {
            copy( $source_file, $upload_file );
        }

        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype( basename( $upload_file ), null );

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $wp_upload_dir['url'] . '/' . basename( $upload_file ),
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload_file ) ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Insert the attachment.
        $attach_id = wp_insert_attachment( $attachment, $upload_file, $product_id );

        // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Generate the metadata for the attachment, and update the database record.
        $attach_data = wp_generate_attachment_metadata( $attach_id, $upload_file );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        set_post_thumbnail( $product_id, $attach_id );
    }

    function ajax_delete() {
        $number = wc_clean( $_POST['card_number'] );

        check_ajax_referer( 'pw-gift-cards-delete', 'security' );

        $gift_card = new PW_Gift_Card( $number );
        if ( $gift_card->get_id() ) {
            $gift_card->deactivate();
            wp_send_json_success();
        } else {
            wp_send_json_error( array( 'message' => _e( 'Gift card not found.', 'pw-woocommerce-gift-cards' ) ) );
        }
    }

    function ajax_restore() {
        $number = wc_clean( $_POST['card_number'] );

        check_ajax_referer( 'pw-gift-cards-restore', 'security' );

        $gift_card = new PW_Gift_Card( $number );
        if ( $gift_card->get_id() ) {
            $gift_card->reactivate();
            wp_send_json_success();
        } else {
            wp_send_json_error( array( 'message' => _e( 'Gift card not found.', 'pw-woocommerce-gift-cards' ) ) );
        }
    }
}

global $pw_gift_cards_admin;
$pw_gift_cards_admin = new PW_Gift_Cards_Admin();

endif;
