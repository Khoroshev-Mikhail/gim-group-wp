<?php

function strategy_assets() {
    wp_enqueue_style('headercss', get_template_directory_uri() . '/assets/css/header.css', time());
    wp_enqueue_style('containercss', get_template_directory_uri() . '/assets/css/container.css', time());
    wp_enqueue_style('footercss', get_template_directory_uri() . '/assets/css/footer.css', time());
    wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/assets/css/tailwind.css', time());
    wp_enqueue_script( 'myfns', get_template_directory_uri() . '/assets/js/myfns.js');
}
add_action('wp_enqueue_scripts', 'strategy_assets');
show_admin_bar(false);

register_nav_menus( array(
    'primary-menu' => 'Primary Menu', // Имя и описание вашего меню
) );