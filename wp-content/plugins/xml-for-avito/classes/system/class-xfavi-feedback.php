<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Sends feedback about the plugin
 *
 * @link			https://icopydoc.ru/
 * @since		1.5.0
 */

final class XFAVI_Feedback {
	private $pref = 'xfavi';

	public function __construct( $pref = null ) {
		if ( $pref ) {
			$this->pref = $pref;
		}

		$this->listen_submits_func();
	}

	public function get_form() { ?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Отправить данные о работе плагина', 'xml-for-avito' ); ?>
			</h2>
			<div class="inside">
				<p>
					<?php _e( 'Пожалуйста, помогите сделать плагин лучше', 'xml-for-avito' ); ?>!
					<?php _e( 'Следующие данные будут переданы', 'xml-for-avito' ); ?>:
				</p>
				<ul class="xfavi_ul">
					<li>
						<?php _e( 'URL ваших фидов', 'xml-for-avito' ); ?>
					</li>
					<li>
						<?php _e( 'Статус генерации файлов', 'xml-for-avito' ); ?>
					</li>
					<li>
						<?php _e( 'Информация о версии PHP', 'xml-for-avito' ); ?>
					</li>
					<li>
						<?php _e( 'Включен ли режим multisite', 'xml-for-avito' ); ?>
					</li>
					<li>
						<?php _e( 'Техническая информация и логи плагина', 'xml-for-avito' ); ?> XML for Avito
					</li>
				</ul>
				<p>
					<?php _e( 'Помог ли Вам плагин загрузить продукцию на', 'xml-for-avito' ); ?> Avito?
				</p>
				<form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" enctype="multipart/form-data">
					<p>
						<input type="radio" name="<?php echo $this->get_radio_name(); ?>" value="yes"><?php _e( 'Да', 'xml-for-avito' ); ?><br />
						<input type="radio" name="<?php echo $this->get_radio_name(); ?>" value="no"><?php _e( 'Нет', 'xml-for-avito' ); ?><br />
					</p>
					<p>
						<?php _e( 'Если вы не возражаете, чтобы с Вами связались в случае возникновения дополнительных вопросов по поводу работы плагина, то укажите Ваш адрес электронной почты', 'xml-for-avito' ); ?>.
					</p>
					<p><input type="email" name="<?php echo $this->get_input_name(); ?>"></p>
					<p>
						<?php _e( 'Ваше сообщение', 'xml-for-avito' ); ?>:
					</p>
					<p><textarea rows="6" cols="32" name="<?php echo $this->get_textarea_name(); ?>"
							placeholder="<?php _e( 'Введите текст, чтобы отправить мне сообщение (Вы можете написать мне на русском или английском языке). Я проверяю свою электронную почту несколько раз в день', 'xml-for-avito' ); ?>"></textarea>
					</p>
					<?php wp_nonce_field( $this->get_nonce_action(), $this->get_nonce_field() ); ?>
					<input class="button-primary" type="submit" name="<?php echo $this->get_submit_name(); ?>"
						value="<?php _e( 'Отправить данные', 'xml-for-avito' ); ?>" />
				</form>
			</div>
		</div>
		<?php
	}

	public function get_block_support_project() { ?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Пожалуйста, поддержите проект', 'xml-for-avito' ); ?>!
			</h2>
			<div class="inside">
				<p>
					<?php _e( 'Спасибо за использование плагина', 'xml-for-avito' ); ?> <strong>XML for Avito</strong>
				</p>
				<p>
					<?php _e( 'Пожалуйста, помогите сделать плагин лучше', 'xml-for-avito' ); ?> <a
						href="https://forms.gle/rtdDcK94C9tuqdbw5" target="_blank">
						<?php _e( 'ответив на 6 вопросов', 'xml-for-avito' ); ?>!
					</a>
				</p>
				<p>
					<?php _e( 'Если этот плагин полезен вам, пожалуйста, поддержите проект', 'xml-for-avito' ); ?>:
				</p>
				<ul class="xfavi_ul">
					<li><a href="https://wordpress.org/support/plugin/xml-for-avito/reviews/" target="_blank">
							<?php _e( 'Оставьте комментарий на странице плагина', 'xml-for-avito' ); ?>
						</a>.</li>
					<li>
						<?php _e( 'Поддержите проект деньгами', 'xml-for-avito' ); ?>. <a href="https://sobe.ru/na/xml_for_avito"
							target="_blank">
							<?php _e( 'Поддержать проект', 'xml-for-avito' ); ?>
						</a>.
					</li>
					<li>
						<?php _e( 'Заметили ошибку или есть идея как улучшить качество плагина', 'xml-for-avito' ); ?>? <a
							href="mailto:support@icopydoc.ru">
							<?php _e( 'Напишите мне', 'xml-for-avito' ); ?>
						</a>.
					</li>
				</ul>
				<p>
					<?php _e( 'С уважением, Максим Глазунов', 'xml-for-avito' ); ?>.
				</p>
				<p><span style="color: red;">
						<?php _e( 'Принимаю заказы на индивидуальные доработки плагина', 'xml-for-avito' ); ?>
					</span>:<br /><a href="mailto:support@icopydoc.ru">
						<?php _e( 'Оставить заявку', 'xml-for-avito' ); ?>
					</a>.</p>
			</div>
		</div>
		<?php
	}

