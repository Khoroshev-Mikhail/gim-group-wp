<?php if (!defined('ABSPATH')) {exit;}
/**
* Traits for variable products
*
* @author		Maxim Glazunov
* @link			https://icopydoc.ru/
* @since		1.6.7
*
* @return 		$result_xml (string)
*
* @depends		class:	XFAVI_Get_Paired_Tag
*				methods: add_skip_reason
*				functions: 
*/

trait XFAVI_T_Variable_Get_Brand {
	public function get_brand($tag_name = 'Brand', $result_xml = '') {
		$product = $this->get_product();
		$offer = $this->get_offer();
		$tag_value = '';

		$brand = xfavi_optionGET('xfavi_brand', $this->get_feed_id(), 'set_arr');
		if (empty($brand) || $brand === 'disabled') { } else {
			$brand = (int)$brand;
			$tag_value = $offer->get_attribute(wc_attribute_taxonomy_name_by_id($brand));
			if (empty($tag_value)) {	
				$tag_value = $product->get_attribute(wc_attribute_taxonomy_name_by_id($brand));
			}
		}
		
		$tag_value = apply_filters('xfavi_f_variable_tag_value_brand', $tag_value, array('product' => $product, 'offer' => $offer), $this->get_feed_id());
		if (!empty($tag_value)) {	
			$tag_name = apply_filters('xfavi_f_variable_tag_name_brand', $tag_name, array('product' => $product, 'offer' => $offer), $this->get_feed_id());
			$result_xml = new XFAVI_Get_Paired_Tag($tag_name, $tag_value);
		}

		$result_xml = apply_filters('xfavi_f_variable_tag_brand', $result_xml, array('product' => $product, 'offer' => $offer), $this->get_feed_id());
		return $result_xml;
	}
}
?>