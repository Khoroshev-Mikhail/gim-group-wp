<?php /* Template Name: Машиноместа */ ?>

<?php get_header(); ?>

<section class="_section mt-5">
    <div class="_wrapper">
        <div class="w-full bg-white p-5 rounded-2xl">
            <h1 class="">
                <?php the_title();?>
            </h1>
            <div class="">
                <?php the_content();?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>