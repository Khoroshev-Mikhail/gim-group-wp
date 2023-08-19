
<section class="_section mt-5">
    <div class="_wrapper flex flex-col ">
        
        <div class="mt-5">
            <h2 class="block text-_blue_for-text text-[32px]">Выбор квартиры</h2>
        </div>
        <form method="get" action="/project/zhk-diamond/" id="filter">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5  mt-10">

            <div>
                <select class="w-full py-3.5 px-3 rounded-lg" name="rooms_apart">
                    <option value="0">Количество комнат</option>
                    <?php foreach(get_acf_field_values('rooms_apart') as $item): ?>
                        <option value="<?=$item?>" <?=(!empty($_GET['rooms_apart']) && $_GET['rooms_apart'] == $item) ? 'selected' : ''?>><?=$item?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <select class="w-full py-3.5 px-3 rounded-lg" name="s_apart">
                    <option value="0">Площадь квартиры</option>
                    <?php foreach(get_acf_field_values('s_apart') as $item): ?>
                        <option value="<?=$item?>" <?=(!empty($_GET['s_apart']) && $_GET['s_apart'] == $item) ? 'selected' : ''?>><?=$item?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="hidden md:block">

            </div>

            <div class="flex justify-between">
                <div class="w-1/2 flex flex-col">
                    <input type="text" name="price_apart_from" value="<?=(!empty($_GET['price_apart_from'])) ? $_GET['price_apart_from'] : min(get_acf_field_values('price_apart'))?>"  class="w-full p-3 rounded-l-xl border-r-[1px]"/>
                    <input type="range" class="w-[calc(100%-12px)] ml-auto block h-[1px]"/>
                </div>
                <div class="w-1/2 flex flex-col">
                    <input type="text" name="price_apart_to" value="<?=(!empty($_GET['price_apart_to'])) ? $_GET['price_apart_to'] : max(get_acf_field_values('price_apart'))?>"   class="w-full p-3 rounded-r-xl"/>
                    <input type="range" class="w-[calc(100%-12px)] mr-auto block h-[1px]"/>
                </div>
            </div>
            <div class="w-full flex justify-between col-span-1 md:col-span-3">
                <button class="flex flex-col h-full justify-center">
                    <div class="bg-white rounded-xl p-3">
                        <span class="text-red-500 pr-1">%</span>Акция
                    </div>
                </button>
                <button class="flex flex-col h-full">
                    <div class="bg-white rounded-xl p-3">
                        Применить
                    </div>
                </button>
                <button type="reset" onclick="location.replace('<?=getUrl()?>')" class="flex flex-col justify-center h-full">
                    <div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/clear.png" class="w-6 inline pr-1"/>
                        очистить
                    </div>
                </button>
            </div>
        </div>
                    </form>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-10">
            <?php
                $posts_per_page = 10;
                $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
                $current_term = get_queried_object(); 
                $meta_query = [];
                if (isset($_GET['rooms_apart']) && !empty($_GET['rooms_apart']) && $_GET['rooms_apart'] != 0) {
                    $meta_query[] = array(
                        'key' => 'rooms_apart',
                        'value' => $_GET['rooms_apart'],
                        'compare' => 'IN',
                    );
                }

                if (isset($_GET['s_apart']) && !empty($_GET['s_apart']) && $_GET['s_apart'] != 0) {
                    $meta_query[] = array(
                        'key' => 's_apart',
                        'value' => $_GET['s_apart'],
                        'compare' => 'IN',
                    );
                }

                if (isset($_GET['price_apart_from']) && !empty($_GET['price_apart_to'])) {
                    $meta_query[] = array(
                        'key' => 'price_apart',
                        'value' => [$_GET['price_apart_from'], $_GET['price_apart_to']],
                        'compare' => 'BETWEEN',
                    );
                } 

                $related_posts = get_posts(array(
                    'post_type' => 'apart',
                    'tax_query' => array(
                        array(
                            'taxonomy' => $current_term->taxonomy,
                            'field'    => 'term_id',
                            'terms'    => $current_term->term_id,
                        ),
                    ),
                    'meta_query' => $meta_query,
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
            <div class="flex gap-x-2 navigation">
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
                        'meta_query' => $meta_query,
                        'posts_per_page' => -1, // Получить все записи
                    ));
                    echo paginate_links(array(
                        'total' => ceil(count($all_related_posts) / 10),
                        'current' => $paged, // Используйте значение $paged
                        'prev_text' => 'ss',
                        'next_text' => 'vv',
                    ));
                ?>
            </div>
            <?php if ($paged != ceil(count($all_related_posts) / 10)):?>
            <div class="next-page" data-page="<?=($paged == 0) ? 1: $paged?>">
                Показать еще
            </div>
            <?php endif;?>
        </div>


    </div>
</section>

<script>
    (function($){ 
        $(document).on('click', '.next-page', function(){

        })
    })(jQuery)
</script>