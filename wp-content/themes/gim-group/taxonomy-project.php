<?php get_header();?>

<div class="container">
    <?php 
        get_template_part('template-parts/02header');
        get_template_part('template-parts/03callback');
        get_template_part('template-parts/taxonomy/01about');
        get_template_part('template-parts/taxonomy/project/choose');
        get_template_part('template-parts/06feedback');
        get_template_part('template-parts/05calculator');
    ?>
<div>

<?php get_footer(); ?>