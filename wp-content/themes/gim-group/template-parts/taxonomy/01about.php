<?php $current_term = get_queried_object(); ?>
<section class="_section mt-14">
    <div class="_wrapper">
        <div class="flex flex-col md:flex-row justify-between w-full bg-white rounded-2xl p-8 md:gap-x-10 lg:gap-x-30">
            <div class="w-full md:w-2/3 flex flex-col justify-between gap-y-4 text-_dark-gray-for-text">
                <h2 class="block text-_blue_for-text text-[32px]">О проекте</h2>
                <div>
                    <?php the_field('short_desc_project', 'project_' . $current_term->term_id); ?>
                </div>
                <div>
                    <?php the_field('desc_project', 'project_' . $current_term->term_id); ?>
                </div>
            </div>
            <div class="flex flex-col w-full md:w-1/3 text-_dark-blue_for-text font-bold pt-10 md:pt-5 lg:pr-10">
                <div class="h-1/2">
                    <?php the_field('address_project', 'project_' . $current_term->term_id); ?>
                </div>
                <div class="pt-5 md:pt-0 flex h-1/2 gap-x-5 md:gap-x-0 md:justify-between">
                    <div>
                        <p><?php the_field('floors_project', 'project_' . $current_term->term_id); ?> Этажей</p>
                        <p class="text-_dark-gray-for-text -mt-0.5 text-[12px] font-medium">Этажность</p>
                    </div>
                    <div>
                        <p>
                            <?php
                                if(!empty($_GET['type']) && $_GET['type'] == 'real'){
                                    $values = get_acf_field_values('s_real');
                                    if (!empty($values)) {
                                        $minValue = min($values);
                                        $maxValue = max($values);

                                        echo "$minValue - $maxValue м<sup>2</sup>";
                                    } else {
                                        echo "Различная";
                                    }
                                } else if(!empty($_GET['type']) && $_GET['type'] == 'parking'){
                                    $values = get_acf_field_values('s_parking');
                                    if (!empty($values)) {
                                        $minValue = min($values);
                                        $maxValue = max($values);

                                        echo "$minValue - $maxValue м<sup>2</sup>";
                                    } else {
                                        echo "Различная";
                                    }
                                } else {
                                    $values = get_acf_field_values('s_apart');
                                    if (!empty($values)) {
                                        $minValue = min($values);
                                        $maxValue = max($values);

                                        echo "$minValue - $maxValue м<sup>2</sup>";
                                    } else {
                                        echo "Различная";
                                    }
                                }
                            ?>
                        </p>
                        <p class="text-_dark-gray-for-text -mt-0.5 text-[12px] font-medium">
                            Площадь 
                            <?php
                                if(!empty($_GET['type']) && $_GET['type'] == 'real'){
                                    echo 'помещений';
                                } else if(!empty($_GET['type']) && $_GET['type'] == 'parking'){
                                    echo 'машиномест';
                                } else {
                                    echo 'квартир';
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-b-2 border-_blue-for-icons grid xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-8 px-8 py-16">

                <div class="flex ">
                    <img class="block w-12 h-12" src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/1.png" />
                    <div class="flex flex-col justify-center">
                        <div class="px-7 text-[16px] xs:text-[14px] sm:text-[16px]">
                            Полноценная инфраструктура
                        </div>
                    </div>
                </div>
                <div class="flex ">
                    <img class="block w-12 h-12" src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/3.png" />
                    <div class="flex flex-col justify-center">
                        <div class="px-7 text-[16px] xs:text-[14px] sm:text-[16px]">
                            Транспортная доступность
                        </div>
                    </div>
                </div>
                <div class="flex ">
                    <img class="block w-8 h-12 mx-2" src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/5.png" />
                    <div class="flex flex-col justify-center">
                        <div class="px-7 text-[16px] xs:text-[14px] sm:text-[16px]">
                            Собственная котельная
                        </div>
                    </div>
                </div>
                <div class="flex ">
                    <img class="block w-12 h-12" src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/7.png" />
                    <div class="flex flex-col justify-center">
                        <div class="px-7 text-[16px] xs:text-[14px] sm:text-[16px]">
                            Надежность сделки
                        </div>
                    </div>
                </div>


                <div class="flex ">
                    <img class="block w-10 h-12 mx-1" src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/2.png" />
                    <div class="flex flex-col justify-center">
                        <div class="px-7 text-[16px] xs:text-[14px] sm:text-[16px]">
                            Закрытая территория
                        </div>
                    </div>
                </div>
                <div class="flex ">
                    <img class="block w-12 h-12" src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/4.png" />
                    <div class="flex flex-col justify-center">
                        <div class="px-7 text-[16px] xs:text-[14px] sm:text-[16px]">
                            Продуманные планировки
                        </div>
                    </div>
                </div>
                <div class="flex ">
                    <img class="block w-10 h-12 mx-1" src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/6.png" />
                    <div class="flex flex-col justify-center">
                        <div class="px-7 text-[16px] xs:text-[14px] sm:text-[16px]">
                            Подземный паркинг
                        </div>
                    </div>
                </div>
                <div class="flex ">
                    <img class="block w-10 h-12 mx-1" src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/8.png" />
                    <div class="flex flex-col justify-center">
                        <div class="px-7 text-[16px] xs:text-[14px] sm:text-[16px]">
                            Безопасность
                        </div>
                    </div>
                </div>


        </div>
    </div>
</section>