<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Starts feed generation
 *
 * @link       https://icopydoc.ru/
 * @since      1.6.0
 */

class XFAVI_Generation_XML {
	private $pref = 'xfavi';
	protected $feed_id;
	protected $result_xml = '';

	public function __construct( $feed_id ) {
		$this->feed_id = $feed_id;
	}

	public function write_file( $result_xml, $cc ) {
		$filename = urldecode( xfavi_optionGET( 'xfavi_file_file', $this->get_feed_id(), 'set_arr' ) );
		if ( $this->get_feed_id() === '1' ) {
			$prefFeed = '';
		} else {
			$prefFeed = $this->get_feed_id();
		}

		if ( $filename == '' ) {
			$filename = XFAVI_SITE_UPLOADS_DIR_PATH . "/" . $prefFeed . "feed-yml-0-tmp.xml";
		}
		if ( file_exists( $filename ) ) { // файл есть
			if ( ! $handle = fopen( $filename, $cc ) ) {
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Не могу открыть файл ' . $filename . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
			}
			if ( fwrite( $handle, $result_xml ) === FALSE ) {
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Не могу произвести запись в файл ' . $handle . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
			} else {
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Ура! Записали; Файл: Файл: class-generation-xml.php; Строка: ' . __LINE__ );
				return true;
			}
			fclose( $handle );
		} else {
			new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Файла $filename = ' . $filename . ' еще нет. Файл: class-generation-xml.php; Строка: ' . __LINE__ );
			// файла еще нет
			// попытаемся создать файл
			if ( is_multisite() ) {
				// загружаем shop2_295221-xml в папку загрузок
				$upload = wp_upload_bits( $prefFeed . 'feed-yml-' . get_current_blog_id() . '-tmp.xml', null, $result_xml );
			} else {
				// загружаем shop2_295221-xml в папку загрузок
				$upload = wp_upload_bits( $prefFeed . 'feed-yml-0-tmp.xml', null, $result_xml );
			}
			/**
			 *	для работы с csv или xml требуется в плагине разрешить загрузку таких файлов
			 *	$upload['file'] => '/var/www/wordpress/wp-content/uploads/2010/03/feed-xml.xml', // путь
			 *	$upload['url'] => 'http://site.ru/wp-content/uploads/2010/03/feed-xml.xml', // урл
			 *	$upload['error'] => false, // сюда записывается сообщение об ошибке в случае ошибки
			 */
			// проверим получилась ли запись
			if ( $upload['error'] ) {
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Запись вызвала ошибку: ' . $upload['error'] . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
			} else {
				xfavi_optionUPD( 'xfavi_file_file', urlencode( $upload['file'] ), $this->get_feed_id(), 'yes', 'set_arr' );
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Запись удалась! Путь файла: ' . $upload['file'] . '; УРЛ файла: ' . $upload['url'] );
				return true;
			}
		}
	}

