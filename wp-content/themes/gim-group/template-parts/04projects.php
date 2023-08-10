<section class="_section mt-20">
    <div class="_wrapper">
        <div>

                <?php
$parent_category = get_category_by_slug('nedvizhimost'); // Замените 'nedvizhimost' на слаг вашей категории "Недвижимость"
$subcategories = get_categories(array('parent' => $parent_category->term_id, 'hide_empty' => false)); // Добавляем параметр 'hide_empty' => false

// Вывод списка подкатегорий и их количество
if ($subcategories) {
    echo '<p>Количество подкатегорий: ' . count($subcategories) . '</p>';
    echo '<ul>';
    foreach ($subcategories as $subcategory) {
        echo '<li><a href="' . get_category_link($subcategory->term_id) . '">' . $subcategory->name . '</a></li>';
    }
    echo '</ul>';
}
                ?>

        </div>

        <h2 class="_h">Проекты</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-7 mt-7">

            <div class="relative aspect-[225/100] rounded-xl text-white">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chest_1.webp" class="w-full h-full" />
                <div class="absolute w-full top-[14%] left-[7%] flex gap-x-2">
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_blue-button">Сдан</div>
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_red-button">Осталось мало квартир</div>
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_orange-button">Акция</div>
                </div>
                <div class="absolute top-[35%] xs:top-[50%] md:top-[40%] lg:top-[50%] left-[6%]">
                    <h3 class="w-2/3 font-semibold text-[20px] leading-[18px]">Жилой комплекс "Жемчужина"</h3>
                    <p class="text-[10px] xs:mt-1">г.Владимир, ул.Чайковского, д.8</p>
                </div>
                <p class="absolute bottom-[3%] xs:bottom-[12%] left-[6%] font-semibold text-[20px]">от 2 790 000 руб.</p>
            </div>

            <div class="relative aspect-[225/100] rounded-xl text-white">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg.webp" class="w-full h-full" />
                <div class="absolute w-full top-[14%] left-[7%] flex gap-x-2">
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_blue-button">Сдан</div>
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_red-button">Осталось мало квартир</div>
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_orange-button">Акция</div>
                </div>
                <div class="absolute top-[35%] xs:top-[50%] md:top-[40%] lg:top-[50%] left-[6%]">
                    <h3 class="w-2/3 font-semibold text-[20px] leading-[18px]">Жилой комплекс "Жемчужина"</h3>
                    <p class="text-[10px] xs:mt-1">г.Владимир, ул.Чайковского, д.8</p>
                </div>
                <p class="absolute bottom-[3%] xs:bottom-[12%] left-[6%] font-semibold text-[20px]">от 2 790 000 руб.</p>
            </div>

            <div class="relative aspect-[225/100] rounded-xl text-white">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg.webp" class="w-full h-full" />
                <div class="absolute w-full top-[14%] left-[7%] flex gap-x-2">
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_blue-button">Сдан</div>
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_red-button">Осталось мало квартир</div>
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_orange-button">Акция</div>
                </div>
                <div class="absolute top-[35%] xs:top-[50%] md:top-[40%] lg:top-[50%] left-[6%]">
                    <h3 class="w-2/3 font-semibold text-[20px] leading-[18px]">Жилой комплекс "Жемчужина"</h3>
                    <p class="text-[10px] xs:mt-1">г.Владимир, ул.Чайковского, д.8</p>
                </div>
                <p class="absolute bottom-[3%] xs:bottom-[12%] left-[6%] font-semibold text-[20px]">от 2 790 000 руб.</p>
            </div>

            <div class="relative aspect-[225/100] rounded-xl text-white">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chest_1.webp" class="w-full h-full" />
                <div class="absolute w-full top-[14%] left-[7%] flex gap-x-2">
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_blue-button">Сдан</div>
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_red-button">Осталось мало квартир</div>
                    <div class="px-3 py-1 rounded-md text-[10px] font-semibold bg-_orange-button">Акция</div>
                </div>
                <div class="absolute top-[35%] xs:top-[50%] md:top-[40%] lg:top-[50%] left-[6%]">
                    <h3 class="w-2/3 font-semibold text-[20px] leading-[18px]">Жилой комплекс "Жемчужина"</h3>
                    <p class="text-[10px] xs:mt-1">г.Владимир, ул.Чайковского, д.8</p>
                </div>
                <p class="absolute bottom-[3%] xs:bottom-[12%] left-[6%] font-semibold text-[20px]">от 2 790 000 руб.</p>
            </div>

        </div>

    </div>
</section>