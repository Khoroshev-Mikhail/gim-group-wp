<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Traits Title for simple products
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
 *                                      get_offer
 *                          functions:  
 *                          constants:  
 */

trait XFAVI_T_Simple_Get_Title {
	/**
	 * Summary of get_title
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string
	 */
	public function get_title( $tag_name = 'title', $result_xml = '' ) {
		if ( get_post_meta( $this->get_product()->get_id(), '_xfavi_product_name', true ) !== '' ) {
			$result_xml_name = get_post_meta( $this->get_product()->get_id(), '_xfavi_product_name', true );
		} else {
			$result_xml_name = $this->get_product()->get_title(); // название товара
			$result_xml_name = apply_filters(
				'xfavi_f_simple_tag_value_name',
				$result_xml_name,
				[ 'product' => $this->get_product() ],
				$this->get_feed_id()
			);
		}

		$result_xml_name = mb_substr( $result_xml_name, 0, 50 );
		$result_xml_name = htmlspecialchars( $result_xml_name, ENT_NOQUOTES );
		$result_xml = new XFAVI_Get_Paired_Tag( $tag_name, $result_xml_name );

		$result_xml = apply_filters(
			'xfavi_f_simple_tag_name',
			$result_xml,
			[ 'product' => $this->get_product() ],
			$this->get_feed_id()
		);
		return $result_xml;
	}
}