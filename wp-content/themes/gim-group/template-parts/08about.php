<section class="_section mt-32">
    <div class="_wrapper ">
        <div class="flex flex-col md:flex-row justify-between rounded-2xl bg-[url('/images/bg.webp')] bg-cover bg-center bg-no-repeat text-white !p-10">        

        <div class="w-full md:w-1/4 text-[24px] md:text-[22px] lg:text-[28px]">
            <a href="<?php echo get_permalink(get_theme_mod('about_link_setting')); ?>" class="border-b pb-[-5px] cursor-pointer">О застройщике</a>
        </div>
        <div class="w-full md:w-3/4 mt-5 flex-col">
            <div class="">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_white.png" alt="Логотип ГИМ-ГРУПП" class="w-full"/>
            </div>
            <div class="md:pl-[27.5%] mt-5 md:-mt-5">
                <p class="text-[12px] sm:text-[14px] md:text-[10px]"><?php echo get_theme_mod('about_desc_setting'); ?></p>
                <p class="text-[10px] mt-1"><?php echo get_theme_mod('about_sign_setting'); ?></p>
            </div>
        </div>
        
        </div>
    </div>
</section>