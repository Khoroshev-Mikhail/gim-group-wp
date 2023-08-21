<style>
    ._fixed{
        height: 100%;
        width: 100%; 
        background-color: rgba(0, 0, 0, 0.5) !important; 
        position: fixed; 
        top: 0px;
        left: 0px;
        z-index: 1000;
        display: flex;
        justify-content: center;
        cursor: pointer;
    }
    ._xmark{
        position: fixed;
        top: 15px;
        right: 15px;
        width: 60px;
        height: 60px;
        cursor: pointer;
    }
    ._left{
        position: fixed;
        top: calc(50% - 30px);
        left: 15px;
        width: 60px;
        height: 60px;
        cursor: pointer;
        z-index: 9999;
    }
    ._right{
        position: fixed;
        top: calc(50% - 30px);
        right: 15px;
        width: 60px;
        height: 60px;
        cursor: pointer;
        z-index: 9999;
    }
    .swiper-button-disabled img{
        display: none;
    }
    ._xmark img{
        width: 60px;
        height: 60px;
    }
    ._fixed__wrapper{
        width: calc(100% - 90px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    @media(min-width: 640px){
        ._fixed__wrapper{
            width: 75%;
        }
    }
    @media(min-width: 768px){
        ._fixed__wrapper{
            width: 66%;
        }
    }
    ._fixed__wrapper iframe{
        aspect-ratio: 16/9;
        width: 100%;
    }

    ._show{
        display: none;
    }
</style>

<script type="text/javascript">
    function open_slider(id){
        const element = document.querySelector(id)
        element.classList.remove('_show');
    }
    function close_slider(id) {
        const element = document.querySelector(id)
        element.classList.add('_show');
    }
</script>
<?php
    $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
    $current_term = get_queried_object(); 
    $posts_per_page = 10;
    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<section class="_section mt-5">
    <div class="_wrapper flex flex-col ">
        
        <div class="mt-5">
            <h2 class="block text-_blue_for-text text-[32px]">
            <?php
                if(!empty($_GET['type']) && $_GET['type'] == 'real'){
                    echo 'Выбор коммерческой недвижимости';
                } else if(!empty($_GET['type']) && $_GET['type'] == 'parking'){
                    echo 'Выбор машиноместа';
                } else{
                    echo 'Выбор квартиры';
                }
            ?>
            </h2>
        </div>
        
        <form method="get" action="<?php echo $url; ?>" id="filter">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5  mt-10">
                
                <?php 
                    if(empty($_GET['type']) || !empty($_GET['type']) && $_GET['type'] !== 'parking'){
                ?>
                    <div>
                        <select class="w-full py-3.5 px-3 rounded-lg" name="rooms_apart">
                            <option value="0">Количество комнат</option>
                            <?php foreach(get_acf_field_values('rooms_apart') as $item): ?>
                                <option value="<?=$item?>" <?=(!empty($_GET['rooms_apart']) && $_GET['rooms_apart'] == $item) ? 'selected' : ''?>><?=$item?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                <?php
                    }
                ?>
                <div>
                    <select class="w-full py-3.5 px-3 rounded-lg" name="s_apart">
                        <option value="0">
                            <?php
                                if(!empty($_GET['type']) && $_GET['type'] == 'real'){
                                    echo 'Площадь помещения';
                                } else if(!empty($_GET['type']) && $_GET['type'] == 'parking'){
                                    echo 'Площадь машиноместа';
                                } else{
                                    echo 'Площадь квартиры';
                                }
                            ?>
                        </option>
                        <?php
                            if(!empty($_GET['type']) && $_GET['type'] == 'real'){
                                $s = 's_real';
                            } else if(!empty($_GET['type']) && $_GET['type'] == 'parking'){
                                $s = 's_parking';
                            } else{
                                $s = 's_apart';
                            }
                            foreach(get_acf_field_values($s) as $item): 
                        ?>
                            <option value="<?=$item?>" <?=(!empty($_GET[$s]) && $_GET[$s] == $item) ? 'selected' : ''?>><?=$item?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                
                <?php 
                    if(!empty($_GET['type']) && $_GET['type'] == 'real'){
                ?>
                        <div class="">
                            <select class="w-full py-3.5 px-3 rounded-lg" name="purpose_real">
                                <option value="0">Назначение помещения</option>
                                <?php foreach(get_acf_field_values('purpose_real') as $item): ?>
                                    <option value="<?=$item?>" <?=(!empty($_GET['purpose_real']) && $_GET['purpose_real'] == $item) ? 'selected' : ''?>><?=$item?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                <?php
                    } else{
                        ?>
                            <div class="hidden md:block">

                            </div>
                        <?php
                    }
                ?>
                <?php 
                    if(!empty($_GET['type']) && $_GET['type'] == 'parking'){
                ?>
                    <div class="hidden md:block"></div>
                <?php
                    }
                ?>

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
                    <button type="submit" name="submit_form" class="flex flex-col h-full">
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
                    'paged' => $paged,
                ));
                if ($related_posts) {
                    foreach ($related_posts as $post) {
                        ?>
                            <div class="flex flex-col p-5 justify-between aspect-square bg-white rounded-2xl">
                                <div class="text-_dark-blue_for-text font-bold w-full md:w-7/12">
                                    <?php echo get_field('rooms_apart', $post->ID); ?>-комнатная квартира
                                </div>
                                <div class="h-2/3">
                                    <?php 
                                        $images = get_field('images_apart', $post->ID); 
                                        if (is_array($images) && !empty($images)) {
                                            ?>
                                                <img src="<?php echo esc_url($images[0]['url']); ?>" alt="" class="h-full mx-auto" onclick="open_slider('<?php echo '#slider-' . $post->ID;?>')"/>
                                                <div class="_fixed _show" id="<?php echo 'slider-' . $post->ID;?>">
                                                    <div class="_xmark" onclick="close_slider('<?php echo '#slider-' . $post->ID;?>')">
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/taxonomy/projects/xmark.svg" alt="x" width="60px" height="60px"/>
                                                    </div>
                                                    <div class="_left" id="_FIXED_PREV_BUTTON">
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_left.svg" alt="x" width="60px" height="60px"/>
                                                    </div>
                                                    <div class="_right" id="_FIXED_NEXT_BUTTON">
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_right.svg" alt="x" width="60px" height="60px"/>
                                                    </div>
                                                    <div class="_fixed__wrapper swiper-flat">
                                                        <div class="swiper-wrapper">
                                                            <?php
                                                                foreach ($images as $image) {
                                                                    ?>
                                                                        <div class="swiper-slide w-full h-full flex flex-col justify-center">
                                                                            <img src="<?php echo esc_url($image['url']); ?>" alt="" class="w-full h-auto mx-auto"/>
                                                                        </div>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                        } else {
                                            echo '<img src="' . get_template_directory_uri() . '/assets/images/taxonomy/projects/clear.png" alt="" class="h-full mx-auto"/>';
                                        }
                                    ?>
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
                        'posts_per_page' => -1, 
                    ));
                    echo paginate_links(array(
                        'total' => ceil(count($all_related_posts) / 10),
                        'current' => $paged,
                        'prev_text' => 'Prev',
                        'next_text' => 'Next',
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


<script type="text/javascript">
    const swiper = new Swiper('.swiper-flat', {
        navigation: {
            prevEl: '#_FIXED_PREV_BUTTON',
            nextEl: '#_FIXED_NEXT_BUTTON',
        },
        spaceBetween: 300,
        slidesPerView: 1,
    });
</script>



<!-- Конец скрипта для модалке при клике на видео -->
