<?php if (!defined('ABSPATH')) {exit;}
/*
Version: 1.0.0
Date: 20-02-2022
Author: Maxim Glazunov
Author URI: https://icopydoc.ru 
License: GPLv2
Description: This code helps ensure backward compatibility with older versions of the plugin.
*/

define('xfavi_DIR', plugin_dir_path(__FILE__)); // xfavi_DIR contains /home/p135/www/site.ru/wp-content/plugins/myplagin/		
define('xfavi_URL', plugin_dir_url(__FILE__)); // xfavi_URL contains http://site.ru/wp-content/plugins/myplagin/		
$upload_dir = (object)wp_get_upload_dir(); // xfavi_UPLOAD_DIR contains /home/p256/www/site.ru/wp-content/uploads
define('xfavi_UPLOAD_DIR', $upload_dir->basedir);
$name_dir = $upload_dir->basedir."/xml-for-avito"; 
define('xfavi_NAME_DIR', $name_dir); // xfavi_UPLOAD_DIR contains /home/p256/www/site.ru/wp-content/uploads/xfavi
$xfavi_keeplogs = xfavi_optionGET('xfavi_keeplogs');
define('xfavi_KEEPLOGS', $xfavi_keeplogs);
define('xfavi_VER', '1.4.5');
if (!defined('xfavi_ALLNUMFEED')) {
	define('xfavi_ALLNUMFEED', '3');
}

/*
* С версии 1.0.0
* Возвращает дерево таксономий, обернутое в <option></option>
*/
function xfavi_cat_tree($TermName = '', $termID = -1, $value_arr = [ ], $separator = '', $parent_shown = true) {
	/* 
	* $value_arr - массив id отмеченных ранее select-ов
	*/
	$result = '';
	$args = 'hierarchical=1&taxonomy='.$TermName.'&hide_empty=0&orderby=id&parent=';
	if ($parent_shown) {
		$term = get_term($termID , $TermName); 
		$selected = '';
		if (!empty($value_arr)) {
			foreach ($value_arr as $value) {		
				if ($value == $term->term_id) {
					$selected = 'selected'; break;
				}
			}
		}
		// $result = $separator.$term->name.'('.$term->term_id.')<br/>';
		$result = '<option title="'.$term->name.'; ID: '.$term->term_id.'; '. __('товаров', 'xml-for-avito'). ': '.$term->count.'" class="hover" value="'.$term->term_id.'" '.$selected .'>'.$separator.$term->name.'</option>';
		$parent_shown = false;
	}
	$separator .= '-';  
	$terms = get_terms($TermName, $args . $termID);
	if (count($terms) > 0) {
		foreach ($terms as $term) {
			$selected = '';
			if (!empty($value_arr)) {
				foreach ($value_arr as $value) {
					if ($value == $term->term_id) {
						$selected = 'selected'; break;
					}
				}
			}
			$result .= '<option title="'.$term->name.'; ID: '.$term->term_id.'; '. __('товаров', 'xml-for-avito'). ': '.$term->count.'" class="hover" value="'.$term->term_id.'" '.$selected .'>'.$separator.$term->name.'</option>';
			// $result .=  $separator.$term->name.'('.$term->term_id.')<br/>';
			$result .= xfavi_cat_tree($TermName, $term->term_id, $value_arr, $separator, $parent_shown);
		}
	}
	return $result; 
}

/**
 * @since 0.1.0
 * 
 * Функция обеспечивает правильность данных, чтобы не валились ошибки и не зависало
 */
function validation_variable($args, $p = 'xfavi') {
	$is_string = common_option_get('woo_'.'hook_isc'.$p);
	if ($is_string == '202' && $is_string !== $args) {
		return true;
	} else {
		return false;
	}
}