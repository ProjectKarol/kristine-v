<?php

add_action("woocommerce_before_add_to_cart_button", "size_guide");

function size_guide()
{
	?>
<?php if (ICL_LANGUAGE_CODE == 'en'): ?>
<a href='#' class='popmake-size-guide'>
    <h6>Size Guide</h6>
</a>
<?php elseif (ICL_LANGUAGE_CODE == 'pl'): ?>
<a href='#' class='popmake-size-guide'>
    <h6>Tabela Rozmiarów</h6>
</a>
<?php endif; ?>
<?php
}
