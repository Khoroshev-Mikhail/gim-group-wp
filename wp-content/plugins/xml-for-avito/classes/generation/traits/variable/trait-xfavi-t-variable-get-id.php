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

trait XFAVI_T_Variable_Get_Id {
	public function get_id($tag_name = 'Id', $result_xml = '') {
		$xfavi_var_source_id = xfavi_optionGET('xfavi_var_source_id', $this->get_feed_id(), 'set_arr');
		if ($xfavi_var_source_id === 'product_id') {
			$result_xml_id = $this->get_product()->get_id();
		} else {
			$result_xml_id = $this->get_offer()->get_id();
		}

		$result_xml = new XFAVI_Get_Paired_Tag($tag_name, $result_xml_id);
		$result_xml = apply_filters('xfavi_f_variable_tag_id', $result_xml, [ 'product' => $this->get_product(), 'offer' => $this->get_offer() ], $this->get_feed_id());
		return $result_xml;
	}
}