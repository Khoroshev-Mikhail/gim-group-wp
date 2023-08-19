<section class="_section mt-5">
    <div class="_wrapper">
        <div class="relative text-white">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg.webp" alt="Два дома в Ессентуках" class="w-full h-auto"/>
            <div class="absolute top-[10%] xs:top-[20%] md:top-[30%]  left-[6%]">
                <h1 class="text-[22px] xs:text-[28px] sm:text-[36px] md:text-[48px] lg:text-[64px] maxw:text-[72px] leading-none">
                    <?php echo get_theme_mod('header_setting'); ?>
                </h1>
                <p class="text-[10px] xs:text-[12px] sm:text-[14px] md:text-[16px] lg:text-[20px] leading-none font-semibold mt-2">
                    <?php echo get_theme_mod('header_desc_setting'); ?>
                </p>
            </div>
            <a href="<?php echo get_permalink(get_theme_mod('link_setting')); ?>" class="absolute bottom-[10%] left-[6%] text-[12px] xs:text-[14px] sm:text-[16px] md:text-[18px] lg:text-[24px] leading-none font-semibold border-b pb-[-5px] cursor-pointer">
                Подробнее
            </a>
        </div>
    </div>
</section>