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

trait XFAVI_T_Variable_Get_Description {
	public function get_description($tag_name = 'description', $result_xml = '') {
		$product = $this->get_product();
		$offer = $this->get_offer();
		$tag_value = '';

		$xfavi_xml_rules = xfavi_optionGET('xfavi_xml_rules', $this->get_feed_id(), 'set_arr');
		$xfavi_desc = xfavi_optionGET('xfavi_desc', $this->get_feed_id(), 'set_arr');
		$xfavi_the_content = xfavi_optionGET('xfavi_the_content', $this->get_feed_id(), 'set_arr');
		$xfavi_enable_tags_custom = xfavi_optionGET('xfavi_enable_tags_custom', $this->get_feed_id(), 'set_arr');
		$xfavi_enable_tags_behavior = xfavi_optionGET('xfavi_enable_tags_behavior', $this->get_feed_id(), 'set_arr');
		
		if ($xfavi_enable_tags_behavior == 'default') {
			$enable_tags = '<p>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<ul>,<li>,<ol>,<em>,<strong>,<br/>,<br>';
			$enable_tags = apply_filters('xfavi_enable_tags_filter', $enable_tags, $this->get_feed_id());
		} else {
			$enable_tags = trim($xfavi_enable_tags_custom);
			if ($enable_tags !== '') {
				$enable_tags = '<'.str_replace(',', '>,<', $enable_tags).'>';
			}			
		}		

		switch ($xfavi_desc) { 
		case "full": $description_xml = $product->get_description(); break;
		case "excerpt": $description_xml = $product->get_short_description(); break;
		case "fullexcerpt": 
			$description_xml = $product->get_description(); 
			if (empty($description_xml)) {
				$description_xml = $product->get_short_description();
			}
			break;
		case "excerptfull": 
			$description_xml = $product->get_short_description();		 
			if (empty($description_xml)) {
				$description_xml = $product->get_description();
			} 
			break;
		case "fullplusexcerpt": 
			$description_xml = $product->get_description().'<br/>'.$product->get_short_description();
			break;
		case "excerptplusfull": 
			$description_xml = $product->get_short_description().'<br/>'.$product->get_description(); 
			break;	
		break;	
			break;	
		default: $description_xml = $product->get_description(); 
			if (class_exists('XmlForAvitoPro')) {
				if ($xfavi_desc === 'post_meta') {
					$description_xml = '';
					$description_xml = apply_filters('xfavi_description_filter', $description_xml, $product->get_id(), $product, $this->get_feed_id());
					if (!empty($description_xml)) {trim($description_xml);}
				}
			}
		}	

		$result_xml_desc = '';
		$description_xml = apply_filters('xfavi_description_xml_filter', $description_xml, $product->get_id(), $product, $this->get_feed_id()); 
		if (!empty($description_xml)) {
			if ($xfavi_the_content === 'enabled') {
				$description_xml = html_entity_decode(apply_filters('the_content', $description_xml));
			}
			$description_xml = $this->replace_tags($description_xml, $xfavi_enable_tags_behavior);
			$description_xml = strip_tags($description_xml, $enable_tags);
			$description_xml = str_replace('<br>', '<br/>', $description_xml);
			$description_xml = strip_shortcodes($description_xml);
			$description_xml = apply_filters('xfavi_description_filter', $description_xml, $product->get_id(), $product, $this->get_feed_id());
			$description_xml = apply_filters('xfavi_description_filter_variable', $description_xml, $product->get_id(), $product, $offer, $this->get_feed_id());			
			$description_xml = trim($description_xml);
			
			$description_xml = apply_filters('xfavi_f_variable_val_description', $description_xml, array('product' => $product, 'offer' => $offer), $this->get_feed_id());
			if ($description_xml !== '') {
				$result_xml_desc = '<description><![CDATA['.$description_xml.']]></description>'.PHP_EOL;
			} 
		}

		// вариации

		$xfavi_var_desc_priority = xfavi_optionGET('xfavi_var_desc_priority', $this->get_feed_id(), 'set_arr');
		// Описание.
		if ($xfavi_var_desc_priority === 'on' || empty($description_xml)) {
			switch ($xfavi_desc) { 
				case "excerptplusfull": 
					$description_xml = $product->get_short_description().'<br/>'.$offer->get_description(); 
				break;					
				case "fullplusexcerpt": 
					$description_xml = $offer->get_description().'<br/>'.$product->get_short_description();
				break;	
				default: $description_xml = $offer->get_description();
			}		
		}

		if (!empty($description_xml)) {
			if ($xfavi_the_content === 'enabled') {
				$description_xml = html_entity_decode(apply_filters('the_content', $description_xml)); /* с версии 3.3.6 */
			}
			$description_xml = $this->replace_tags($description_xml, $xfavi_enable_tags_behavior);
			$description_xml = strip_tags($description_xml, $enable_tags);
			$description_xml = str_replace('<br>', '<br/>', $description_xml);
			$description_xml = strip_shortcodes($description_xml);
			$description_xml = apply_filters('xfavi_description_filter', $description_xml, $product->get_id(), $product, $this->get_feed_id());
			$description_xml = apply_filters('xfavi_description_filter_variable', $description_xml, $product->get_id(), $product, $offer, $this->get_feed_id()); /* с версии 3.2.6 */
			$description_xml = trim($description_xml);

			$description_xml = apply_filters('xfavi_f_variable_val_description', $description_xml, array('product' => $product, 'offer' => $offer), $this->get_feed_id());
			if ($description_xml !== '') {
				$result_xml .= '<description><![CDATA['.$description_xml.']]></description>'.PHP_EOL;
			}
			$description_xml = ''; // обнулим значение описания вариации, чтобы след вариация получила своё
		} else {
			// если у вариации нет своего описания - пробуем подставить общее
			if (!empty($result_xml_desc)) {$result_xml .= $result_xml_desc;}
		}

		$result_xml = apply_filters('xfavi_f_variable_tag_description', $result_xml, array('product' => $product, 'offer' => $offer), $this->get_feed_id());
		return $result_xml;
	}

	private function replace_tags($description_xml, $xfavi_enable_tags_behavior) {
		if ($xfavi_enable_tags_behavior == 'default') {
			$description_xml = str_replace('<ul>', '', $description_xml);
			$description_xml = str_replace('<li>', '', $description_xml);
			$description_xml = str_replace('</li>', '<br/>', $description_xml);
		}
		return $description_xml;
	}
}