<?php get_header(); ?>

<div class="container">

    <section class="_section">
        <div class="_wrapper mt-7 relative">

            <div class="flex justify-between text-_blue_for-text h-16 text-[14px] bg-white rounded-2xl px-10">
                <div class="flex flex-col justify-center py-[18px]">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_top.png"  alt="ГИМ ГРУПП" height="20" class="w-auto h-full"/>
                </div>
                <div class="flex flex-col justify-center ">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/burger.svg" alt="Меню" class="md:hidden" onclick="toggleMenu()"/>
                </div>
                <nav class="flex-col justify-center hidden md:flex text-[14px] lg:text-[16px]">
                    <ul class="flex [&>li]:inline gap-x-3 lg:gap-x-10">
                        <li><a href="#">Проекты</a></li>
                        <li><a href="#">Коммерческая недвижимость</a></li>
                        <li><a href="#">Машиноместа</a></li>
                    </ul>
                </nav>
                <div class="hidden md:flex flex-col justify-center">
                    <a href="tel:74922779554" class="text-right leading-4">+7 (4922) 779-554</a>
                    <p class="text-_gray-dark text-right leading-4">пн-пт:9:00-18:00<span class="hidden lg:inline">, сб-вс:выходной</span></p>
                </div>
            </div>

            <div class="mobile-menu absolute z-50 top-0 left-0 flex flex-col justify-between px-12 py-[18px] bg-white min-h-screen rounded-2xl h-full w-full">
                <div class="flex justify-between">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_top.png"  alt="ГИМ ГРУПП" height="20" class="w-auto block h-7"/>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/xmark.svg" alt="Меню" class="h-7" onclick="toggleMenu()"/>
                </div>
                <div class="mt-4">
                    <ul class="text-right w-full space-y-2">
                        <li><a href="#">Проекты</a></li>
                        <li><a href="#">Коммерческая недвижимость</a></li>
                        <li><a href="#">Машиноместа</a></li>
                    </ul>
                </div>
                <div class="flex flex-col justify-center pb-8">
                    <a href="tel:74922779554" class="text-right leading-4">+7 (4922) 779-554</a>
                    <p class="text-_gray-dark text-right leading-4">пн-пт: 9:00-18:00</p>
                </div>
            </div>

        </div>

    </section>

    <section class="_section mt-5">
        <div class="_wrapper">
            <div class="relative text-white">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg.webp" alt="Два дома в Ессентуках" class="w-full h-auto"/>
                <div class="absolute top-[10%] xs:top-[20%] md:top-[30%]  left-[6%]">
                    <h1 class="text-[22px] xs:text-[28px] sm:text-[36px] md:text-[48px] lg:text-[64px] maxw:text-[72px] leading-none">Два дома<br/> в Ессентуках</h1>
                    <p class="text-[10px] xs:text-[12px] sm:text-[14px] md:text-[16px] lg:text-[20px] leading-none font-semibold mt-2">Восемьдесят эксклюзивных квартир</p>
                </div>
                <a href="#" class="absolute bottom-[10%] left-[6%] text-[12px] xs:text-[14px] sm:text-[16px] md:text-[18px] lg:text-[24px] leading-none font-semibold border-b pb-[-5px] cursor-pointer">Подробнее</a>
            </div>
        </div>
    </section>

    <section class="_section mt-14">
        <div class="_wrapper">
            <form onSubmit="()=>{}" class="flex flex-col gap-y-2 xs:gap-y-3 sm:gap-y-4 md:flex-row md:justify-between gap-x-8">
                <input type="text" name="name" placeholder="Ваше имя" class="w-full md:w-1/3 p-4 bg-white rounded-xl"/>
                <input type="tel" name="phone" placeholder="Ваш телефон" class="w-full md:w-1/3 p-4 bg-white rounded-xl"/>
                <button type="submit" class="w-full md:w-1/3 p-4 bg-_blue-for-bg text-white rounded-xl">
                    Получить консультацию
                </button>
            </form>
        </div>
    </section>

    <section class="_section mt-20">
        <div class="_wrapper">
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

    <section class="_section mt-20">
        <div class="_wrapper flex flex-col">
            <h2 class="_h">Варианты покупки</h2>
            <div class="flex flex-col md:flex-row justify-between gap-x-5 gap-y-5 mt-7">
                <div class="flex flex-col gap-y-5 rounded-2xl bg-white w-full md:w-3/5 px-8 py-5"> 
                    <div class="text-_blue_for-text text-[32px]">
                        Ипотека
                    </div>
                    <div class="flex">
                        <div class="flex flex-col w-3/5 justify-between gap-y-5 pr-5 text-[10px] border-r border-_gray">
                            <div>
                                <select value="0" onchange="" class="w-full bg-_gray p-3 rounded-lg lg:hidden">
                                    <option value={0.001}>
                                        Ипотека 0.1%
                                    </option>
                                    <option value={0.064}>
                                        Семейная ипотека
                                    </option>
                                    <option value={0.051}>
                                        IT специалистам
                                    </option>
                                </select>
                            </div>
                            <div class="hidden lg:flex justify-between gap-x-3">
                                <button class="p-3 bg-_gray rounded-lg">
                                    Ипотека 0.1%
                                </button>
                                <button class=" p-3 bg-_gray rounded-lg">
                                    Семейная ипотека
                                </button>
                                <button class=" p-3 bg-_gray rounded-lg">
                                    IT специалистам
                                </button>
                            </div>
                            <div>
                                <label class="text-_gray-for-text">Стоимость квартиры</label>
                                <input type="number" value="0" onchange="" placeholder="" class="w-full rounded-lg bg-_gray p-3"/>
                                <input type="range" value="" min="0" max="0" onChange="" class="w-[calc(100%-12px)] mx-auto block h-[1px]" />
                            </div>
                            <div>
                                <label class="text-_gray-for-text">Первоначальный взнос</label>
                                <input type="number" value="" onChange="" placeholder="" class="w-full rounded-lg bg-_gray p-3"/>
                                <input type="range" value="" onChange="" min="0" max="" class="w-[calc(100%-12px)] mx-auto block h-[1px]" />
                            </div>
                            <div>
                                <label class="text-_gray-for-text">Срок кредита</label>
                                <input  type="numer" value="" onchange="" placeholder="" class="w-full rounded-lg bg-_gray p-3"/>
                                <input type="range" value="" onchange="" min="" max="" class="w-[calc(100%-12px)] mx-auto block h-[1px]" />
                            </div>
                            <div>
                                <button class="bg-_blue-button text-white w-full rounded-lg p-3 mt-3">
                                    Получить одобрение онлайн
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col w-2/5 justify-between pl-5">
                            <div class="text-[14px] sm:text-[16px] md:text-[28px] leading-none font-medium pt-1">
                                Ипотека %
                            </div>
                            <div class="">
                                <p class="text-_gray-for-text text-[14px] sm:text-[16px]">Процентная ставка</p>
                                <p class="text-_blue_for-text text-[16px] xs:text-[18px] sm:text-[20px] md:text-[24px] lg:text-[32px] font-semibold">!! </p>
                            </div>
                            <div class="">
                                <p class="text-_gray-for-text text-[14px] sm:text-[16px]">Ежемесячный платеж</p>
                                <p class="text-_blue_for-text text-[16px] xs:text-[18px] sm:text-[20px] md:text-[24px] lg:text-[32px] font-semibold">!! руб.</p>
                            </div>
                            <div class="">
                                <p class="text-_gray-for-text text-[14px] sm:text-[16px]">Переплата</p>
                                <p class="text-_blue_for-text text-[14px] xs:text-[16px] sm:text-[18px] md:text-[22px] lg:text-[28px] font-medium">!! руб.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-between rounded-2xl bg-[#157BBC] gap-y-2 xs:gap-y-4 sm:gap-y-6 text-white w-full md:w-2/5  px-8 py-5">
                    <div>
                        <p>Рассрочка</p>
                    </div>
                    <div>
                        <p>С действующей программой гибкой рассрочки от застройщика вы можете купить готовую, новую квартиру не дожидаясь продажи старой. А остаток погасить, например, через целый год. Это отличное решение для тех, кому не подходит ипотека, а для полной оплаты возможности нет.</p>
                    </div>
                    <div>
                        <a class="underline">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="_section mt-20">
        <div class="_wrapper ">
            <div class="flex flex-col md:flex-row justify-between h-full py-5 px-2 xs:px-4 md:px-5 md:py-10 lg:p-20 rounded-2xl bg-[url('/images/bg.webp')] bg-cover bg-center bg-no-repeat">

                <div class="flex flex-col justify-center h-full text-white md:w-2/5 md:pr-4">
                    <div>
                        <p class="_h2-text">Остались вопросы?</p>
                        <p class="text-[14px] xs:text-[16px] sm:text-[18px]">Оставьте свои контактные данные и мы свяжемся с вами</p>
                    </div>
                </div>

                <div class="flex flex-col justify-center h-full md:w-3/5">
                    <form class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4" onSubmit="">
                        <div class="col-span-1 rounded-lg bg-white p-3">
                            <input type="text" name="name" placeholder="Ваше имя" class="w-full"/>
                        </div>
                        <div class="col-span-1 rounded-lg bg-white p-3">
                            <input type="text" name="phone" placeholder="Ваш телефон" class="w-full"/>
                        </div>
                        <div class="col-span-1">
                            <select class="w-full bg-white text-_blue_for-text rounded-lg p-3.5">
                                <option>Сегодня</option>
                                <option>Завтра</option>
                            </select>
                        </div>
                        <div class="col-span-1">
                            <select class="w-full bg-white text-_blue_for-text rounded-lg p-3.5">
                                <option>Ближайшее время</option>
                                <option>09:00</option>
                                <option>09:30</option>
                                <option>10:00</option>
                                <option>10:30</option>
                                <option>11:00</option>
                                <option>11:30</option>
                                <option>12:00</option>
                                <option>12:30</option>
                                <option>13:00</option>
                                <option>13:30</option>
                                <option>14:00</option>
                                <option>14:30</option>
                                <option>15:00</option>
                                <option>15:30</option>
                                <option>16:00</option>
                                <option>16:30</option>
                                <option>17:00</option>
                                <option>17:30</option>
                            </select>
                        </div>
                        <div class="md:col-start-2 md:col-end-3">
                            <button type="submit" class="w-full text-center p-3 rounded-lg bg-_blue-for-bg">Отправить</button>
                        </div>
                    </form>
                </div>

            </div>    
        </div>
    </section>

    <!-- SLIDER -->

    <section class="_section mt-32">
        <div class="_wrapper ">
            <div class="flex flex-col md:flex-row justify-between rounded-2xl bg-[url('/images/bg.webp')] bg-cover bg-center bg-no-repeat text-white !p-10">        

            <div class="w-full md:w-1/4 text-[24px] md:text-[22px] lg:text-[28px]">
                О застройщике
            </div>
            <div class="w-full md:w-3/4 mt-5 flex-col">
                <div class="">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_white.png" alt="Логотип ГИМ-ГРУПП" class="w-full"/>
                </div>
                <div class="md:pl-[27.5%] mt-5 md:-mt-5">
                    <p class="text-[12px] sm:text-[14px] md:text-[10px]">ООО "СЗ ГИМ ГРУПП" представляет собой комманду профессионалов с многолетним стажем работы в сфере строительства жилой недвижимости. Забота о своих клиентов с учетом индивидуального подхода к каждому, применение современных технологических решений, строгий контроль качества и сроков выполнения работ являются отличительными способностями комании, отличающими ее от других на рынке недвижимости города Владимира и области.</p>
                    <p class="text-[10px] mt-1">ООО "ГИМ ГРУПП" - гарант успешного разрешения Ващего жилищного вопроса.</p>
                </div>
            </div>
            
            </div>
        </div>
    </section>

    <section class="_section mt-14 pb-14">
        <div class="_wrapper flex md:flex-row flex-col justify-between gap-x-2 md:gap-x-4">
            
            <div class='w-full sm:w-1/2 mx-auto md:w-3/12 mt-5 md:-mt-[10px] lg:-mt-[16px] order-2 md:order-1'>
                <Image src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_footer.png"  alt="ГИМ ГРУПП Логотип" />
            </div>

            <div class='w-full md:w-auto mx-auto order-1 md:order-2'>
                <nav>
                    <ul class='columns-2 text-[12px] text-center md:text-left'>
                        <li>Проекты</li>
                        <li>Коммерческая недвижимость</li>
                        <li>Машиноместа</li>
                        <li>Проекты</li>
                        <li>Коммерческая недвижимость</li>
                        <li>Машиноместа</li>
                    </ul>
                </nav>
            </div>

            <div class='flex flex-col justify-start order-3 mx-auto'>
                <a href="tel:74922779554" class="text-center md:text-right text-[24px] lg:text-[36px] leading-tight">+7 (4922) 779-554</a>
                <p class="text-_gray-dark text-right leading-4">пн-пт:9:00-18:00, сб-вс:выходной</p>
            </div>

        </div>
    </section>

<div>

<?php get_footer(); ?>
