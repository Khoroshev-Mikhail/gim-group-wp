<?php if (!defined('ABSPATH')) {exit;}
/**
* Traits for variable products
*
* @author		Maxim Glazunov
* @link			https://icopydoc.ru/
* @since		1.6.0
*
* @return 		$result_xml (string)
*
* @depends		class:	XFAVI_Get_Paired_Tag
*				methods: add_skip_reason
*				functions: 
*/

trait XFAVI_T_Variable_Get_Appareltype {
	public function get_appareltype($tag_name = 'ApparelType', $result_xml = '') {
		$product = $this->get_product();
		$offer = $this->offer;

		// ApparelType
		if (get_post_meta($product->get_id(), '_xfavi_appareltype', true) === '' || get_post_meta($product->get_id(), '_xfavi_appareltype', true) === 'default') {
			// если в карточке товара запрет - проверяем значения по дефолту
			if (get_term_meta($this->get_feed_category_id(), 'xfavi_default_appareltype', true) !== '') {	
				$result_appareltype = get_term_meta($this->get_feed_category_id(), 'xfavi_default_appareltype', true);
			} else {
				$result_appareltype = '';
			}
		} else {
			$result_appareltype = get_post_meta($product->get_id(), '_xfavi_appareltype', true);
			if ($result_appareltype === 'disabled') {
				$result_appareltype = '';
			}
		}
		if (($result_appareltype == '' || $result_appareltype === 'disabled')) {
			$result_xml_appareltype = '';
		} else {	
			$result_xml_appareltype = $result_appareltype;
		}
		// end ApparelType

		$result_xml_appareltype = new XFAVI_Get_Paired_Tag($tag_name, $result_xml_appareltype);
		return $result_xml_appareltype; 
	}
}
?>