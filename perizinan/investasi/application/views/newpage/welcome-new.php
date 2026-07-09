    <div class="hidden md:flex justify-end mt-32 mb-4 w-4/5 mx-auto px-4">
        <ul class="flex gap-10 font-semibold text-base">
            <li class="font-roboto text-blue-800 cursor-pointer">
                <a href="#">
                    <?= !empty($language_data['menu_presentation_book']) ? $language_data['menu_presentation_book'] : 'Presentation Book' ?>
                </a>
            </li>
            <li class="font-roboto text-blue-800">
                <a href="<?= base_url('/news') ?>">
                    <?= !empty($language_data['menu_news']) ? $language_data['menu_news'] : 'News' ?>
                </a>
            </li>
        </ul>
    </div>

<div id="mobile-menu" class="fixed top-6 right-4 z-50 bg-white rounded-lg p-4 hidden w-1/2">
    <ul class="space-y-4 text-sm">
        <li>
            <a href="#" class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 hover:bg-gray-100">
                <?php echo get_landing_title($value_landing, 'v_menu1'); ?>
            </a>
        </li>

        <li>
            <a href="/get-in-touch" class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 hover:bg-gray-100">
                <?php echo get_landing_title($value_landing, 'v_menu2'); ?>
            </a>
        </li>

        <li>
            <a href="#" class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 hover:bg-gray-100">
                <?php echo get_landing_title($value_landing, 'v_menu3'); ?>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url('/news'); ?>" class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 hover:bg-gray-100">
                <?php echo get_landing_title($value_landing, 'v_menu4'); ?>
            </a>
        </li>

        <li>
            <a href="#about" class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 hover:bg-gray-100">
                <?php echo get_landing_title($value_landing, 'v_menu5'); ?>
            </a>
        </li>

        <div class="flex">
            <select id="countries" class="bg-gray-50 border border-blue-600 text-sm rounded-lg block w-full p-2.5 text-blue-800">
                <option selected>ID</option>
                <option value="US">EN</option>
            </select>
        </div>

        <button class="font-roboto py-3 px-6 bg-blue-700 rounded-lg font-semibold text-white">WJIS</button>
    </ul>
