<section class="_section mt-20">
    <div class="_wrapper ">
        <div class="flex flex-col md:flex-row justify-between h-full py-5 px-2 xs:px-4 md:px-5 md:py-10 lg:p-20 rounded-2xl bg-[url('/images/bg.webp')] bg-cover bg-center bg-no-repeat">

            <div class="flex flex-col justify-center h-full text-white md:w-2/5 md:pr-4">
                <div>
                    <p class="_h2-text">Остались вопросы?</p>
                    <p class="text-[14px] xs:text-[16px] sm:text-[18px]">Оставьте свои контактные данные и мы свяжемся с вами</p>
                </div>
            </div>

            <div class="flex flex-col justify-center h-full md:w-3/5 mt-7 md:mt-0">
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

<script type="text/javascript">
    console.log('<?php echo get_theme_mod('feedback_time_dropdown_setting')[2];?>')
    </script>