<?php if (!defined('ABSPATH')) {exit;}
/**
* Traits for products
*
* @author		Maxim Glazunov
* @link			https://icopydoc.ru/
* @since		1.6.0
*
* @return 		$result_xml (string)
*
* @depends		class:		XFAVI_Get_Paired_Tag
*				methods: 	get_product
*							get_feed_id
*				functions:	xfavi_optionGET
*/
trait XFAVI_T_Common_Ad {
	public function get_common_ad($result_xml = '') {
		$xfavi_listing_fee = xfavi_optionGET('xfavi_listing_fee', $this->get_feed_id(), 'set_arr'); 
		if (empty($xfavi_listing_fee) || $xfavi_listing_fee == 'disabled') {
		} else {
			$result_xml = new XFAVI_Get_Paired_Tag('ListingFee', $xfavi_listing_fee);
		}

		$result_xml = apply_filters('xfavi_f_common_ad', $result_xml, [ 'product' => $this->get_product() ], $this->get_feed_id());
		return $result_xml;
	}
}