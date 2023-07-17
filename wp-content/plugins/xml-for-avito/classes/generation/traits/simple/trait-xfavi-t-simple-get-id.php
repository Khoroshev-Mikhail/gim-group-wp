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

trait XFAVI_T_Simple_Get_Id {
	public function get_id($tag_name = 'Id', $result_xml = '') {
		$product = $this->product;
		$result_xml_id = $product->get_id();

		$result_xml_id = new XFAVI_Get_Paired_Tag($tag_name, $result_xml_id);
		return $result_xml_id; 
	}
}
?>