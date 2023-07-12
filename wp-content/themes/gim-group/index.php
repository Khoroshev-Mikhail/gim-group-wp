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

    <script>
    function toggleMenu() {
        const menu = document.querySelector('.mobile-menu');
        menu.classList.toggle('show');
    }
    </script>

    <style>
        .mobile-menu {
            display: none;
        }
        
        .mobile-menu.show {
            display: flex;
        }
    </style>




<div>

<?php get_footer(); ?>
