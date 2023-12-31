<?php
include_once 'custom-functions.php';


function strategy_assets() {
    wp_enqueue_style('headercss', get_template_directory_uri() . '/assets/css/header.css', time());
    wp_enqueue_style('containercss', get_template_directory_uri() . '/assets/css/container.css', time());
    wp_enqueue_style('footercss', get_template_directory_uri() . '/assets/css/footer.css', time());
    wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/assets/css/tailwind.css', time());
    wp_enqueue_style('mytailwindcss', get_template_directory_uri() . '/assets/css/my_tailwind.css', time());

    wp_enqueue_script( 'myfns', get_template_directory_uri() . '/assets/js/myfns.js');
}
add_action('wp_enqueue_scripts', 'strategy_assets');
show_admin_bar(false);

register_nav_menus( array(
    'header-menu' => 'Верхнее меню (шапка)', 
    'footer-menu' => 'Нижнее меню (футер)', 
) );
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method(){
	wp_enqueue_script( 'jquery' );
}
function default_theme_customizer($wp_customize) {
    $wp_customize->remove_section('static_front_page');
    $wp_customize->remove_section('custom_css');
    $wp_customize->remove_control('site_icon');

    $wp_customize->add_setting('phone_setting', array(
        'default' => '+7 (4922) 779-554',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('phone_control', array(
        'label' => 'Телефон компании',
        'section' => 'title_tagline',
        'settings' => 'phone_setting',
        'type' => 'text',
    ));
    $wp_customize->add_setting('workingmode_setting', array(
        'default' => 'пн-пт:9:00-18:00, сб-вс:выходной',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('workingmode_control', array(
        'label' => 'Режим работы',
        'section' => 'title_tagline',
        'settings' => 'workingmode_setting',
        'type' => 'text',
    ));
}
add_action('customize_register', 'default_theme_customizer');

function header_theme_customizer($wp_customize) {
    $wp_customize->add_section('header', array(
        'title' => 'Шапка сайта',
        'description' => 'Значения для ипотечного калькулятора',
        'priority' => 50,
    ));

    $wp_customize->add_setting('header_setting', array(
        'default' => 'Два дома в <br /> Ессентуках',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('header_control', array(
        'label' => 'Заголовок',
        'section' => 'header',
        'settings' => 'header_setting',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('header_desc_setting', array(
        'default' => 'Восемьдесят эксклюзивных квартир',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('header_desc_control', array(
        'label' => 'Подзаголовок(описание)',
        'section' => 'header',
        'settings' => 'header_desc_setting',
        'type' => 'text',
    ));

    $wp_customize->add_setting('link_setting', array(
        'default' => '',
    ));
    $wp_customize->add_control('link_control', array(
        'label' => 'Ссылка (подробнее)',
        'section' => 'header',
        'settings' => 'link_setting',
        'type' => 'dropdown-pages',
    ));
  
}
add_action('customize_register', 'header_theme_customizer');

function calculator_theme_customizer($wp_customize){
    $wp_customize->add_section('calculator', array(
        'title' => 'Варианты покупки',
        'description' => 'Значения для ипотечного калькулятора',
        'priority' => 50,
    ));

    $wp_customize->add_setting('calculator_header_setting', array(
        'default' => 'Варианты покупки',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('calculator_header_control', array(
        'label' => 'Заголовок',
        'section' => 'calculator',
        'settings' => 'calculator_header_setting',
        'type' => 'text',
    ));

    $wp_customize->add_setting('mortgage_1_setting', array(
        'default' => 'Ипотека 0.1%',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('mortgage_1_control', array(
        'label' => 'Ипотечный вариант №1',
        'section' => 'calculator',
        'settings' => 'mortgage_1_setting',
        'type' => 'text',
    ));
    $wp_customize->add_setting('mortgage_1_rate_setting', array(
        'default' => 0.1,
        'sanitize_callback' => 'sanitize_custom_floatval',
    ));
    $wp_customize->add_control('mortgage_1_rate_control', array(
        'label' => 'Процентная ставка №1',
        'section' => 'calculator',
        'settings' => 'mortgage_1_rate_setting',
        'input_attrs' => array(
            'min' => 0, 
            'max' => 100,
            'step' => 0.1
        ),
    ));
    
    $wp_customize->add_setting('mortgage_2_setting', array(
        'default' => 'Семейная ипотека',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('mortgage_2_control', array(
        'label' => 'Ипотечный вариант №2',
        'section' => 'calculator',
        'settings' => 'mortgage_2_setting',
        'type' => 'text',
    ));
    $wp_customize->add_setting('mortgage_2_rate_setting', array(
        'default' => 6,
        'sanitize_callback' => 'sanitize_custom_floatval',
    ));
    $wp_customize->add_control('mortgage_2_rate_control', array(
        'label' => 'Процентная ставка №2',
        'section' => 'calculator',
        'settings' => 'mortgage_2_rate_setting',
        'input_attrs' => array(
            'min' => 0, 
            'max' => 100,
            'step' => 0.1
        ),
    ));

    $wp_customize->add_setting('mortgage_3_setting', array(
        'default' => 'IT специалистам',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('mortgage_3_control', array(
        'label' => 'Ипотечный вариант №3',
        'section' => 'calculator',
        'settings' => 'mortgage_3_setting',
        'type' => 'text',
    ));
    $wp_customize->add_setting('mortgage_3_rate_setting', array(
        'default' => 5.1,
        'sanitize_callback' => 'sanitize_custom_floatval',
    ));
    $wp_customize->add_control('mortgage_3_rate_control', array(
        'label' => 'Процентная ставка №3',
        'section' => 'calculator',
        'settings' => 'mortgage_3_rate_setting',
        'input_attrs' => array(
            'min' => 0, 
            'max' => 100,
            'step' => 0.1
        ),
    ));
    $wp_customize->add_setting('calculator_desc_setting', array(
        'default' => 'С действующей программой гибкой рассрочки от застройщика вы можете купить готовую, новую квартиру не дожидаясь продажи старой. А остаток погасить, например, через целый год. Это отличное решение для тех, кому не подходит ипотека, а для полной оплаты возможности нет.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('calculator_desc_control', array(
        'label' => 'Текст блока "Рассрочка"',
        'section' => 'calculator',
        'settings' => 'calculator_desc_setting',
        'type' => 'textarea',
    ));
    $wp_customize->add_setting('calculator_desc_link_setting', array(
        'default' => '',

    ));
    $wp_customize->add_control('calculator_desc_link_control', array(
        'label' => 'Ссылка (подробнее)',
        'section' => 'calculator',
        'settings' => 'calculator_desc_link_setting',
        'type' => 'dropdown-pages',
    ));
};
add_action('customize_register', 'calculator_theme_customizer');

function feedback_theme_customizer($wp_customize) {
    $wp_customize->add_section('feedback', array(
        'title' => 'Форма обратной связи',
        'description' => 'Значения выпадающий списков',
        'priority' => 60,
    ));
    $wp_customize->add_setting('feedback_date_dropdown_setting', array(
        'default' => 'option0',
    ));
    
    $wp_customize->add_control('feedback_date_dropdown_control', array(
        'label' => 'День звонка',
        'section' => 'feedback',
        'settings' => 'feedback_date_dropdown_setting',
        'type' => 'select',
        'choices' => array(
            'option0' => 'Сегодня',
            'option1' => 'Завтра',
        ),
    ));


    $wp_customize->add_setting('feedback_time_dropdown_setting', array(
        'default' => 'option0',
    ));
    
    $wp_customize->add_control('feedback_time_dropdown_control', array(
        'label' => 'Время звонка',
        'section' => 'feedback',
        'settings' => 'feedback_time_dropdown_setting',
        'type' => 'select',
        'choices' => array(
            'option0' => 'Ближайшее время',   
            'option1' => '09:00',                 
            'option2' => '09:30',
            'option3' => '10:00',
            'option4' => '10:30',
            'option5' => '11:00',
            'option6' => '11:30',
            'option7' => '12:00',
            'option8' => '12:30',
            'option9' => '13:00',
            'option10' => '13:30',
            'option11' => '14:00',
            'option12' => '14:30',
            'option13' => '15:00',
            'option14' => '15:30',
            'option15' => '16:00',
            'option16' => '16:30',
            'option17' => '17:00',
            'option18' => '17:30',
        ),
    ));
}
// add_action('customize_register', 'feedback_theme_customizer');

function about_theme_customizer($wp_customize) {
    $wp_customize->add_section('about', array(
        'title' => 'О застройщике',
        'description' => 'Значения выпадающий списков',
        'priority' => 80,
    ));

    $wp_customize->add_setting('about_link_setting', array(
        'default' => '',
    ));
    $wp_customize->add_control('about_link_control', array(
        'label' => 'Ссылка (О застройщике)',
        'section' => 'about',
        'settings' => 'about_link_setting',
        'type' => 'dropdown-pages',
    ));
    $wp_customize->add_setting('about_desc_setting', array(
        'default' => 'ООО "СЗ ГИМ ГРУПП" представляет собой комманду профессионалов с многолетним стажем работы в сфере строительства жилой недвижимости. Забота о своих клиентов с учетом индивидуального подхода к каждому, применение современных технологических решений, строгий контроль качества и сроков выполнения работ являются отличительными способностями комании, отличающими ее от других на рынке недвижимости города Владимира и области. ООО "ГИМ ГРУПП" - гарант успешного разрешения Ващего жилищного вопроса.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('about_desc_control', array(
        'label' => 'Описание под логотипом',
        'section' => 'about',
        'settings' => 'about_desc_setting',
        'type' => 'textarea',
    ));
    $wp_customize->add_setting('about_sign_setting', array(
        'default' => 'ООО "ГИМ ГРУПП" - гарант успешного разрешения Ващего жилищного вопроса.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('about_sign_control', array(
        'label' => 'Описание под логотипом (Дополнительно)',
        'section' => 'about',
        'settings' => 'about_sign_setting',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'about_theme_customizer');


// Скрываем стандартные поля заголовка и текста при создании и редактировании записи
function hide_default_editor() {
    global $post_type;
    
    // Замените 'post' на ваш тип записи (например, 'post' для статей)
    if ($post_type === 'post') {
        remove_post_type_support('post', 'editor');
    }
}
add_action('admin_init', 'hide_default_editor');

// Добавляем кастомные поля ACF в режиме редактирования записи
function show_custom_acf_fields($post) {
    if ($post->post_type === 'post') {
        acf_form(array(
            'post_id' => $post->ID,
            'post_title' => false,
            'post_content' => false,
            'submit_value' => 'Сохранить',
        ));
    }
}
add_action('edit_form_after_title', 'show_custom_acf_fields');




// Удаление комментариев из админ-панели
function disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

// Отключение комментариев на уровне функций
function disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'disable_comments_post_types_support');

// Закрывает комментарии на уровне базы данных
function disable_comments_status() {
    return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

// Скрывает существующие комментарии
function disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);


function get_acf_field_values($field) {
    global $wpdb;

    $query = 'SELECT DISTINCT meta_value
          FROM ' . $wpdb->postmeta. '
          WHERE meta_key = "' . $field . '"
          ORDER BY meta_value';
    $result = $wpdb->get_col($query); 
    return $result;
}

function getUrl() {
    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    $url = $url[0];
    
    return $url;
}
function remove_title_field() {
    remove_post_type_support('apart', 'title');
    remove_post_type_support('real', 'title');
    remove_post_type_support('parking', 'title');
    remove_post_type_support('slider', 'title');
    remove_post_type_support('document', 'title');
}
add_action('init', 'remove_title_field');

function remove_editor_field() {
    remove_post_type_support('apart', 'editor');
    remove_post_type_support('real', 'editor');
    remove_post_type_support('parking', 'editor');
    remove_post_type_support('slider', 'editor');
    remove_post_type_support('document', 'editor');
}
add_action('init', 'remove_editor_field');


function replace_title_slider($title, $post_id) {
    if (get_post_type($post_id) === 'slider') {
        $title = get_field('title_slider', $post_id);
        if ($title) {
            return $title;
        } else {
            return 'Без заголовка';
        }
    }
    return $title;
}
add_filter('the_title', 'replace_title_slider', 10, 2);

function replace_title_with_custom_field($title, $post_id) {
    $post_type = get_post_type($post_id);
    $field_mappings = array(
        'apart' => 'number_apart',
        'real' => 'number_real',
        'parking' => 'number_parking',
        'document' => 'title_document'
    );
    
    if (array_key_exists($post_type, $field_mappings)) {
        $custom_field = get_field($field_mappings[$post_type], $post_id);
        if ($custom_field) {
            return $custom_field;
        } else {
            return 'Без номера';
        }
    }
    
    return $title;
}

add_filter('the_title', 'replace_title_with_custom_field', 10, 2);









