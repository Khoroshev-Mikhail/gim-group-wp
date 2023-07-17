<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Get_Unit_Offer_Simple for simple products
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
 * @depends                 classes:    XFAVI_Get_Unit_Offer
 *                                      XFAVI_Error_Log
 *                          traits:     
 *                          methods:    
 *                                      
 *                                      
 *                          functions:  
 *                          constants:  
 */

class XFAVI_Get_Unit_Offer_Simple extends XFAVI_Get_Unit_Offer {
	use XFAVI_T_Common_Ad;
	use XFAVI_T_Common_Contact_Info;
	use XFAVI_T_Common_Get_CatId;
	use XFAVI_T_Common_Skips;

	use XFAVI_T_Simple_Get_Adtype;
	use XFAVI_T_Simple_Get_Apparel;
	use XFAVI_T_Simple_Get_Appareltype;
	use XFAVI_T_Simple_Get_Brand;
	use XFAVI_T_Simple_Get_Category;
	use XFAVI_T_Simple_Get_Color;
	use XFAVI_T_Simple_Get_Condition;
	use XFAVI_T_Simple_Get_Generation;
	use XFAVI_T_Simple_Get_Forwhom;
	use XFAVI_T_Simple_Get_Description;
	use XFAVI_T_Simple_Get_Goods_Sub_Type;
	use XFAVI_T_Simple_Get_Goods_Type;
	use XFAVI_T_Simple_Get_Id;
	use XFAVI_T_Simple_Get_Image;
	use XFAVI_T_Simple_Get_Make;
	use XFAVI_T_Simple_Get_Material;
	use XFAVI_T_Simple_Get_Mechanism;
	use XFAVI_T_Simple_Get_Model;
	use XFAVI_T_Simple_Get_OEM;
	use XFAVI_T_Simple_Get_Price;
	use XFAVI_T_Simple_Get_ProductSubType;
	use XFAVI_T_Simple_Get_Size;
	use XFAVI_T_Simple_Get_Title;

	public function generation_product_xml( $result_xml = '' ) {
		$this->set_category_id();
		// $this->feed_category_id = $this->get_catid();
		$this->get_skips();

		if ( get_term_meta( $this->get_feed_category_id(), 'xfavi_avito_standart', true ) !== '' ) {
			$xfavi_avito_standart = get_term_meta( $this->get_feed_category_id(), 'xfavi_avito_standart', true );
		} else {
			new XFAVI_Error_Log( 'FEED № ' . $this->get_feed_id() . '; WARNING: Для категории $this->get_feed_category_id() = ' . $this->get_feed_category_id() . ' задан стандарт по умолчанию; Файл: class-xfavi-get-unit-offer-simple.php; Строка: ' . __LINE__ );
			$xfavi_avito_standart = 'lichnye_veshi';
		}

		switch ( $xfavi_avito_standart ) {
			case "lichnye_veshi":
				$result_xml = $this->lichnye_veshi();
				break;
			case "dom":
				$result_xml = $this->dom();
				break;
			case "tehnika":
				$result_xml = $this->tehnika();
				break;
			case "zapchasti":
				$result_xml = $this->zapchasti();
				break;
			case "business":
				$result_xml = $this->business();
				break;
			case "hobby":
				$result_xml = $this->hobby();
				break;
			case "zhivotnye":
				$result_xml = $this->zhivotnye();
				break;
			default:
				$result_xml = $this->lichnye_veshi();
		}

		// TODO: @deprecated. Удалить в след.версиях
		$result_xml = apply_filters( 'xfavi_append_simple_offer_filter', $result_xml, $this->product, $this->get_feed_id() );

		$result_xml = apply_filters(
			'x4avi_f_append_simple_offer',
			$result_xml,
			[ 
				'product' => $this->product,
				'feed_category_id' => $this->get_feed_category_id()
			],
			$this->get_feed_id()
		);
		$result_xml .= '</Ad>' . PHP_EOL;
		return $result_xml;
	}

