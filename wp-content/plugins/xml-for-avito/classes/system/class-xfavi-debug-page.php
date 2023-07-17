<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Plugin Debug Page
 *
 * @link			https://icopydoc.ru/
 * @since		3.7.0
 */

class XFAVI_Debug_Page {
	private $pref = 'xfavi';
	private $feedback;

	public function __construct( $pref = null ) {
		if ( $pref ) {
			$this->pref = $pref;
		}
		$this->feedback = new XFAVI_Feedback();

		$this->listen_submit();
		$this->get_html_form();
	}

	public function get_html_form() { ?>
		<div class="wrap">
			<h1>
				<?php _e( 'Страница отладки', $this->get_pref() ); ?> v.
				<?php echo xfavi_optionGET( 'xfavi_version' ); ?>
			</h1>
			<?php do_action( 'my_admin_notices' ); ?>
			<div id="dashboard-widgets-wrap">
				<div id="dashboard-widgets" class="metabox-holder">
					<div id="postbox-container-1" class="postbox-container">
						<div class="meta-box-sortables">
							<?php $this->get_html_block_logs(); ?>
						</div>
					</div>
					<div id="postbox-container-2" class="postbox-container">
						<div class="meta-box-sortables">
							<?php $this->get_html_block_simulation(); ?>
						</div>
					</div>
					<div id="postbox-container-3" class="postbox-container">
						<div class="meta-box-sortables">
							<?php $this->get_html_block_possible_problems(); ?>
							<?php $this->get_html_block_sandbox(); ?>
						</div>
					</div>
					<div id="postbox-container-4" class="postbox-container">
						<div class="meta-box-sortables">
							<?php do_action( 'xfavi_before_support_project' ); ?>
							<?php $this->feedback->get_form(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php // end get_html_form();
	}

	public function get_html_block_logs() {
		$xfavi_keeplogs = xfavi_optionGET( $this->get_input_name_keeplogs() );
		$xfavi_disable_notices = xfavi_optionGET( $this->get_input_name_disable_notices() );
		?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Логи', $this->get_pref() ); ?>
			</h2>
			<div class="inside">
				<p>
					<?php if ( $xfavi_keeplogs === 'on' ) {
						$upload_dir = wp_get_upload_dir();
						echo '<strong>' . __( "Логи тут", $this->get_pref() ) . ':</strong><br /><a href="' . $upload_dir['baseurl'] . '/xml-for-avito/xml-for-avito.log" target="_blank">' . $upload_dir['basedir'] . '/xml-for-avito/xml-for-avito.log</a>';
					} ?>
				</p>
				<form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row"><label for="<?php echo $this->get_input_name_keeplogs(); ?>"><?php _e( 'Вести логи', $this->get_pref() ); ?></label><br />
									<input class="button" id="<?php echo $this->get_submit_name_clear_logs(); ?>" type="submit"
										name="<?php echo $this->get_submit_name_clear_logs(); ?>"
										value="<?php _e( 'Очистить логи', $this->get_pref() ); ?>" />
								</th>
								<td class="overalldesc">
									<input type="checkbox" name="<?php echo $this->get_input_name_keeplogs(); ?>"
										id="<?php echo $this->get_input_name_keeplogs(); ?>" <?php checked( $xfavi_keeplogs, 'on' ); ?> /><br />
									<span class="description">
										<?php _e( 'Не устанавливайте этот флажок, если вы не разработчик', $this->get_pref() ); ?>!
									</span>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="<?php echo $this->get_input_name_disable_notices(); ?>"><?php _e( 'Отключить уведомления', $this->get_pref() ); ?></label></th>
								<td class="overalldesc">
									<input type="checkbox" name="<?php echo $this->get_input_name_disable_notices(); ?>"
										id="<?php echo $this->get_input_name_disable_notices(); ?>" <?php checked( $xfavi_disable_notices, 'on' ); ?> /><br />
									<span class="description">
										<?php _e( 'Отключить уведомления о XML-сборке', $this->get_pref() ); ?>!
									</span>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="button-primary"></label></th>
								<td class="overalldesc"></td>
							</tr>
							<tr>
								<th scope="row"><label for="button-primary"></label></th>
								<td class="overalldesc">
									<?php wp_nonce_field( $this->get_nonce_action_debug_page(), $this->get_nonce_field_debug_page() ); ?><input
										id="button-primary" class="button-primary" type="submit"
										name="<?php echo $this->get_submit_name(); ?>"
										value="<?php _e( 'Сохранить', $this->get_pref() ); ?>" /><br />
									<span class="description">
										<?php _e( 'Нажмите, чтобы сохранить настройки', $this->get_pref() ); ?>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<?php
	} // end get_html_block_logs();

	public function get_html_block_simulation() { ?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Симуляция запроса', $this->get_pref() ); ?>
			</h2>
			<div class="inside">
				<form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" enctype="multipart/form-data">
					<?php $resust_simulated = '';
					$resust_report = '';
					if ( isset( $_POST['xfavi_feed_id'] ) ) {
						$xfavi_feed_id = sanitize_text_field( $_POST['xfavi_feed_id'] );
					} else {
						$xfavi_feed_id = '1';
					}
					if ( isset( $_POST['xfavi_simulated_post_id'] ) ) {
						$xfavi_simulated_post_id = sanitize_text_field( $_POST['xfavi_simulated_post_id'] );
					} else {
						$xfavi_simulated_post_id = '';
					}
					if ( isset( $_REQUEST['xfavi_submit_simulated'] ) ) {
						if ( ! empty( $_POST ) && check_admin_referer( 'xfavi_nonce_action_simulated', 'xfavi_nonce_field_simulated' ) ) {
							$post_id = (int) $xfavi_simulated_post_id;

							$result_get_unit_obj = new XFAVI_Get_Unit( $post_id, $xfavi_feed_id );
							$simulated_result_xml = $result_get_unit_obj->get_result();

							$resust_report_arr = $result_get_unit_obj->get_skip_reasons_arr();

							if ( empty( $resust_report_arr ) ) {
								$resust_report = 'Всё штатно';
							} else {
								foreach ( $result_get_unit_obj->get_skip_reasons_arr() as $value ) {
									$resust_report .= $value . PHP_EOL;
								}
							}
							$resust_simulated = $simulated_result_xml;
						}
					} ?>
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row"><label for="xfavi_simulated_post_id">postId</label></th>
								<td class="overalldesc">
									<input type="number" min="1" name="xfavi_simulated_post_id"
										value="<?php echo $xfavi_simulated_post_id; ?>">
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="xfavi_feed_id">feed_id</label></th>
								<td class="overalldesc">
									<select style="width: 100%" name="xfavi_feed_id" id="xfavi_feed_id">
										<?php if ( is_multisite() ) {
											$cur_blog_id = get_current_blog_id();
										} else {
											$cur_blog_id = '0';
										}
										$xfavi_settings_arr = xfavi_optionGET( 'xfavi_settings_arr' );
										$xfavi_settings_arr_keys_arr = array_keys( $xfavi_settings_arr );
										for ( $i = 0; $i < count( $xfavi_settings_arr_keys_arr ); $i++ ) :
											$feed_id = (string) $xfavi_settings_arr_keys_arr[ $i ];
											if ( $xfavi_settings_arr[ $feed_id ]['xfavi_feed_assignment'] === '' ) {
												$feed_assignment = '';
											} else {
												$feed_assignment = ' (' . $xfavi_settings_arr[ $feed_id ]['xfavi_feed_assignment'] . ')';
											} ?>
											<option value="<?php echo $feed_id; ?>" <?php selected( $xfavi_feed_id, $feed_id ); ?>>
												<?php _e( 'Feed', $this->get_pref() ); ?> 			<?php echo $feed_id; ?>: feed-xml-<?php echo $cur_blog_id; ?>.xml<?php echo $feed_assignment; ?></option>
										<?php endfor; ?>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row" colspan="2"><textarea rows="4"
										style="width: 100%;"><?php echo htmlspecialchars( $resust_report ); ?></textarea></th>
							</tr>
							<tr>
								<th scope="row" colspan="2"><textarea rows="16"
										style="width: 100%;"><?php echo htmlspecialchars( $resust_simulated ); ?></textarea></th>
							</tr>
						</tbody>
					</table>
					<?php wp_nonce_field( 'xfavi_nonce_action_simulated', 'xfavi_nonce_field_simulated' ); ?><input
						class="button-primary" type="submit" name="xfavi_submit_simulated"
						value="<?php _e( 'Симуляция', $this->get_pref() ); ?>" />
				</form>
			</div>
		</div>
	<?php // end get_html_feeds_list();
	} // end get_html_block_simulation();

	public function get_html_block_possible_problems() { ?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Возможные проблемы', $this->get_pref() ); ?>
			</h2>
			<div class="inside">
				<?php
				$possible_problems_arr = $this->get_possible_problems_list();
				if ( $possible_problems_arr[1] > 0 ) { // $possibleProblemsCount > 0) {
					echo '<ol>' . $possible_problems_arr[0] . '</ol>';
				} else {
					echo '<p>' . __( 'Функции самодиагностики не выявили потенциальных проблем', $this->get_pref() ) . '.</p>';
				}
				?>
			</div>
		</div>
		<?php
	} // end get_html_block_sandbox();

	public function get_html_block_sandbox() { ?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Песочница', $this->get_pref() ); ?>
			</h2>
			<div class="inside">
				<?php
				require_once XFAVI_PLUGIN_DIR_PATH . '/sandbox.php';
				try {
					xfavi_run_sandbox();
				} catch (Exception $e) {
					echo 'Exception: ', $e->getMessage(), "\n";
				}
				?>
			</div>
		</div>
		<?php
	} // end get_html_block_sandbox();

	public static function get_possible_problems_list() {
		$possibleProblems = '';
		$possibleProblemsCount = 0;
		$conflictWithPlugins = 0;
		$conflictWithPluginsList = '';
		$check_global_attr_count = wc_get_attribute_taxonomies();
		if ( count( $check_global_attr_count ) < 1 ) {
			$possibleProblemsCount++;
			$possibleProblems .= '<li>' . __( 'Ваш сайт не имеет глобальных атрибутов! Это может повлиять на качество XML-фида. Это также может вызвать трудности при настройке плагина', 'xml-for-avito' ) . '. <a href="https://icopydoc.ru/globalnyj-i-lokalnyj-atributy-v-woocommerce/?utm_source=xml-for-avito&utm_medium=organic&utm_campaign=in-plugin-xml-for-avito&utm_content=debug-page&utm_term=possible-problems">' . __( 'Please read the recommendations', 'xml-for-avito' ) . '</a>.</li>';
		}
		if ( is_plugin_active( 'snow-storm/snow-storm.php' ) ) {
			$possibleProblemsCount++;
			$conflictWithPlugins++;
			$conflictWithPluginsList .= 'Snow Storm<br/>';
		}
		if ( is_plugin_active( 'email-subscribers/email-subscribers.php' ) ) {
			$possibleProblemsCount++;
			$conflictWithPlugins++;
			$conflictWithPluginsList .= 'Email Subscribers & Newsletters<br/>';
		}
		if ( is_plugin_active( 'saphali-search-castom-filds/saphali-search-castom-filds.php' ) ) {
			$possibleProblemsCount++;
			$conflictWithPlugins++;
			$conflictWithPluginsList .= 'Email Subscribers & Newsletters<br/>';
		}
		if ( is_plugin_active( 'w3-total-cache/w3-total-cache.php' ) ) {
			$possibleProblemsCount++;
			$conflictWithPlugins++;
			$conflictWithPluginsList .= 'W3 Total Cache<br/>';
		}
		if ( is_plugin_active( 'docket-cache/docket-cache.php' ) ) {
			$possibleProblemsCount++;
			$conflictWithPlugins++;
			$conflictWithPluginsList .= 'Docket Cache<br/>';
		}
		if ( class_exists( 'MPSUM_Updates_Manager' ) ) {
			$possibleProblemsCount++;
			$conflictWithPlugins++;
			$conflictWithPluginsList .= 'Easy Updates Manager<br/>';
		}
		if ( class_exists( 'OS_Disable_WordPress_Updates' ) ) {
			$possibleProblemsCount++;
			$conflictWithPlugins++;
			$conflictWithPluginsList .= 'Disable All WordPress Updates<br/>';
		}
		if ( $conflictWithPlugins > 0 ) {
			$possibleProblemsCount++;
			$possibleProblems .= '<li><p>' . __( 'Скорее всего, эти плагины негативно влияют на работу', 'xml-for-avito' ) . ' XML for Avito:</p>' . $conflictWithPluginsList . '<p>' . __( 'Если вы разработчик одного из плагинов из списка выше, пожалуйста, свяжитесь со мной', 'xml-for-avito' ) . ': <a href="mailto:support@icopydoc.ru">support@icopydoc.ru</a>.</p></li>';
		}
		return array( $possibleProblems, $possibleProblemsCount, $conflictWithPlugins, $conflictWithPluginsList );
	}

	private function get_pref() {
		return $this->pref;
	}

	private function get_input_name_keeplogs() {
		return $this->get_pref() . '_keeplogs';
	}

	private function get_input_name_disable_notices() {
		return $this->get_pref() . '_disable_notices';
	}

	private function get_input_name_enable_five_min() {
		return $this->get_pref() . '_enable_five_min';
	}

	private function get_submit_name() {
		return $this->get_pref() . '_submit_debug_page';
	}

	private function get_nonce_action_debug_page() {
		return $this->get_pref() . '_nonce_action_debug_page';
	}

	private function get_nonce_field_debug_page() {
		return $this->get_pref() . '_nonce_field_debug_page';
	}

	private function get_submit_name_clear_logs() {
		return $this->get_pref() . '_submit_clear_logs';
	}

	private function listen_submit() {
		if ( isset( $_REQUEST[ $this->get_submit_name()] ) ) {
			$this->seve_data();
			$message = __( 'Обновлено', $this->get_pref() );
			$class = 'notice-success';

			add_action( 'my_admin_notices', function () use ($message, $class) {
				$this->admin_notices_func( $message, $class );
			}, 10, 2 );
		}

		if ( isset( $_REQUEST[ $this->get_submit_name_clear_logs()] ) ) {
			$filename = XFAVI_PLUGIN_UPLOADS_DIR_PATH . '/xml-for-avito.log';
			if ( file_exists( $filename ) ) {
				$res = unlink( $filename );
			} else {
				$res = false;
			}
			if ( $res == true ) {
				$message = __( 'Логи были очищены', $this->get_pref() );
				$class = 'notice-success';
			} else {
				$message = __( 'Ошибка доступа к log-файлу. Возможно log-файл был удален ранее', $this->get_pref() );
				$class = 'notice-warning';
			}

			add_action( 'my_admin_notices', function () use ($message, $class) {
				$this->admin_notices_func( $message, $class );
			}, 10, 2 );
		}
		return;
	}

	private function seve_data() {
		if ( ! empty( $_POST ) && check_admin_referer( $this->get_nonce_action_debug_page(), $this->get_nonce_field_debug_page() ) ) {
			if ( isset( $_POST[ $this->get_input_name_keeplogs()] ) ) {
				$keeplogs = sanitize_text_field( $_POST[ $this->get_input_name_keeplogs()] );
			} else {
				$keeplogs = '';
			}
			if ( isset( $_POST[ $this->get_input_name_disable_notices()] ) ) {
				$disable_notices = sanitize_text_field( $_POST[ $this->get_input_name_disable_notices()] );
			} else {
				$disable_notices = '';
			}
			if ( isset( $_POST[ $this->get_input_name_enable_five_min()] ) ) {
				$enable_five_min = sanitize_text_field( $_POST[ $this->get_input_name_enable_five_min()] );
			} else {
				$enable_five_min = '';
			}
			if ( is_multisite() ) {
				update_blog_option( get_current_blog_id(), 'xfavi_keeplogs', $keeplogs );
				update_blog_option( get_current_blog_id(), 'xfavi_disable_notices', $disable_notices );
			} else {
				update_option( 'xfavi_keeplogs', $keeplogs );
				update_option( 'xfavi_disable_notices', $disable_notices );
			}
		}
		return;
	}

	private function admin_notices_func( $message, $class ) {
		printf( '<div class="notice %1$s"><p>%2$s</p></div>', $class, $message );
	}
}