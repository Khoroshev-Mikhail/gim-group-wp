<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Traits Apparel for simple products
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
 *                          traits:     
 *                          methods:    get_feed_id
 *                                      get_product
 *                          functions:  common_option_get
 *                          constants:  
 */

trait XFAVI_T_Simple_Get_Apparel {
	/**
	 * Summary of get_apparel
	 * @param string $tag_name
	 * @param string $standart
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	public function get_apparel( $tag_name = 'Apparel', $standart = '', $result_xml = '' ) {
		if ( get_post_meta( $this->get_product()->get_id(), '_xfavi_apparel', true ) === ''
			|| get_post_meta( $this->get_product()->get_id(), '_xfavi_apparel', true ) === 'default' ) {
			// если в карточке товара запрет - проверяем значения по дефолту
			if ( get_term_meta( $this->get_feed_category_id(), 'xfavi_default_apparel', true ) == '' ) {
				$this->add_skip_reason( [ 
					'reason' => __( 'Отсутствует Apparel', 'xml-for-avito' ),
					'post_id' => $this->get_product()->get_id(),
					'file' => 'trait-xfavi-t-simple-get-apparel.php',
					'line' => __LINE__
				] );
				return '';
			} else if ( get_term_meta( $this->get_feed_category_id(), 'xfavi_default_apparel', true ) == 'disabled' ) {
				$result_apparel = '';
			} else {
				$result_apparel = get_term_meta( $this->get_feed_category_id(), 'xfavi_default_apparel', true );
			}
		} else {
			$result_apparel = get_post_meta( $this->get_product()->get_id(), '_xfavi_apparel', true );
			if ( $result_apparel === 'disabled' ) {
				$result_apparel = '';
			}
		}
		if ( ( $result_apparel == '' || $result_apparel === 'disabled' ) ) {
			if ( $standart === 'lichnye_veshi'
				&& in_array( $this->get_feed_category_avito_name(), [ 'Одежда, обувь, аксессуары', 'Детская одежда и обувь' ] ) ) {
				$this->add_skip_reason( [ 
					'reason' => __( 'Отсутствует Apparel', 'xml-for-avito' ),
					'post_id' => $this->get_product()->get_id(),
					'file' => 'trait-xfavi-t-simple-get-apparel.php',
					'line' => __LINE__
				] );
				return '';
			}
		}

		$result_apparel = apply_filters(
			'xfavi_f_simple_tag_apparel',
			$result_apparel,
			[ 'product' => $this->get_product() ],
			$this->get_feed_id()
		);

		if ( empty( $result_apparel ) ) {
			return $result_xml;
		}

		if ( $result_apparel == 'Сумки' ) {
			$result_xml .= $this->get_color();
			$result_xml .= $this->get_material();
		}

		$result_xml .= new XFAVI_Get_Paired_Tag( $tag_name, $result_apparel );
		return $result_xml;
	}
}