	private function get_common_xml_data( $result_xml = '' ) {
		$result_xml .= $this->get_common_ad();
		$result_xml .= $this->get_contact_info();
		$result_xml .= $this->get_category();
		$result_xml .= $this->get_condition();

		$result_xml .= $this->get_image();
		$result_xml .= $this->get_description();
		$result_xml .= $this->get_id();
		$result_xml .= $this->get_title();

		if ( class_exists( 'WOOCS' ) ) {
			$xfavi_wooc_currencies = xfavi_optionGET( 'xfavi_wooc_currencies', $this->get_feed_id(), 'set_arr' );
			if ( $xfavi_wooc_currencies !== '' ) {
				global $WOOCS;
				$WOOCS->set_currency( $xfavi_wooc_currencies );
			}
		}
		$result_xml .= $this->get_price();
		if ( class_exists( 'WOOCS' ) ) {
			global $WOOCS;
			$WOOCS->reset_currency();
		}
		return $result_xml;
	}

	/**
	 * Summary of lichnye_veshi
	 * 
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	private function lichnye_veshi( $result_xml = '' ) {
		$result_xml .= $this->get_offer_tag();

		$result_xml .= $this->get_goods_type();
		$result_xml .= $this->get_goods_sub_type();
		$result_xml .= $this->get_product_sub_type();
		$result_xml .= $this->get_forwhom();
		$result_xml .= $this->get_mechanism();
		$result_xml .= $this->get_apparel( 'Apparel', 'lichnye_veshi' );
		$result_xml .= $this->get_appareltype();
		$result_xml .= $this->get_adtype();
		$result_xml .= $this->get_size();
		$result_xml .= $this->get_brand();

		$result_xml .= $this->get_common_xml_data();
		return $result_xml;
	}

	/**
	 * Summary of dom
	 * 
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	private function dom( $result_xml = '' ) {
		$result_xml .= $this->get_offer_tag();

		$result_xml .= $this->get_goods_type();
		$result_xml .= $this->get_adtype();
		$result_xml .= $this->get_goods_sub_type();

		$result_xml .= $this->get_common_xml_data();
		return $result_xml;
	}

	/**
	 * Summary of tehnika
	 * 
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	private function tehnika( $result_xml = '' ) {
		$result_xml .= $this->get_offer_tag();

		$result_xml .= $this->get_goods_type();
		$result_xml .= $this->get_goods_sub_type( 'ProductsType' );
		$result_xml .= $this->get_adtype( 'AdType', 'tehnika' );
		$result_xml .= $this->get_oem();

		$result_xml .= $this->get_common_xml_data();
		return $result_xml;
	}

	/**
	 * Summary of zapchasti
	 * 
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	private function zapchasti( $result_xml = '' ) {
		$result_xml .= $this->get_offer_tag();

		$result_xml .= $this->get_goods_type( 'TypeId', 'zapchasti' );
		// $result_xml .= $this->get_goods_sub_type('ProductsType');
		$result_xml .= $this->get_adtype( 'AdType', 'zapchasti' );
		$result_xml .= $this->get_oem();
		$result_xml .= $this->get_brand();
		$result_xml .= $this->get_make();
		$result_xml .= $this->get_model();
		$result_xml .= $this->get_generation();

		$result_xml .= $this->get_common_xml_data();
		return $result_xml;
	}

	/**
	 * Summary of business
	 * 
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	private function business( $result_xml = '' ) {
		$result_xml .= $this->get_offer_tag();

		$result_xml .= $this->get_goods_type();
		$result_xml .= $this->get_goods_sub_type();

		$result_xml .= $this->get_common_xml_data();
		return $result_xml;
	}

	/**
	 * Summary of hobby
	 * 
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	private function hobby( $result_xml = '' ) {
		$result_xml .= $this->get_offer_tag();

		$result_xml .= $this->get_goods_type( 'GoodsType', 'hobby' );
		$result_xml .= $this->get_adtype();

		$result_xml .= $this->get_common_xml_data();
		return $result_xml;
	}

	/**
	 * Summary of zhivotnye
	 * 
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	private function zhivotnye( $result_xml = '' ) {
		$result_xml .= $this->get_offer_tag();

		$result_xml .= $this->get_goods_type( 'GoodsType', 'zhivotnye' );

		$result_xml .= $this->get_common_xml_data();
		return $result_xml;
	}

	/**
	 * Summary of get_offer_tag
	 * 
	 * @return string
	 */
	private function get_offer_tag() {
		return '<Ad>' . PHP_EOL;
	}
}