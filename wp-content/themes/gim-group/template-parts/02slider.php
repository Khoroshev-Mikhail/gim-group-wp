<section class="_section mt-5 ">
    <div class="_wrapper overflow-hidden">
        <div class="_main-slider">
            <div class="swiper-wrapper">
                <?php
                    $slider_posts = new WP_Query(array(
                        'post_type' => 'slider',
                        'posts_per_page' => -1,
                        'orderby' => 'date', 
                        'order' => 'ASC',
                    ));

                    if ($slider_posts->have_posts()) :
                        while ($slider_posts->have_posts()) : $slider_posts->the_post();
                            $image = get_field('image_slider');
                            $title = get_field('title_slider');
                            $subtitle = get_field('subtitle_slider');
                            $link = get_field('link_slider');
                ?>

                <div class="swiper-slide ">
                    <div class="relative text-white">
                        <img src="<?php echo $image ? $image : get_template_directory_uri() . "/assets/images/bg.webp"; ?>" alt="<?php echo $title; ?>" class="w-full h-auto"/>
                        <div class="absolute top-[10%] xs:top-[20%] md:top-[30%]  left-[6%]">
                            <h1 class="text-[22px] xs:text-[28px] sm:text-[36px] md:text-[48px] lg:text-[64px] maxw:text-[72px] leading-none">
                                <?php echo $title; ?>
                            </h1>
                            <p class="text-[10px] xs:text-[12px] sm:text-[14px] md:text-[16px] lg:text-[20px] leading-none font-semibold mt-2">
                                <?php echo $subtitle; ?>
                            </p>
                        </div>
                        <a href="<?php echo $link; ?>" class="absolute bottom-[10%] left-[6%] text-[12px] xs:text-[14px] sm:text-[16px] md:text-[18px] lg:text-[24px] leading-none font-semibold border-b pb-[-5px] cursor-pointer">
                            Подробнее
                        </a>
                    </div>
                </div>
<?php
endwhile;
    wp_reset_postdata(); // Сброс данных записи
else :
    echo 'Нет доступных записей.';
endif;

?>

            </div>
        </div>
    </div>
</section>  




<script type="text/javascript">
    const swiper = new Swiper('._main-slider', {
        // navigation: {
        //     nextEl: '#_NEXT_BUTTON_MAIN_SLIDER',
        //     prevEl: '#_PREV_BUTTON_MAIN_SLIDER',
        // },
        // pagination: {
        //     el: '.swiper-pagination',
        //     type: 'bullets',
        // },
        slidesPerView: 1,
        spaceBetween: 20,
        autoplay: {
            delay: 5000,
        },
        speed: 1500,
    });
</script>