	public function gluing( $id_arr ) {
		/**	
		 * $id_arr[$i]['ID'] - ID товара
		 * $id_arr[$i]['post_modified_gmt'] - Время обновления карточки товара
		 * global $wpdb;
		 * $res = $wpdb->get_results("SELECT ID, post_modified_gmt FROM $wpdb->posts WHERE post_type = 'product' AND post_status = 'publish'");	
		 */
		if ( $this->get_feed_id() === '1' ) {
			$prefFeed = '';
		} else {
			$prefFeed = $this->get_feed_id();
		}

		$name_dir = XFAVI_SITE_UPLOADS_DIR_PATH . '/xml-for-avito/feed' . $this->get_feed_id();
		if ( ! is_dir( $name_dir ) ) {
			if ( ! mkdir( $name_dir ) ) {
				error_log( 'FEED № ' . $this->get_feed_id() . '; Нет папки xml-for-avito! И создать не вышло! $name_dir =' . $name_dir . '; Файл: class-xfavi-generation-xml.php; Строка: ' . __LINE__, 0 );
			} else {
				error_log( 'FEED № ' . $this->get_feed_id() . '; Создали папку xml-for-avito! Файл: class-xfavi-generation-xml.php; Строка: ' . __LINE__, 0 );
			}
		}

		/** 
		 *	этот блок исправляет потенциальную проблему изменения относительных путей типа:
		 *	/home/c/can/can.beget.tech/public_html/wp-content/uploads/xml-for-avito/feed2/ids_in_xml.tmp 
		 *	/home/c/can/canpower.ru/public_html/wp-content/uploads/xml-for-avito/feed2/ids_in_xml.tmp
		 **/
		$xfavi_file_file = urldecode( xfavi_optionGET( 'xfavi_file_file', $this->get_feed_id(), 'set_arr' ) );
		$xfavi_file_ids_in_xml = urldecode( xfavi_optionGET( 'xfavi_file_ids_in_xml', $this->get_feed_id(), 'set_arr' ) );
		if ( empty( $xfavi_file_ids_in_xml ) ||
			$xfavi_file_ids_in_xml !== XFAVI_PLUGIN_UPLOADS_DIR_PATH . '/feed' . $this->get_feed_id() . '/ids_in_xml.tmp'
		) { // если не указан адрес файла с id-шниками или они не равны
			$xfavi_file_ids_in_xml = XFAVI_PLUGIN_UPLOADS_DIR_PATH . '/feed' . $this->get_feed_id() . '/ids_in_xml.tmp';
			xfavi_optionUPD( 'xfavi_file_ids_in_xml', urlencode( $xfavi_file_ids_in_xml ), $this->get_feed_id(), 'yes', 'set_arr' );
		}

		$xfavi_date_save_set = xfavi_optionGET( 'xfavi_date_save_set', $this->get_feed_id(), 'set_arr' );
		clearstatcache(); // очищаем кэш дат файлов

		foreach ( $id_arr as $product ) {
			$filename = $name_dir . '/' . $product['ID'] . '.tmp';
			$filenameIn = $name_dir . '/' . $product['ID'] . '-in.tmp'; /* с версии 2.0.0 */
			new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; RAM ' . round( memory_get_usage() / 1024, 1 ) . ' Кб. ID товара/файл = ' . $product['ID'] . '.tmp; Файл: class-xfavi-generation-xml.php; Строка: ' . __LINE__ );
			if ( is_file( $filename ) && is_file( $filenameIn ) ) { // if (file_exists($filename)) {
				$last_upd_file = filemtime( $filename ); // 1318189167			
				if ( ( $last_upd_file < strtotime( $product['post_modified_gmt'] ) ) || ( $xfavi_date_save_set > $last_upd_file ) ) {
					// Файл кэша обновлен раньше чем время модификации товара
					// или файл обновлен раньше чем время обновления настроек фида
					new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; NOTICE: Файл кэша ' . $filename . ' обновлен РАНЬШЕ чем время модификации товара или время сохранения настроек фида! Файл: class-xfavi-generation-xml.php; Строка: ' . __LINE__ );
					$result_get_unit_obj = new XFAVI_Get_Unit( $product['ID'], $this->get_feed_id() );
					$result_xml = $result_get_unit_obj->get_result();
					$ids_in_xml = $result_get_unit_obj->get_ids_in_xml();

					xfavi_wf( $result_xml, $product['ID'], $this->get_feed_id(), $ids_in_xml );
					new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Обновили кэш товара. Файл: class-generation-xml.php; Строка: ' . __LINE__ );
					file_put_contents( $xfavi_file_ids_in_xml, $ids_in_xml, FILE_APPEND );
				} else {
					// Файл кэша обновлен позже чем время модификации товара
					// или файл обновлен позже чем время обновления настроек фида
					new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; NOTICE: Файл кэша ' . $filename . ' обновлен ПОЗЖЕ чем время модификации товара или время сохранения настроек фида; Файл: class-xfavi-generation-xml.php; Строка: ' . __LINE__ );
					new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Пристыковываем файл кэша без изменений; Файл: class-xfavi-generation-xml.php; Строка: ' . __LINE__ );
					$result_xml = file_get_contents( $filename );
					$ids_in_xml = file_get_contents( $filenameIn );
					file_put_contents( $xfavi_file_ids_in_xml, $ids_in_xml, FILE_APPEND );
				}
			} else { // Файла нет
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; NOTICE: Файла кэша товара ' . $filename . ' ещё нет! Создаем... Файл: class-xfavi-generation-xml.php; Строка: ' . __LINE__ );
				$result_get_unit_obj = new XFAVI_Get_Unit( $product['ID'], $this->get_feed_id() );
				$result_xml = $result_get_unit_obj->get_result();
				$ids_in_xml = $result_get_unit_obj->get_ids_in_xml();

				xfavi_wf( $result_xml, $product['ID'], $this->get_feed_id(), $ids_in_xml );
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Создали кэш товара. Файл: class-generation-xml.php; Строка: ' . __LINE__ );
				file_put_contents( $xfavi_file_ids_in_xml, $ids_in_xml, FILE_APPEND );
			}
		}
	} // end function gluing()

