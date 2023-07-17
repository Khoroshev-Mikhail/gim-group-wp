<?php if (!defined('ABSPATH')) {exit;}
/**
 * Traits OEM for simple products
 *
 * @package					XML for Avito
 * @subpackage				
 * @since					1.6.0
 * 
 * @version					1.0.0
 * @author					Maxim Glazunov
 * @link					https://icopydoc.ru/
 * @see						
 * 
 * @param	string			$tag_name (not require)
 * @param	string			$result_xml (not require)
 *
 * @return 					$result_xml (string)
 *
 * @depends					classes:	XFAVI_Get_Paired_Tag
 *							traits:		
 *							methods:	get_product
 *										get_feed_id
 *							functions:	xfavi_optionGET
 *							constants:	
 */

trait XFAVI_T_Simple_Get_Oem {
	public function get_oem($tag_name = 'OEM', $result_xml = '') {
		$tag_value = '';

		$oem = xfavi_optionGET('xfavi_oem', $this->get_feed_id(), 'set_arr');
		switch ($oem) { /* disabled, sku, id */
			case "disabled": // выгружать штрихкод нет нужды		
				break; 
			case "sku": // выгружать из артикула
				$tag_value = $this->get_product()->get_sku();
			default:
				$oem = (int)$oem;
				$tag_value = $this->get_product()->get_attribute(wc_attribute_taxonomy_name_by_id($oem));
		} 
		
		if (!empty($oem) && $oem !== 'disabled') { // значение внутри карточки товара в приоритете
			if (get_post_meta($this->get_product()->get_id(), '_xfavi_oem', true) !== '') {
				$tag_value = get_post_meta($this->get_product()->get_id(), '_xfavi_oem', true);
			}
		}
		
		$tag_value = apply_filters('xfavi_f_simple_tag_value_oem', $tag_value, [ 'product' => $this->get_product() ], $this->get_feed_id());
		if (!empty($tag_value)) {	
			$tag_name = apply_filters('xfavi_f_simple_tag_name_oem', $tag_name, [ 'product' => $this->get_product() ], $this->get_feed_id());
			$result_xml = new XFAVI_Get_Paired_Tag($tag_name, $tag_value);
		}

		$result_xml = apply_filters('xfavi_f_simple_tag_oem', $result_xml, [ 'product' => $this->get_product() ], $this->get_feed_id());
		return $result_xml;
	}
}