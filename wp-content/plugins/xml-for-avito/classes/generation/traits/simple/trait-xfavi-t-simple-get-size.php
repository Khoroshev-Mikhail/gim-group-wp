<?php if (!defined('ABSPATH')) {exit;}
/**
* Traits for simple products
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

trait XFAVI_T_Simple_Get_Size {
	public function get_size($tag_name = 'Size', $result_xml = '') {
		$product = $this->get_product();
		$tag_value = '';

		$size = xfavi_optionGET('xfavi_size', $this->get_feed_id(), 'set_arr');
		if (empty($size) || $size === 'disabled') { } else {
			$size = (int)$size;
			$tag_value = $product->get_attribute(wc_attribute_taxonomy_name_by_id($size));
		}
		
		$tag_value = apply_filters('xfavi_f_simple_tag_value_size', $tag_value, array('product' => $product), $this->get_feed_id());
		if (!empty($tag_value)) {	
			$tag_name = apply_filters('xfavi_f_simple_tag_name_size', $tag_name, array('product' => $product), $this->get_feed_id());
			$result_xml = new XFAVI_Get_Paired_Tag($tag_name, $tag_value);
		}

		$result_xml = apply_filters('xfavi_f_simple_tag_size', $result_xml, array('product' => $product), $this->get_feed_id());
		return $result_xml;
	}
}
?>