=== PW WooCommerce Gift Cards ===
Contributors: pimwick
Donate link: https://paypal.me/pimwick
Tags: woocommerce, gift cards, gift certificates, pimwick
Requires at least: 4.5
Tested up to: 5.2.3
Requires PHP: 5.6
Stable tag: 1.85
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sell gift cards to your WooCommerce store, in just a few minutes!

== Description ==

**Your WooCommerce store should offer gift cards!**

Gift Cards are convenient and increase sales organically. the WooCommerce Gift Cards plugin makes it easy to sell gift cards to your store. So easy to get started, you can be selling gift cards for your WooCommerce store in 5 minutes!

**Purchasing** Similar to Amazon.com gift cards, the customer can specify the amount, recipient, and message when purchasing.

**Receiving** WooCommerce email template system for beautiful emails. Click the link directly in the email to add the gift card to the cart automatically!

**Redeeming** Integrates into your theme to make redeeming a gift card easy for the customer. Applies the balance after tax, just like cash. New balance shown on the cart and checkout pages.

**Compatible with WooCommerce Pre-Orders** If you use the WooCommerce Pre-Orders plugin from WooCommerce.com.

**Setup is easy!** One-click creation of the Gift Card product. Easily customized to suit your needs.

**Gift Card Admin** See your gift card liability at a glance. View details about individual cards.


> **<a href="https://www.pimwick.com/gift-cards/">PW WooCommerce Gift Cards Pro</a> lets you do more:**
>
> * **Set Custom Amounts** - Allow customers to specify the amount. You can set a minimum and a maximum amount.
> * **Schedule delivery** - Optionally allow customers to schedule when a gift card will be delivered.
> * **Specify a Default Amount** - Choose an amount that will be pre-selected when purchasing a gift card.
> * **Customer-facing Balance Page** - A shortcode to let customers check their gift card balances.
> * **Adding funds to existing gift card** - Customers can add funds to existing gift cards from the Check Balance page.
> * **Expiration Dates** - Automatically set an expiration date based on the purchase date.
> * **Balance Adjustments** - Perform balance adjustments in the admin area.
> * **Sell Physical Gift Cards** - Import existing gift card numbers and balances.
> * **Manually Generate Gift Cards** - Specify the amount and quantity for the cards to create multiple cards in one step.

Compatible with WooCommerce 3.0 and higher.

Available in the following languages:
* Danish
* Dutch
* English
* French
* German
* Italian
* Portuguese
* Russian
* Spanish
* Swedish

