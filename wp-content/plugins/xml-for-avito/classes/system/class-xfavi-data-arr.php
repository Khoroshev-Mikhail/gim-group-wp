<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Set and Get the Plugin Data
 *
 * @package			XML for Avito
 * @subpackage		
 * @since			0.1.0
 * 
 * @version			0.1.0 (11-02-2023)
 * @author			Maxim Glazunov
 * @link			https://icopydoc.ru/
 * @see				
 * 
 * @param
 *
 * @return			
 *
 * @depends			classes:	
 *					traits:		
 *					methods:	
 *					functions:	
 *					constants:	
 */

class XFAVI_Data_Arr {
	private $data_arr = [];
	private $manager_name;

	public function __construct( $manager_name = '', $data_arr = [] ) {
		$this->data_arr = [ 
			[ 
				0 => 'xfavi_status_sborki', 1 => '-1', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_status_sborki',
				'def_val' => '-1',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			[ 
				0 => 'xfavi_date_sborki', 1 => '0000000001', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_date_sborki',
				'def_val' => '0000000001',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			[ 
				0 => 'xfavi_date_sborki_end', 1 => '0000000001', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_date_sborki_end',
				'def_val' => '0000000001',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			[ 
				0 => 'xfavi_date_save_set', 1 => '0000000001', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_date_save_set',
				'def_val' => '0000000001',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			[ 
				0 => 'xfavi_count_products_in_feed', 1 => '-1', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_count_products_in_feed',
				'def_val' => '-1',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			[ 
				0 => 'xfavi_file_url', 1 => '', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_file_url',
				'def_val' => '',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			[ 
				0 => 'xfavi_file_file', 1 => '', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_file_file',
				'def_val' => '',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			[ 
				0 => 'xfavi_errors', 1 => '', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_errors',
				'def_val' => '',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			[ 
				0 => 'xfavi_status_cron', 1 => 'off', 2 => 'private', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_status_cron',
				'def_val' => 'off',
				'mark' => 'private',
				'required' => true,
				'type' => 'auto',
				'tab' => 'none'
			],
			// ------------------- ОСНОВНЫЕ НАСТРОЙКИ -------------------
			[ 
				0 => 'xfavi_run_cron', 1 => 'off', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_run_cron',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => true,
				'type' => 'select',
				'tab' => 'main_tab',
				'data' => [ 
					'label' => __( 'Автоматическое создание файла', 'xml-for-avito' ),
					'desc' => __( 'Интервал обновления вашего фида', 'xml-for-avito' ),
					'woo_attr' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'hourly', 'text' => __( 'Раз в час', 'xml-for-avito' ) ],
						[ 'value' => 'six_hours', 'text' => __( 'Каждые 6 часов', 'xml-for-avito' ) ],
						[ 'value' => 'twicedaily', 'text' => __( '2 раза в день', 'xml-for-avito' ) ],
						[ 'value' => 'daily', 'text' => __( 'Раз в день', 'xml-for-avito' ) ],
						[ 'value' => 'week', 'text' => __( 'Раз в неделю', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_ufup', 1 => '0', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_ufup',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => true,
				'type' => 'select',
				'tab' => 'main_tab',
				'data' => [ 
					'label' => __( 'Обновить фид при обновлении карточки товара', 'xml-for-avito' ),
					'desc' => '',
					'woo_attr' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'on', 'text' => __( 'Включено', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_feed_assignment', 1 => '', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_feed_assignment',
				'def_val' => '',
				'mark' => 'public',
				'required' => true,
				'type' => 'text',
				'tab' => 'main_tab',
				'data' => [ 
					'label' => __( 'Назначение фида', 'xml-for-avito' ),
					'desc' => __( 'Не используется в фиде. Внутренняя заметка для вашего удобства', 'xml-for-avito' ),
					'placeholder' => __( 'Для Авито', 'xml-for-avito' )
				]
			],
			[ 
				0 => 'xfavi_step_export', 1 => '500', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_step_export',
				'def_val' => '500',
				'mark' => 'public',
				'required' => true,
				'type' => 'select',
				'tab' => 'main_tab',
				'data' => [ 
					'label' => __( 'Шаг экспорта', 'xml-for-avito' ),
					'desc' =>
					sprintf( '%s. %s. %s',
						__( 'Значение влияет на скорость создания XML фида', 'xml-for-avito' ),
						__(
							'Если у вас возникли проблемы с генерацией файла - попробуйте уменьшить значение в данном поле',
							'xml-for-avito'
						),
						__( 'Более 500 можно устанавливать только на мощных серверах', 'xml-for-avito' )
					),
					'woo_attr' => false,
					'key_value_arr' => [ 
						[ 'value' => '80', 'text' => '80' ],
						[ 'value' => '200', 'text' => '200' ],
						[ 'value' => '300', 'text' => '300' ],
						[ 'value' => '450', 'text' => '450' ],
						[ 'value' => '500', 'text' => '500' ],
						[ 'value' => '800', 'text' => '800' ],
						[ 'value' => '1000', 'text' => '1000' ]
					]
				]
			],
			[ 
				0 => 'xfavi_type_sborki', 1 => 'xml', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_type_sborki',
				'def_val' => 'xml',
				'mark' => 'public',
				'required' => true,
				'type' => 'select',
				'tab' => 'main_tab',
				'data' => [ 
					'label' => __( 'Расширение файла фида', 'xml-for-avito' ),
					'desc' => '',
					'woo_attr' => false,
					'key_value_arr' => [ 
						[ 'value' => 'xml', 'text' => 'XML (' . __( 'рекомендуется', 'xml-for-avito' ) . ')' ],
						[ 'value' => 'csv', 'text' => 'CSV' ]
					]
				]
			],
			[ //  ? удалить целиком
				0 => 'xfavi_file_ids_in_xml', 1 => '', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_file_ids_in_yml',
				'def_val' => '',
				'mark' => 'public',
				'required' => false,
				'type' => 'text',
				'tab' => 'main_tab',
				'data' => []
			],
			[ 
				0 => 'xfavi_whot_export', 1 => 'all', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_whot_export',
				'def_val' => 'all',
				'mark' => 'public',
				'required' => true,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Что экспортировать', 'xml-for-avito' ),
					'desc' => '',
					'woo_attr' => false,
					'key_value_arr' => [ 
						[ 
							'value' => 'all',
							'text' => __( 'Вариативные и обычные товары', 'xml-for-avito' )
						],
						[ 
							'value' => 'simple',
							'text' => __( 'Только обычные товары', 'xml-for-avito' )
						]
					]
				]
			],
			[ 
				0 => 'xfavi_desc', 1 => 'fullexcerpt', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_desc',
				'def_val' => 'fullexcerpt',
				'mark' => 'public',
				'required' => true,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Описание товара', 'xml-for-avito' ),
					'desc' => sprintf( '[description] - %s',
						__( 'Источник описания товара', 'xml-for-avito' )
					),
					'woo_attr' => false,
					'key_value_arr' => [ 
						[ 
							'value' => 'excerpt',
							'text' => __( 'Только Краткое описание', 'xml-for-avito' )
						],
						[ 
							'value' => 'full',
							'text' => __( 'Только Полное описание', 'xml-for-avito' )
						],
						[ 
							'value' => 'excerptfull',
							'text' => __( 'Краткое или Полное описание', 'xml-for-avito' )
						],
						[ 
							'value' => 'fullexcerpt',
							'text' => __( 'Полное или Краткое описание', 'xml-for-avito' )
						],
						[ 
							'value' => 'excerptplusfull',
							'text' => __( 'Краткое плюс Полное описание', 'xml-for-avito' )
						],
						[ 
							'value' => 'fullplusexcerpt',
							'text' => __( 'Полное плюс Краткое описание', 'xml-for-avito' )
						]
					],
					'tr_class' => 'xfavi_tr'
				]
			],
			[ 
				0 => 'xfavi_enable_tags_behavior', 1 => 'default', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_enable_tags_behavior',
				'def_val' => '',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Список разрешенных тегов', 'xml-for-avito' ),
					'desc' => '',
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'default', 'text' => __( 'По умолчанию', 'xml-for-avito' ) ],
						[ 'value' => 'custom', 'text' => __( 'Из поля ниже', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_enable_tags_custom', 1 => '', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_enable_tags_custom',
				'def_val' => '',
				'mark' => 'public',
				'required' => true,
				'type' => 'text',
				'tab' => 'filtration_tab',
				'data' => [ 
					'default_value' => false,
					'label' => '',
					'desc' => sprintf( '%s <code>p,br,h3</code>',
						__( 'Например', 'xml-for-avito' )
					),
					'placeholder' => 'p,br,h3'
				]
			],
	
			[ 
				0 => 'xfavi_the_content', 1 => 'enabled', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_the_content',
				'def_val' => 'enabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Задействовать фильтр', 'xml-for-avito' ) . ' the_content',
					'desc' => sprintf( '%s: %s',
						__( 'По умолчанию', 'xml-for-avito' ),
						__( 'Включено', 'xml-for-avito' )
					),
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'enabled', 'text' => __( 'Включено', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_behavior_strip_symbol', 1 => 'default', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_behavior_strip_symbol',
				'def_val' => 'default',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Задействовать фильтр', 'xml-for-avito' ) . ' the_content',
					'desc' => sprintf( '%s: %s',
						__( 'По умолчанию', 'xml-for-avito' ),
						__( 'Включено', 'xml-for-avito' )
					),
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'default', 'text' => __( 'По умолчанию', 'xml-for-avito' ) ],
						[ 'value' => 'del', 'text' => __( 'Удалить', 'xml-for-avito' ) ],
						[ 'value' => 'slash', 'text' => __( 'Заменить на', 'xml-for-avito' ) . '/' ],
						[ 'value' => 'amp', 'text' => __( 'Заменить на', 'xml-for-avito' ) . 'amp;' ]
					]
				]
			],
			[ 
				0 => 'xfavi_var_desc_priority', 1 => 'on', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_var_desc_priority',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __(
						'Описание вариации имеет приоритет над другими',
						'xml-for-avito'
					),
					'desc' => sprintf( '%s: %s',
						__( 'По умолчанию', 'xml-for-avito' ),
						__( 'Включено', 'xml-for-avito' )
					),
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'on', 'text' => __( 'Включено', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_var_source_id', 1 => 'product_id', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_var_source_id',
				'def_val' => 'product_id',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Источник ID для вариативных товаров', 'xml-for-avito' ),
					'desc' => sprintf( '%s: %s',
						__( 'По умолчанию', 'xml-for-avito' ),
						__( 'ID вариации', 'xml-for-avito' )
					),
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'product_id', 'text' => __( 'ID товара', 'xml-for-avito' ) ],
						[ 'value' => 'offer_id', 'text' => __( 'ID вариации', 'xml-for-avito' ) ]
					]
				]
			],
	
			[ 
				0 => '"xfavi_allowEmail', 1 => 'Да', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => '"xfavi_allowEmail',
				'def_val' => 'Да',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Связь по Email', 'xml-for-avito' ),
					'desc' => sprintf( '%s Allow Email. %s',
						__( 'Элемент', 'xml-for-avito' ),
						__( 'Возможность написать сообщение по объявлению через сайт', 'xml-for-avito' )
					),
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'Да', 'text' => __( 'Да', 'xml-for-avito' ) ],
						[ 'value' => 'Нет', 'text' => __( 'Нет', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_contactPhone', 1 => '', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_contactPhone',
				'def_val' => '',
				'mark' => 'public',
				'required' => true,
				'type' => 'text',
				'tab' => 'main_tab',
				'data' => [ 
					'label' => __( 'Телефон', 'xml-for-avito' ),
					'desc' => __( 'ContactPhone', 'xml-for-avito' ),
					'placeholder' => ''
				]
			],
			[ 
				0 => 'xfavi_address', 1 => '', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_address',
				'def_val' => '',
				'mark' => 'public',
				'required' => true,
				'type' => 'text',
				'tab' => 'main_tab',
				'data' => [ 
					'label' => __( 'Адрес', 'xml-for-avito' ),
					'desc' => __( 'Полный адрес объекта — строка до 256 символов', 'xml-for-avito' ),
					'placeholder' => ''
				]
			],
			[ 
				0 => 'xfavi_contact_method', 1 => 'all', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_contact_method',
				'def_val' => 'all',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Способ связи', 'xml-for-avito' ),
					'desc' => '',
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'all', 'text' => __( 'По телефону и в сообщениях', 'xml-for-avito' ) ],
						[ 'value' => 'phone', 'text' => __( 'По телефону', 'xml-for-avito' ) ],
						[ 'value' => 'msg', 'text' => __( 'В сообщениях', 'xml-for-avito' ) ]
					]
				]
			],
	
			[ 
				0 => 'xfavi_main_product', 1 => 'other', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_main_product',
				'def_val' => 'all',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Какие товары вы продаёте', 'xml-for-avito' ),
					'desc' => __( 'Укажите основную категорию', 'xml-for-avito' ),
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'electronics', 'text' => __( 'Электроника', 'xml-for-avito' ) ],
						[ 'value' => 'computer', 'text' => __( 'Компьютеры', 'xml-for-avito' ) ],
						[ 'value' => 'clothes_and_shoes', 'text' => __( 'Одежда и обувь', 'xml-for-avito' ) ],
						[ 'value' => 'auto_parts', 'text' => __( 'Автозапчасти', 'xml-for-avito' ) ],
						[ 'value' => 'other', 'text' => __( 'Прочее', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_listing_fee', 1 => 'disabled', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_listing_fee',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Какие товары вы продаёте', 'xml-for-avito' ),
					'desc' => sprintf( '%s <strong>ListingFee</strong>. %s: 
						<br/>Package – %s
						<br />PackageSingle – %s
						<br />Single – %s',
						__( 'Элемент', 'xml-for-avito' ),
						__( 'Согласно справке Авито', 'xml-for-avito' ),
						__(
							'размещение объявления осуществляется только при наличии подходящего пакета размещения',
							'xml-for-avito'
						),
						__(
							'при наличии подходящего пакета оплата размещения объявления произойдет с него; если нет подходящего пакета, но достаточно денег на кошельке Авито, то произойдет разовое размещение',
							'xml-for-avito'
						),
						__(
							'только разовое размещение, произойдет при наличии достаточной суммы на кошельке Авито; если есть подходящий пакет размещения, он будет проигнорирован',
							'xml-for-avito'
						)
					),
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'Package', 'text' => sprintf( 'Package (%s)', __( 'По умолчанию', 'xml-for-avito' ) ) ],
						[ 'value' => 'PackageSingle', 'text' => 'PackageSingle' ],
						[ 'value' => 'Single', 'text' => 'Single' ]
					]
				]
			],
			[ 
				0 => 'xfavi_no_default_png_products', 1 => '0', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_no_default_png_products',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Удалить default.png из XML', 'xml-for-avito' ),
					'desc' => '',
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'on', 'text' => __( 'Включено', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_skip_products_without_pic', 1 => '0', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_skip_products_without_pic',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Пропустить товары без картинок', 'xml-for-avito' ),
					'desc' => '',
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'on', 'text' => __( 'Включено', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_skip_missing_products', 1 => '0', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_skip_missing_products',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => sprintf( '%s (%s)',
						__( 'Исключать товары которых нет в наличии', 'xml-for-avito' ),
						__( 'за исключением товаров, для которых разрешен предварительный заказ', 'xml-for-avito' ),
					),
					'desc' => '',
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'on', 'text' => __( 'Включено', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_skip_backorders_products', 1 => '0', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_skip_backorders_products',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'filtration_tab',
				'data' => [ 
					'label' => __( 'Исключать из фида товары для предзаказа', 'xml-for-avito' ),
					'desc' => '',
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'on', 'text' => __( 'Включено', 'xml-for-avito' ) ]
					]
				]
			],
			[ 
				0 => 'xfavi_size', 1 => '', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_size',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'wp_list_table',
				'data' => [ 
					'label' => __( 'Размер', 'xml-for-avito' ),
					'desc' => __( 'Элемент', 'xml-for-avito' ),
					'woo_attr' => true,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ]
					],
					'rules' => [ 
						'yandex_market', 'dbs', 'single_catalog', 'sales_terms', 'sbermegamarket', 'beru',
						'products_and_offers', 'yandex_webmaster', 'all_elements', 'ozon', 'vk'
					],
					'tag_name' => 'Size'
				]
			],
			[ 
				0 => 'xfavi_condition', 1 => 'new', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_condition',
				'def_val' => 'new',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'wp_list_table',
				'data' => [ 
					'label' => __( 'Состояние товара', 'xml-for-avito' ),
					'desc' => sprintf( '%s Condition. %s',
						__( 'Обязательный элемент', 'xml-for-avito' ),
						__( 'Задайте значение по умолчанию', 'xml-for-avito' )
					),
					'woo_attr' => false,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'new', 'text' => __( 'Новый', 'xml-for-avito' ) ],
						[ 'value' => 'bu', 'text' => __( 'Б/у', 'xml-for-avito' ) ]
					],
					'rules' => [ 
						'yandex_market', 'dbs', 'single_catalog', 'sales_terms', 'sbermegamarket', 'beru',
						'products_and_offers', 'yandex_webmaster', 'all_elements', 'ozon', 'vk'
					],
					'tag_name' => 'Condition'
				]
			],
			[ 
				0 => 'xfavi_oem', 1 => 'disabled', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_oem',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'wp_list_table',
				'data' => [ 
					'label' => 'OEM',
					'desc' => __( 'Элемент', 'xml-for-avito' ),
					'woo_attr' => true,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'sku', 'text' => __( 'Подставлять из Артикул', 'xml-for-avito' ) ]
					],
					'rules' => [ 
						'yandex_market', 'dbs', 'single_catalog', 'sales_terms', 'sbermegamarket', 'beru',
						'products_and_offers', 'yandex_webmaster', 'all_elements', 'ozon', 'vk'
					],
					'tag_name' => 'OEM'
				]
			],
			[ 
				0 => 'xfavi_brand', 1 => 'disabled', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_brand',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'wp_list_table',
				'data' => [ 
					'label' => __( 'Производитель', 'xml-for-avito' ),
					'desc' => __( 'Элемент', 'xml-for-avito' ),
					'woo_attr' => true,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'sku', 'text' => __( 'Подставлять из Артикул', 'xml-for-avito' ) ]
					],
					'rules' => [ 
						'yandex_market', 'dbs', 'single_catalog', 'sales_terms', 'sbermegamarket', 'beru',
						'products_and_offers', 'yandex_webmaster', 'all_elements', 'ozon', 'vk'
					],
					'tag_name' => 'Brand'
				]
			],
			[ 
				0 => 'xfavi_make', 1 => 'disabled', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_make',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'wp_list_table',
				'data' => [ 
					'label' => __( 'Марка автомобиля', 'xml-for-avito' ),
					'desc' => __( 'Элемент', 'xml-for-avito' ),
					'woo_attr' => true,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'sku', 'text' => __( 'Подставлять из Артикул', 'xml-for-avito' ) ]
					],
					'rules' => [ 
						'yandex_market', 'dbs', 'single_catalog', 'sales_terms', 'sbermegamarket', 'beru',
						'products_and_offers', 'yandex_webmaster', 'all_elements', 'ozon', 'vk'
					],
					'tag_name' => 'Make'
				]
			],
			[ 
				0 => 'xfavi_model', 1 => 'disabled', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_model',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'wp_list_table',
				'data' => [ 
					'label' => __( 'Модель', 'xml-for-avito' ),
					'desc' => __( 'Элемент', 'xml-for-avito' ),
					'woo_attr' => true,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'sku', 'text' => __( 'Подставлять из Артикул', 'xml-for-avito' ) ]
					],
					'rules' => [ 
						'yandex_market', 'dbs', 'single_catalog', 'sales_terms', 'sbermegamarket', 'beru',
						'products_and_offers', 'yandex_webmaster', 'all_elements', 'ozon', 'vk'
					],
					'tag_name' => 'Model'
				]
			],
			[ 
				0 => 'xfavi_generation', 1 => 'disabled', 2 => 'public', // TODO: Удалить потом эту строку
				'opt_name' => 'xfavi_generation',
				'def_val' => 'disabled',
				'mark' => 'public',
				'required' => false,
				'type' => 'select',
				'tab' => 'wp_list_table',
				'data' => [ 
					'label' => __( 'Поколение автомобиля', 'xml-for-avito' ),
					'desc' => __( 'Элемент', 'xml-for-avito' ),
					'woo_attr' => true,
					'default_value' => false,
					'key_value_arr' => [ 
						[ 'value' => 'disabled', 'text' => __( 'Отключено', 'xml-for-avito' ) ],
						[ 'value' => 'sku', 'text' => __( 'Подставлять из Артикул', 'xml-for-avito' ) ]
					],
					'rules' => [ 
						'yandex_market', 'dbs', 'single_catalog', 'sales_terms', 'sbermegamarket', 'beru',
						'products_and_offers', 'yandex_webmaster', 'all_elements', 'ozon', 'vk'
					],
					'tag_name' => 'Generation'
				]
			]
		];

		if ( empty( $manager_name ) ) {
			$blog_title = get_bloginfo( 'name' );
			$this->manager_name = substr( $blog_title, 0, 20 );
		}
		if ( ! empty( $data_arr ) ) {
			$this->data_arr = $data_arr;
		}

		array_push( $this->data_arr,
			[ 'xfavi_managerName', $this->manager_name, 'public' ]
		);

		$args_arr = [ $this->manager_name ];
		$this->data_arr = apply_filters( 'xfavi_set_default_feed_settings_result_arr_filter', $this->data_arr, $args_arr );
	}

	/**
	 * Summary of get_data_arr
	 * 
	 * @return array
	 */
	public function get_data_arr() {
		return $this->data_arr;
	}

	/**
	 * Get data for tabs
	 * 
	 * @param string $whot
	 * 
	 * @return array	Example: array([0] => opt_key1, [1] => opt_key2, ...)
	 */
	public function get_data_for_tabs( $whot = '' ) {
		$res_arr = [];
		if ( $this->data_arr ) {
			for ( $i = 0; $i < count( $this->data_arr ); $i++ ) {
				switch ( $whot ) {
					case "main_tab":
					case "shop_data_tab":
					case "tags_settings_tab":
					case "filtration_tab":
						if ( $this->data_arr[ $i ]['tab'] === $whot ) {
							$arr = $this->data_arr[ $i ]['data'];
							$arr['opt_name'] = $this->data_arr[ $i ]['opt_name'];
							$arr['tab'] = $this->data_arr[ $i ]['tab'];
							$arr['type'] = $this->data_arr[ $i ]['type'];
							$res_arr[] = $arr;
						}
						break;
					case "wp_list_table":
						if ( $this->data_arr[ $i ]['tab'] === $whot ) {
							$arr = $this->data_arr[ $i ];
							$res_arr[] = $arr;
						}
						break;
					default:
						$arr = $this->data_arr[ $i ]['data'];
						$arr['opt_name'] = $this->data_arr[ $i ]['opt_name'];
						$arr['tab'] = $this->data_arr[ $i ]['tab'];
						$arr['type'] = $this->data_arr[ $i ]['type'];
						$res_arr[] = $arr;
				}
			}
			return $res_arr;
		} else {
			return $res_arr;
		}
	}

	/**
	 * Get plugin options name
	 * 
	 * @param string $whot
	 * 
	 * @return array	Example: array([0] => opt_key1, [1] => opt_key2, ...)
	 */
	public function get_opts_name( $whot = '' ) {
		if ( $this->data_arr ) {
			$res_arr = [];
			for ( $i = 0; $i < count( $this->data_arr ); $i++ ) {
				switch ( $whot ) {
					case "public":
						if ( $this->data_arr[ $i ][2] === 'public' ) {
							$res_arr[] = $this->data_arr[ $i ][0];
						}
						break;
					case "private":
						if ( $this->data_arr[ $i ][2] === 'private' ) {
							$res_arr[] = $this->data_arr[ $i ][0];
						}
						break;
					default:
						$res_arr[] = $this->data_arr[ $i ][0];
				}
			}
			return $res_arr;
		} else {
			return [];
		}
	}

	/**
	 * Get plugin options name and default date (array)
	 * 
	 * @param string $whot
	 * 
	 * @return array	Example: array(opt_name1 => opt_val1, opt_name2 => opt_val2, ...)
	 */
	public function get_opts_name_and_def_date( $whot = 'all' ) {
		if ( $this->data_arr ) {
			$res_arr = [];
			for ( $i = 0; $i < count( $this->data_arr ); $i++ ) {
				switch ( $whot ) {
					case "public":
						if ( $this->data_arr[ $i ][2] === 'public' ) {
							$res_arr[ $this->data_arr[ $i ][0] ] = $this->data_arr[ $i ][1];
						}
						break;
					case "private":
						if ( $this->data_arr[ $i ][2] === 'private' ) {
							$res_arr[ $this->data_arr[ $i ][0] ] = $this->data_arr[ $i ][1];
						}
						break;
					default:
						$res_arr[ $this->data_arr[ $i ][0] ] = $this->data_arr[ $i ][1];
				}
			}
			return $res_arr;
		} else {
			return [];
		}
	}

	/**
	 * Get plugin options name and default date (stdClass object)
	 * 
	 * @param string $whot
	 * 
	 * @return array<stdClass>
	 */
	public function get_opts_name_and_def_date_obj( $whot = 'all' ) {
		$source_arr = $this->get_opts_name_and_def_date( $whot );

		$res_arr = [];
		foreach ( $source_arr as $key => $value ) {
			$obj = new stdClass();
			$obj->name = $key;
			$obj->opt_def_value = $value;
			$res_arr[] = $obj; // unit obj
			unset( $obj );
		}
		return $res_arr;
	}
}