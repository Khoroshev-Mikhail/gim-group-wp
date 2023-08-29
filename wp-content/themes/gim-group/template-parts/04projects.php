<section class="_section mt-14">
    <div class="_wrapper">
        <h2 class="_h">Проекты</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-7 mt-7">
            <?php
                $projects = get_terms(array(
                    'taxonomy' => 'project', 
                    'hide_empty' => false,    
                ));

                if ($projects && !is_wp_error($projects)) {
                    foreach ($projects as $project) {
                        $project_image = get_field('image_project', 'project_' . $project->term_id);
                        ?>
                            <a href="<?php echo get_term_link($project); ?>" class="block relative aspect-[225/100] rounded-xl text-white">
                                <img src="<?php echo $project_image['url']; ?>" class="w-full h-full" />
                                <div class="absolute w-full top-[14%] left-[7%] flex gap-x-2">
                                    <?php 
                                        $checkboxes_project = get_field('checkboxes_project', 'project_' . $project->term_id);
                                        if (in_array("Сдан", $checkboxes_project)) {
                                            echo '<div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_blue-button">Сдан</div>';
                                        }
                                        if (in_array("Осталось мало квартир", $checkboxes_project)) {
                                            echo '<div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_red-button">Осталось мало квартир</div>';
                                        }
                                        if (in_array("Акция", $checkboxes_project)) {
                                            echo '<div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_orange-button">Акция</div>';
                                        }
                                    ?>
                                </div>
                                <div class="absolute top-[35%] xs:top-[50%] md:top-[40%] lg:top-[50%] left-[6%]">
                                    <h3 class="font-semibold text-[20px] leading-[18px]">
                                        <?php echo $project->name; ?>
                                    </h3>
                                    <p class="text-[10px] xs:mt-1">
                                        <?php the_field('address_project', 'project_' . $project->term_id); ?>
                                    </p>
                                </div>
                                <p class="absolute bottom-[3%] xs:bottom-[12%] left-[6%] font-semibold text-[20px]">от 2 790 000 руб.</p>
                            </a>
                        <?php
                    }
                }
            ?>
        </div>

    </div>
</section>