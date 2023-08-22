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
    $posts_per_page = 15;
    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if(!empty($_GET['type']) && $_GET['type'] == 'real'){
        $post_type = 'real';
    } else if(!empty($_GET['type']) && $_GET['type'] == 'parking'){
        $post_type = 'parking';
    } else{
        $post_type = 'apart';
    }
?>
<section class="_section mt-5">
    <div class="_wrapper flex flex-col ">
        
        <div class="mt-5">
            <h2 id="choose" class="block text-_blue_for-text text-[32px]">
            <?php
                if($post_type == 'real'){
                    echo 'Выбор коммерческой недвижимости';
                } else if($post_type == 'parking'){
                    echo 'Выбор машиноместа';
                } else{
                    echo 'Выбор квартиры';
                }
            ?>
            </h2>
        </div>
        
        <form method="get" action="<?php echo $url . '#choose'; ?>" id="filter">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5  mt-10">
                
                <?php 
                    if($post_type == 'apart' || $post_type == 'real'){
                ?>
                    <div>
                        <select class="w-full py-3.5 px-3 rounded-lg" name="rooms">
                            <option value="0">Количество комнат</option>
                                <?php foreach(get_acf_field_values('rooms_' . $post_type) as $item): ?>
                                    <option value="<?=$item?>" <?=(!empty($_GET['rooms']) && $_GET['rooms'] == $item) ? 'selected' : ''?>><?=$item?></option>
                                <?php endforeach;?>
                        </select>
                    </div>
                <?php
                    }
                ?>
                <div>
                    <select class="w-full py-3.5 px-3 rounded-lg" name="s">
                        <option value="0">
                            <?php
                                if($post_type == 'real'){
                                    echo 'Площадь помещения';
                                } else if($post_type == 'parking'){
                                    echo 'Площадь машиноместа';
                                } else{
                                    echo 'Площадь квартиры';
                                }
                            ?>
                        </option>
                        <?php foreach(get_acf_field_values('s_' . $post_type) as $item): ?>
                            <option value="<?=$item?>" <?=(!empty($_GET['s']) && $_GET['s'] == $item) ? 'selected' : ''?>><?=$item?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                
                <?php if($post_type == 'real'){ ?>
                    <div class="">
                        <select class="w-full py-3.5 px-3 rounded-lg" name="purpose">
                            <option value="0">Назначение помещения</option>
                                <?php foreach(get_field('purpose_real') as $item): ?>
                                    <option value="<?=$item?>" <?=(!empty($_GET['purpose_real']) && $_GET['purpose_real'] == $item) ? 'selected' : ''?>><?=$item?></option>
                                <?php endforeach;?>
                        </select>
                    </div>
                <?php
                    } else{
                        ?>
                            <div class="hidden md:block"></div>
                        <?php
                    }
                ?>
                <?php if($post_type == 'parking'){ ?>
                    <div class="hidden md:block"></div>
                <?php } ?>

                <?php
                    $min_price = min(get_acf_field_values('price_' . $post_type) ? get_acf_field_values('price_' . $post_type) : [0]);
                    $max_price = max(get_acf_field_values('price_' . $post_type) ? get_acf_field_values('price_' . $post_type) : [30000000]); 
                ?>
                <div class="flex justify-between">
                    <div class="w-1/2 flex flex-col">
                        <input id="price_from_input" onchange="input_handler(this, 'price_from_range')" type="number" name="price_from" value="<?=(!empty($_GET['price_from'])) ? $_GET['price_from'] : $min_price; ?>"  class="w-full p-3 rounded-l-xl border-r-[1px]"/>
                        <input id="price_from_range" onchange="input_handler(this, 'price_from_input')" min="<?php echo $min_price; ?>" max="<?php echo $max_price ?>" value="<?=(!empty($_GET['price_from'])) ? $_GET['price_from'] : $min_price; ?>" type="range" class="w-[calc(100%-12px)] ml-auto block h-[1px]"/>
                    </div>
                    <div class="w-1/2 flex flex-col">
                        <input id="price_to_input" onchange="input_handler(this, 'price_to_range')" type="number" name="price_to" value="<?=(!empty($_GET['price_to'])) ? $_GET['price_to'] : $max_price;?>"   class="w-full p-3 rounded-r-xl"/>
                        <input id="price_to_range" onchange="input_handler(this, 'price_to_input')" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" value="<?=(!empty($_GET['price_to'])) ? $_GET['price_to'] : $max_price;?>" type="range" class="w-[calc(100%-12px)] mr-auto block h-[1px]"/>
                    </div>
                </div>
                <div class="w-full flex justify-between col-span-1 md:col-span-3">
                    <button class="hidden flex flex-col h-full justify-center">
                        <div class="bg-white rounded-xl p-3">
                            <span class="text-red-500 pr-1">%</span>Акция
                        </div>
                    </button>
                    <button type="submit" 
                        name="<?php echo (!empty($_GET['type']) && $_GET['type'] !== '') ? 'type' : ''; ?>"
                        value="<?php echo (!empty($_GET['type']) && $_GET['type'] !== '') ? $_GET['type'] : ''; ?>" 
                        class="flex flex-col h-full">
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
                if($post_type == 'real'){
                    if (isset($_GET['rooms']) && !empty($_GET['rooms']) && $_GET['rooms'] != 0) {
                        $meta_query[] = array(
                            'key' => 'rooms_real',
                            'value' => $_GET['rooms'],
                            'compare' => 'IN',
                        );
                    }
    
                    if (isset($_GET['s']) && !empty($_GET['s']) && $_GET['s'] != 0) {
                        $meta_query[] = array(
                            'key' => 's_real',
                            'value' => $_GET['s'],
                            'compare' => 'IN',
                        );
                    }

                    if (isset($_GET['purpose']) && !empty($_GET['purpose']) && $_GET['purpose'] != 0) {
                        $meta_query[] = array(
                            'key' => 'purpose_real',
                            'value' => $_GET['purpose'],
                            'compare' => 'IN',
                        );
                    }
    
                    if (isset($_GET['price_from']) && !empty($_GET['price_to'])) {
                        $meta_query[] = array(
                            'key' => 'price_real',
                            'value' => [$_GET['price_from'], $_GET['price_to']],
                            'compare' => 'BETWEEN',
                        );
                    } 
    
                    $related_posts = get_posts(array(
                        'post_type' => 'real',
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
                } else if($post_type == 'parking'){    
                    if (isset($_GET['s']) && !empty($_GET['s']) && $_GET['s'] != 0) {
                        $meta_query[] = array(
                            'key' => 's_parking',
                            'value' => $_GET['s'],
                            'compare' => 'IN',
                        );
                    }
    
                    if (isset($_GET['price_apart_from']) && !empty($_GET['price_apart_to'])) {
                        $meta_query[] = array(
                            'key' => 'price_parking',
                            'value' => [$_GET['price_from'], $_GET['price_to']],
                            'compare' => 'BETWEEN',
                        );
                    } 
    
                    $related_posts = get_posts(array(
                        'post_type' => 'parking',
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
                } else{
                    if (isset($_GET['rooms']) && !empty($_GET['rooms']) && $_GET['rooms'] != 0) {
                        $meta_query[] = array(
                            'key' => 'rooms_apart',
                            'value' => $_GET['rooms'],
                            'compare' => 'IN',
                        );
                    }
    
                    if (isset($_GET['s']) && !empty($_GET['s']) && $_GET['s'] != 0) {
                        $meta_query[] = array(
                            'key' => 's_apart',
                            'value' => $_GET['s'],
                            'compare' => 'IN',
                        );
                    }
    
                    if (isset($_GET['price_from']) && !empty($_GET['price_to'])) {
                        $meta_query[] = array(
                            'key' => 'price_apart',
                            'value' => [$_GET['price_from'], $_GET['price_to']],
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
                }
                
                if ($related_posts) {
                    foreach ($related_posts as $post) {
                        ?>
                            <div class="flex flex-col p-5 justify-between aspect-square bg-white rounded-2xl">
                                <div class="text-_dark-blue_for-text font-bold w-full">
                                    <?php
                                        if($post_type == 'real'){
                                            echo get_field('rooms_real', $post->ID) . '-комнатное помещение №';
                                        } else if($post_type == 'apart'){
                                            echo get_field('rooms_apart', $post->ID) . '-комнатная квартира №';
                                        } else if($post_type == 'parking'){
                                            echo 'Машиноместо №';
                                        }
                                    ?>
                                </div>
                                <div class="h-2/3">
                                    <?php 
                                        $images = get_field('images_' . $post_type, $post->ID); 
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
                                            echo '<img src="' . get_template_directory_uri() . '/assets/images/taxonomy/projects/no-image.png" alt="" class="h-full mx-auto"/>';
                                        }
                                    ?>
                                </div>
                                <div class="flex justify-between">
                                    <div class="text-_dark-blue_for-text font-bold">
                                        <?php echo get_field('s_' . $post_type, $post->ID); ?> м2
                                    </div>
                                    <div>
                                        <?php echo get_field('price_' . $post_type, $post->ID); ?> руб.
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                } else{
                    echo '<h2 class="w-full text-_blue_for-text text-[20px]">По выбранным фильтрам недвижимости нет!</h2>';
                }
            ?>
        </div>
        
        <div class="flex justify-between mt-10 text-_dark-blue_for-text font-bold">
            <div class="flex gap-x-2 navigation">
                <?php
                    $all_related_posts = get_posts(array(
                        'post_type' => $post_type,
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
                        'total' => ceil(count($all_related_posts) / $posts_per_page),
                        'current' => $paged,
                        'prev_text' => '',
                        'next_text' => '',
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

    function input_handler({value}, id){
        const pairElement = document.getElementById(id);
        pairElement.value = value;
    }
</script>



<!-- Конец скрипта для модалке при клике на видео -->
