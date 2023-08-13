<section class="_section mt-5">
    <div class="_wrapper flex flex-col ">
        
        <div class="mt-5">
            <h2 class="block text-_blue_for-text text-[32px]">Выбор квартиры</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5  mt-10">

            <div>
                <select class="w-full py-3.5 px-3 rounded-lg">
                    <option>Количество комнат</option>
                </select>
            </div>
            <div>
                <select class="w-full py-3.5 px-3 rounded-lg">
                    <option>Параметры квартиры</option>
                </select>
            </div>

            <div class="hidden md:block">

            </div>

            <div class="flex justify-between">
                <div class="w-1/2 flex flex-col">
                    <input type="text" class="w-full p-3 rounded-l-xl border-r-[1px]"/>
                    <input type="range" class="w-[calc(100%-12px)] ml-auto block h-[1px]"/>
                </div>
                <div class="w-1/2 flex flex-col">
                    <input type="text" class="w-full p-3 rounded-r-xl"/>
                    <input type="range" class="w-[calc(100%-12px)] mr-auto block h-[1px]"/>
                </div>
            </div>
            <div class="w-full flex justify-between col-span-1 md:col-span-2">
                <button class="flex flex-col h-full justify-center">
                    <div class="bg-white rounded-xl p-3">
                        <span class="text-red-500 pr-1">%</span>Акция
                    </div>
                </button>
                <button class="flex flex-col justify-center h-full">
                    <div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/clear.png" class="w-6 inline pr-1"/>
                        очистить
                    </div>
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-10">
            <?php
                $posts_per_page = 10;
                $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
                $current_term = get_queried_object(); 

                $related_posts = get_posts(array(
                    'post_type' => 'apart',
                    'tax_query' => array(
                        array(
                            'taxonomy' => $current_term->taxonomy,
                            'field'    => 'term_id',
                            'terms'    => $current_term->term_id,
                        ),
                    ),
                    'posts_per_page' => $posts_per_page,
                    'paged' => $paged, // Добавьте этот параметр
                ));
                if ($related_posts) {
                    foreach ($related_posts as $post) {
                        ?>
                            <div class="flex flex-col p-5 justify-between aspect-square bg-white rounded-2xl">
                                <div class="text-_dark-blue_for-text font-bold w-full md:w-7/12">
                                    <?php echo get_field('rooms_apart', $post->ID); ?>-комнатная квартира
                                </div>
                                <div class="h-2/3">
                                    <img src="/images/plan.png" alt="" class="h-full mx-auto"/>
                                </div>
                                <div class="flex justify-between">
                                    <div class="text-_dark-blue_for-text font-bold">
                                        <?php echo get_field('s_apart', $post->ID); ?> м2
                                    </div>
                                    <div>
                                        <?php echo get_field('price_apart', $post->ID); ?> руб.
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                }
            ?>
        </div>
        
        <div class="flex justify-between mt-10 text-_dark-blue_for-text font-bold">
            <div class="flex gap-x-2">
                <?php
                    $all_related_posts = get_posts(array(
                        'post_type' => 'apart',
                        'tax_query' => array(
                            array(
                                'taxonomy' => $current_term->taxonomy,
                                'field'    => 'term_id',
                                'terms'    => $current_term->term_id,
                            ),
                        ),
                        'posts_per_page' => -1, // Получить все записи
                    ));
                    echo paginate_links(array(
                        'total' => count($all_related_posts),
                        'current' => $paged, // Используйте значение $paged
                        'prev_text' => 'ss',
                        'next_text' => 'vv',
                    ));
                ?>
            </div>
            <div>
                Показать еще
            </div>
        </div>


    </div>
</section>