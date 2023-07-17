<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Traits GoodsType for variable products
 *
 * @package                 XML for Avito
 * @subpackage              
 * @since                   0.1.0
 * 
 * @version                 1.9.1 (11-07-2023)
 * @author                  Maxim Glazunov
 * @link                    https://icopydoc.ru/
 * @see                     
 *
 * @depends                 classes:    XFAVI_Get_Paired_Tag
 *                                      SimpleXMLElement
 *                          traits:     
 *                          methods:    get_feed_id
 *                                      get_product
 *                                      get_offer
 *                          functions:  
 *                          constants:  XFAVI_PLUGIN_DIR_PATH
 */

trait XFAVI_T_Variable_Get_Goods_Type {
	/**
	 * Summary of get_goods_type
	 * @param string $tag_name
	 * @param string $standart
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	public function get_goods_type( $tag_name = 'GoodsType', $standart = '', $result_xml = '' ) {
		// для Охота и рыбалка в разделе хобби GoodsType не нужен
		if ( $this->get_feed_category_avito_name() === 'Охота и рыбалка' ) {
			return '';
		}

		if ( get_post_meta( $this->get_product()->get_id(), '_xfavi_goods_type', true ) === ''
			|| get_post_meta( $this->get_product()->get_id(), '_xfavi_goods_type', true ) === 'default' ) {
			// если в карточке товара запрет - проверяем значения по дефолту
			if ( get_term_meta( $this->get_feed_category_id(), 'xfavi_default_goods_type', true ) == '' ) {
				$this->add_skip_reason( [ 
					'offer_id' => $this->get_offer()->get_id(),
					'reason' => __( 'Отсутствует GoodsType', 'xml-for-avito' ),
					'post_id' => $this->get_product()->get_id(),
					'file' => 'trait-xfavi-t-variable-get-goods-type.php',
					'line' => __LINE__
				] );
				return '';
			} else {
				$xfavi_default_goods_type = get_term_meta( $this->get_feed_category_id(), 'xfavi_default_goods_type', true );
				$xfavi_default_goods_type = str_replace( '_', ' ', $xfavi_default_goods_type );
				if ( $xfavi_default_goods_type === 'disabled' ) {
					$result_goods_type = '';
				} else {
					$result_goods_type = $xfavi_default_goods_type;
				}
			}
		} else {
			$result_goods_type = get_post_meta( $this->get_product()->get_id(), '_xfavi_goods_type', true );
			$result_goods_type = str_replace( '_', ' ', $result_goods_type );
			if ( $result_goods_type === 'disabled' && $standart === '' ) {
				$this->add_skip_reason( [ 
					'offer_id' => $this->get_offer()->get_id(),
					'reason' => __( 'Отсутствует GoodsType', 'xml-for-avito' ),
					'post_id' => $this->get_product()->get_id(),
					'file' => 'trait-xfavi-t-variable-get-goods-type.php',
					'line' => __LINE__
				] );
				return '';
			} else if ( $result_goods_type === 'disabled' && $standart === 'hobby' ) {
				if ( $this->get_feed_category_avito_name() === 'Велосипеды'
					|| $this->get_feed_category_avito_name() === 'Охота и рыбалка' ) {
				} else {
					$this->add_skip_reason( [ 
						'offer_id' => $this->get_offer()->get_id(),
						'reason' => __( 'Отсутствует GoodsType', 'xml-for-avito' ),
						'post_id' => $this->get_product()->get_id(),
						'file' => 'trait-xfavi-t-variable-get-goods-type.php',
						'line' => __LINE__
					] );
					return '';
				}
			} else if ( $result_goods_type === 'disabled' && $standart === 'zhivotnye' ) {
				if ( $this->get_feed_category_avito_name() === 'Другие животные'
					|| $this->get_feed_category_avito_name() === 'Кошки'
					|| $this->get_feed_category_avito_name() === 'Собаки' ) {
					$this->add_skip_reason( [ 
						'offer_id' => $this->get_offer()->get_id(),
						'reason' => __( 'Отсутствует GoodsType / Bread', 'xml-for-avito' ),
						'post_id' => $this->get_product()->get_id(), 'file' => 'trait-xfavi-t-variable-get-goods-type.php',
						'line' => __LINE__ ] );
					return '';
				}
			}
		}

		if ( $result_goods_type !== '' && $standart === 'zhivotnye' ) {
			if ( $this->get_feed_category_avito_name() === 'Кошки' ||
				$this->get_feed_category_avito_name() === 'Собаки' ) {
				$tag_name = 'Breed';
				$result_xml .= new XFAVI_Get_Paired_Tag( 'AdType', 'Продаю как заводчик' );
			}
		}

		// для Велосипеды в разделе хобби GoodsType называется VehicleType
		if ( $this->get_feed_category_avito_name() === 'Велосипеды' ) {
			$tag_name = 'VehicleType';
		}

		// для раздела запчасти
		if ( $result_goods_type !== '' && $standart === 'zapchasti' ) {

			$result = false;
			$xml_url = XFAVI_PLUGIN_DIR_PATH . 'data/TypeId.xml';
			$xml_string = file_get_contents( $xml_url );
			$xml_object = new SimpleXMLElement( $xml_string );

			foreach ( $xml_object->children() as $second_gen ) {
				if ( $result_goods_type === (string) $second_gen[0] ) {
					$result_goods_type = $second_gen['id'];
					$result = true;
					break;
				}
			}
			if ( $result === false ) {
				$this->add_skip_reason( [ 
					'offer_id' => $this->get_offer()->get_id(),
					'reason' => __( 'Отсутствует TypeId', 'xml-for-avito' ),
					'post_id' => $this->get_product()->get_id(),
					'file' => 'trait-xfavi-t-variable-get-goods-type.php',
					'line' => __LINE__
				] );
				return '';
			}
		}

		if ( ! empty( $result_goods_type ) ) {
			$result_xml .= new XFAVI_Get_Paired_Tag( $tag_name, $result_goods_type );
		}

		if ( $result_goods_type === 'Телевизоры и проекторы' ) {
			$result_xml = $this->get_goods_sub_type( 'ProductsType', $result_xml );
		}

		return $result_xml;
	}
}