	private function get_pref() {
		return $this->pref;
	}

	private function get_radio_name() {
		return $this->get_pref() . '_its_ok';
	}

	private function get_input_name() {
		return $this->get_pref() . '_email';
	}

	private function get_textarea_name() {
		return $this->get_pref() . '_message';
	}

	private function get_submit_name() {
		return $this->get_pref() . '_submit_send_stat';
	}

	private function get_nonce_action() {
		return $this->get_pref() . '_nonce_action_send_stat';
	}

	private function get_nonce_field() {
		return $this->get_pref() . '_nonce_field_send_stat';
	}

	private function listen_submits_func() {
		if ( isset( $_REQUEST[ $this->get_submit_name()] ) ) {
			$this->send_data();
			add_action( 'admin_notices', function () {
				$class = 'notice notice-success is-dismissible';
				$message = __( 'Данные были отправлены. Спасибо', 'xml-for-avito' );
				printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
			}, 9999 );
		}
	}

	private function send_data() {
		if ( ! empty( $_POST ) && check_admin_referer( $this->get_nonce_action(), $this->get_nonce_field() ) ) {
			if ( is_multisite() ) {
				$xfavi_is_multisite = 'включен';
				$xfavi_keeplogs = get_blog_option( get_current_blog_id(), 'xfavi_keeplogs' );
			} else {
				$xfavi_is_multisite = 'отключен';
				$xfavi_keeplogs = get_option( 'xfavi_keeplogs' );
			}
			$feed_id = '1'; // (string)
			$unixtime = (string) current_time( 'Y-m-d H:i' );
			$mail_content = '<h1>Заявка (#' . $unixtime . ')</h1>';
			$mail_content .= "Версия плагина: " . XFAVI_PLUGIN_VERSION . "<br />";
			$mail_content .= "Версия WP: " . get_bloginfo( 'version' ) . "<br />";
			$woo_version = xfavi_get_woo_version_number();
			$mail_content .= "Версия WC: " . $woo_version . "<br />";
			$mail_content .= "Версия PHP: " . phpversion() . "<br />";
			$mail_content .= "Режим мультисайта: " . $xfavi_is_multisite . "<br />";
			$mail_content .= "Вести логи: " . $xfavi_keeplogs . "<br />";
			$upload_dir = wp_get_upload_dir();
			$mail_content .= 'Расположение логов: <a href="' . $upload_dir['baseurl'] . '/xfavi/plugins.log" target="_blank">' . $upload_dir['basedir'] . '/xfavi/xfavi.log</a><br />';
			$possible_problems_arr = XFAVI_Debug_Page::get_possible_problems_list();
			if ( $possible_problems_arr[1] > 0 ) {
				$possible_problems_arr[3] = str_replace( '<br/>', PHP_EOL, $possible_problems_arr[3] );
				$mail_content .= "Самодиагностика: " . PHP_EOL . $possible_problems_arr[3];
			} else {
				$mail_content .= "Самодиагностика: Функции самодиагностики не выявили потенциальных проблем" . "<br />";
			}
			if ( ! class_exists( 'XmlforAvitoPro' ) ) {
				$mail_content .= "Pro: не активна" . "<br />";
			} else {
				if ( ! defined( 'xfavip_VER' ) ) {
					define( 'xfavip_VER', 'н/д' );
				}
				$order_id = xfavi_optionGET( 'xfavip_order_id' );
				$order_email = xfavi_optionGET( 'xfavip_order_email' );
				$mail_content .= "Pro: активна (v " . xfavip_VER . " (#" . $order_id . " / " . $order_email . "))" . "<br />";
			}
			$yandex_zen_rss = xfavi_optionGET( 'yzen_yandex_zen_rss' );
			$mail_content .= "RSS for Yandex Zen: " . $yandex_zen_rss . "<br />";
			if ( isset( $_POST[ $this->get_radio_name()] ) ) {
				$mail_content .= PHP_EOL . "Помог ли плагин: " . sanitize_text_field( $_POST[ $this->get_radio_name()] );
			}
			if ( isset( $_POST[ $this->get_input_name()] ) ) {
				$mail_content .= '<br />Почта: <a href="mailto:' . sanitize_email( $_POST[ $this->get_input_name()] ) . '?subject=Ответ разработчика XML for Avito (#' . $unixtime . ')" target="_blank" rel="nofollow noreferer" title="' . sanitize_email( $_POST['xfavi_email'] ) . '">' . sanitize_email( $_POST['xfavi_email'] ) . '</a>';
			}
			if ( isset( $_POST[ $this->get_textarea_name()] ) ) {
				$mail_content .= "<br />Сообщение: " . sanitize_text_field( $_POST[ $this->get_textarea_name()] );
			}
			/*$argsp = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1 );
					 $products = new WP_Query($argsp);
					 $vsegotovarov = $products->found_posts;*/
			$xfavi_settings_arr = xfavi_optionGET( 'xfavi_settings_arr' );
			$xfavi_settings_arr_keys_arr = array_keys( $xfavi_settings_arr );
			for ( $i = 0; $i < count( $xfavi_settings_arr_keys_arr ); $i++ ) {
				$feed_id = $xfavi_settings_arr_keys_arr[ $i ];

				$status_sborki = (int) xfavi_optionGET( 'xfavi_status_sborki', $feed_id );
				$xfavi_file_url = urldecode( xfavi_optionGET( 'xfavi_file_url', $feed_id, 'set_arr' ) );
				$xfavi_file_file = urldecode( xfavi_optionGET( 'xfavi_file_file', $feed_id, 'set_arr' ) );
				$xfavi_whot_export = xfavi_optionGET( 'xfavi_whot_export', $feed_id, 'set_arr' );
				$xfavi_status_cron = xfavi_optionGET( 'xfavi_status_cron', $feed_id, 'set_arr' );
				$xfavi_ufup = xfavi_optionGET( 'xfavi_ufup', $feed_id, 'set_arr' );
				$xfavi_date_sborki = xfavi_optionGET( 'xfavi_date_sborki', $feed_id, 'set_arr' );
				$xfavi_main_product = xfavi_optionGET( 'xfavi_main_product', $feed_id, 'set_arr' );
				$xfavi_errors = xfavi_optionGET( 'xfavi_errors', $feed_id, 'set_arr' );

				$mail_content .= "<br /> ФИД №: " . $i . "<br />";
				$mail_content .= "status_sborki: " . $status_sborki . "<br />";
				$mail_content .= "УРЛ: " . get_site_url() . "<br />";
				$mail_content .= "УРЛ XML-фида: " . $xfavi_file_url . "<br />";
				$mail_content .= "Временный файл: " . $xfavi_file_file . "<br />";
				$mail_content .= "Что экспортировать: " . $xfavi_whot_export . "<br />";
				$mail_content .= "Автоматическое создание файла: " . $xfavi_status_cron . "<br />";
				$mail_content .= "Обновить фид при обновлении карточки товара: " . $xfavi_ufup . "<br />";
				$mail_content .= "Дата последней сборки XML: " . $xfavi_date_sborki . "<br />";
				$mail_content .= "Что продаёт: " . $xfavi_main_product . "<br />";
				$mail_content .= "Ошибки: " . $xfavi_errors . "<br />";
			}

			add_filter( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );
			wp_mail( 'support@icopydoc.ru', 'Отчёт XML for Avito', $mail_content );
			// Сбросим content-type, чтобы избежать возможного конфликта
			remove_filter( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );
		}
	}

	public static function set_html_content_type() {
		return 'text/html';
	}
}