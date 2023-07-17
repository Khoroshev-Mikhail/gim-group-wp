<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( false === new XFAVI_Сheck()) {
	return;
}
class XFAVI_Сheck {
	private $deactivation = false;
	private $php = '5.6.0';

	public function __construct() {
		$this->php_check();
		$this->plugins_dependence_check();
	}

	public function php_check() {
		if ( version_compare( phpversion(), $this->min_v_php, '<' ) ) { // не совпали версии
			add_action( 'admin_notices', function () {
				$this->warning_notice( 'notice notice-error',
					'<strong style="font-weight: 700;">XML for Avito</strong> ' . __( 'для плагина требуется версия php не менее', 'xml-for-avito' ) . ' ' . $this->min_v_php . ' ' . __( 'У вас установлена версия', 'xml-for-avito' ) . ' ' . phpversion()
				);
			} );
		}
	}

	public function plugins_dependence_check() {
		$plugin = 'woocommerce/woocommerce.php';
		if ( ! in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) ) ) && ! ( is_multisite() && array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', array() ) ) ) ) {
			add_action( 'admin_notices', 'xfavi_warning_notice' );
			return;
		}
	}

	public function warning_notice( $class = 'notice', $message = '' ) {
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}

	public function set_deactivation( $val = true ) {
		$this->deactivation = $val;
	}

	public function get_deactivation() {
		return $this->skip;
	}
}