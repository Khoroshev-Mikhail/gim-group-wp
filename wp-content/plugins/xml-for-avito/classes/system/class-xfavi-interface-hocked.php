<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The main class of the plugin XML for Avito
 *
 * @package			XML for Avito
 * @subpackage		
 * @since			4.5.0
 * 
 * @version			1.0.0 (24-12-2022)
 * @author			Maxim Glazunov
 * @link			https://icopydoc.ru/
 * @see				
 * 
 * @param		
 *
 * @return		
 *
 * @depends			classes:	YFYM_Error_Log
 *					traits:	
 *					methods:	
 *					functions:	common_option_get
 *								common_option_upd
 *					constants:	
 *					options:	
 *
 */

final class XFAVI_Interface_Hoocked {
	public function __construct() {
		$this->init_hooks();
		$this->init_classes();
	}

	public function init_hooks() {
		// индивидуальные опции доставки товара
		// add_action('add_meta_boxes', array($this, 'xfavi_add_custom_box'));
		add_action( 'save_post', array( $this, 'xfavi_save_post_product_function' ), 50, 3 );
		// пришлось юзать save_post вместо save_post_product ибо wc блочит обновы

		// https://wpruse.ru/woocommerce/custom-fields-in-products/
		// https://wpruse.ru/woocommerce/custom-fields-in-variations/
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'xfavi_added_wc_tabs' ), 10, 1 );
		add_action( 'admin_footer', array( $this, 'xfavi_art_added_tabs_icon' ), 10, 1 );
		add_action( 'woocommerce_product_data_panels', array( $this, 'xfavi_art_added_tabs_panel' ), 10, 1 );
		add_action( 'woocommerce_process_product_meta', array( $this, 'xfavi_art_woo_custom_fields_save' ), 10, 1 );

		/* Мета-поля для категорий товаров */
		add_action( "product_cat_edit_form_fields", array( $this, 'xfavi_add_meta_product_cat' ), 10, 1 );
		add_action( 'edited_product_cat', array( $this, 'xfavi_save_meta_product_cat' ), 10, 1 );
		add_action( 'create_product_cat', array( $this, 'xfavi_save_meta_product_cat' ), 10, 1 );
	}

	public function init_classes() {
		return;
	}

	// Сохраняем данные блока, когда пост сохраняется
	function xfavi_save_post_product_function( $post_id, $post, $update ) {
		new XFAVI_Error_Log( 'Стартовала функция xfavi_save_post_product_function! Файл: xml-for-avito.php; Строка: ' . __LINE__ );

		if ( $post->post_type !== 'product' ) {
			return;
		} // если это не товар вукомерц
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		} // если это ревизия
		// проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
		// если это автосохранение ничего не делаем
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// проверяем права юзера
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		// Все ОК. Теперь, нужно найти и сохранить данные
		// Очищаем значение поля input.
		new XFAVI_Error_Log( 'Работает функция xfavi_save_post_product_function! Файл: xml-for-avito.php; Строка: ' . __LINE__ );

		// Убедимся что поле установлено.
		if ( isset( $_POST['_xfavi_condition'] ) ) {
			$xfavi_condition = sanitize_text_field( $_POST['_xfavi_condition'] );
			$xfavi_adType = sanitize_text_field( $_POST['_xfavi_adType'] );
			$xfavi_goods_type = sanitize_text_field( $_POST['_xfavi_goods_type'] );
			$xfavi_goods_subtype = sanitize_text_field( $_POST['_xfavi_goods_subtype'] );
			$xfavi_apparel = sanitize_text_field( $_POST['_xfavi_apparel'] );
			$xfavi_appareltype = sanitize_text_field( $_POST['_xfavi_appareltype'] );
			$xfavi_product_sub_type = sanitize_text_field( $_POST['_xfavi_product_sub_type'] );
			$xfavi_forwhom = sanitize_text_field( $_POST['_xfavi_forwhom'] );
			$xfavi_mechanism = sanitize_text_field( $_POST['_xfavi_mechanism'] );
			$xfavi_material = sanitize_text_field( $_POST['_xfavi_material'] );
			$xfavi_color = sanitize_text_field( $_POST['_xfavi_color'] );
			$xfavi_oem = sanitize_text_field( $_POST['_xfavi_oem'] );
			$xfavi_product_name = sanitize_text_field( $_POST['_xfavi_product_name'] );


			// Обновляем данные в базе данных
			update_post_meta( $post_id, '_xfavi_condition', $xfavi_condition );
			update_post_meta( $post_id, '_xfavi_adType', $xfavi_adType );
			update_post_meta( $post_id, '_xfavi_goods_type', $xfavi_goods_type );
			update_post_meta( $post_id, '_xfavi_goods_subtype', $xfavi_goods_subtype );
			update_post_meta( $post_id, '_xfavi_apparel', $xfavi_apparel );
			update_post_meta( $post_id, '_xfavi_appareltype', $xfavi_appareltype );
			update_post_meta( $post_id, '_xfavi_product_sub_type', $xfavi_product_sub_type );
			update_post_meta( $post_id, '_xfavi_forwhom', $xfavi_forwhom );
			update_post_meta( $post_id, '_xfavi_mechanism', $xfavi_mechanism );
			update_post_meta( $post_id, '_xfavi_material', $xfavi_material );
			update_post_meta( $post_id, '_xfavi_color', $xfavi_color );
			update_post_meta( $post_id, '_xfavi_oem', $xfavi_oem );
			update_post_meta( $post_id, '_xfavi_product_name', $xfavi_product_name );
		}

		// нужно ли запускать обновление фида при перезаписи файла
		$xfavi_settings_arr = xfavi_optionGET( 'xfavi_settings_arr' );
		$xfavi_settings_arr_keys_arr = array_keys( $xfavi_settings_arr );
		for ( $i = 0; $i < count( $xfavi_settings_arr_keys_arr ); $i++ ) {
			$feed_id = $xfavi_settings_arr_keys_arr[ $i ];

			new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; Шаг $i = ' . $i . ' цикла по формированию кэша файлов; Файл: xml-for-avito.php; Строка: ' . __LINE__ );

			$result_get_unit_obj = new XFAVI_Get_Unit( $post_id, $feed_id ); // формируем фид товара
			$result_xml = $result_get_unit_obj->get_result();
			$ids_in_xml = $result_get_unit_obj->get_ids_in_xml();

			xfavi_wf( $result_xml, $post_id, $feed_id, $ids_in_xml ); // записываем кэш-файл

			$xfavi_ufup = xfavi_optionGET( 'xfavi_ufup', $feed_id, 'set_arr' );
			if ( $xfavi_ufup !== 'on' ) {
				continue; /*return;*/
			}
			$status_sborki = (int) xfavi_optionGET( 'xfavi_status_sborki', $feed_id );
			if ( $status_sborki > -1 ) {
				continue; /*return;*/
			} // если идет сборка фида - пропуск

			$xfavi_date_save_set = xfavi_optionGET( 'xfavi_date_save_set', $feed_id, 'set_arr' );
			$xfavi_date_sborki = xfavi_optionGET( 'xfavi_date_sborki', $feed_id, 'set_arr' );

			// !! т.к у нас работа с array_keys, то в $feed_id может быть int, а не string значит двойное равенство лучше
			if ( $feed_id == '1' ) {
				$prefFeed = '';
			} else {
				$prefFeed = $feed_id;
			}
			if ( is_multisite() ) {
				/**
				 *	wp_get_upload_dir();
				 *   'path'    => '/home/site.ru/public_html/wp-content/uploads/2016/04',
				 *	'url'     => 'http://site.ru/wp-content/uploads/2016/04',
				 *	'subdir'  => '/2016/04',
				 *	'basedir' => '/home/site.ru/public_html/wp-content/uploads',
				 *	'baseurl' => 'http://site.ru/wp-content/uploads',
				 *	'error'   => false,
				 */
				$upload_dir = (object) wp_get_upload_dir();
				$filenamefeed = $upload_dir->basedir . "/xml-for-avito/" . $prefFeed . "feed-avito-" . get_current_blog_id() . ".xml";
			} else {
				$upload_dir = (object) wp_get_upload_dir();
				$filenamefeed = $upload_dir->basedir . "/xml-for-avito/" . $prefFeed . "feed-avito-0.xml";
			}
			if ( ! file_exists( $filenamefeed ) ) {
				new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; WARNING: Файла filenamefeed = ' . $filenamefeed . ' не существует! Пропускаем быструю сборку; Файл: xml-for-avito.php; Строка: ' . __LINE__ );
				continue;
			} // файла с фидом нет

			clearstatcache(); // очищаем кэш дат файлов
			$last_upd_file = filemtime( $filenamefeed );
			new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; $xfavi_date_save_set=' . $xfavi_date_save_set . ';$filenamefeed=' . $filenamefeed, 0 );
			new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; Начинаем сравнивать даты! Файл: xml-for-avito.php; Строка: ' . __LINE__ );
			if ( $xfavi_date_save_set > $last_upd_file ) {
				// настройки фида сохранялись позже, чем создан фид		
				// нужно полностью пересобрать фид
				new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; NOTICE: Настройки фида сохранялись позже, чем создан фид; Файл: xml-for-avito.php; Строка: ' . __LINE__ );
				$arr_maybe = array( 'off', 'five_min', 'hourly', 'six_hours', 'twicedaily', 'daily', 'week' );
				$xfavi_run_cron = xfavi_optionGET( 'xfavi_status_cron', $feed_id, 'set_arr' );
				if ( in_array( $xfavi_run_cron, $arr_maybe ) ) {
					if ( $xfavi_run_cron === 'off' ) {
					} else {
						$feedid = (string) $feed_id; // для правильности работы важен тип string!
						$recurrence = $xfavi_run_cron;
						wp_clear_scheduled_hook( 'xfavi_cron_period', array( $feedid ) );
						wp_schedule_event( time(), $recurrence, 'xfavi_cron_period', array( $feedid ) );
						new XFAVI_Error_Log( 'FEED № ' . $feedid . '; Для полной пересборки после быстрого сохранения xfavi_cron_period внесен в список заданий; Файл: xml-for-avito.php; Строка: ' . __LINE__ );
					}
				} else {
					new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; ERROR: Крон ' . $xfavi_run_cron . ' не зарегистрирован. Файл: xml-for-avito.php; Строка: ' . __LINE__ );
				}
			} else { // нужно лишь обновить цены	
				$feed_id = (string) $feed_id;
				new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; NOTICE: Настройки фида сохранялись раньше, чем создан фид. Нужно лишь обновить цены; Файл: xml-for-avito.php; Строка: ' . __LINE__ );
				$generation = new XFAVI_Generation_XML( $feed_id );
				$generation->clear_file_ids_in_xml( $feed_id );
				$generation->onlygluing();
			}
		}
		return;
	}
	public static function xfavi_added_wc_tabs( $tabs ) {
		$tabs['xfavi_special_panel'] = array(
			'label' => __( 'Avito', 'xml-for-avito' ), // название вкладки
			'target' => 'xfavi_added_wc_tabs', // идентификатор вкладки
			'class' => array( 'hide_if_grouped' ), // классы управления видимостью вкладки в зависимости от типа товара
			'priority' => 70, // приоритет вывода
		);
		return $tabs;
	}

	public static function xfavi_art_added_tabs_icon() {
		// https://rawgit.com/woothemes/woocommerce-icons/master/demo.html 
		?>
		<style>
			#woocommerce-coupon-data ul.wc-tabs li.xfavi_special_panel_options a::before,
			#woocommerce-product-data ul.wc-tabs li.xfavi_special_panel_options a::before,
			.woocommerce ul.wc-tabs li.xfavi_special_panel_options a::before {
				font-family: WooCommerce;
				content: "\e014";
			}
		</style>
		<?php
	}

	public static function xfavi_art_added_tabs_panel() {
		global $post; ?>
		<div id="xfavi_added_wc_tabs" class="panel woocommerce_options_panel">
			<?php do_action( 'xfavi_before_options_group', $post ); ?>
			<div class="options_group">
				<h2><strong>
						<?php _e( 'Индивидуальные настройки товара для XML фида для Avito', 'xml-for-avito' ); ?>
					</strong></h2>
				<?php do_action( 'xfavi_prepend_options_group', $post ); ?>
				<?php
				woocommerce_wp_select( array(
					'id' => '_xfavi_condition',
					'label' => __( 'Состояние товара', 'xml-for-avito' ),
					'placeholder' => '1',
					'description' => __( 'Обязательный элемент', 'xml-for-avito' ) . ' <strong>Condition</strong>',
					'options' => array(
						'new' => __( 'Новый', 'xml-for-avito' ),
						'bu' => __( 'Б/у', 'xml-for-avito' ),
					),
				) );
				woocommerce_wp_select( array(
					'id' => '_xfavi_adType',
					'label' => __( 'AdType', 'xml-for-avito' ),
					'placeholder' => '1',
					'description' => __( 'Обязателен для форматов "Для дома и дачи" и "Личные вещи"', 'xml-for-avito' ),
					'options' => array(
						'default' => __( 'По умолчанию', 'xml-for-avito' ),
						'disabled' => __( 'Отключено', 'xml-for-avito' ),
						'Товар приобретен на продажу' => __( 'Товар приобретен на продажу', 'xml-for-avito' ),
						'Товар от производителя' => __( 'Товар от производителя', 'xml-for-avito' ),
						'Продаю своё' => __( 'Продаю своё', 'xml-for-avito' ),
					),
				) ); ?>
				<p class="form-field _xfavi_goods_type">
					<label for="xfavi_goods_type">
						<?php _e( 'Тип товара', 'xml-for-avito' ); ?>
					</label><select name="_xfavi_goods_type" id="_xfavi_goods_type" class="select short">
						<?php $xfavi_goods_type = esc_attr( get_post_meta( $post->ID, '_xfavi_goods_type', 1 ) ); ?>
						<option value="default" <?php selected( $xfavi_goods_type, 'default' ); ?>><?php _e( 'По умолчанию', 'xml-for-avito' ); ?></option>
						<option value="disabled" <?php selected( $xfavi_goods_type, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
						<?php echo xfavi_option_construct_product( $post );

						/*xfavi_category_goods_type(2, $xfavi_goods_type);*/?>
					</select><span class="description">
						<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>GoodsType</strong> / <strong>Breed</strong> /
						<strong>TypeId</strong> / <strong>VehicleType</strong>. <a href="//autoload.avito.ru/format/"
							target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>
					</span>
				</p>
				<p class="form-field _xfavi_goods_subtype">
					<label for="xfavi_goods_subtype">
						<?php _e( 'Тип товара', 'xml-for-avito' ); ?>
					</label><select name="_xfavi_goods_subtype" id="_xfavi_goods_subtype" class="select short">
						<?php $xfavi_goods_subtype = esc_attr( get_post_meta( $post->ID, '_xfavi_goods_subtype', 1 ) ); ?>
						<option value="default" <?php selected( $xfavi_goods_subtype, 'default' ); ?>><?php _e( 'По умолчанию', 'xml-for-avito' ); ?></option>
						<option value="Ворота, заборы и ограждения" <?php selected( $xfavi_goods_subtype, 'Ворота, заборы и ограждения' ); ?>><?php _e( 'Ворота, заборы и ограждения', 'xml-for-avito' ); ?></option>
						<option value="Железобетонные изделия" <?php selected( $xfavi_goods_subtype, 'Железобетонные изделия' ); ?>><?php _e( 'Железобетонные изделия', 'xml-for-avito' ); ?></option>
						<option value="Изоляция" <?php selected( $xfavi_goods_subtype, 'Изоляция' ); ?>><?php _e( 'Изоляция', 'xml-for-avito' ); ?></option>
						<option value="Кровля и водосток" <?php selected( $xfavi_goods_subtype, 'Кровля и водосток' ); ?>><?php _e( 'Кровля и водосток', 'xml-for-avito' ); ?></option>
						<option value="Лаки и краски" <?php selected( $xfavi_goods_subtype, 'Лаки и краски' ); ?>><?php _e( 'Лаки и краски', 'xml-for-avito' ); ?></option>
						<option value="Листовые материалы" <?php selected( $xfavi_goods_subtype, 'Листовые материалы' ); ?>>
							<?php _e( 'Листовые материалы', 'xml-for-avito' ); ?></option>
						<option value="Лестницы и комплектующие" <?php selected( $xfavi_goods_subtype, 'Лестницы и комплектующие' ); ?>><?php _e( 'Лестницы и комплектующие', 'xml-for-avito' ); ?></option>
						<option value="Металлопрокат" <?php selected( $xfavi_goods_subtype, 'Металлопрокат' ); ?>><?php _e( 'Металлопрокат', 'xml-for-avito' ); ?></option>
						<option value="Общестроительные материалы" <?php selected( $xfavi_goods_subtype, 'Общестроительные материалы' ); ?>><?php _e( 'Общестроительные материалы', 'xml-for-avito' ); ?></option>
						<option value="Отделка" <?php selected( $xfavi_goods_subtype, 'Отделка' ); ?>><?php _e( 'Отделка', 'xml-for-avito' ); ?></option>
						<option value="Пиломатериалы" <?php selected( $xfavi_goods_subtype, 'Пиломатериалы' ); ?>><?php _e( 'Пиломатериалы', 'xml-for-avito' ); ?></option>
						<option value="Сваи" <?php selected( $xfavi_goods_subtype, 'Сваи' ); ?>><?php _e( 'Сваи', 'xml-for-avito' ); ?></option>
						<option value="Строительные смеси" <?php selected( $xfavi_goods_subtype, 'Строительные смеси' ); ?>>
							<?php _e( 'Строительные смеси', 'xml-for-avito' ); ?></option>
						<option value="Строительство стен" <?php selected( $xfavi_goods_subtype, 'Строительство стен' ); ?>>
							<?php _e( 'Строительство стен', 'xml-for-avito' ); ?></option>
						<option value="Сыпучие материалы" <?php selected( $xfavi_goods_subtype, 'Сыпучие материалы' ); ?>><?php _e( 'Сыпучие материалы', 'xml-for-avito' ); ?></option>
						<option value="Электрика" <?php selected( $xfavi_goods_subtype, 'Электрика' ); ?>><?php _e( 'Электрика', 'xml-for-avito' ); ?></option>
						<option value="Телевизоры" <?php selected( $xfavi_goods_subtype, 'Телевизоры' ); ?>><?php _e( 'Телевизоры', 'xml-for-avito' ); ?></option>
						<option value="Проекторы" <?php selected( $xfavi_goods_subtype, 'Проекторы' ); ?>><?php _e( 'Проекторы', 'xml-for-avito' ); ?></option>
						<option value="Другое" <?php selected( $xfavi_goods_subtype, 'Другое' ); ?>><?php _e( 'Другое', 'xml-for-avito' ); ?></option>
					</select><span class="description">
						<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>GoodsSubType</strong> /
						<strong>ProductsType</strong>.
						<a href="//autoload.avito.ru/format/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>
					</span>
				</p>
				<p class="form-field _xfavi_apparel">
					<label for="_xfavi_apparel">Apparel</label><select name="_xfavi_apparel" id="_xfavi_apparel"
						class="select short">
						<?php $xfavi_apparel = esc_attr( get_post_meta( $post->ID, '_xfavi_apparel', 1 ) ); ?>
						<option value="default" <?php selected( $xfavi_apparel, 'default' ); ?>><?php _e( 'По умолчанию', 'xml-for-avito' ); ?></option>
						<option value="disabled" <?php selected( $xfavi_apparel, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
						<?php echo xfavi_category_goods_type( 3, $xfavi_apparel ); ?>
					</select><span class="description">
						<?php _e( 'Обязательный элемент для Одежды, обуви, аксессуаров', 'xml-for-avito' ); ?>
						<strong>Apparel</strong>. <a href="//autoload.avito.ru/format/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>
					</span>
				</p>
				<p class="form-field _xfavi_appareltype">
					<label for="_xfavi_appareltype">ApparelType</label><select name="_xfavi_appareltype" id="_xfavi_appareltype"
						class="select short">
						<?php $xfavi_apparel = esc_attr( get_post_meta( $post->ID, '_xfavi_appareltype', 1 ) ); ?>
						<option value="default" <?php selected( $xfavi_apparel, 'default' ); ?>><?php _e( 'По умолчанию', 'xml-for-avito' ); ?></option>
						<option value="disabled" <?php selected( $xfavi_apparel, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
						<?php echo xfavi_category_goods_type( 4, $xfavi_apparel ); ?>
					</select><span class="description">
						<?php _e( 'Подтип товара (для верхней одежды)', 'xml-for-avito' ); ?> <strong>ApparelType</strong>. <a
							href="//autoload.avito.ru/format/" target="_blank">
							<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
						</a>
					</span>
				</p>
				<?php
				woocommerce_wp_text_input( [ 
					'id' => '_xfavi_product_sub_type',
					'label' => 'ProductSubType',
					'description' => sprintf( '%s <strong>ProductSubType</strong>. %s',
						__( 'Элемент', 'xml-for-avito' ),
						__( 'используется в подкатегории "Часы"', 'xml-for-avito' )
					),
					'type' => 'text',
				] );

				woocommerce_wp_select( [ 
					'id' => '_xfavi_forwhom',
					'label' => __( 'Для кого', 'xml-for-avito' ),
					'description' => __( 'Элемент', 'xml-for-avito' ) . ' <strong>forwhom</strong>',
					'options' => [ 
						'' => __( 'Отключено', 'xml-for-avito' ),
						'Женские' => __( 'Женские', 'xml-for-avito' ),
						'Мужские' => __( 'Мужские', 'xml-for-avito' ),
						'Унисекс' => __( 'Унисекс', 'xml-for-avito' ),
						'Детские' => __( 'Детские', 'xml-for-avito' )
					],
				] );

				woocommerce_wp_select( [ 
					'id' => '_xfavi_mechanism',
					'label' => __( 'Механизм', 'xml-for-avito' ),
					'description' => __( 'Элемент', 'xml-for-avito' ) . ' <strong>Mechanism</strong>',
					'options' => [ 
						'' => __( 'Отключено', 'xml-for-avito' ),
						'Кварцевые' => __( 'Кварцевые', 'xml-for-avito' ),
						'Механические' => __( 'Механические', 'xml-for-avito' ),
						'Электронные' => __( 'Электронные', 'xml-for-avito' ),
						'Другие' => __( 'Другие', 'xml-for-avito' )
					],
				] );

				woocommerce_wp_text_input( [ 
					'id' => '_xfavi_material',
					'label' => __( 'Материал', 'xml-for-avito' ),
					'description' => sprintf( '%s <strong>Material</strong>. %s',
						__( 'Элемент', 'xml-for-avito' ),
						__( 'используется в подкатегории "Сумки"', 'xml-for-avito' )
					),
					'type' => 'text',
				] );

				woocommerce_wp_select( [ 
					'id' => '_xfavi_color',
					'label' => __( 'Цвет', 'xml-for-avito' ),
					'description' => __( 'Элемент', 'xml-for-avito' ) . ' <strong>Color</strong>',
					'options' => [ 
						'disabled' => __( 'Отключено', 'xml-for-avito' ),
						'Серый' => __( 'Серый', 'xml-for-avito' ),
						'Синий' => __( 'Синий', 'xml-for-avito' ),
						'Бежевый' => __( 'Бежевый', 'xml-for-avito' ),
						'Чёрный' => __( 'Чёрный', 'xml-for-avito' ),
						'Коричневый' => __( 'Коричневый', 'xml-for-avito' ),
						'Белый' => __( 'Белый', 'xml-for-avito' ),
						'Зелёный' => __( 'Зелёный', 'xml-for-avito' ),
						'Красный' => __( 'Красный', 'xml-for-avito' ),
						'Розовый' => __( 'Розовый', 'xml-for-avito' ),
						'Разноцветный' => __( 'Разноцветный', 'xml-for-avito' ),
						'Фиолетовый' => __( 'Фиолетовый', 'xml-for-avito' ),
						'Голубой' => __( 'Голубой', 'xml-for-avito' ),
						'Оранжевый' => __( 'Оранжевый', 'xml-for-avito' ),
						'Жёлтый' => __( 'Жёлтый', 'xml-for-avito' ),
						'Серебряный' => __( 'Серебряный', 'xml-for-avito' ),
						'Золотой' => __( 'Золотой', 'xml-for-avito' ),
						'Бордовый' => __( 'Бордовый', 'xml-for-avito' )
					],
				] );

				woocommerce_wp_text_input( [ 
					'id' => '_xfavi_oem',
					'label' => __( 'Номер детали OEM', 'xml-for-avito' ),
					'description' => __( 'Элемент', 'xml-for-avito' ) . ' <strong>OEM</strong> ' . __( 'используется только в подкатегории "Запчасти"', 'xml-for-avito' ),
					'type' => 'text',
				] );

				woocommerce_wp_text_input( [ 
					'id' => '_xfavi_product_name',
					'label' => __( 'Имя товара для Авито', 'xml-for-avito' ),
					'description' => __( 'При помощи этого поля можно изменить название товара в фиде', 'xml-for-avito' ),
					'type' => 'text',
					'custom_attributes' => [ 'maxlength' => 50 ]
				] );

				do_action( 'xfavi_append_options_group', $post ); ?>
			</div>
			<?php do_action( 'xfavi_after_options_group', $post ); ?>
		</div>
		<?php
	}

	public static function xfavi_art_woo_custom_fields_save( $post_id ) {
		// Сохранение текстового поля
		if ( isset( $_POST['_xfavi_condition'] ) ) {
			update_post_meta( $post_id, '_xfavi_condition', sanitize_text_field( $_POST['_xfavi_condition'] ) );
		}
		if ( isset( $_POST['_xfavi_custom'] ) ) {
			update_post_meta( $post_id, '_xfavi_custom', sanitize_text_field( $_POST['_xfavi_custom'] ) );
		}
		do_action( 'xfavi_process_product_meta_save', $post_id );
	}

	public static function xfavi_add_meta_product_cat( $term ) { ?>
		<tr class="form-field term-parent-wrap">
			<th scope="row" valign="top"><label>
					<?php _e( 'Обрабатывать согласно правилам Авито', 'xml-for-avito' ); ?>
				</label></th>
			<td>
				<select name="xfavi_cat_meta[xfavi_avito_standart]" id="xfavi_avito_standart">
					<?php $xfavi_avito_standart = esc_attr( get_term_meta( $term->term_id, 'xfavi_avito_standart', 1 ) ); ?>
					<option value="" <?php selected( $xfavi_avito_standart, '' ); ?> disabled="disabled"><?php _e( 'Не задано. Задайте', 'xml-for-avito' ); ?>!</option>
					<option value="dom" <?php selected( $xfavi_avito_standart, 'dom' ); ?>><?php _e( 'Для дома и дачи', 'xml-for-avito' ); ?></option>
					<option value="tehnika" <?php selected( $xfavi_avito_standart, 'tehnika' ); ?>><?php _e( 'Электроника', 'xml-for-avito' ); ?></option>
					<option value="business" <?php selected( $xfavi_avito_standart, 'business' ); ?>><?php _e( 'Для бизнеса', 'xml-for-avito' ); ?></option>
					<option value="lichnye_veshi" <?php selected( $xfavi_avito_standart, 'lichnye_veshi' ); ?>><?php _e( 'Личные вещи', 'xml-for-avito' ); ?></option>
					<option value="zhivotnye" <?php selected( $xfavi_avito_standart, 'zhivotnye' ); ?>><?php _e( 'Животные', 'xml-for-avito' ); ?></option>
					<option value="zapchasti" <?php selected( $xfavi_avito_standart, 'zapchasti' ); ?>><?php _e( 'Запчасти и аксессуары', 'xml-for-avito' ); ?> (<?php _e( 'кроме', 'xml-for-avito' ); ?> "<?php _e( 'Шины, диски и колёса', 'xml-for-avito' ); ?>")</option>
					<option value="hobby" <?php selected( $xfavi_avito_standart, 'hobby' ); ?>><?php _e( 'Хобби и отдых', 'xml-for-avito' ); ?></option>
				</select><br /><label>AdType:</label><br />
				<select name="xfavi_cat_meta[xfavi_adType]" id="xfavi_adType">
					<?php $xfavi_adType = esc_attr( get_term_meta( $term->term_id, 'xfavi_adType', 1 ) ); ?>
					<option data-chained="zapchasti" value="Товар приобретен на продажу" <?php selected( $xfavi_adType, 'Товар приобретен на продажу' ); ?>><?php _e( 'Товар приобретен на продажу', 'xml-for-avito' ); ?></option>
					<option data-chained="zapchasti" value="Товар от производителя" <?php selected( $xfavi_adType, 'Товар от производителя' ); ?>><?php _e( 'Товар от производителя', 'xml-for-avito' ); ?></option>
					<option data-chained="hobby" value="Товар приобретен на продажу" <?php selected( $xfavi_adType, 'Товар приобретен на продажу' ); ?>><?php _e( 'Товар приобретен на продажу', 'xml-for-avito' ); ?></option>
					<option data-chained="hobby" value="Товар от производителя" <?php selected( $xfavi_adType, 'Товар от производителя' ); ?>><?php _e( 'Товар от производителя', 'xml-for-avito' ); ?></option>
					<!-- option data-chained="tehnika" value="disabled" <?php selected( $xfavi_adType, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option -->
					<option data-chained="tehnika" value="Товар приобретен на продажу" <?php selected( $xfavi_adType, 'Товар приобретен на продажу' ); ?>><?php _e( 'Товар приобретен на продажу', 'xml-for-avito' ); ?></option>
					<option data-chained="tehnika" value="Продаю своё" <?php selected( $xfavi_adType, 'Продаю своё' ); ?>><?php _e( 'Продаю своё', 'xml-for-avito' ); ?></option>
					<option data-chained="zhivotnye" value="disabled" <?php selected( $xfavi_adType, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
					<option data-chained="business" value="disabled" <?php selected( $xfavi_adType, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
					<option data-chained="lichnye_veshi" value="Товар приобретен на продажу" <?php selected( $xfavi_adType, 'Товар приобретен на продажу' ); ?>><?php _e( 'Товар приобретен на продажу', 'xml-for-avito' ); ?>
					</option>
					<option data-chained="lichnye_veshi" value="Товар от производителя" <?php selected( $xfavi_adType, 'Товар от производителя' ); ?>><?php _e( 'Товар от производителя', 'xml-for-avito' ); ?></option>
					<option data-chained="dom" value="Товар приобретен на продажу" <?php selected( $xfavi_adType, 'Товар приобретен на продажу' ); ?>><?php _e( 'Товар приобретен на продажу', 'xml-for-avito' ); ?></option>
					<option data-chained="dom" value="Товар от производителя" <?php selected( $xfavi_adType, 'Товар от производителя' ); ?>><?php _e( 'Товар от производителя', 'xml-for-avito' ); ?></option>
				</select><br />
				<p class="description">
					<?php _e( 'Укажите по каким правилам будут обрабатываться товары из данной категории', 'xml-for-avito' ); ?>.
					<a href="//autoload.avito.ru/format/" target="_blank">
						<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
					</a>
				</p>
			</td>
		</tr>
		<?php $result_arr = xfavi_option_construct( $term ); ?>
		<tr class="form-field term-parent-wrap">
			<th scope="row" valign="top"><label>
					<?php _e( 'Авито', 'xml-for-avito' ); ?> Category
				</label></th>
			<td>
				<select name="xfavi_cat_meta[xfavi_avito_product_category]" id="xfavi_avito_product_category">
					<?php $xfavi_goods_type = esc_attr( get_term_meta( $term->term_id, '_xfavi_goods_type', 1 ) ); ?>
					<option value="" <?php selected( $xfavi_goods_type, '' ); ?> disabled="disabled"><?php _e( 'Не задано. Задайте', 'xml-for-avito' ); ?>!</option>
					<?php echo $result_arr[0]; ?>
				</select><br />
				<p class="description">
					<?php _e( 'Обязательный элемент', 'xml-for-avito' ); ?> <strong>Category</strong>. <a
						href="//autoload.avito.ru/format/" target="_blank">
						<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
					</a><br /><strong>
						<?php _e( 'Внимание', 'xml-for-avito' ); ?>!
					</strong>
					<?php _e( 'Если выпадающий список пуст, то сначала измените значение опции', 'xml-for-avito' ); ?> "
					<?php _e( 'Обрабатывать согласно правилам Авито', 'xml-for-avito' ); ?>".
					<?php _e( 'Укажите какой категори на Авито соответствует данная категория', 'xml-for-avito' ); ?>.
				</p>
			</td>
		</tr>
		<tr class="form-field term-parent-wrap">
			<th scope="row" valign="top"><label>
					<?php _e( 'Авито', 'xml-for-avito' ); ?>:<br />- GoodsType<br />- Breed*<br />- TypeId**<br />-
					VehicleType***
				</label></th>
			<td>
				<select name="xfavi_cat_meta[xfavi_default_goods_type]" id="xfavi_default_goods_type">
					<option value="disabled">
						<?php _e( 'Отключено', 'xml-for-avito' ); ?>
					</option>
					<?php echo $result_arr[1]; ?>
				</select><br />
				<p class="description">
					<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>GoodsType</strong> / <strong>Breed</strong> /
					<strong>TypeId</strong> / <strong>VehicleType</strong>. <a href="//autoload.avito.ru/format/"
						target="_blank">
						<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
					</a><br />
					*Breed -
					<?php _e( 'Если Авито Category "Собаки" или "Кошки"', 'xml-for-avito' ); ?><br />
					**TypeId -
					<?php _e( 'Если Авито Category "Запчасти и аксессуары"', 'xml-for-avito' ); ?><br />
					***VehicleType -
					<?php _e( 'Если Авито Category "Велосипеды"', 'xml-for-avito' ); ?>
				</p>
			</td>
		</tr>
		<tr class="form-field term-parent-wrap">
			<th scope="row" valign="top"><label>
					<?php _e( 'Авито', 'xml-for-avito' ); ?> GoodsSubType / ProductsType
				</label></label></th>
			<td>
				<select name="xfavi_cat_meta[xfavi_default_goods_subtype]" id="xfavi_default_goods_subtype">
					<option value="disabled">
						<?php _e( 'Отключено', 'xml-for-avito' ); ?>
					</option>
					<?php echo $result_arr[2]; ?>
				</select><br />
				<p class="description">
					<?php _e( 'Элемент', 'xml-for-avito' ); ?> <strong>GoodsSubType</strong> / <strong>ProductsType</strong>. <a
						href="//autoload.avito.ru/format/" target="_blank">
						<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
					</a>
				</p>
			</td>
		</tr>
		<tr class="form-field term-parent-wrap">
			<th scope="row" valign="top"><label>
					<?php _e( 'Apparel', 'xml-for-avito' ); ?>
				</label></th>
			<td>
				<select name="xfavi_cat_meta[xfavi_default_apparel]" id="xfavi_default_apparel">
					<?php $xfavi_default_apparel = esc_attr( get_term_meta( $term->term_id, 'xfavi_default_apparel', 1 ) ); ?>
					<option value="disabled" <?php selected( $xfavi_default_apparel, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
					<?php echo xfavi_category_goods_type( 3, $xfavi_default_apparel ); ?>
				</select><br />
				<p class="description">
					<?php _e( 'Обязательный элемент для Одежды, обуви, аксессуаров', 'xml-for-avito' ); ?>
					<strong>Apparel</strong>. <a href="//autoload.avito.ru/format/" target="_blank">
						<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
					</a>
				</p>
			</td>
		</tr>
		<tr class="form-field term-parent-wrap">
			<th scope="row" valign="top"><label>
					<?php _e( 'ApparelType', 'xml-for-avito' ); ?>
				</label></th>
			<td>
				<select name="xfavi_cat_meta[xfavi_default_appareltype]" id="xfavi_default_appareltype">
					<?php $xfavi_default_appareltype = esc_attr( get_term_meta( $term->term_id, 'xfavi_default_appareltype', 1 ) ); ?>
					<option value="disabled" <?php selected( $xfavi_default_appareltype, 'disabled' ); ?>><?php _e( 'Отключено', 'xml-for-avito' ); ?></option>
					<?php echo xfavi_category_goods_type( 4, $xfavi_default_appareltype ); ?>
				</select><br />
				<p class="description">
					<?php _e( 'Подтип товара (для верхней одежды)', 'xml-for-avito' ); ?> <strong>ApparelType</strong>. <a
						href="//autoload.avito.ru/format/" target="_blank">
						<?php _e( 'Подробнее', 'xml-for-avito' ); ?>
					</a>
				</p>
			</td>
		</tr>
		<script type="text/javascript">jQuery(document).ready(function () {
				/* https://github.com/tuupola/jquery_chained or $("#series").chainedTo("#mark"); */
				jQuery("#xfavi_adType").chained("#xfavi_avito_standart");
				jQuery("#xfavi_avito_product_category").chained("#xfavi_avito_standart");
				jQuery("#xfavi_default_goods_type").chained("#xfavi_avito_product_category");
				jQuery("#xfavi_default_goods_subtype").chained("#xfavi_default_goods_type");
			});</script>
		<?php
	}
	/* Сохранение данных в БД */
	function xfavi_save_meta_product_cat( $term_id ) {
		if ( ! isset( $_POST['xfavi_cat_meta'] ) ) {
			return;
		}
		$xfavi_cat_meta = array_map( 'sanitize_text_field', $_POST['xfavi_cat_meta'] );
		foreach ( $xfavi_cat_meta as $key => $value ) {
			if ( empty( $value ) ) {
				delete_term_meta( $term_id, $key );
				continue;
			}
			update_term_meta( $term_id, $key, $value );
		}
		return $term_id;
	}


	private function save_post_meta( $post_meta_arr, $post_id ) {
		for ( $i = 0; $i < count( $post_meta_arr ); $i++ ) {
			$meta_name = $post_meta_arr[ $i ];
			if ( isset( $_POST[ $meta_name ] ) ) {
				update_post_meta( $post_id, $meta_name, sanitize_text_field( $_POST[ $meta_name ] ) );
			}
		}
	}
} // end class XFAVI_Interface_Hoocked