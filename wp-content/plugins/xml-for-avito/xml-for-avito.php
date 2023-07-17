<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Plugin Name: XML for Avito
 * Plugin URI: https://icopydoc.ru/category/documentation/xml-for-avito/
 * Description: Подключите свой магазин к Avito чтобы увеличить продажи!
 * Version: 1.9.1
 * Requires at least: 4.5
 * Requires PHP: 5.6
 * Author: Maxim Glazunov
 * Author URI: https://icopydoc.ru
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: xml-for-avito
 * Domain Path: /languages
 * Tags: xml, avito, market, export, woocommerce
 * WC requires at least: 3.0.0
 * WC tested up to: 7.8.2
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * Copyright 2018-2023 (Author emails: djdiplomat@yandex.ru, support@icopydoc.ru)
 */

$nr = false;
// Check php version
if ( version_compare( phpversion(), '5.6.0', '<' ) ) { // не совпали версии
	add_action( 'admin_notices', function () {
		warning_notice( 'notice notice-error',
			sprintf(
				'<strong style="font-weight: 700;">%1$s</strong> %2$s 5.6.0 %3$s %4$s',
				'XML for Avito',
				__( 'для плагина требуется версия php не менее', 'xml-for-avito' ),
				__( 'У вас установлена версия', 'xml-for-avito' ),
				phpversion()
			)
		);
	} );
	$nr = true;
}

// Check if WooCommerce is active
$plugin = 'woocommerce/woocommerce.php';
if ( ! in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', [] ) ) )
	&& ! ( is_multisite()
		&& array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', [] ) ) )
) {
	add_action( 'admin_notices', function () {
		warning_notice(
			'notice notice-error',
			sprintf(
				'<strong style="font-weight: 700;">XML for Avito</strong> %1$s',
				__( 'требуется, чтобы WooCommerce был установлен и активирован', 'xml-for-avito' )
			)
		);
	} );
	$nr = true;
}

if ( ! function_exists( 'warning_notice' ) ) {
	/**
	 * Display a notice in the admin Plugins page. Usually used in a @hook 'admin_notices'
	 * 
	 * @since	1.7.2
	 * 
	 * @param	string			$class (not require)
	 * @param	string 			$message (not require)
	 * 
	 * @return	string|void
	 */
	function warning_notice( $class = 'notice', $message = '' ) {
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}
}

// Define constants
define( 'XFAVI_PLUGIN_VERSION', '1.9.1' );

$upload_dir = wp_get_upload_dir();
// http://site.ru/wp-content/uploads
define( 'XFAVI_SITE_UPLOADS_URL', $upload_dir['baseurl'] );

// /home/site.ru/public_html/wp-content/uploads
define( 'XFAVI_SITE_UPLOADS_DIR_PATH', $upload_dir['basedir'] );

// http://site.ru/wp-content/uploads/xml-for-avito
define( 'XFAVI_PLUGIN_UPLOADS_DIR_URL', $upload_dir['baseurl'] . '/xml-for-avito' );

// /home/site.ru/public_html/wp-content/uploads/xml-for-avito
define( 'XFAVI_PLUGIN_UPLOADS_DIR_PATH', $upload_dir['basedir'] . '/xml-for-avito' );
unset( $upload_dir );

// http://site.ru/wp-content/plugins/xml-for-avito/
define( 'XFAVI_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

// /home/p135/www/site.ru/wp-content/plugins/xml-for-avito/
define( 'XFAVI_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

// /home/p135/www/site.ru/wp-content/plugins/xml-for-avito/xml-for-avito.php
define( 'XFAVI_PLUGIN_MAIN_FILE_PATH', __FILE__ );

// xml-for-avito - псевдоним плагина
define( 'XFAVI_PLUGIN_SLUG', wp_basename( dirname( __FILE__ ) ) );

// xml-for-avito/xml-for-avito.php - полный псевдоним плагина (папка плагина + имя главного файла)
define( 'XFAVI_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// $nr = apply_filters('xfavi_f_nr', $nr);

// load translation
add_action( 'plugins_loaded', function () {
	load_plugin_textdomain( 'xml-for-avito', false, dirname( XFAVI_PLUGIN_BASENAME ) . '/languages/' );
} );

if ( false === $nr ) {
	unset( $nr );
	require_once XFAVI_PLUGIN_DIR_PATH . '/packages.php';
	register_activation_hook( __FILE__, [ 'XmlforAvito', 'on_activation' ] );
	register_deactivation_hook( __FILE__, [ 'XmlforAvito', 'on_deactivation' ] );
	add_action( 'plugins_loaded', [ 'XmlforAvito', 'init' ], 10 ); // активируем плагин
	define( 'XFAVI_ACTIVE', true );
}