The following currency switcher plugins are supported:
* Aelia Currency Switcher
* WooCommerce Currency Switcher by realmag777
* WPML WooCommerce Multi-currency by OnTheGoSystems
* Multi Currency for WooCommerce by VillaTheme
* WooCommerce Ultimate Multi Currency Suite by Dev49.net (requires a patch, contact us for details)
* Polylang + Hyyan WooCommerce Polylang Integration

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/pw-gift-cards` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to Pimwick Plugins -> PW Gift Cards

== Screenshots ==

1. **Purchasing** Similar to Amazon.com gift cards, the customer can specify the amount, recipient, and message when purchasing.
2. **Receiving** WooCommerce email template system for beautiful emails. Click the link directly in the email to add the gift card to the cart automatically!
3. **Redeeming** Integrates into your theme to make redeeming a gift card easy for the customer. Applies the balance after tax, just like cash. New balance shown on the cart and checkout pages.
4. **Setup is easy!** One-click creation of the Gift Card product. Easily customized to suit your needs.
5. **Gift Card Admin** See your gift card liability at a glance. View details about individual cards.

== Changelog ==

= 1.85 =
* Compatibility fix for the "Variation Swatches for WooCommerce" plugin by Emran Ahmed.

= 1.84 =
* Calculate the balance in the admin search query rather than on each record when displaying.

= 1.83 =
* Improved performance of the admin search. Ensured compatibility with the upcoming WooCommerce 3.8.0 release.

= 1.82 =
* Fixed an issue that may make the PW Gift Cards Email not available on some systems.

= 1.81 =
* Added the option to use the WooCommerce Transactional Email system for gift card emails.

= 1.80 =
* Display the redeemed gift card number in the order email. Disabled the WooCommerce Transactional Email system for gift card emails.

= 1.79 =
* Improved integration with our BOGO plugin. You can now offer eGift cards as a free gift to purchasing customers if you have our PW WooCommerce BOGO plugin installed.

= 1.78 =
* Tested for compatibility with the latest versions of WordPress and WooCommerce.

= 1.77 =
* Fixed small integration issue with the WooCommerce Currency Switcher by realmag777. Removed warning about missing $fees_total definition.

= 1.76 =
* Removed a potential PHP Warning from the wc_get_template function call.

= 1.75 =
* Improved German translation.

= 1.74 =
* Added Swedish translation. Improved German translation.

= 1.73 =
* Confirmed compatibility with WooCommerce v3.6.4 and WordPress v5.2.1

= 1.72
* Fixed calculation issue when fees are included.

= 1.71
* Improved compatibility with WordPress Multisite. Added config flag to share the database across sites: PWGC_MULTISITE_SHARED_DATABASE

= 1.70
* Changed the hook from woocommerce_thankyou to woocommerce_payment_complete to make this more compatible with payment processors that use the Thank You page even for failed orders. Added a new hook pw_gift_cards_amount_attribute_visible_on_product_page to optionally hide the Amount attributes on the product page.

= 1.69
* Updated hooks for status changes to make it more comptaible with WooCommerce POS.

= 1.68
* Added a new hook to allow altering the randomly generated card numbers to do things like add a prefix. Hook: pw_gift_cards_random_card_number.

= 1.67
* Disable AJAX add to cart for the Rigid and OceanWP themes.

= 1.66
* Deduct gift card balance in the woocommerce_pre_payment_complete hook when redeeming.

= 1.65
* Fixed issue where Order would not be marked as Complete when a gift card is purchased along with a Virtual Downloadable product.

= 1.64
* Allow translation of the Pimwick Plugins menu without causing any issues. Fixed issue with WPML when not using multicurrency.

= 1.63
* Check for WPML object to prevent a warning message on some systems.

= 1.62
* Fixed a display issue when Format Price is disabled.

= 1.61
* Fixed issue with order total when redeeming a gift card with WPML currency switcher.

= 1.60
* Allow the gift card code to be applied from the Coupon Code field, even when there is an Individual Use Only coupon applied.

= 1.59
* Added support for Multi Currency for WooCommerce by VillaTheme.

= 1.58
* Added support for WPML WooCommerce Multi-currency.

= 1.57
* Added support for WooCommerce Ultimate Multi Currency Suite by Dev49.net. Removed the misleading "Invalid Email Address" option from setup. Prevent invalid email addresses from being entered when purchasing a gift card.

= 1.56
* Added a new hook to change the Select Amount text on the catalog page: pwgc_select_amount_text

= 1.55
* Fixed compatibility issue with older versions of WooCommerce Memberships plugin.

= 1.54
* Added a notice when a gift card with a zero balance is added to the cart.

= 1.53
* Fixed issue where Checkout page would not reload when a Gift Card number was entered into the Coupon field.

= 1.52
* Added a new setting to apply a fix for themes that do not have the correct WooCommerce hooks.

= 1.51
* Fixed error when checking balance in the admin area.

= 1.50
* Improved support for opting out of discounts in WooCommerce Memberships v1.12.2 and later.

= 1.49
* Added Danish translation.

= 1.48
* Added support for Aelia Currency Switcher and WooCommerce Currency Switcher by realmag777.

= 1.47
* Added an Enabled/Disabled option to the PW Gift Card email. Removed some extraneous code from the payment-method-pw-gift-card template file.

= 1.46 =
* Added $email variable to the woocommerce_email_header hook to fix compatibility with other themes and plugins such as Kadence Themes.

= 1.45 =
* Changed ajaxurl to be relative so it will work if the front-end is not using https.

= 1.44 =
* Added {product_title} to the email template parser.

= 1.43 =
* Fix for PayPal payment whenever amount is less than zero and shipping is the only charge.

= 1.42 =
* Disable AJAX add-to-cart on certain incompatible themes.

= 1.41 =
* Changed the variation selector to be more compatible with other plugins.

= 1.40 =
* Added Portuguese Brazil translation files.

= 1.39 =
* Added Russian translation files.

= 1.38 =
* Added compatibility for WordPress Multi-Site.

= 1.37 =
* Confirmed compatibility with WooCommerce v3.5.0

= 1.36 =
* Updated the template for the redeem form so that CSS styles can be applied immediately.

= 1.35 =
* Prevent the gift card form from being loaded if woocommerce_before_add_to_cart_quantity is called multiple times.

= 1.34 =
* Ensure compatibility with plugins that only check for the Variable type using is_type() rather than the class.

= 1.33 =
* Fixed an issue where entering a gift card on the Cart page might take the customer back to the homepage if permalinks are set to Plain.

= 1.32 =
* Fixed an issue with calculation when using WooCommerce Services for automatic tax calculation.

= 1.31 =
* Show an Expired message on the cart and checkout pages for expired cards. Do not show deactivated cards unless searching for them. Updated translation files. Fix an issue that can prevent the gift card from being added to the cart.

= 1.30 =
* Added a product object to the email template so that product details can be added to the recipient email.

= 1.29 =
* Added support for the plugin WooCommerce Pre-Orders from WooCommerce.com

= 1.28 =
* Added support for variation radio buttons.

= 1.27 =
* Fixed issue with IT and ES translations and the {sender} field in the email templates.

= 1.26 =
* Updated for compatibility with WPML.

= 1.25 =
* Added a setting to not display the gift card redeem field on the Cart or Checkout pages. Fixed a possible conflict with other themes that results in the Apply button not working on the Cart page.

= 1.24 =
* Fixed issue with translationing Other Amount attribute.

= 1.23 =
* Fixed issue with custom translations.

= 1.22 =
* Added email address validation to the "To" field when purchasing a gift card.

= 1.21 =
* Fixed an issue preventing the translation of the To/From/Message fields. Added DE language translation. Fixed issue with non-logged in users redeeming gift cards automatically from the email link.

= 1.20 =
* Fixed an issue with recurring subscription total from the WooCommerce Subscriptions plugin.

= 1.19 =
* Fixed an issue with searching for gift cards in the admin area when there is a table collation mismatch.

= 1.18 =
* Fixed the "Add to Cart" text for some users.

= 1.17 =
* Added recipient to the available fields in the email template.

= 1.16 =
* Added French translations courtesy of Nicolas G.

= 1.15 =
* New options to specify the location of the Apply Gift Card box on the Cart and Checkout pages.

= 1.14 =
* New feature: Search by recipient email address.

= 1.13 =
* Added the ability to search for gift cards and view all cards.

= 1.12 =
* Fixed an issue where pw_gift_card_amount meta value was added to non-gift card order line items.

= 1.11 =
* Added a new option to disable using WooCommerce Transactional Email system.

= 1.10 =
* Fixed compatibility with automatic tax calculations provided by WooCommerce Services.

= 1.9 =
* Updated text domain to support translations.

= 1.7 =
* Added the ability to apply a gift card on the Checkout page. Fixed an issue with updating amounts.

= 1.6 =
* Include the pimwick Text Domain to make translations easier.

= 1.5 =
* Fixed issue with auto-creating the Gift Card product.

= 1.4 =
* Improved compatibility for older browsers such as IE11.

= 1.3 =
* Fixed issue when using older versions of PHP.

= 1.2 =
* Fixed issue with removing all default amounts and re-adding.

= 1.1 =
* Added PW Gift Cards under WooCommerce -> Settings -> Products. New option to disable the feature that auto-completes gift card only orders. Moved the (optional) flag to the title instead of the placeholder for the Message field.

= 1.0 =
* Initial version.

== Upgrade Notice ==

= 1.85 =
* Compatibility fix for the "Variation Swatches for WooCommerce" plugin by Emran Ahmed.

= 1.84 =
* Calculate the balance in the admin search query rather than on each record when displaying.

= 1.83 =
* Improved performance of the admin search. Ensured compatibility with the upcoming WooCommerce 3.8.0 release.

= 1.82 =
* Fixed an issue that may make the PW Gift Cards Email not available on some systems.

= 1.81 =
* Added the option to use the WooCommerce Transactional Email system for gift card emails.

= 1.80 =
* Display the redeemed gift card number in the order email. Disabled the WooCommerce Transactional Email system for gift card emails.

= 1.79 =
* Improved integration with our BOGO plugin. You can now offer eGift cards as a free gift to purchasing customers if you have our PW WooCommerce BOGO plugin installed.

= 1.78 =
* Tested for compatibility with the latest versions of WordPress and WooCommerce.

= 1.77 =
* Fixed small integration issue with the WooCommerce Currency Switcher by realmag777. Removed warning about missing $fees_total definition.

= 1.76 =
* Removed a potential PHP Warning from the wc_get_template function call.

= 1.75 =
* Improved German translation.

= 1.74 =
* Added Swedish translation. Improved German translation.

= 1.73 =
* Confirmed compatibility with WooCommerce v3.6.4 and WordPress v5.2.1

= 1.72
* Fixed calculation issue when fees are included.

= 1.71
* Improved compatibility with WordPress Multisite. Added config flag to share the database across sites: PWGC_MULTISITE_SHARED_DATABASE

= 1.70
* Changed the hook from woocommerce_thankyou to woocommerce_payment_complete to make this more compatible with payment processors that use the Thank You page even for failed orders. Added a new hook pw_gift_cards_amount_attribute_visible_on_product_page to optionally hide the Amount attributes on the product page.

= 1.69
* Updated hooks for status changes to make it more comptaible with WooCommerce POS.

= 1.68
* Added a new hook to allow altering the randomly generated card numbers to do things like add a prefix. Hook: pw_gift_cards_random_card_number.

= 1.67
* Disable AJAX add to cart for the Rigid and OceanWP themes.

= 1.66
* Deduct gift card balance in the woocommerce_pre_payment_complete hook when redeeming.

= 1.65
* Fixed issue where Order would not be marked as Complete when a gift card is purchased along with a Virtual Downloadable product.

= 1.64
* Allow translation of the Pimwick Plugins menu without causing any issues. Fixed issue with WPML when not using multicurrency.

= 1.63
* Check for WPML object to prevent a warning message on some systems.

= 1.62
* Fixed a display issue when Format Price is disabled.

= 1.61
* Fixed issue with order total when redeeming a gift card with WPML currency switcher.

= 1.60
* Allow the gift card code to be applied from the Coupon Code field, even when there is an Individual Use Only coupon applied.

= 1.59
* Added support for Multi Currency for WooCommerce by VillaTheme.

= 1.58
* Added support for WPML WooCommerce Multi-currency.

= 1.57
* Added support for WooCommerce Ultimate Multi Currency Suite by Dev49.net. Removed the misleading "Invalid Email Address" option from setup. Prevent invalid email addresses from being entered when purchasing a gift card.

= 1.56
* Added a new hook to change the Select Amount text on the catalog page: pwgc_select_amount_text

= 1.55
* Fixed compatibility issue with older versions of WooCommerce Memberships plugin.

= 1.54
* Added a notice when a gift card with a zero balance is added to the cart.

= 1.53
* Fixed issue where Checkout page would not reload when a Gift Card number was entered into the Coupon field.

= 1.52
* Added a new setting to apply a fix for themes that do not have the correct WooCommerce hooks.

= 1.51
* Fixed error when checking balance in the admin area.

= 1.50
* Improved support for opting out of discounts in WooCommerce Memberships v1.12.2 and later.

= 1.49
* Added Danish translation.

= 1.48
* Added support for Aelia Currency Switcher and WooCommerce Currency Switcher by realmag777.

= 1.47
* Added an Enabled/Disabled option to the PW Gift Card email. Removed some extraneous code from the payment-method-pw-gift-card template file.

= 1.46 =
* Added $email variable to the woocommerce_email_header hook to fix compatibility with other themes and plugins such as Kadence Themes.

= 1.45 =
* Changed ajaxurl to be relative so it will work if the front-end is not using https.

= 1.44 =
* Added {product_title} to the email template parser.

= 1.43 =
* Fix for PayPal payment whenever amount is less than zero and shipping is the only charge.

= 1.42 =
* Disable AJAX add-to-cart on certain incompatible themes.

= 1.41 =
* Changed the variation selector to be more compatible with other plugins.

= 1.40 =
* Added Portuguese Brazil translation files.

= 1.39 =
* Added Russian translation files.

= 1.38 =
* Added compatibility for WordPress Multi-Site.

= 1.37 =
* Confirmed compatibility with WooCommerce v3.5.0

= 1.36 =
* Updated the template for the redeem form so that CSS styles can be applied immediately.

= 1.35 =
* Prevent the gift card form from being loaded if woocommerce_before_add_to_cart_quantity is called multiple times.

= 1.34 =
* Ensure compatibility with plugins that only check for the Variable type using is_type() rather than the class.

= 1.33 =
* Fixed an issue where entering a gift card on the Cart page might take the customer back to the homepage if permalinks are set to Plain.

= 1.32 =
* Fixed an issue with calculation when using WooCommerce Services for automatic tax calculation.

= 1.31 =
* Show an Expired message on the cart and checkout pages for expired cards. Do not show deactivated cards unless searching for them. Updated translation files. Fix an issue that can prevent the gift card from being added to the cart.

= 1.30 =
* Added a product object to the email template so that product details can be added to the recipient email.

= 1.29 =
* Added support for the plugin WooCommerce Pre-Orders from WooCommerce.com

= 1.28 =
* Added support for variation radio buttons.

= 1.27 =
* Fixed issue with IT and ES translations and the {sender} field in the email templates.

= 1.26 =
* Updated for compatibility with WPML.

= 1.25 =
* Added a setting to not display the gift card redeem field on the Cart or Checkout pages. Fixed a possible conflict with other themes that results in the Apply button not working on the Cart page.

= 1.24 =
* Fixed issue with translationing Other Amount attribute.

= 1.23 =
* Fixed issue with custom translations.

= 1.22 =
* Added email address validation to the "To" field when purchasing a gift card.

= 1.21 =
* Fixed an issue preventing the translation of the To/From/Message fields. Added DE language translation. Fixed issue with non-logged in users redeeming gift cards automatically from the email link.

= 1.20 =
* Fixed an issue with recurring subscription total from the WooCommerce Subscriptions plugin.

= 1.19 =
* Fixed an issue with searching for gift cards in the admin area when there is a table collation mismatch.

= 1.18 =
* Fixed the "Add to Cart" text for some users.

= 1.17 =
* Added recipient to the available fields in the email template.

= 1.16 =
* Added French translations courtesy of Nicolas G.

= 1.15 =
* New options to specify the location of the Apply Gift Card box on the Cart and Checkout pages.

= 1.14 =
* New feature: Search by recipient email address.

= 1.13 =
* Added the ability to search for gift cards and view all cards.

= 1.12 =
* Fixed an issue where pw_gift_card_amount meta value was added to non-gift card order line items.

= 1.11 =
* Added a new option to disable using WooCommerce Transactional Email system.

= 1.10 =
* Fixed compatibility with automatic tax calculations provided by WooCommerce Services.

= 1.9 =
* Updated text domain to support translations.

= 1.7 =
* Added the ability to apply a gift card on the Checkout page. Fixed an issue with updating amounts.

= 1.6 =
* Include the pimwick Text Domain to make translations easier.

= 1.5 =
* Fixed issue with auto-creating the Gift Card product.

= 1.4 =
* Improved compatibility for older browsers such as IE11.

= 1.3 =
* Fixed issue when using older versions of PHP.

= 1.2 =
* Fixed issue with removing all default amounts and re-adding.

= 1.1 =
* Added PW Gift Cards under WooCommerce -> Settings -> Products. New option to disable the feature that auto-completes gift card only orders. Moved the (optional) flag to the title instead of the placeholder for the Message field.

= 1.0 =
* Initial version.