	public function clear_file_ids_in_xml( $feed_id ) {
		$xfavi_file_ids_in_xml = urldecode( xfavi_optionGET( 'xfavi_file_ids_in_xml', $feed_id, 'set_arr' ) );
		if ( is_file( $xfavi_file_ids_in_xml ) ) {
			new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; NOTICE: Обнуляем файл $xfavi_file_ids_in_xml = ' . $xfavi_file_ids_in_xml . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
			file_put_contents( $xfavi_file_ids_in_xml, '' );
		} else {
			new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; WARNING: Файла c idшниками $xfavi_file_ids_in_xml = ' . $xfavi_file_ids_in_xml . ' нет! Создадим пустой; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
			$xfavi_file_ids_in_xml = XFAVI_PLUGIN_UPLOADS_DIR_PATH . '/feed' . $feed_id . '/ids_in_xml.tmp';
			$res = file_put_contents( $xfavi_file_ids_in_xml, '' );
			if ( $res !== false ) {
				new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; NOTICE: Файл c idшниками $xfavi_file_ids_in_xml = ' . $xfavi_file_ids_in_xml . ' успешно создан; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
				xfavi_optionUPD( 'xfavi_file_ids_in_xml', urlencode( $xfavi_file_ids_in_xml ), $feed_id, 'yes', 'set_arr' );
			} else {
				new XFAVI_Error_Log( 'FEED № ' . $feed_id . '; ERROR: Ошибка создания файла $xfavi_file_ids_in_xml = ' . $xfavi_file_ids_in_xml . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
			}
		}
	}

	public function run() {
		$result_xml = '';

		$step_export = (int) xfavi_optionGET( 'xfavi_step_export', $this->get_feed_id(), 'set_arr' );
		$status_sborki = (int) xfavi_optionGET( 'xfavi_status_sborki', $this->get_feed_id() ); // файл уже собран. На всякий случай отключим крон сборки

		new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; $status_sborki = ' . $status_sborki . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );

		switch ( $status_sborki ) {
			case -1: // сборка завершена
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; case -1; Файл: class-generation-xml.php; Строка: ' . __LINE__ );

				wp_clear_scheduled_hook( 'xfavi_cron_sborki', [ $this->get_feed_id() ] );
				break;
			case 1: // сборка начата		
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; case 1; Файл: class-generation-xml.php; Строка: ' . __LINE__ );

				$result_xml = $this->get_feed_header();
				$result = $this->write_file( $result_xml, 'w+' );
				if ( $result !== true ) {
					new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; xfavi_write_file вернула ошибку! $result =' . $result . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
					$this->stop();
					return;
				} else {
					new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; xfavi_write_file отработала успешно; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
				}
				$this->clear_file_ids_in_xml( $this->get_feed_id() ); /* С версии 2.0.0 */
				$status_sborki = 2;
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; status_sborki увеличен на ' . $step_export . ' и равен ' . $status_sborki . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
				xfavi_optionUPD( 'xfavi_status_sborki', $status_sborki, $this->get_feed_id() );
				break;
			default:
				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; case default; Файл: class-generation-xml.php; Строка: ' . __LINE__ );

				$offset = ( ( $status_sborki - 1 ) * $step_export ) - $step_export; // $status_sborki - $step_export;
				$args = [ 
					'post_type' => 'product',
					'post_status' => 'publish',
					'posts_per_page' => $step_export,
					'offset' => $offset,
					'relation' => 'AND',
					'orderby' => 'ID',
				];
				$whot_export = xfavi_optionGET( 'xfavi_whot_export', $this->get_feed_id(), 'set_arr' );
				switch ( $whot_export ) {
					case "xfavi_vygruzhat":
						$args['meta_query'] = [ 
							[ 
								'key' => '_xfavi_vygruzhat',
								'value' => 'yes'
							]
						];
						break;
					case "xmlset":
						$xfavi_xmlset_number = '1';
						$xfavi_xmlset_number = apply_filters( 'xfavi_xmlset_number_filter', $xfavi_xmlset_number, $this->get_feed_id() );
						$xfavi_xmlset_key = '_xfavi_xmlset' . $xfavi_xmlset_number;
						$args['meta_query'] = [ 
							[ 
								'key' => $xfavi_xmlset_key,
								'value' => 'yes'
							]
						];
						break;
				} // end switch($whot_export)
				$args = apply_filters( 'xfavi_query_arg_filter', $args, $this->get_feed_id() );

				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Полная сборка. $whot_export = ' . $whot_export . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );

				new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; $args =>; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
				new XFAVI_Error_Log( $args );

				$featured_query = new \WP_Query( $args );
				$prod_id_arr = [];
				if ( $featured_query->have_posts() ) {
					for ( $i = 0; $i < count( $featured_query->posts ); $i++ ) {
						$prod_id_arr[ $i ]['ID'] = $featured_query->posts[ $i ]->ID;
						$prod_id_arr[ $i ]['post_modified_gmt'] = $featured_query->posts[ $i ]->post_modified_gmt;
					}
					wp_reset_query(); /* Remember to reset */
					unset( $featured_query ); // чутка освободим память
					$this->gluing( $prod_id_arr );
					$status_sborki++; // = $status_sborki + $step_export;
					new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; status_sborki увеличен на ' . $step_export . ' и равен ' . $status_sborki . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
					xfavi_optionUPD( 'xfavi_status_sborki', $status_sborki, $this->get_feed_id() );
				} else { // если постов нет, пишем концовку файла
					$result_xml = $this->get_feed_footer();
					$result = xfavi_write_file( $result_xml, 'a', $this->get_feed_id() );
					new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Файл фида готов. Осталось только переименовать временный файл в основной; Файл: xml-for-google-merchant-center.php; Строка: ' . __LINE__ );
					xfavi_rename_file( $this->get_feed_id() );

					$this->stop();
				}
			// end default
		} // end switch($status_sborki)
		return; // final return from public function phase()
	}

	public function stop() {
		$status_sborki = -1;
		xfavi_optionUPD( 'xfavi_status_sborki', $status_sborki, $this->get_feed_id() );
		wp_clear_scheduled_hook( 'xfavi_cron_sborki', [ $this->get_feed_id() ] );
		do_action( 'xfavi_after_construct', $this->get_feed_id(), 'full' ); // сборка закончена
	}

	/**
	 * Проверим, нужна ли пересборка фида при обновлении поста
	 * 
	 * @param mixed $post_id
	 * 
	 * @return bool
	 */
	public function check_ufup( $post_id ) {
		$xfavi_ufup = xfavi_optionGET( 'xfavi_ufup', $this->get_feed_id(), 'set_arr' );
		if ( $xfavi_ufup === 'on' ) {
			$status_sborki = (int) xfavi_optionGET( 'xfavi_status_sborki', $this->get_feed_id() );
			if ( $status_sborki > -1 ) { // если идет сборка фида - пропуск
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	protected function get_feed_header( $result_xml = '' ) {
		new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Стартовала xfavi_feed_header; Файл: offer.php; Строка: ' . __LINE__ );
		$result_xml .= '<Ads formatVersion="3" target="Avito.ru">' . PHP_EOL;
		$unixtime = (string) current_time( 'Y-m-d H:i' ); // время в unix формате 
		xfavi_optionUPD( 'xfavi_date_sborki', $unixtime, $this->get_feed_id(), 'yes', 'set_arr' );
		do_action( 'xfavi_before_items' );
		return $result_xml;
	}

	protected function get_ids_in_xml( $file_content ) {
		/**
		 * $file_content - содержимое файла (Обязательный параметр)
		 * Возвращает массив в котором ключи - это id товаров в БД WordPress, попавшие в фид
		 */
		$res_arr = [];
		$file_content_string_arr = explode( PHP_EOL, $file_content );
		for ( $i = 0; $i < count( $file_content_string_arr ) - 1; $i++ ) {
			$r_arr = explode( ';', $file_content_string_arr[ $i ] );
			$res_arr[ $r_arr[0] ] = '';
		}
		return $res_arr;
	}

	protected function get_feed_body( $result_xml = '' ) {
		$xfavi_file_ids_in_xml = urldecode( xfavi_optionGET( 'xfavi_file_ids_in_xml', $this->get_feed_id(), 'set_arr' ) );
		$file_content = file_get_contents( $xfavi_file_ids_in_xml );
		$ids_in_xml_arr = $this->get_ids_in_xml( $file_content );

		$name_dir = XFAVI_SITE_UPLOADS_DIR_PATH . '/xml-for-avito/feed' . $this->get_feed_id();

		foreach ( $ids_in_xml_arr as $key => $value ) {
			$product_id = (int) $key;
			$filename = $name_dir . '/' . $product_id . '.tmp';
			$result_xml .= file_get_contents( $filename );
		}

		xfavi_optionUPD( 'xfavi_count_products_in_feed', count( $ids_in_xml_arr ), $this->get_feed_id(), 'yes', 'set_arr' );
		// товаров попало в фид - count($ids_in_xml_arr);

		return $result_xml;
	}

	protected function get_feed_footer( $result_xml = '' ) {
		$result_xml .= $this->get_feed_body( $result_xml );

		$result_xml = apply_filters( 'xfavi_after_offers_filter', $result_xml, $this->get_feed_id() );
		$result_xml .= '</Ads>';

		$unixtime = (string) current_time( 'Y-m-d H:i' ); // время в unix формате 			
		xfavi_optionUPD( 'xfavi_date_sborki_end', $unixtime, $this->get_feed_id(), 'yes', 'set_arr' );

		return $result_xml;
	}

	/**
	 * Get feed ID
	 * 
	 * @return string
	 */
	protected function get_feed_id() {
		return $this->feed_id;
	}

	public function onlygluing() {
		$result_xml = $this->get_feed_header();
		/* создаем файл или перезаписываем старый удалив содержимое */
		$result = xfavi_write_file( $result_xml, 'w+', $this->get_feed_id() );
		if ( $result !== true ) {
			new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; xfavi_write_file вернула ошибку! $result =' . $result . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
		}

		xfavi_optionUPD( 'xfavi_status_sborki', '-1', $this->get_feed_id() );
		$whot_export = xfavi_optionGET( 'xfavi_whot_export', $this->get_feed_id(), 'set_arr' );

		$result_xml = '';
		$step_export = -1;
		$prod_id_arr = [];

		if ( $whot_export === 'xfavi_vygruzhat' ) {
			$args = [ 
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $step_export, // сколько выводить товаров
				// 'offset' => $offset,
				'relation' => 'AND',
				'orderby' => 'ID',
				'fields' => 'ids',
				'meta_query' => [ 
					[ 
						'key' => '_xfavi_vygruzhat',
						'value' => 'yes'
					]
				]
			];
		} else { //  if ($whot_export == 'all' || $whot_export == 'simple')
			$args = [ 
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $step_export, // сколько выводить товаров
				// 'offset' => $offset,
				'relation' => 'AND',
				'orderby' => 'ID',
				'fields' => 'ids'
			];
		}

		$args = apply_filters( 'xfavi_query_arg_filter', $args, $this->get_feed_id() );
		new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Быстрая сборка. $whot_export = ' . $whot_export . '; Файл: class-generation-xml.php; Строка: ' . __LINE__ );

		new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; NOTICE: onlygluing до запуска WP_Query RAM ' . round( memory_get_usage() / 1024, 1 ) . ' Кб; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
		$featured_query = new WP_Query( $args );
		new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; NOTICE: onlygluing после запуска WP_Query RAM ' . round( memory_get_usage() / 1024, 1 ) . ' Кб; Файл: class-generation-xml.php; Строка: ' . __LINE__ );

		global $wpdb;
		if ( $featured_query->have_posts() ) {
			for ( $i = 0; $i < count( $featured_query->posts ); $i++ ) {
				/**
				 *	если не юзаем 'fields'  => 'ids'
				 *	$prod_id_arr[$i]['ID'] = $featured_query->posts[$i]->ID;
				 *	$prod_id_arr[$i]['post_modified_gmt'] = $featured_query->posts[$i]->post_modified_gmt;
				 */
				$curID = $featured_query->posts[ $i ];
				$prod_id_arr[ $i ]['ID'] = $curID;
				$res = $wpdb->get_results( $wpdb->prepare( "SELECT post_modified_gmt FROM $wpdb->posts WHERE id=%d", $curID ), ARRAY_A );
				$prod_id_arr[ $i ]['post_modified_gmt'] = $res[0]['post_modified_gmt'];
				// get_post_modified_time('Y-m-j H:i:s', true, $featured_query->posts[$i]);
			}
			wp_reset_query(); /* Remember to reset */
			unset( $featured_query ); // чутка освободим память
		}
		if ( ! empty( $prod_id_arr ) ) {
			new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; NOTICE: onlygluing передала управление this->gluing; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
			$this->gluing( $prod_id_arr );
		}

		// если постов нет, пишем концовку файла
		$result_xml = $this->get_feed_footer();
		$result = xfavi_write_file( $result_xml, 'a', $this->get_feed_id() );
		new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; Файл фида готов. Осталось только переименовать временный файл в основной; Файл: class-generation-xml.php; Строка: ' . __LINE__ );
		xfavi_rename_file( $this->get_feed_id() );

		$this->stop();
	} // end function onlygluing()
}