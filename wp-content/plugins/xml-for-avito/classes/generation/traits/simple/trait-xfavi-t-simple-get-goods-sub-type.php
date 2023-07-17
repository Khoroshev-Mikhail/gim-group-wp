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

trait XFAVI_T_Simple_Get_Goods_Sub_Type {
	public function get_goods_sub_type($tag_name = 'GoodsSubType', $result_xml = '') {
		$product = $this->product;

		if (get_post_meta($product->get_id(), '_xfavi_goods_subtype', true) === 'disabled') {
			$result_goods_subtype = 'disabled';
		} else if (get_post_meta($product->get_id(), '_xfavi_goods_subtype', true) == '' 
			|| get_post_meta($product->get_id(), '_xfavi_goods_subtype', true) === 'default') {
			$result_goods_subtype = get_term_meta($this->get_feed_category_id(), 'xfavi_default_goods_subtype', true);
			$result_goods_subtype = str_replace('_', ' ', $result_goods_subtype);
		} else {
			$result_goods_subtype = get_post_meta($product->get_id(), '_xfavi_goods_subtype', true);
		}
		if ($result_goods_subtype == '' || $result_goods_subtype == 'disabled') {

		} else {
			$result_xml .= new XFAVI_Get_Paired_Tag($tag_name, $result_goods_subtype);
		}
		
		return $result_xml; 
	}
}