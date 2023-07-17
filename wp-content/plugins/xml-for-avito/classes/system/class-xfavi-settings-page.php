<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Plugin Settings Page
 *
 * @link			https://icopydoc.ru/
 * @since		1.5.0
 */

class XFAVI_Settings_Page {
	private $feed_id;
	private $feedback;

	public function __construct() {
		$this->feedback = new XFAVI_Feedback();

		$this->init_hooks(); // подключим хуки
		$this->listen_submit();

		$this->get_html_form();
	}

	public function get_html_form() { ?>
		<div class="wrap">
			<h1>
				<?php _e( 'Экспорт Avito', 'xml-for-avito' ); ?>
			</h1>
			<?php echo $this->get_html_banner(); ?>
			<div id="poststuff">
				<?php $this->get_html_feeds_list(); ?>

				<div id="post-body" class="columns-2">

					<div id="postbox-container-1" class="postbox-container">
						<div class="meta-box-sortables">
							<?php $this->get_html_info_block(); ?>

							<?php do_action( 'xfavi_before_support_project' ); ?>

							<?php $this->feedback->get_block_support_project(); ?>

							<?php do_action( 'xfavi_between_container_1', $this->get_feed_id() ); ?>

							<?php $this->feedback->get_form(); ?>

							<?php do_action( 'xfavi_append_container_1', $this->get_feed_id() ); ?>
						</div>
					</div><!-- /postbox-container-1 -->

					<div id="postbox-container-2" class="postbox-container">
						<div class="meta-box-sortables">
							<?php if ( empty( $this->get_feed_id() ) ) : ?>
								<?php _e( 'XML фиды не найдены', 'xml-for-avito' ); ?>.
								<?php _e( 'Нажмите кнопку "Добавить фид" в верхней части этой страницы', 'xml-for-avito' ); ?>.
							<?php else :
								if ( isset( $_GET['tab'] ) ) {
									$tab = $_GET['tab'];
								} else {
									$tab = 'main_tab';
								}
								echo $this->get_html_tabs( $tab ); ?>

								<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
									<?php do_action( 'xfavi_prepend_form_container_2', $this->get_feed_id() ); ?>
									<input type="hidden" name="xfavi_num_feed_for_save" value="<?php echo $this->get_feed_id(); ?>">
									<?php switch ( $tab ) :
										case 'main_tab': ?>
											<?php $this->get_html_main_settings(); ?>
											<?php break;
										case 'shop_data': ?>
											<?php $this->get_html_shop_data(); ?>
											<?php break;
										case 'filtration': ?>
											<?php $this->get_html_filtration(); ?>
											<?php do_action( 'xfavi_after_main_param_block', $this->get_feed_id() ); ?>
											<?php break;  
										endswitch; ?>

									<?php do_action( 'xfavi_after_optional_elemet_block', $this->get_feed_id() ); ?>
									<div class="postbox">
										<div class="inside">
											<table class="form-table">
												<tbody>
													<tr>
														<th scope="row"><label for="button-primary"></label></th>
														<td class="overalldesc">
															<?php wp_nonce_field( 'xfavi_nonce_action', 'xfavi_nonce_field' ); ?><input
																id="button-primary" class="button-primary" type="submit"
																name="xfavi_submit_action" value="<?php
																if ( $tab === 'main_tab' ) {
																	echo __( 'Сохранить', 'xml-for-avito' ) . ' & ' . __( 'Создать фид', 'xml-for-avito' );
																} else {
																	_e( 'Сохранить', 'xml-for-avito' );
																}
																?>" /><br />
															<span class="description"><small>
																	<?php _e( 'Нажмите, чтобы сохранить настройки', 'xml-for-avito' ); ?><small></span>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</form>
							<?php endif; ?>
						</div>
					</div><!-- /postbox-container-2 -->

				</div>
			</div><!-- /poststuff -->
			<?php $this->get_html_icp_banners(); ?>
			<?php $this->get_html_my_plugins_list(); ?>
		</div>
	<?php // end get_html_form();
	}

	public function get_html_banner() {
		if ( ! class_exists( 'XmlforAvitoPro' ) ) {
			return '<div class="notice notice-info">
				<p><span class="xfavi_bold">XML for Avito Pro</span> - ' . __( 'необходимое расширение для тех, кто хочет', 'xml-for-avito' ) . ' <span class="xfavi_bold" style="color: green;">' . __( 'экономить рекламный бюджет', 'xml-for-avito' ) . '</span> ' . __( 'на Avito', 'xml-for-avito' ) . '! <a href="https://icopydoc.ru/product/xml-for-avito-pro/?utm_source=xml-for-avito&utm_medium=organic&utm_campaign=in-plugin-xml-for-avito&utm_content=settings&utm_term=about-xml-pro">' . __( 'Подробнее', 'xml-for-avito' ) . '</a>.</p>
			</div>';
		} else {
			return '';
		}
	} // end get_html_banner();

