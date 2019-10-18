<?php
// Add Shortcode
function menu_function()
{
	ob_start(); ?>

<div class="menu-shortcode">
    <?php if (ICL_LANGUAGE_CODE == 'en'): ?>
    <div class="credit-footer">
        <div class="credit-item-element">Copyright © 2019 Kristine-V. All Rights Reserved.</div>
        <div class="credit-item-element"><a href="/privacy-policy/">Privacy</a> | <a href="/privacy-tools/">Privacy
                Tools</a> | <a href="/terms-of-service/">Terms and Conditions</a></div>
        <div class="credit-item-element paytments-credit">Payments are secure and encrypted <img id="payment_logos"
                src="https://www.kristine-v.com/wp-content/uploads/2019/07/set_credit_card-horizontal-transparent.png"
                alt="" width="150" height="auto" /></div>
    </div>
    <?php elseif (ICL_LANGUAGE_CODE == 'pl'): ?>
    <div class="credit-footer">
        <div class="credit-item-element">Copyright © 2019 Kristine-V. All Rights Reserved.</div>
        <div class="credit-item-element"><a href="/pl/polityka-prywatnosci/">Polityka Prywatności</a> | <a
                href="/pl/narzedzia-ochrony-prywatnosci/">Narzedzia prywatności</a> | <a
                href="/pl/regulamin/">Regulamin</a></div>
        <div class="credit-item-element paytments-credit">Płatności są szyfrowane <img id="payment_logos"
                src="https://www.kristine-v.com/wp-content/uploads/2019/07/set_credit_card-horizontal-transparent.png"
                alt="" width="150" height="auto" /></div>
    </div>
    <?php elseif (ICL_LANGUAGE_CODE == 'ru'): ?>
    <div class="credit-footer">
        <div class="credit-item-element">Copyright © 2019 Kristine-V. Все права защищены.</div>
        <div class="credit-item-element"><a href="/ru/политика-конфиденциальности/">Конфиденциальность</a> | <a
                href="ru/инструменты-конфиденциальности/">Инструменты конфиденциальности</a> | <a
                href="/ru/условия-обслуживания/">Срок и условие</a></div>
        <div class="credit-item-element paytments-credit">Платежи безопасны и зашифрованы <img id="payment_logos"
                src="https://www.kristine-v.com/wp-content/uploads/2019/07/set_credit_card-horizontal-transparent.png"
                alt="" width="150" height="auto" /></div>
    </div>
    <?php endif; ?>
</div>


<?php return ob_get_clean();
}
add_shortcode('menu-shortcode', 'menu_function');

add_filter('body_class', 'wpml_body_class');
function wpml_body_class($classes)
{
	$classes[] = ICL_LANGUAGE_CODE;
	return $classes;
}
