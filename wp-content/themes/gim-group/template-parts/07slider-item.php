<div class="swiper-slide">
    <div class="flex flex-col bg-white rounded-2xl p-5 text-left">
        <div class=" text-_gray-for-text text-[12px] md:text-[10px]">
            <?php echo get_the_date();?>
        </div>
        <div class="text-_blue_for-text mt-5 pr-8 font-semibold text-[20px] md:text-[18px]">
            <a href="<?php the_permalink();?>">
                <?php the_title();?>
            </a>
        </div>
        <div class="flex gap-x-4 mt-10">
            <p class="block w-10/12 text-_gray-for-text text-[10px]">
                <?php echo strip_tags(get_the_excerpt()); ?>
            </p>
            <button class="ml-auto flex flex-col justify-center w-2/12 max-w-[50px]">
                <a href="<?php the_permalink();?>" class='flex flex-col justify-center w-full aspect-square bg-_gray-button rounded-2xl'>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_right_white.svg" alt=">" width="14" height="14" class='mx-auto'/>
                </a>
            </button>
        </div>
    </div>
</div>