	public function get_html_feeds_list() {
		$xfaviListTable = new XFAVI_WP_List_Table(); ?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'xfavi_nonce_action_add_new_feed', 'xfavi_nonce_field_add_new_feed' ); ?><input class="button"
				type="submit" name="xfavi_submit_add_new_feed" value="<?php _e( 'Добавить фид', 'xml-for-avito' ); ?>" />
		</form>
		<form method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<input type="hidden" name="xfavi_form_id" value="xfavi_wp_list_table" />
			<?php $xfaviListTable->prepare_items();
			$xfaviListTable->display(); ?>
		</form>
	<?php // end get_html_feeds_list();
	} // end get_html_feeds_list();

	public function get_html_info_block() {
		$status_sborki = (int) xfavi_optionGET( 'xfavi_status_sborki', $this->get_feed_id() );
		$xfavi_file_url = urldecode( xfavi_optionGET( 'xfavi_file_url', $this->get_feed_id(), 'set_arr' ) );
		$xfavi_date_sborki = xfavi_optionGET( 'xfavi_date_sborki', $this->get_feed_id(), 'set_arr' );
		//		$xfavi_date_sborki_end = xfavi_optionGET('xfavi_date_sborki_end', $this->get_feed_id(), 'set_arr');
		$xfavi_status_cron = xfavi_optionGET( 'xfavi_status_cron', $this->get_feed_id(), 'set_arr' );
		//		$xfavi_count_products_in_feed = xfavi_optionGET('xfavi_count_products_in_feed', $this->get_feed_id(), 'set_arr');
		?>
		<div class="postbox">
			<?php if ( is_multisite() ) {
				$cur_blog_id = get_current_blog_id();
			} else {
				$cur_blog_id = '0';
			} ?>
			<h2 class="hndle">
				<?php _e( 'Фид', 'xml-for-avito' ); ?>
				<?php echo $this->get_feed_id(); ?>:
				<?php if ( $this->get_feed_id() !== '1' ) {
					echo $this->get_feed_id();
				} ?>feed-avito-
				<?php echo $cur_blog_id; ?>.xml
				<?php $assignment = xfavi_optionGET( 'xfavi_feed_assignment', $this->get_feed_id(), 'set_arr' );
				if ( $assignment === '' ) {
				} else {
					echo '(' . $assignment . ')';
				} ?>
				<?php if ( empty( $xfavi_file_url ) ) : ?>
					<?php _e( 'not created yet', 'xml-for-avito' ); ?>
				<?php else : ?>
					<?php if ( $status_sborki !== -1 ) : ?>
						<?php _e( 'updating', 'xml-for-avito' ); ?>
					<?php else : ?>
						<?php _e( 'создан', 'xml-for-avito' ); ?>
					<?php endif; ?>
				<?php endif; ?>
			</h2>
			<div class="inside">
				<p><strong style="color: green;">
						<?php _e( 'Инструкция', 'xml-for-avito' ); ?>:
					</strong> <a
						href="https://icopydoc.ru/kak-sozdat-fid-dlya-avito-instruktsiya/?utm_source=xml-for-avito&utm_medium=organic&utm_campaign=in-plugin-xml-for-avito&utm_content=settings&utm_term=main-instruction"
						target="_blank">
						<?php _e( 'Как создать XML фид', 'xml-for-avito' ); ?>
					</a>.</p>
				<?php if ( empty( $xfavi_file_url ) ) : ?>
					<?php if ( $status_sborki !== -1 ) : ?>
						<p>
							<?php _e( 'Идет автоматическое создание файла. XML-фид в скором времени будет создан', 'xml-for-avito' ); ?>.
						</p>
					<?php else : ?>
						<p><span class="xfavi_bold">
								<?php _e( 'Перейдите в "Товары" -> "Категории". Отредактируйте имющиеся у вас на сайте категории выбрав соответсвующие значения напротив пунктов: "Обрабатывать согласно правилам Авито", "Авито Category" и "Авито GoodsType"', 'xml-for-avito' ); ?>.
							</span></p>
						<p>
							<?php _e( 'После вернитесь на данную страницу и в поле "Автоматическое создание файла" выставите значение, отличное от значения "отключено", при необходимости измените значение других полей и нажмите "Сохранить"', 'xml-for-avito' ); ?>.
						</p>
						<p>
							<?php _e( 'Через 1 - 7 минут (зависит от числа товаров), фид будет сгенерирован и вместо данного сообщения появится ссылка', 'xml-for-avito' ); ?>.
						</p>
					<?php endif; ?>
				<?php else : ?>
					<?php if ( $status_sborki !== -1 ) : ?>
						<p>
							<?php _e( 'Идет автоматическое создание файла. XML-фид в скором времени будет создан', 'xml-for-avito' ); ?>.
						</p>
					<?php else : ?>
						<p><span class="fgmc_bold">
								<?php _e( 'Ваш фид здесь', 'xml-for-avito' ); ?>:
							</span><br /><a target="_blank" href="<?php echo $xfavi_file_url; ?>"><?php echo $xfavi_file_url; ?></a>
							<br />
							<?php _e( 'Размер файла', 'xml-for-avito' ); ?>:
							<?php clearstatcache();
							if ( $this->get_feed_id() == '1' ) {
								$prefFeed = '';
							} else {
								$prefFeed = $this->get_feed_id();
							}
							$upload_dir = (object) wp_get_upload_dir();
							if ( is_multisite() ) {
								$filename = $upload_dir->basedir . "/xml-for-avito/" . $prefFeed . "feed-avito-" . get_current_blog_id() . ".xml";
							} else {
								$filename = $upload_dir->basedir . "/xml-for-avito/" . $prefFeed . "feed-avito-0.xml";
							}
							if ( is_file( $filename ) ) {
								echo xfavi_formatSize( filesize( $filename ) );
							} else {
								echo '0 KB';
							} ?>
							<br />
							<?php _e( 'Начало генерации', 'xml-for-avito' ); ?>:
							<?php echo $xfavi_date_sborki; ?>
							<?php /*	<br/><?php _e('Сгенерирован', 'xml-for-avito'); ?>: <?php echo $xfavi_date_sborki_end; ?>
											<br/><?php _e('Товаров', 'xml-for-avito'); ?>: <?php echo $xfavi_count_products_in_feed; ?></p>
											*/?>
						<?php endif; ?>
					<?php endif; ?>
			</div>
		</div>
		<?php
	} // end get_html_info_block();

	public function get_html_tabs( $current = 'main_tab' ) {
		$tabs_arr = [
			'main_tab' => __( 'Основные настройки', 'xml-for-avito' ),
			'shop_data' => __( 'Даннные магазина', 'xml-for-avito' ),
			'filtration' => __( 'Фильтрация', 'xml-for-avito' )
		];
		$tabs_arr = apply_filters('xfavi_f_tabs_arr', $tabs_arr);

		$html = '<div class="nav-tab-wrapper" style="margin-bottom: 10px;">';
		foreach ( $tabs_arr as $tab => $name ) {
			if ( $tab === $current ) {
				$class = ' nav-tab-active';
			} else {
				$class = '';
			}
			if ( isset( $_GET['feed_id'] ) ) {
				$nf = '&feed_id=' . sanitize_text_field( $_GET['feed_id'] );
			} else {
				$nf = '';
			}
			$html .= sprintf( 
				'<a class="nav-tab%1$s" href="?page=xfaviexport&tab=%2$s%3$s">%4$s</a>', 
				$class, $tab, $nf, $name 
			);
		}
		$html .= '</div>';

		return $html;
	} // end get_html_tabs();

	public function get_html_main_settings() {
		$xfavi_status_cron = xfavi_optionGET( 'xfavi_status_cron', $this->get_feed_id(), 'set_arr' );
		$xfavi_ufup = xfavi_optionGET( 'xfavi_ufup', $this->get_feed_id(), 'set_arr' );
		$xfavi_feed_assignment = xfavi_optionGET( 'xfavi_feed_assignment', $this->get_feed_id(), 'set_arr' );

		$xfavi_step_export = xfavi_optionGET( 'xfavi_step_export', $this->get_feed_id(), 'set_arr' );

		$xfavi_size = xfavi_optionGET( 'xfavi_size', $this->get_feed_id(), 'set_arr' );
		$xfavi_condition = xfavi_optionGET( 'xfavi_condition', $this->get_feed_id(), 'set_arr' );
		$xfavi_oem = xfavi_optionGET( 'xfavi_oem', $this->get_feed_id(), 'set_arr' );
		$xfavi_brand = xfavi_optionGET( 'xfavi_brand', $this->get_feed_id(), 'set_arr' );
		$xfavi_make = xfavi_optionGET( 'xfavi_make', $this->get_feed_id(), 'set_arr' );
		$xfavi_model = xfavi_optionGET( 'xfavi_model', $this->get_feed_id(), 'set_arr' );
		$xfavi_generation = xfavi_optionGET( 'xfavi_generation', $this->get_feed_id(), 'set_arr' );

		$xfavi_file_url = urldecode( xfavi_optionGET( 'xfavi_file_url', $this->get_feed_id(), 'set_arr' ) );
		$xfavi_date_sborki = xfavi_optionGET( 'xfavi_date_sborki', $this->get_feed_id(), 'set_arr' );

		?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Основные параметры', 'xml-for-avito' ); ?> (
				<?php _e( 'Фид', 'xml-for-avito' ); ?> ID:
				<?php echo $this->get_feed_id(); ?>)
			</h2>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="xfavi_run_cron">
									<?php _e( 'Автоматическое создание файла', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_run_cron" id="xfavi_run_cron">
									<option value="off" <?php selected( $xfavi_status_cron, 'off' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
									<option value="hourly" <?php selected( $xfavi_status_cron, 'hourly' ); ?>><?php _e( 'Раз в час', 'xml-for-avito' ); ?></option>
									<option value="six_hours" <?php selected( $xfavi_status_cron, 'six_hours' ); ?>><?php _e( 'Каждые 6 часов', 'xml-for-avito' ); ?></option>
									<option value="twicedaily" <?php selected( $xfavi_status_cron, 'twicedaily' ); ?>><?php _e( '2 раза в день', 'xml-for-avito' ); ?></option>
									<option value="daily" <?php selected( $xfavi_status_cron, 'daily' ); ?>><?php _e( 'Раз в день', 'xml-for-avito' ); ?></option>
									<option value="week" <?php selected( $xfavi_status_cron, 'week' ); ?>><?php _e( 'Раз в неделю', 'xml-for-avito' ); ?></option>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Интервал обновления вашего фида', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_ufup">
									<?php _e( 'Обновить фид при обновлении карточки товара', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input type="checkbox" name="xfavi_ufup" id="xfavi_ufup" <?php checked( $xfavi_ufup, 'on' ); ?> />
							</td>
						</tr>
						<?php do_action( 'xfavi_after_ufup_option', $this->get_feed_id() ); ?>
						<tr>
							<th scope="row"><label for="xfavi_feed_assignment">
									<?php _e( 'Назначение фида', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input type="text" maxlength="25" name="xfavi_feed_assignment" id="xfavi_feed_assignment"
									value="<?php echo $xfavi_feed_assignment; ?>"
									placeholder="<?php _e( 'Для Авито', 'xml-for-avito' ); ?>" /><br />
								<span class="description"><small>
										<?php _e( 'Не используется в фиде. Внутренняя заметка для вашего удобства', 'xml-for-avito' ); ?>.
									</small></span>
							</td>
						</tr>
						<tr class="xfavi_tr">
							<th scope="row"><label for="xfavi_step_export">
									<?php _e( 'Шаг экспорта', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_step_export" id="xfavi_step_export">
									<option value="80" <?php selected( $xfavi_step_export, '80' ); ?>>80</option>
									<option value="200" <?php selected( $xfavi_step_export, '200' ); ?>>200</option>
									<option value="300" <?php selected( $xfavi_step_export, '300' ); ?>>300</option>
									<option value="450" <?php selected( $xfavi_step_export, '450' ); ?>>450</option>
									<option value="500" <?php selected( $xfavi_step_export, '500' ); ?>>500</option>
									<option value="800" <?php selected( $xfavi_step_export, '800' ); ?>>800</option>
									<option value="1000" <?php selected( $xfavi_step_export, '1000' ); ?>>1000</option>
									<?php do_action( 'xfavi_step_export_option', $this->get_feed_id() ); ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Значение влияет на скорость создания XML фида', 'xml-for-avito' ); ?>.
										<?php _e( 'Если у вас возникли проблемы с генерацией файла - попробуйте уменьшить значение в данном поле', 'xml-for-avito' ); ?>.
										<?php _e( 'Более 500 можно устанавливать только на мощных серверах', 'xml-for-avito' ); ?>.
									</small></span>
							</td>
						</tr>
						<tr class="xfavi_tr">
							<th scope="row"><label for="xfavi_size">
									<?php _e( 'Размер', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_size" id="xfavi_size">
									<option value="off" <?php selected( $xfavi_size, 'off' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
									<?php foreach ( xfavi_get_attributes() as $attribute ) : ?>
										<option value="<?php echo $attribute['id']; ?>" <?php selected( $xfavi_size, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>
									<?php endforeach; ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>Size</strong>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_condition">
									<?php _e( 'Состояние товара', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_condition" id="xfavi_condition">
									<option value="new" <?php selected( $xfavi_condition, 'new' ); ?>><?php _e( 'Новый', 'xml-for-avito' ); ?></option>
									<option value="bu" <?php selected( $xfavi_condition, 'bu' ); ?>><?php _e( 'Б/у', 'xml-for-avito' ); ?></option>
									<?php do_action( 'xfavi_condition_option', $this->get_feed_id() ); ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Обязательный элемент', 'xml-for-avito' ); ?> <strong>Condition</strong>.
										<?php _e( 'Задайте значение по умолчанию', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr class="xfavi_tr">
							<th scope="row"><label for="xfavi_oem">
									<?php _e( 'Номер детали', 'xml-for-avito' ); ?> OEM
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_oem" id="xfavi_oem">
									<option value="disabled" <?php selected( $xfavi_oem, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
									<option value="sku" <?php selected( $xfavi_oem, 'sku' ); ?>><?php _e( 'Подставлять из', 'xml-for-avito' ); ?> "<?php _e( 'Артикул', 'xml-for-avito' ); ?>"</option>
									<?php foreach ( xfavi_get_attributes() as $attribute ) : ?>
										<option value="<?php echo $attribute['id']; ?>" <?php selected( $xfavi_oem, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>
									<?php endforeach; ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>OEM</strong> —
										<?php _e( 'исчтоник значения по умолчанию', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_brand">
									<?php _e( 'Производитель', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_brand" id="xfavi_brand">
									<option value="disabled" <?php selected( $xfavi_brand, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
									<option value="sku" <?php selected( $xfavi_brand, 'sku' ); ?>><?php _e( 'Подставлять из', 'xml-for-avito' ); ?> "<?php _e( 'Артикул', 'xml-for-avito' ); ?>"</option>
									<?php foreach ( xfavi_get_attributes() as $attribute ) : ?>
										<option value="<?php echo $attribute['id']; ?>" <?php selected( $xfavi_brand, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>
									<?php endforeach; ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>Brand</strong> —
										<?php _e( 'исчтоник значения по умолчанию', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_make">
									<?php _e( 'Марка автомобиля', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_make" id="xfavi_make">
									<option value="disabled" <?php selected( $xfavi_make, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
									<option value="sku" <?php selected( $xfavi_make, 'sku' ); ?>><?php _e( 'Подставлять из', 'xml-for-avito' ); ?> "<?php _e( 'Артикул', 'xml-for-avito' ); ?>"</option>
									<?php foreach ( xfavi_get_attributes() as $attribute ) : ?>
										<option value="<?php echo $attribute['id']; ?>" <?php selected( $xfavi_make, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>
									<?php endforeach; ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>Make</strong> —
										<?php _e( 'исчтоник значения по умолчанию', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_model">
									<?php _e( 'Модель', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_model" id="xfavi_model">
									<option value="disabled" <?php selected( $xfavi_model, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
									<option value="sku" <?php selected( $xfavi_model, 'sku' ); ?>><?php _e( 'Подставлять из', 'xml-for-avito' ); ?> "<?php _e( 'Артикул', 'xml-for-avito' ); ?>"</option>
									<?php foreach ( xfavi_get_attributes() as $attribute ) : ?>
										<option value="<?php echo $attribute['id']; ?>" <?php selected( $xfavi_model, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>
									<?php endforeach; ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>Model</strong> —
										<?php _e( 'исчтоник значения по умолчанию', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_generation">
									<?php _e( 'Поколение автомобиля', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_generation" id="xfavi_generation">
									<option value="disabled" <?php selected( $xfavi_generation, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
									<?php foreach ( xfavi_get_attributes() as $attribute ) : ?>
										<option value="<?php echo $attribute['id']; ?>" <?php selected( $xfavi_generation, $attribute['id'] ); ?>><?php echo $attribute['name']; ?></option>
									<?php endforeach; ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>Generation</strong> —
										<?php _e( 'исчтоник значения по умолчанию', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	} // end get_html_main_settings();

	public function get_html_shop_data() {
		$xfavi_allowEmail = stripslashes( htmlspecialchars( xfavi_optionGET( 'xfavi_allowEmail', $this->get_feed_id(), 'set_arr' ) ) );
		$xfavi_managerName = stripslashes( htmlspecialchars( xfavi_optionGET( 'xfavi_managerName', $this->get_feed_id(), 'set_arr' ) ) );
		$xfavi_contactPhone = stripslashes( htmlspecialchars( xfavi_optionGET( 'xfavi_contactPhone', $this->get_feed_id(), 'set_arr' ) ) );
		$xfavi_main_product = xfavi_optionGET( 'xfavi_main_product', $this->get_feed_id(), 'set_arr' );
		$xfavi_listing_fee = xfavi_optionGET( 'xfavi_listing_fee', $this->get_feed_id(), 'set_arr' );
		$xfavi_address = stripslashes( htmlspecialchars( xfavi_optionGET( 'xfavi_address', $this->get_feed_id(), 'set_arr' ) ) );
		$xfavi_contact_method = stripslashes( htmlspecialchars( xfavi_optionGET( 'xfavi_contact_method', $this->get_feed_id(), 'set_arr' ) ) );
		?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Данные магазина', 'xml-for-avito' ); ?> (
				<?php _e( 'Фид', 'xml-for-avito' ); ?> ID:
				<?php echo $this->get_feed_id(); ?>)
			</h2>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr class="xfavi_tr">
							<th scope="row"><label for="xfavi_contact_method">
									<?php _e( 'Способ связи', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_contact_method" id="xfavi_contact_method">
									<option value="all" <?php selected( $xfavi_contact_method, 'all' ); ?>><?php _e( 'По телефону и в сообщениях', 'xml-for-avito' ); ?></option>
									<option value="phone" <?php selected( $xfavi_contact_method, 'phone' ); ?>><?php _e( 'По телефону', 'xml-for-avito' ); ?></option>
									<option value="msg" <?php selected( $xfavi_contact_method, 'msg' ); ?>><?php _e( 'В сообщениях', 'xml-for-avito' ); ?></option>
								</select>
							</td>
						</tr>
						<th scope="row"><label for="xfavi_allowEmail">
								<?php _e( 'Связь по Email', 'xml-for-avito' ); ?>
							</label></th>
						<td class="overalldesc">
							<select name="xfavi_allowEmail" id="xfavi_allowEmail">
								<option value="Да" <?php selected( $xfavi_allowEmail, 'Да' ); ?>><?php _e( 'Да', 'xml-for-avito' ); ?></option>
								<option value="Нет" <?php selected( $xfavi_allowEmail, 'Нет' ); ?>><?php _e( 'Нет', 'xml-for-avito' ); ?></option>
							</select><br />
							<span class="description"><small>
									<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>Allow Email</strong>.
									<?php _e( 'Возможность написать сообщение по объявлению через сайт', 'xml-for-avito' ); ?>
								</small></span>
						</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_managerName">
									<?php _e( 'Имя менеджера', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input maxlength="40" type="text" name="xfavi_managerName" id="xfavi_managerName"
									value="<?php echo $xfavi_managerName; ?>" /><br />
								<span class="description"><small>
										<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>ManagerName</strong>.
										<?php _e( 'Имя менеджера, контактного лица компании по данному объявлению — строка не более 40 символов', 'xml-for-avito' ); ?>.
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_contactPhone">
									<?php _e( 'Телефон', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input maxlength="40" type="text" name="xfavi_contactPhone" id="xfavi_contactPhone"
									value="<?php echo $xfavi_contactPhone; ?>" /><br />
								<span class="description"><small>
										<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>ContactPhone</strong>.
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_address">
									<?php _e( 'Адрес', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input maxlength="256" type="text" name="xfavi_address" id="xfavi_address"
									value="<?php echo $xfavi_address; ?>" /><br />
								<span class="description"><small>
										<?php _e( 'Обязательный элемент', 'xml-for-avito' ); ?> <strong>Address</strong>.
										<?php _e( 'Полный адрес объекта — строка до 256 символов', 'xml-for-avito' ); ?>.
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_main_product">
									<?php _e( 'Какие товары вы продаёте', 'xml-for-avito' ); ?>?
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_main_product" id="xfavi_main_product">
									<option value="electronics" <?php selected( $xfavi_main_product, 'electronics' ); ?>><?php _e( 'Электроника', 'xml-for-avito' ); ?></option>
									<option value="computer" <?php selected( $xfavi_main_product, 'computer' ); ?>><?php _e( 'Компьютеры', 'xml-for-avito' ); ?></option>
									<option value="clothes_and_shoes" <?php selected( $xfavi_main_product, 'clothes_and_shoes' ); ?>><?php _e( 'Одежда и обувь', 'xml-for-avito' ); ?></option>
									<option value="auto_parts" <?php selected( $xfavi_main_product, 'auto_parts' ); ?>><?php _e( 'Автозапчасти', 'xml-for-avito' ); ?></option>
									<option value="products_for_children" <?php selected( $xfavi_main_product, 'products_for_children' ); ?>><?php _e( 'Детские товары', 'xml-for-avito' ); ?></option>
									<option value="sporting_goods" <?php selected( $xfavi_main_product, 'sporting_goods' ); ?>>
										<?php _e( 'Спортивные товары', 'xml-for-avito' ); ?></option>
									<option value="goods_for_pets" <?php selected( $xfavi_main_product, 'goods_for_pets' ); ?>>
										<?php _e( 'Товары для домашних животных', 'xml-for-avito' ); ?></option>
									<option value="sexshop" <?php selected( $xfavi_main_product, 'sexshop' ); ?>><?php _e( 'Секс-шоп (товары для взрослых)', 'xml-for-avito' ); ?></option>
									<option value="books" <?php selected( $xfavi_main_product, 'books' ); ?>><?php _e( 'Книги', 'xml-for-avito' ); ?></option>
									<option value="health" <?php selected( $xfavi_main_product, 'health' ); ?>><?php _e( 'Товары для здоровья', 'xml-for-avito' ); ?></option>
									<option value="food" <?php selected( $xfavi_main_product, 'food' ); ?>><?php _e( 'Еда', 'xml-for-avito' ); ?></option>
									<option value="construction_materials" <?php selected( $xfavi_main_product, 'construction_materials' ); ?>><?php _e( 'Строительные материалы', 'xml-for-avito' ); ?>
									</option>
									<option value="other" <?php selected( $xfavi_main_product, 'other' ); ?>><?php _e( 'Прочее', 'xml-for-avito' ); ?></option>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Укажите основную категорию', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<th scope="row"><label for="xfavi_listing_fee">
								<?php _e( 'Вариант платного размещения', 'xml-for-avito' ); ?>
							</label></th>
						<td class="overalldesc">
							<select name="xfavi_listing_fee" id="xfavi_listing_fee">
								<option value="disabled" <?php selected( $xfavi_listing_fee, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
								<option value="Package" <?php selected( $xfavi_listing_fee, 'Package' ); ?>>Package (<?php _e( 'По умолчанию', 'xml-for-avito' ); ?>)</option>
								<option value="PackageSingle" <?php selected( $xfavi_listing_fee, 'PackageSingle' ); ?>>
									PackageSingle</option>
								<option value="Single" <?php selected( $xfavi_listing_fee, 'Single' ); ?>>Single</option>
							</select><br />
							<span class="description"><small>
									<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>ListingFee</strong>.
									<?php _e( 'Согласно справке Авито', 'xml-for-avito' ); ?>:
									<br />Package –
									<?php _e( 'размещение объявления осуществляется только при наличии подходящего пакета размещения', 'xml-for-avito' ); ?>
									<br />PackageSingle –
									<?php _e( 'при наличии подходящего пакета оплата размещения объявления произойдет с него; если нет подходящего пакета, но достаточно денег на кошельке Авито, то произойдет разовое размещение', 'xml-for-avito' ); ?>
									<br />Single –
									<?php _e( 'только разовое размещение, произойдет при наличии достаточной суммы на кошельке Авито; если есть подходящий пакет размещения, он будет проигнорирован', 'xml-for-avito' ); ?>
								</small></span>
						</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	} // end get_html_shop_data();

	public function get_html_filtration() {
		$xfavi_whot_export = xfavi_optionGET( 'xfavi_whot_export', $this->get_feed_id(), 'set_arr' );
		$xfavi_desc = xfavi_optionGET( 'xfavi_desc', $this->get_feed_id(), 'set_arr' );
		$xfavi_enable_tags_custom = xfavi_optionGET( 'xfavi_enable_tags_custom', $this->get_feed_id(), 'set_arr' );
		$xfavi_enable_tags_behavior = xfavi_optionGET( 'xfavi_enable_tags_behavior', $this->get_feed_id(), 'set_arr' );
		$xfavi_the_content = xfavi_optionGET( 'xfavi_the_content', $this->get_feed_id(), 'set_arr' );
		$xfavi_behavior_strip_symbol = xfavi_optionGET( 'xfavi_behavior_strip_symbol', $this->get_feed_id(), 'set_arr' );
		$xfavi_var_desc_priority = xfavi_optionGET( 'xfavi_var_desc_priority', $this->get_feed_id(), 'set_arr' );
		$xfavi_var_source_id = xfavi_optionGET( 'xfavi_var_source_id', $this->get_feed_id(), 'set_arr' );
		$xfavi_no_default_png_products = xfavi_optionGET( 'xfavi_no_default_png_products', $this->get_feed_id(), 'set_arr' );
		$xfavi_skip_products_without_pic = xfavi_optionGET( 'xfavi_skip_products_without_pic', $this->get_feed_id(), 'set_arr' );
		$xfavi_skip_missing_products = xfavi_optionGET( 'xfavi_skip_missing_products', $this->get_feed_id(), 'set_arr' );
		$xfavi_skip_backorders_products = xfavi_optionGET( 'xfavi_skip_backorders_products', $this->get_feed_id(), 'set_arr' );
		?>
		<div class="postbox">
			<h2 class="hndle">
				<?php _e( 'Фильтрация', 'xml-for-avito' ); ?> (
				<?php _e( 'Фид', 'xml-for-avito' ); ?> ID:
				<?php echo $this->get_feed_id(); ?>)
			</h2>
			<div class="inside">
				<table class="form-table">
					<tbody>
						<tr class="xfavi_tr">
							<th scope="row"><label for="xfavi_whot_export">
									<?php _e( 'Что экспортировать', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_whot_export" id="xfavi_whot_export">
									<option value="all" <?php selected( $xfavi_whot_export, 'all' ); ?>><?php _e( 'Вариативные и обычные товары' ); ?></option>
									<option value="simple" <?php selected( $xfavi_whot_export, 'simple' ); ?>><?php _e( 'Только обычные товары', 'xml-for-avito' ); ?></option>
									<?php do_action( 'xfavi_after_whot_export_option', $xfavi_whot_export, $this->get_feed_id() ); ?>
								</select><br />
								<span class="description"><small>
										<?php _e( 'Что экспортировать', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_desc">
									<?php _e( 'Описание товара', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_desc" id="xfavi_desc">
									<option value="excerpt" <?php selected( $xfavi_desc, 'excerpt' ); ?>><?php _e( 'Только Краткое описание', 'xml-for-avito' ); ?></option>
									<option value="full" <?php selected( $xfavi_desc, 'full' ); ?>><?php _e( 'Только Полное описание', 'xml-for-avito' ); ?></option>
									<option value="excerptfull" <?php selected( $xfavi_desc, 'excerptfull' ); ?>><?php _e( 'Краткое или Полное описание', 'xml-for-avito' ); ?></option>
									<option value="fullexcerpt" <?php selected( $xfavi_desc, 'fullexcerpt' ); ?>><?php _e( 'Полное или Краткое описание', 'xml-for-avito' ); ?></option>
									<option value="excerptplusfull" <?php selected( $xfavi_desc, 'excerptplusfull' ); ?>><?php _e( 'Краткое плюс Полное описание', 'xml-for-avito' ); ?></option>
									<option value="fullplusexcerpt" <?php selected( $xfavi_desc, 'fullplusexcerpt' ); ?>><?php _e( 'Полное плюс Краткое описание', 'xml-for-avito' ); ?></option>
									<?php do_action( 'xfavi_append_select_xfavi_desc', $xfavi_desc, $this->get_feed_id() ); ?>
								</select><br />
								<?php do_action( 'xfavi_after_select_xfavi_desc', $xfavi_desc, $this->get_feed_id() ); ?>
								<span class="description"><small>
										<?php _e( 'Источник описания товара', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_enable_tags_custom">
									<?php _e( 'Список разрешенных тегов', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_enable_tags_behavior" id="xfavi_enable_tags_behavior">
									<option value="default" <?php selected( $xfavi_enable_tags_behavior, 'default' ); ?>><?php _e( 'По умолчанию', 'xml-for-avito' ); ?></option>
									<option value="custom" <?php selected( $xfavi_enable_tags_behavior, 'custom' ); ?>><?php _e( 'Из поля ниже', 'xml-for-avito' ); ?></option>
								</select><br />
								<input style="min-width: 100%;" type="text" name="xfavi_enable_tags_custom"
									id="xfavi_enable_tags_custom" value="<?php echo $xfavi_enable_tags_custom; ?>"
									placeholder="p,br,h3" /><br />
								<span class="description"><small>
										<?php _e( 'Например', 'xml-for-avito' ); ?>: <code>p,br,h3</code>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_the_content">
									<?php _e( 'Задействовать фильтр', 'xml-for-avito' ); ?> the_content
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_the_content" id="xfavi_the_content">
									<option value="disabled" <?php selected( $xfavi_the_content, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
									<option value="enabled" <?php selected( $xfavi_the_content, 'enabled' ); ?>><?php _e( 'Включено', 'xml-for-avito' ); ?></option>
								</select><br />
								<span class="description"><small>
										<?php _e( 'По умолчанию', 'xml-for-avito' ); ?>:
										<?php _e( 'Включено', 'xml-for-avito' ); ?>
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_behavior_strip_symbol">
									<?php _e( 'В атрибутах', 'xml-for-avito' ); ?>
									<?php _e( 'амперсанд', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_behavior_strip_symbol" id="xfavi_behavior_strip_symbol">
									<option value="default" <?php selected( $xfavi_behavior_strip_symbol, 'default' ); ?>><?php _e( 'По умолчанию', 'xml-for-avito' ); ?></option>
									<option value="del" <?php selected( $xfavi_behavior_strip_symbol, 'del' ); ?>><?php _e( 'Удалить', 'xml-for-avito' ); ?></option>
									<option value="slash" <?php selected( $xfavi_behavior_strip_symbol, 'slash' ); ?>><?php _e( 'Заменить на', 'xml-for-avito' ); ?> /</option>
									<option value="amp" <?php selected( $xfavi_behavior_strip_symbol, 'amp' ); ?>><?php _e( 'Заменить на', 'xml-for-avito' ); ?> amp;</option>
								</select><br />
								<span class="description"><small>
										<?php _e( 'По умолчанию', 'xml-for-avito' ); ?> "
										<?php _e( 'Удалить', 'xml-for-avito' ); ?>"
									</small></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_var_desc_priority">
									<?php _e( 'Описание вариации имеет приоритет над другими', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input type="checkbox" name="xfavi_var_desc_priority" id="xfavi_var_desc_priority" <?php checked( $xfavi_var_desc_priority, 'on' ); ?> />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_var_source_id">
									<?php _e( 'Источник ID для вариативных товаров', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<select name="xfavi_var_source_id" id="xfavi_var_source_id">
									<option value="product_id" <?php selected( $xfavi_var_source_id, 'product_id' ); ?>><?php _e( 'ID товара', 'xml-for-avito' ); ?></option>
									<option value="offer_id" <?php selected( $xfavi_var_source_id, 'offer_id' ); ?>><?php _e( 'ID вариации', 'xml-for-avito' ); ?></option>
								</select><br />
								<span class="description">
									<?php _e( 'По умолчанию', 'xml-for-avito' ); ?> "
									<?php _e( 'ID вариации', 'xml-for-avito' ); ?>"
								</span>
							</td>
						</tr>
						<tr class="xfavi_tr">
							<th scope="row"><label for="xfavi_no_default_png_products">
									<?php _e( 'Удалить default.png из XML', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input type="checkbox" name="xfavi_no_default_png_products" id="xfavi_no_default_png_products"
									<?php checked( $xfavi_no_default_png_products, 'on' ); ?> />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_skip_products_without_pic">
									<?php _e( 'Пропустить товары без картинок', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input type="checkbox" name="xfavi_skip_products_without_pic"
									id="xfavi_skip_products_without_pic" <?php checked( $xfavi_skip_products_without_pic, 'on' ); ?> />
							</td>
						</tr>
						<tr class="xfavi_tr">
							<th scope="row"><label for="xfavi_skip_missing_products">
									<?php _e( 'Исключать товары которых нет в наличии', 'xml-for-avito' ); ?> (
									<?php _e( 'за исключением товаров, для которых разрешен предварительный заказ', 'xml-for-avito' ); ?>)
								</label></th>
							<td class="overalldesc">
								<input type="checkbox" name="xfavi_skip_missing_products" id="xfavi_skip_missing_products" <?php checked( $xfavi_skip_missing_products, 'on' ); ?> />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="xfavi_skip_backorders_products">
									<?php _e( 'Исключать из фида товары для предзаказа', 'xml-for-avito' ); ?>
								</label></th>
							<td class="overalldesc">
								<input type="checkbox" name="xfavi_skip_backorders_products" id="xfavi_skip_backorders_products"
									<?php checked( $xfavi_skip_backorders_products, 'on' ); ?> />
							</td>
						</tr>
						<?php do_action( 'xfavi_after_skip_products_without_pic', $this->get_feed_id() ); ?>

						<?php do_action( 'xfavi_after_step_export', $this->get_feed_id() ); ?>

						<?php do_action( 'xfavi_append_main_param_table', $this->get_feed_id() ); ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	} // end get_html_filtration();

	public function get_html_icp_banners() { ?>
		<div id="icp_slides" class="clear">
			<div class="icp_wrap">
				<input type="radio" name="icp_slides" id="icp_point1">
				<input type="radio" name="icp_slides" id="icp_point2">
				<input type="radio" name="icp_slides" id="icp_point3" checked>
				<input type="radio" name="icp_slides" id="icp_point4">
				<input type="radio" name="icp_slides" id="icp_point5">
				<input type="radio" name="icp_slides" id="icp_point6">
				<input type="radio" name="icp_slides" id="icp_point7">
				<div class="icp_slider">
					<div class="icp_slides icp_img1"><a href="//wordpress.org/plugins/yml-for-yandex-market/"
							target="_blank"></a></div>
					<div class="icp_slides icp_img2"><a href="//wordpress.org/plugins/import-products-to-ok-ru/"
							target="_blank"></a></div>
					<div class="icp_slides icp_img3"><a href="//wordpress.org/plugins/xml-for-google-merchant-center/"
							target="_blank"></a></div>
					<div class="icp_slides icp_img4"><a href="//wordpress.org/plugins/gift-upon-purchase-for-woocommerce/"
							target="_blank"></a></div>
					<div class="icp_slides icp_img5"><a href="//wordpress.org/plugins/xml-for-avito/" target="_blank"></a></div>
					<div class="icp_slides icp_img6"><a href="//wordpress.org/plugins/xml-for-o-yandex/" target="_blank"></a>
					</div>
					<div class="icp_slides icp_img7"><a href="//wordpress.org/plugins/import-from-yml/" target="_blank"></a>
					</div>
				</div>
				<div class="icp_control">
					<label for="icp_point1"></label>
					<label for="icp_point2"></label>
					<label for="icp_point3"></label>
					<label for="icp_point4"></label>
					<label for="icp_point5"></label>
					<label for="icp_point6"></label>
					<label for="icp_point7"></label>
				</div>
			</div>
		</div>
	<?php
	} // end get_html_icp_banners()

	public function get_html_my_plugins_list() { ?>
		<div class="metabox-holder">
			<div class="postbox">
				<h2 class="hndle">
					<?php _e( 'My plugins that may interest you', 'xml-for-avito' ); ?>
				</h2>
				<div class="inside">
					<p><span class="xfavi_bold">XML for Google Merchant Center</span> -
						<?php _e( 'Создает XML-фид для загрузки в Google Merchant Center', 'xml-for-avito' ); ?>. <a
							href="https://wordpress.org/plugins/xml-for-google-merchant-center/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="xfavi_bold">YML for Yandex Market</span> -
						<?php _e( 'Создает YML-фид для импорта ваших товаров на Яндекс Маркет', 'xml-for-avito' ); ?>. <a
							href="https://wordpress.org/plugins/yml-for-yandex-market/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="xfavi_bold">Import from YML</span> -
						<?php _e( 'Импортирует товары из YML в ваш магазин', 'xml-for-avito' ); ?>. <a
							href="https://wordpress.org/plugins/import-from-yml/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="xfavi_bold">Integrate myTarget for WooCommerce</span> -
						<?php _e( 'Этот плагин помогает настроить счетчик myTarget для динамического ремаркетинга для WooCommerce', 'xml-for-avito' ); ?>.
						<a href="https://wordpress.org/plugins/wc-mytarget/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="xfavi_bold">XML for Hotline</span> -
						<?php _e( 'Создает XML-фид для импорта ваших товаров на Hotline', 'xml-for-avito' ); ?>. <a
							href="https://wordpress.org/plugins/xml-for-hotline/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="xfavi_bold">Gift upon purchase for WooCommerce</span> -
						<?php _e( 'Этот плагин добавит маркетинговый инструмент, который позволит вам дарить подарки покупателю при покупке', 'xml-for-avito' ); ?>.
						<a href="https://wordpress.org/plugins/gift-upon-purchase-for-woocommerce/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="xfavi_bold">Import products to OK.ru</span> -
						<?php _e( 'С помощью этого плагина вы можете импортировать товары в свою группу на ok.ru', 'xml-for-avito' ); ?>.
						<a href="https://wordpress.org/plugins/import-products-to-ok-ru/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="ip2vk_bold">Import Products to VK</span> -
						<?php _e( 'С помощью этого плагина вы можете импортировать товары в свою группу в VK.com', 'xml-for-avito' ); ?>.
						<a href="https://wordpress.org/plugins/import-products-to-vk/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="xfavi_bold">XML for Avito</span> -
						<?php _e( 'Создает XML-фид для импорта ваших товаров на', 'xml-for-avito' ); ?> Avito. <a
							href="https://wordpress.org/plugins/xml-for-avito/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
					<p><span class="xfavi_bold">XML for O.Yandex (Яндекс Объявления)</span> -
						<?php _e( 'Создает XML-фид для импорта ваших товаров на', 'xml-for-avito' ); ?> Яндекс.Объявления. <a
							href="https://wordpress.org/plugins/xml-for-o-yandex/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>.
					</p>
				</div>
			</div>
		</div>
		<?php
	} // end get_html_my_plugins_list()

	public function admin_head_css_func() {
		/* печатаем css в шапке админки */
		print '<style>/* XML for Avito */
			.metabox-holder .postbox-container .empty-container {height: auto !important;}
			.icp_img1 {background-image: url(' . XFAVI_PLUGIN_DIR_URL . 'img/sl1.jpg);}
			.icp_img2 {background-image: url(' . XFAVI_PLUGIN_DIR_URL . 'img/sl2.jpg);}
			.icp_img3 {background-image: url(' . XFAVI_PLUGIN_DIR_URL . 'img/sl3.jpg);}
			.icp_img4 {background-image: url(' . XFAVI_PLUGIN_DIR_URL . 'img/sl4.jpg);}
			.icp_img5 {background-image: url(' . XFAVI_PLUGIN_DIR_URL . 'img/sl5.jpg);}
			.icp_img6 {background-image: url(' . XFAVI_PLUGIN_DIR_URL . 'img/sl6.jpg);}
			.icp_img7 {background-image: url(' . XFAVI_PLUGIN_DIR_URL . 'img/sl7.jpg);}
		</style>';
	}

	private function init_hooks() {
		// наш класс, вероятно, вызывается во время срабатывания хука admin_menu.
		// admin_init - следующий в очереди срабатывания, хуки раньше admin_menu нет смысла вешать
		// add_action('admin_init', array($this, 'listen_submits'), 10);
		add_action( 'admin_print_footer_scripts', array( $this, 'admin_head_css_func' ) );
	}

	private function get_feed_id() {
		return $this->feed_id;
	}

	private function save_plugin_set( $opt_name, $feed_id, $save_if_empty = false ) {
		if ( isset( $_POST[ $opt_name ] ) ) {
			$opt_val = sanitize_text_field( $_POST[ $opt_name ] );
			$opt_val = apply_filters( 'x4avi_f_save_plugin_set', $opt_val, array( 'opt_name' => $opt_name, 'feed_id' => $feed_id, 'save_if_empty' => $save_if_empty ) );
			xfavi_optionUPD( $opt_name, $opt_val, $feed_id, 'yes', 'set_arr' );
		} else {
			if ( $save_if_empty === true ) {
				xfavi_optionUPD( $opt_name, '0', $feed_id, 'yes', 'set_arr' );
			}
		}
		return;
	}

	private function listen_submit() {
		// массовое удаление фидов по чекбоксу checkbox_xml_file
		if ( isset( $_GET['xfavi_form_id'] ) && ( $_GET['xfavi_form_id'] === 'xfavi_wp_list_table' ) ) {
			if ( is_array( $_GET['checkbox_xml_file'] ) && ! empty( $_GET['checkbox_xml_file'] ) ) {
				if ( $_GET['action'] === 'delete' || $_GET['action2'] === 'delete' ) {
					$checkbox_xml_file_arr = $_GET['checkbox_xml_file'];
					$xfavi_settings_arr = xfavi_optionGET( 'xfavi_settings_arr' );
					for ( $i = 0; $i < count( $checkbox_xml_file_arr ); $i++ ) {
						$feed_id = $checkbox_xml_file_arr[ $i ];
						unset( $xfavi_settings_arr[ $feed_id ] );
						wp_clear_scheduled_hook( 'xfavi_cron_period', array( $feed_id ) ); // отключаем крон
						wp_clear_scheduled_hook( 'xfavi_cron_sborki', array( $feed_id ) ); // отключаем крон
						$upload_dir = (object) wp_get_upload_dir();
						$name_dir = $upload_dir->basedir . "/xml-for-avito";
						//				$filename = $name_dir.'/ids_in_xml.tmp'; if (file_exists($filename)) {unlink($filename);}
						xfavi_remove_directory( $name_dir . '/feed' . $feed_id );
						xfavi_optionDEL( 'xfavi_status_sborki', $i );

						$xfavi_registered_feeds_arr = xfavi_optionGET( 'xfavi_registered_feeds_arr' );
						for ( $n = 1; $n < count( $xfavi_registered_feeds_arr ); $n++ ) { // первый элемент не проверяем, тк. там инфо по последнему id
							if ( $xfavi_registered_feeds_arr[ $n ]['id'] === $feed_id ) {
								unset( $xfavi_registered_feeds_arr[ $n ] );
								$xfavi_registered_feeds_arr = array_values( $xfavi_registered_feeds_arr );
								xfavi_optionUPD( 'xfavi_registered_feeds_arr', $xfavi_registered_feeds_arr );
								break;
							}
						}
					}
					xfavi_optionUPD( 'xfavi_settings_arr', $xfavi_settings_arr );
					$feed_id = xfavi_get_first_feed_id();
				}
			}
		}

		if ( isset( $_GET['feed_id'] ) ) {
			if ( isset( $_GET['action'] ) ) {
				$action = sanitize_text_field( $_GET['action'] );
				switch ( $action ) {
					case 'edit':
						$feed_id = sanitize_text_field( $_GET['feed_id'] );
						break;
					case 'delete':
						$feed_id = sanitize_text_field( $_GET['feed_id'] );
						$xfavi_settings_arr = xfavi_optionGET( 'xfavi_settings_arr' );
						unset( $xfavi_settings_arr[ $feed_id ] );
						wp_clear_scheduled_hook( 'xfavi_cron_period', array( $feed_id ) ); // отключаем крон
						wp_clear_scheduled_hook( 'xfavi_cron_sborki', array( $feed_id ) ); // отключаем крон
						$upload_dir = (object) wp_get_upload_dir();
						$name_dir = $upload_dir->basedir . "/xml-for-avito";
						//				$filename = $name_dir.'/ids_in_xml.tmp'; if (file_exists($filename)) {unlink($filename);}
						xfavi_remove_directory( $name_dir . '/feed' . $feed_id );
						xfavi_optionUPD( 'xfavi_settings_arr', $xfavi_settings_arr );
						xfavi_optionDEL( 'xfavi_status_sborki', $feed_id );
						$xfavi_registered_feeds_arr = xfavi_optionGET( 'xfavi_registered_feeds_arr' );
						for ( $n = 1; $n < count( $xfavi_registered_feeds_arr ); $n++ ) { // первый элемент не проверяем, тк. там инфо по последнему id
							if ( $xfavi_registered_feeds_arr[ $n ]['id'] === $feed_id ) {
								unset( $xfavi_registered_feeds_arr[ $n ] );
								$xfavi_registered_feeds_arr = array_values( $xfavi_registered_feeds_arr );
								xfavi_optionUPD( 'xfavi_registered_feeds_arr', $xfavi_registered_feeds_arr );
								break;
							}
						}

						$feed_id = xfavi_get_first_feed_id();
						break;
					default:
						$feed_id = xfavi_get_first_feed_id();
				}
			} else {
				$feed_id = sanitize_text_field( $_GET['feed_id'] );
			}
		} else {
			$feed_id = xfavi_get_first_feed_id();
		}

		if ( isset( $_REQUEST['xfavi_submit_add_new_feed'] ) ) { // если создаём новый фид
			if ( ! empty( $_POST ) && check_admin_referer( 'xfavi_nonce_action_add_new_feed', 'xfavi_nonce_field_add_new_feed' ) ) {
				$xfavi_settings_arr = xfavi_optionGET( 'xfavi_settings_arr' );

				if ( is_multisite() ) {
					$xfavi_registered_feeds_arr = get_blog_option( get_current_blog_id(), 'xfavi_registered_feeds_arr' );
					$feed_id = $xfavi_registered_feeds_arr[0]['last_id'];
					$feed_id++;
					$xfavi_registered_feeds_arr[0]['last_id'] = (string) $feed_id;
					$xfavi_registered_feeds_arr[] = array( 'id' => (string) $feed_id );
					update_blog_option( get_current_blog_id(), 'xfavi_registered_feeds_arr', $xfavi_registered_feeds_arr );
				} else {
					$xfavi_registered_feeds_arr = get_option( 'xfavi_registered_feeds_arr' );
					$feed_id = $xfavi_registered_feeds_arr[0]['last_id'];
					$feed_id++;
					$xfavi_registered_feeds_arr[0]['last_id'] = (string) $feed_id;
					$xfavi_registered_feeds_arr[] = array( 'id' => (string) $feed_id );
					update_option( 'xfavi_registered_feeds_arr', $xfavi_registered_feeds_arr );
				}

				$upload_dir = (object) wp_get_upload_dir();
				$name_dir = $upload_dir->basedir . '/xml-for-avito/feed' . $feed_id;
				if ( ! is_dir( $name_dir ) ) {
					if ( ! mkdir( $name_dir ) ) {
						error_log( 'ERROR: Ошибка создания папки ' . $name_dir . '; Файл: class-xfavi-settings-page.php; Строка: ' . __LINE__, 0 );
					}
				}

				$def_plugin_date_arr = new XFAVI_Data_Arr();
				$xfavi_settings_arr[ $feed_id ] = $def_plugin_date_arr->get_opts_name_and_def_date( 'all' );

				xfavi_optionUPD( 'xfavi_settings_arr', $xfavi_settings_arr );

				xfavi_optionADD( 'xfavi_status_sborki', '-1', $feed_id );
				xfavi_optionADD( 'xfavi_last_element', '-1', $feed_id );
				print '<div class="updated notice notice-success is-dismissible"><p>' . __( 'Фид добавлен', 'xml-for-avito' ) . '. ID = ' . $feed_id . '.</p></div>';
			}
		}

		$status_sborki = (int) xfavi_optionGET( 'xfavi_status_sborki', $feed_id );

		if ( isset( $_REQUEST['xfavi_submit_action'] ) ) {
			if ( ! empty( $_POST ) && check_admin_referer( 'xfavi_nonce_action', 'xfavi_nonce_field' ) ) {
				do_action( 'xfavi_prepend_submit_action', $feed_id );

				$feed_id = sanitize_text_field( $_POST['xfavi_num_feed_for_save'] );

				$unixtime = (string)current_time( 'timestamp', 1 ); // 1335808087 - временная зона GMT (Unix формат)
				xfavi_optionUPD( 'xfavi_date_save_set', $unixtime, $feed_id, 'yes', 'set_arr' );

				if ( isset( $_POST['xfavi_run_cron'] ) ) {
					$arr_maybe = array( "off", "five_min", "hourly", "six_hours", "twicedaily", "daily", "week" );
					$xfavi_run_cron = sanitize_text_field( $_POST['xfavi_run_cron'] );

					if ( in_array( $xfavi_run_cron, $arr_maybe ) ) {
						xfavi_optionUPD( 'xfavi_status_cron', $xfavi_run_cron, $feed_id, 'yes', 'set_arr' );
						if ( $xfavi_run_cron === 'off' ) {
							// отключаем крон
							wp_clear_scheduled_hook( 'xfavi_cron_period', array( $feed_id ) );
							xfavi_optionUPD( 'xfavi_status_cron', 'off', $feed_id, 'yes', 'set_arr' );

							wp_clear_scheduled_hook( 'xfavi_cron_sborki', array( $feed_id ) );
							xfavi_optionUPD( 'xfavi_status_sborki', '-1', $feed_id );
						} else {
							$recurrence = $xfavi_run_cron;
							wp_clear_scheduled_hook( 'xfavi_cron_period', array( $feed_id ) );
							wp_schedule_event( time(), $recurrence, 'xfavi_cron_period', array( $feed_id ) );
							new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; xfavi_cron_period внесен в список заданий; Файл: class-xfavi-settings-page.php; Строка: ' . __LINE__ );
						}
					} else {
						new XFAVI_Error_Log( 'Крон ' . $xfavi_run_cron . ' не зарегистрирован. Файл: class-xfavi-settings-page.php; Строка: ' . __LINE__ );
					}
				}

				$def_plugin_date_arr = new XFAVI_Data_Arr();
				$opts_name_and_def_date_arr = $def_plugin_date_arr->get_opts_name_and_def_date( 'public' );
				foreach ( $opts_name_and_def_date_arr as $key => $value ) {
					$save_if_empty = false;
					switch ( $key ) {
						case 'xfavi_status_cron':
						case 'xfavip_exclude_cat_arr': // селект категорий в прошке
							continue 2;
						case 'xfavi_var_desc_priority':
						case 'xfavi_one_variable':
						case 'xfavi_skip_missing_products':
						case 'xfavi_skip_backorders_products':
						case 'xfavi_no_default_png_products':
						/* И галки в прошке */
						case 'xfavip_excl_thumb':
						case 'xfavip_one_variable':
						case 'xfavip_del_tags_atr':
						case 'xfavip_use_del_vc':
							if ( ! isset( $_GET['tab'] ) || ( $_GET['tab'] !== 'filtration' ) ) {
								continue 2;
							} else {
								$save_if_empty = true;
							}
							break;
						case 'xfavi_ufup':
							if ( isset( $_GET['tab'] ) && ( $_GET['tab'] !== 'main_tab' ) ) {
								continue 2;
							} else {
								$save_if_empty = true;
							}
							break;
					}
					$this->save_plugin_set( $key, $feed_id, $save_if_empty );
				}

			}
		}

		$this->feed_id = $feed_id;
		return;
	}
}