</div>
    <div>
        <div class="w-full mx-auto relative md:h-[700px] h-[400px]">
            <img src="<?= base_url('src/assets/img/home-page/banner-2.jpg') ?>" alt="Banner Image" class="w-full h-full object-cover">
            <div class="absolute bottom-20 left-0 w-4/5 lg:w-1/2 bg-green-800 bg-opacity-75 rounded-r-lg">
                <div class="flex flex-col justify-start gap-4 px-4 py-8 sm:px-8 lg:py-16 lg:px-16 lg:pr-24">
                    <h1 class="lg:text-4xl text-white font-bold font-roboto">
                        <?= !empty($homePage[0]->title) ? $homePage[0]->title : 'Judul belum tersedia 😶' ?>
                    </h1>
                    <p class="text-white md:text-lg text-sm font-roboto">
                        <?= !empty($homePage[0]->bannerText) ? $homePage[0]->bannerText : 'Konten masih loading dari semesta... 🚀' ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="w-4/5 mx-auto md:mt-32 mt-10 mb-20">
            <div class="grid md:grid-cols-2 p-4 md:gap-32 gap-6">
                <div class="flex flex-col md:pt-10 pt-4 gap-4 justify-center">
                    <p class="text-4xl md:text-5xl font-bold font-roboto tracking-tight text-blue-800"><?php echo get_landing_title($value_landing, 'v_status_data1'); ?></p>
                    <div class="flex">
                        <hr class="border border-hijau w-10 h-1 bg-hijau">
                        <hr class="border border-kuning w-10 h-1 bg-kuning">
                    </div>
                    <p class="md:text-lg text-sm font-roboto text-blue-800"><?php echo get_landing_title($value_landing, 'v_status_data2'); ?></p>
                    <button class="bg-hijau text-white text-xl px-4 py-2 rounded-2xl font-semibold font-roboto">
                        <a href="#"><?php echo get_landing_title($value_landing, 'v_status1_button'); ?></a>
                    </button>
                </div>
                <div class="w-full md:h-[400px] h-[300px] py-4 order-first md:order-last">
                <p><?php echo get_landing_title($value_landing, 'v_status_data1'); ?></p>

                    <?php
                        $imgFile = get_landing_title($value_landing, 'v_status_data1_img');
                        $imgPath = !empty($imgFile)
                            ? base_url('src/assets/img/home-page/' . $imgFile)
                            : base_url('src/assets/img/home-page/default.jpg');
                    ?>

                    <img src="<?php echo $imgPath; ?>" alt="Dynamic Image" class="w-full h-full object-cover rounded-2xl">
                </div>
            </div>
        </div>
            <div class="w-4/5 mx-auto md:my-10 my-4">
                <div class="grid md:grid-cols-2 p-4 md:gap-32 gap-6">
                    <div class="w-full md:h-400 h-300 py-4 ">
                    <?php 
                    $sectorImg = get_landing_title($value_landing, 'v_sector_img');
                    $imgPath = !empty($sectorImg) 
                        ? base_url('src/assets/img/home-page/' . $sectorImg)
                        : base_url('src/assets/img/home-page/default.jpg'); // fallback image
                    ?>
                        <img src="<?php echo $imgPath; ?>" alt="Image"
                            class="w-full h-full object-cover rounded-2xl ">
                    </div>
                    <div class="flex flex-col md:pt-10 pt-4 gap-4 justify-center">
                        <p class="text-4xl md:text-5xl font-bold font-roboto tracking-tight text-blue-800">
                            <?php echo get_landing_title($value_landing, 'v_status_data3'); ?>
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="text-lg font-roboto text-blue-800">
                            <?php echo get_landing_title($value_landing, 'v_status_data4'); ?>
                        </p>
                        <div>
                            <button class="bg-hijau text-white text-xl px-4 py-2 rounded-2xl font-semibold font-roboto">
                                <a href="">
                                    <?php echo get_landing_title($value_landing, 'v_status1_button'); ?>
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-4/5 mx-auto pt-10">
                <div class="grid md:grid-cols-2 p-4 md:gap-32">
                    <div class="flex flex-col pt-10 gap-4 justify-center">
                        <p class="text-4xl md:text-5xl font-bold font-roboto tracking-tight text-blue-800">
                            <?php echo get_landing_title($value_landing, 'v_status_data5'); ?>
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="text-lg font-roboto text-blue-800">
                            <?php echo get_landing_title($value_landing, 'v_status_data6'); ?>
                        </p>
                        <div>
                            <button class="bg-hijau text-white text-xl px-4 py-2 rounded-2xl font-semibold font-roboto">
                                <a href="">
                                    <?php echo get_landing_title($value_landing, 'v_status1_button'); ?>
                                </a>
                            </button>
                        </div>
                    </div>

                    <div class="w-full md:h-600 h-300 py-4 md:order-last order-first">
                        <?php 
                        $findImg = get_landing_title($value_landing, 'v_find_invest_img');
                        $imgPath = !empty($findImg) 
                            ? base_url('src/assets/img/home-page/' . $findImg)
                            : base_url('src/assets/img/home-page/default.jpg'); // fallback image
                        ?>
                        <img src="<?php echo $imgPath; ?>" alt="Find Investment Image" class="w-full h-full object-cover rounded-2xl">
                    </div>
                </div>
            </div>
            <div class="w-full mx-auto py-10 bg-hijau ">
                <div class="w-4/5 mx-auto grid md:grid-cols-2 p-4 gap-20">
                    <div class="flex flex-col pt-10 gap-4">
                        <p class="text-5xl font-bold text-white">
                            <?php echo get_landing_title($value_landing, 'v_status_data7'); ?>
                        </p>
                        <div class="flex">
                            <hr class="border border-biru w-10 h-1 bg-biru">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="text-lg text-white">
                            <?php echo get_landing_title($value_landing, 'v_status_data8'); ?>
                        </p>
                        <div>
                            <button class="bg-yellow-500 text-white text-xl px-4 py-2 rounded-2xl font-semibold">
                                <a href="">
                                    <?php echo get_landing_title($value_landing, 'v_status1_button'); ?>
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="w-full h-400 py-4 hidden md:flex">
                        <img src="<?= base_url('src/assets/img/section5.png') ?>" alt="Image" class="w-full h-full object-cover rounded-2xl ">
        
                    </div>
                </div>
            </div>
            <div class="w-4/5 mx-auto md:pt-32 pt-10 ">
                <div class="flex gap-4 flex-col">
                    <p class="md:text-5xl text-3xl font-bold block font-roboto text-blue-800">
                        Economy Indicator
                    </p>
                    <div class="flex">
                        <hr class="border border-hijau w-10 h-1 bg-hijau">
                        <hr class="border border-kuning w-10 h-1 bg-kuning">
                    </div>
        
                </div>
            </div>
        <div class="md:w-4/5 w-full md:mx-auto p-4 mb-20">
            <div class="grid md:grid-cols-12 grid-cols-1 gap-8 justify-center">
                <div class="flex border-hijau border-4 rounded-lg md:py-10 md:px-10 justify-center md:col-span-9">
                    <canvas id="myChart"></canvas>
                </div>

                <?php
                if (!empty($stats)) {
                    $uji = new stdClass();
                    $uji->inflationDate = new DateTime($stats->inflationDate);
                    $uji->updated_at = new DateTime($stats->updated_at);
                }
                ?>
                <div class="flex flex-col md:justify-between gap-4 md:gap-0 md:col-span-3 col-span-1">

                    <!-- Inflasi -->
                    <div class="flex items-center gap-5 border-4 border-hijau rounded-lg py-10 pl-6">
                        <div class="flex flex-col gap-2">
                            <p class="text-blue-600 font-bold md:text-2xl text-xl">
                                Inflasi/Inflation
                            </p>
                            <p class="text-blue-800 md:text-2xl text-xl font-bold">
                                <?php 
                                echo (!empty($stats) && isset($stats->inflation)) 
                                    ? $stats->inflation 
                                    : 'Data belum tersedia 😐';
                                ?>
                            </p>
                        </div>
                    </div>

                    <?php
                    if (!empty($stats)) {
                        $gd = new stdClass();
                        $gd->economicGrowthDate = new DateTime($stats->economicGrowthDate);
                        $gd->updated_at = new DateTime($stats->updated_at);
                    }
                    ?>

                    <!-- Pertumbuhan Ekonomi -->
                    <div class="flex items-center gap-5 border-4 border-hijau rounded-lg py-10 pl-6">
                        <div class="flex flex-col gap-2">
                            <p class="text-blue-600 font-bold md:text-2xl text-xl">
                                LPE/Economic Growth
                            </p>
                            <p class="text-blue-800 md:text-2xl text-xl font-bold">
                                <?php 
                                echo (!empty($stats) && isset($stats->economicGrowth)) 
                                    ? $stats->economicGrowth 
                                    : 'Data belum tersedia 😐';
                                ?>
                            </p>
                        </div>
                    </div>

                    <?php
                    if (!empty($stats)) {
                        $wje = new stdClass();
                        $wje->westJavaExportDate = new DateTime($stats->westJavaExportDate);
                        $wje->updated_at = new DateTime($stats->updated_at);
                    }
                    ?>
                    <!-- Ekspor -->
                    <div class="flex items-center gap-5 border-4 border-hijau rounded-lg py-10 pl-6">
                        <div class="flex flex-col gap-2">
                            <p class="text-blue-600 font-bold md:text-2xl text-xl">
                                West Java Export
                            </p>
                            <p class="text-blue-800 md:text-2xl text-xl font-bold">
                                <?php 
                                echo (!empty($stats) && isset($stats->westJavaExport)) 
                                    ? $stats->westJavaExport 
                                    : 'Data belum tersedia 😐';
                                ?>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
            <div class="w-full mx-auto md:pt-10 py-4 bg-hijau ">
                <div class="w-4/5 mx-auto grid md:grid-cols-2 p-4 gap-16">
                    <div class="flex flex-col md:py-10 gap-4 justify-center">
                        <p class="text-5xl font-bold text-white font-roboto tracking-tighter">
                            <?php echo get_landing_title($value_landing, 'v_status_data9'); ?>
                        </p>
                        <div class="flex">
                            <hr class="border border-biru w-10 h-1 bg-biru">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="text-lg text-white font-roboto">
                            <?php echo get_landing_title($value_landing, 'v_status_data10'); ?>
                        </p>
                        <div>
                            <button class="bg-yellow-500 text-white text-xl px-4 py-2 rounded-2xl font-semibold font-roboto">
                                <?php echo get_landing_title($value_landing, 'v_status1_button'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col items-start border-l-8 border-kuning">
                        <div class="w-200 h-200 py-4 ml-10">
                            <img src="<?= base_url('src/assets/img/LogoBIPutih.png') ?>" alt="Image"
                                class="w-full h-full object-contain rounded-2xl ">
        
                        </div>
                        <div class="w-200 h-200 py-4 ml-10">
                            <img src=" <?= base_url('src/assets/img/LogoPMPTSP.png') ?>" alt="Image"
                                class="w-full h-full object-contain rounded-2xl ">
        
                        </div>
                    </div>
                </div>
            </div>