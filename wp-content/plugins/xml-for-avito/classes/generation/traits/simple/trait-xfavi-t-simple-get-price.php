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

trait XFAVI_T_Simple_Get_Price {
	public function get_price($tag_name = 'price', $result_xml = '') {
		$product = $this->product;
		$product_category_id = $this->get_feed_category_id();

		/**
		 * $offer->get_price() - актуальная цена (равна sale_price или regular_price если sale_price пуст)
		 * $offer->get_regular_price() - обычная цена
		 * $offer->get_sale_price() - цена скидки
		 */
		$price_xml = $product->get_price();
		$price_xml = apply_filters('xfavi_simple_price_filter', $price_xml, $product, $this->get_feed_id()); /* с версии 3.0.0 */ 
		$price_xml = apply_filters('xfavi_f_simple_price', $price_xml, array('product' => $product, 'product_category_id' => $product_category_id), $this->get_feed_id());

		if ($price_xml == 0 || empty($price_xml)) {$this->add_skip_reason(array('reason' => __('Price not specified', 'xfavi'), 'post_id' => $product->get_id(), 'file' => 'trait-xfavi-t-simple-get-price.php', 'line' => __LINE__)); return '';}
		
		if (class_exists('XmlforAvitoPro')) {
		   	if ((xfavi_optionGET('xfavip_compare_value', $this->get_feed_id(), 'set_arr') !== false) && (xfavi_optionGET('xfavip_compare_value', $this->get_feed_id(), 'set_arr') !== '')) {
				$xfavip_compare_value = xfavi_optionGET('xfavip_compare_value', $this->get_feed_id(), 'set_arr');
				$xfavip_compare = xfavi_optionGET('xfavip_compare', $this->get_feed_id(), 'set_arr');
				if ($xfavip_compare == '>=' || $xfavip_compare == "&gt;=") {
					if ($price_xml < $xfavip_compare_value) {
						$this->add_skip_reason( [ 'reason' => __('Цена товара', 'xfavi').' '. $product->get_price(). ': < ' . $xfavip_compare_value, 'post_id' => $product->get_id(), 'file' => 'trait-xfavi-t-simple-get-price.php', 'line' => __LINE__ ] ); return '';
					}
				} else {
					if ($price_xml >= $xfavip_compare_value) {
						$this->add_skip_reason( [ 'reason' => __('Цена товара', 'xfavi').' '. $product->get_price(). ': >= ' . $xfavip_compare_value, 'post_id' => $product->get_id(), 'file' => 'trait-xfavi-t-simple-get-price.php', 'line' => __LINE__ ] ); return '';
					}
				}
		   }
		}

		$skip_price_reason = false;
		$skip_price_reason = apply_filters('xfavi_f_simple_skip_price_reason', $skip_price_reason, array('price_xml' => $price_xml, 'product' => $product), $this->get_feed_id());
		if ($skip_price_reason !== false) {
			$this->add_skip_reason(array('reason' => $skip_price_reason, 'post_id' => $product->get_id(), 'file' => 'trait-xfavi-t-simple-get-price.php', 'line' => __LINE__)); return '';
		}
		
		$price_xml = apply_filters('xfavi_simple_price_xml_filter', $price_xml, $product, $this->get_feed_id()); 

		$result_xml .= new XFAVI_Get_Paired_Tag($tag_name, $price_xml);

		$result_xml = apply_filters('xfavi_f_simple_tag_price', $result_xml, array('product' => $product, 'product_category_id' => $product_category_id), $this->get_feed_id());
		return $result_xml;
	}
}