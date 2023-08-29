<section class="_section mt-20">
    <div class="_wrapper flex flex-col">
        <h2 class="_h"><?php echo get_theme_mod('calculator_header_setting'); ?></h2>
        <div class="flex flex-col md:flex-row justify-between gap-x-5 gap-y-5 mt-7">
            <div class="flex flex-col gap-y-5 rounded-2xl bg-white w-full md:w-3/5 px-8 py-5"> 
                <div class="text-_blue_for-text text-[32px]">
                    Ипотека
                </div>
                <div class="flex">
                    <div class="flex flex-col w-3/5 justify-between gap-y-5 pr-5 text-[10px] border-r border-_gray">
                        <div>
                            <select value="0" onchange="choose_mortgage( this.value )" class="w-full bg-_gray p-3 rounded-lg lg:hidden">
                                <option value="1">
                                    <?php echo get_theme_mod('mortgage_1_setting'); ?>
                                </option>
                                <option value="2">
                                    <?php echo get_theme_mod('mortgage_2_setting'); ?>
                                </option>
                                <option value="3">
                                    <?php echo get_theme_mod('mortgage_3_setting'); ?>
                                </option>
                            </select>
                        </div>
                        <div class="hidden lg:flex justify-between gap-x-3">
                            <button class="p-3 bg-_gray rounded-lg" onclick="choose_mortgage(1)">
                                <?php echo get_theme_mod('mortgage_1_setting'); ?>
                            </button>
                            <button class=" p-3 bg-_gray rounded-lg" onclick="choose_mortgage(2)">
                                <?php echo get_theme_mod('mortgage_2_setting'); ?>
                            </button>
                            <button class=" p-3 bg-_gray rounded-lg" onclick="choose_mortgage(3)">
                                <?php echo get_theme_mod('mortgage_3_setting'); ?>
                            </button>
                        </div>
                        <div>
                            <label class="text-_gray-for-text">Стоимость квартиры</label>
                            <input id="total_input" type="number" value="0" min="0" max="" onchange="total_input_handler(this)" placeholder="" class="w-full rounded-lg bg-_gray p-3"/>
                            <input id="total_range" type="range" value="" min="0" max="" onchange="total_range_handler(this)" class="w-[calc(100%-12px)] mx-auto block h-[1px]" />
                        </div>
                        <div>
                            <label class="text-_gray-for-text">Первоначальный взнос</label>
                            <input id="initial_input" type="number" value="" min="0" max="" onchange="initial_input_handler(this)" placeholder="" class="w-full rounded-lg bg-_gray p-3"/>
                            <input id="initial_range" type="range" value="" min="0" max="" onchange="initial_range_handler(this)" class="w-[calc(100%-12px)] mx-auto block h-[1px]" />
                        </div>
                        <div>
                            <label class="text-_gray-for-text">Срок кредита</label>
                            <input id="time_input" type="numer" value="" min="1" max="" onchange="time_input_handler(this)" placeholder="" class="w-full rounded-lg bg-_gray p-3"/>
                            <input id="time_range" type="range" value="" min="1" max="" onchange="time_range_handler(this)" class="w-[calc(100%-12px)] mx-auto block h-[1px]" />
                        </div>
                        <div>
                            <button class="bg-_blue-button text-white w-full rounded-lg p-3 mt-3">
                                Получить одобрение онлайн
                            </button>
                            <!-- https://domclick.ru/ipoteka/calculator?showMlandAuth=true&from=sbercalc&utm_source=sberbank&utm_medium=referral&utm_campaign=calc&prod=3&categoryCode=salaryClient&term=30&dep=600000&cost=3000000&subproductCode=15110&discountIds=[1,7,19]&disabledDiscountIds=[] -->
                        </div>
                    </div>
                    <div class="flex flex-col w-2/5 justify-between pl-5">
                        <div class="text-[14px] sm:text-[16px] md:text-[28px] leading-none font-medium pt-1">
                            <span id="mortgage_span"></span>
                        </div>
                        <div class="">
                            <p class="text-_gray-for-text text-[14px] sm:text-[16px]">Процентная ставка</p>
                            <p class="text-_blue_for-text text-[16px] xs:text-[18px] sm:text-[20px] md:text-[24px] lg:text-[32px] font-semibold">
                                <span id="rate_span"></span>%
                            </p>
                        </div>
                        <div class="">
                            <p class="text-_gray-for-text text-[14px] sm:text-[16px]">Ежемесячный платеж</p>
                            <p class="text-_blue_for-text text-[16px] xs:text-[18px] sm:text-[20px] md:text-[24px] lg:text-[32px] font-semibold">
                                <span id="monthly_payment_span"></span> руб.
                            </p>
                        </div>
                        <div class="">
                            <p class="text-_gray-for-text text-[14px] sm:text-[16px]">Переплата</p>
                            <p class="text-_blue_for-text text-[14px] xs:text-[16px] sm:text-[18px] md:text-[22px] lg:text-[28px] font-medium">
                                <span id="overpayment_span"></span> руб.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-between rounded-2xl bg-[#157BBC] gap-y-2 xs:gap-y-4 sm:gap-y-6 text-white w-full md:w-2/5  px-8 py-5">
                <div>
                    <p>Рассрочка</p>
                </div>
                <div>
                    <p><?php echo get_theme_mod('calculator_desc_setting'); ?></p>
                </div>
                <div>
                    <a href="<?php echo get_permalink(get_theme_mod('calculator_desc_link_setting')); echo get_theme_mod('calculator_desc_link_setting')?>" class="underline">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    const total_input = document.getElementById('total_input');
    const total_range = document.getElementById('total_range');
    const initial_input = document.getElementById('initial_input');
    const initial_range = document.getElementById('initial_range');
    const time_input = document.getElementById('time_input');
    const time_range = document.getElementById('time_range');
    const mortgage_span = document.getElementById('mortgage_span');
    const rate_span = document.getElementById('rate_span');
    const monthly_payment_span = document.getElementById('monthly_payment_span');
    const overpayment_span = document.getElementById('overpayment_span');

    const rate = {
        1: { 
            name: "<?php echo get_theme_mod('mortgage_1_setting'); ?>", 
            value: <?php echo get_theme_mod('mortgage_1_rate_setting'); ?>,
        },
        2: { 
            name: "<?php echo get_theme_mod('mortgage_2_setting'); ?>", 
            value: <?php echo get_theme_mod('mortgage_2_rate_setting'); ?>,
        },
        3: { 
            name: "<?php echo get_theme_mod('mortgage_3_setting'); ?>", 
            value: <?php echo get_theme_mod('mortgage_3_rate_setting'); ?>,
        },
    }

    let total = 2_800_000;
    let initial = total * 20 / 100;
    let rate_percent = rate[1].value;
    let time = 20;

    const max_total = 10_000_000;
    const max_initial = total;
    const max_time = 30;

    total_input.max = max_total;
    total_range.max = max_total;
    total_input.min = initial;
    total_range.min = initial;
    total_input.value = total;
    total_range.value = total;
    
    initial_input.max = max_initial;
    initial_range.max = max_initial;
    initial_input.value = initial;
    initial_range.value = initial;

    time_input.max = max_time;
    time_range.max = max_time;
    time_input.value = time;
    time_range.value = time;

    function calculate(){
        let monthly_payment = Math.ceil( (rate_percent / 100 * ( total - initial) * time + total - initial) / time / 12 );
        let overpayment = Math.ceil(rate_percent / 100 * ( total - initial) * time);
        monthly_payment_span.textContent =  monthly_payment.toLocaleString();
        overpayment_span.textContent = overpayment.toLocaleString();
    }
    function choose_mortgage( number ){
        rate_percent = rate[number].value;
        mortgage_span.textContent = rate[number].name;
        rate_span.textContent = rate[number].value;

        calculate()
    }

    function total_input_handler({ value }){
        total = value <= initial ? initial : (+value);
        // total = +value;
        total_range.value = total;
        initial_input.max = total;
        initial_range.max = total;
        calculate();
    }
    function total_range_handler({ value }){
        total = value <= initial ? initial : (+value);
        // total = +value;
        total_input.value = total;
        initial_input.max = total;
        initial_range.max = total;
        calculate();
    }
    function initial_input_handler({ value }){
        initial = value >= total ? total : value;
        initial_range.value = initial;
        total_input.min = initial;
        total_range.min = initial;
        calculate();
    }
    function initial_range_handler({ value }){
        initial = value >= total ? total : value;
        initial_input.value = initial;
        total_input.min = initial;
        total_range.min = initial;
        calculate();
    }
    function time_input_handler({ value }){
        time = value;
        time_range.value = time;
        calculate();
    }
    function time_range_handler({ value }){
        time = value;
        time_input.value = time;
        calculate();
    }

    choose_mortgage(1)
    calculate();

</script>