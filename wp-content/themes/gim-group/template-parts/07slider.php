<?php 
    if ( have_posts() ) {
?>

<section class="_section mt-20">
    <div class="_wrapper flex flex-col">
        
            <div class='flex justify-between'>
                <h3 class='_h block'>Новости</h3>
                <div class='flex'>
                    <button id="_PREV_BUTTON" class='flex flex-col justify-center cursor-pointer'>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_left.svg" alt="←" />
                    </button>
                    <button id="_NEXT_BUTTON" class='flex flex-col justify-center ml-10 xs:ml-20 cursor-pointer'>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_right.svg" alt="→" />
                    </button>
                </div>
            </div>

            <div class='w-full mt-7'>
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php
                            while ( have_posts() ) {
                                the_post();
                                get_template_part( 'template-parts/07slider', 'item' );
                            }
                        ?>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                const swiper = new Swiper('.swiper', {
                    navigation: {
                        nextEl: '#_NEXT_BUTTON',
                        prevEl: '#_PREV_BUTTON',
                    },
                    spaceBetween: 20,
                    breakpoints: {
                        0: {
                            slidesPerView: 1
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        1000: {
                            slidesPerView: 3,
                        },
                    },
                });
            </script>
        </div>

</section>

<?php } ?>