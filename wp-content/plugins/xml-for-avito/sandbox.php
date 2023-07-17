<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Sandbox function
 * 
 * @since	0.1.0
 *
 * @return	void
 */
function xfavi_run_sandbox() {
	$x = false; // установите true, чтобы использовать песочницу
	if ( true === $x ) {
		printf( '%s<br/>',
			__( 'Песочница работает. Результат появится ниже', 'xml-for-avito' )
		);
		/* вставьте ваш код ниже */
		// Example:
		// $product = wc_get_product(8303);
		// echo $product->get_price();

		/* дальше не редактируем */
		printf( '<br/>%s',
			__( 'Песочница работает правильно', 'xml-for-avito' )
		);
	}
}