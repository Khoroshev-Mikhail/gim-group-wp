<!DOCTYPE html>
<html lang="ru">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="<?php bloginfo( 'charset' ); ?>" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>> <?php wp_body_open(); ?>
    <main>
        <section class="_section">
            <div class="_wrapper mt-7 relative">

                <div class="flex justify-between text-_blue_for-text h-16 text-[14px] bg-white rounded-2xl px-10">
                    <div class="flex flex-col justify-center py-[18px]">
                        <a class="w-auto h-full" href="<?php echo home_url(); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_top.png"  alt="ГИМ ГРУПП" height="20" class="w-auto h-full"/>
                        </a>
                    </div>
                    <div class="flex flex-col justify-center ">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/burger.svg" alt="Меню" class="md:hidden" onclick="toggleMenu()"/>
                    </div>
                    <nav class="flex-col justify-center hidden md:flex text-[14px] lg:text-[16px]">
                        <?php
                            wp_nav_menu( array(
                                'theme_location' => 'header-menu', 
                                'menu_class' => 'flex [&>li]:inline gap-x-3 lg:gap-x-10', 
                            ) );
                        ?>
                    </nav>
                    
                    <div class="hidden md:flex flex-col justify-center">
                        <a href="tel:<?php echo remove_non_numeric(get_theme_mod('phone_setting')); ?>" class="text-right leading-4">
                            <?php echo get_theme_mod('phone_setting'); ?>
                        </a>
                        <p class="text-_gray-dark text-right leading-4">
                            <?php echo get_theme_mod('workingmode_setting'); ?>
                        </p>
                    </div>
                </div>

                <div class="mobile-menu absolute z-50 top-0 left-0 flex flex-col justify-between px-12 py-[18px] bg-white min-h-screen rounded-2xl h-full w-full">
                    <div class="flex justify-between">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_top.png"  alt="ГИМ ГРУПП" height="20" class="w-auto block h-7"/>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/xmark.svg" alt="Меню" class="h-7" onclick="toggleMenu()"/>
                    </div>
                    <div class="mt-4">
                        <?php
                            wp_nav_menu( array(
                                'theme_location' => 'header-menu',
                                'menu_class' => 'text-right w-full space-y-2',
                            ) );
                        ?>
                    </div>
                    <div class="flex flex-col justify-center pb-8">
                        <a href="tel:<?php echo remove_non_numeric(get_theme_mod('phone_setting')); ?>" class="text-right leading-4">
                            <?php echo get_theme_mod('phone_setting'); ?>
                        </a>
                        <p class="text-_gray-dark text-right leading-4">
                            <?php echo get_theme_mod('workingmode_setting'); ?>
                        </p>
                    </div>
                </div>

            </div>
        </section>



