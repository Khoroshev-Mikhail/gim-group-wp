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
* @depends		class:		XFAVI_Get_Paired_Tag
*				methods: 	get_product
*							get_offer
*							get_feed_id
*				functions:	xfavi_optionGET
*/
trait XFAVI_T_Common_Contact_Info {
	public function get_contact_info() {
		$result_xml_сontact_info = '';
		$product = $this->get_product();
		$xfavi_address = stripslashes(htmlspecialchars(xfavi_optionGET('xfavi_address', $this->get_feed_id(), 'set_arr')));
		if ($xfavi_address !== '') {
			$result_xml_сontact_info .= '<Address>'.$xfavi_address.'</Address>'.PHP_EOL;
		} else {
			// new XFAVI_Error_Log('FEED № '.$this->get_feed_id().'; Товар с postId = '.$product->get_id().' пропущен т.к не указан адрес; Файл: offer.php; Строка: '.__LINE__); 
			$this->add_skip_reason(array('reason' => __('В настройках плагина не указан адрес', 'xfavi'), 'post_id' => $product->get_id(), 'file' => 'trait-xfavi-t-common-contact-info.php', 'line' => __LINE__)); return '';
		}
		$xfavi_allowEmail = xfavi_optionGET('xfavi_allowEmail', $this->get_feed_id(), 'set_arr'); 
		$xfavi_managerName = xfavi_optionGET('xfavi_managerName', $this->get_feed_id(), 'set_arr');
		$xfavi_contactPhone = xfavi_optionGET('xfavi_contactPhone', $this->get_feed_id(), 'set_arr');
		if ($xfavi_allowEmail !=='') {$result_xml_сontact_info .= '<AllowEmail>'.$xfavi_allowEmail.'</AllowEmail>'.PHP_EOL;}
		if ($xfavi_managerName !=='') {$result_xml_сontact_info .= '<ManagerName>'.$xfavi_managerName.'</ManagerName>'.PHP_EOL;}
		if ($xfavi_contactPhone !=='') {$result_xml_сontact_info .= '<ContactPhone>'.$xfavi_contactPhone.'</ContactPhone>'.PHP_EOL;}
	
		$result_xml_сontact_info = apply_filters('xfavi_xml_сontact_info', $result_xml_сontact_info, $product->get_id(), $product, array($xfavi_address, $xfavi_allowEmail, $xfavi_managerName, $xfavi_contactPhone), $this->get_feed_id()); /* с версии 1.3.1 */
			
		$xfavi_contact_method = xfavi_optionGET('xfavi_contact_method', $this->get_feed_id(), 'set_arr');
		switch($xfavi_contact_method) {
			case 'all':
				$msg = 'По телефону и в сообщениях';
				break;
			case 'phone':
				$msg = 'По телефону';
				break;
			case 'msg':
				$msg = 'В сообщениях';
				break;
			default:
				$msg = 'По телефону и в сообщениях';
				
		}
		$result_xml_сontact_info .= '<ContactMethod>'.$msg.'</ContactMethod>'.PHP_EOL;
		return $result_xml_сontact_info; 
	}
}