<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once XFAVI_PLUGIN_DIR_PATH . 'includes/old-php-add-functions-1-0-0.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'includes/icopydoc-useful-functions-1-1-3.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'includes/wc-add-functions-1-0-1.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'includes/class-icpd-feedback-1-0-0.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'includes/class-icpd-promo-1-0-0.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'functions.php'; // Подключаем файл функций
require_once XFAVI_PLUGIN_DIR_PATH . 'includes/backward-compatibility.php';

require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi.php';

require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/common/trait-xfavi-t-common-ad.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/common/trait-xfavi-t-common-get-catid.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/common/trait-xfavi-t-common-skips.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/common/trait-xfavi-t-common-сontact-info.php';

require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/global/traits-xfavi-global-variables.php';

require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-adtype.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-apparel.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-appareltype.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-brand.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-category.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-condition.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-description.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-generation.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-forwhom.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-goods-sub-type.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-goods-type.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-id.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-image.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-make.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-material.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-mechanism.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-model.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-oem.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-price.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-product_sub_type.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-size.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-title.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/simple/trait-xfavi-t-simple-get-color.php';

require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-adtype.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-apparel.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-appareltype.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-brand.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-category.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-condition.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-description.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-generation.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-forwhom.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-goods-sub-type.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-goods-type.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-id.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-image.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-make.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-material.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-mechanism.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-model.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-oem.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-price.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-product_sub_type.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-size.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-title.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/traits/variable/trait-xfavi-t-variable-get-color.php';

require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/class-xfavi-get-closed-tag.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/class-xfavi-get-open-tag.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/class-xfavi-get-paired-tag.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/class-xfavi-get-unit.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/class-xfavi-get-unit-offer.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/class-xfavi-get-unit-offer-simple.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/class-xfavi-get-unit-offer-variable.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/generation/class-xfavi-generation-xml.php';

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-wp-list-table.php';
// require_once XFAVI_PLUGIN_DIR_PATH.'classes/system/class-xfavi-settings-feed-wp-list-table.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-feedback.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-error-log.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-plugin-form-activate.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-plugin-upd.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-settings-page.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-interface-hocked.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-data-arr.php';
require_once XFAVI_PLUGIN_DIR_PATH . 'classes/system/class-xfavi-debug-page.php';