        <section class="_section mt-20 pb-14">
            <div class="_wrapper flex md:flex-row flex-col justify-between gap-y-5">
                
                <div class='w-full sm:w-1/2 mx-auto md:w-3/12 mt-5 md:-mt-[10px] lg:-mt-[16px] order-2 md:order-1'>
                    <a href="<?php echo home_url(); ?>" class="block">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_footer.png"  alt="ГИМ ГРУПП" class="w-3/4 sm:w-full mx-auto"/>
                    </a>
                </div>

                <div class='w-full md:w-auto mx-auto order-1 md:order-2'>
                    <nav>
                        <?php
                            wp_nav_menu( array(
                                'theme_location' => 'footer-menu', // Имя зарегистрированного меню
                                'menu_class' => 'sm:columns-2 text-[16px] sm:text-[14px] text-center md:text-left [&>li]:text-center [&>li]:block [&>li]:w-full sm:[&>li]:text-left sm:[&>li]:inline sm:[&>li]:w-auto', // CSS-класс для обертки меню
                            ) );
                        ?>
                    </nav>
                </div>

                <div class='flex flex-col justify-start order-3 mx-auto'>
                    <a href="tel:<?php echo remove_non_numeric(get_theme_mod('phone_setting')); ?>" class="text-center md:text-right text-[24px] lg:text-[36px] leading-tight">
                        <?php echo get_theme_mod('phone_setting'); ?>
                    </a>
                    <p class="text-_gray-dark text-right leading-4">
                        <?php echo get_theme_mod('workingmode_setting'); ?>
                    </p>
                </div>

            </div>
        </section>
    </main>
</body>
