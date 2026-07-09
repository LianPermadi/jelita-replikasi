<!doctype html>
<html lang="en">

<head>
    <title>West Java Investment Partnership</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Icons -->
    <link href="<?= base_url('src/assets/vendor/nucleo/css/nucleo.css') ?>" rel="stylesheet">
    <link href="<?= base_url('src/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">

    <link rel="icon" href="src/img/investasi-favicon.png" type="image/png">

    <link href="<?= base_url('src/css/app.css') ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Bebas+Neue&family=Concert+One&family=Lilita+One&display=swap" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145056801-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-145056801-1');
    </script> --}} -->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XL19332NT0"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-XL19332NT0');
    </script>
   <style>
    .timer {
        margin: 0 10px;
    }
    .gradient-text {
        font-size: 60px;
        /* Menggunakan background-image dengan gradient oranye, hijau, dan biru */
        background: linear-gradient(to right, #ff9d2f, #4affa3, #2fc4ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        /* Tambahkan border */
        -webkit-text-stroke: 2px rgba(0, 0, 0, 0.5); /* Border hitam dengan opacity 50% */
        text-stroke: 2px rgba(0, 0, 0, 0.5); /* Fallback untuk browser selain WebKit */
         font-family: "Archivo Black", sans-serif;
          font-weight: 400;
          font-style: normal;
    }
    @media only screen and (max-width: 600px) {
      .gradient-text{
        font-size: 30px;
      }
    }
</style>



</head>
<?php
function get_landing_title($data_landing, $key) {
    if (!empty($data_landing) && is_array($data_landing)) {
        foreach ($data_landing as $item) {
            if (isset($item->nama) && $item->nama === $key && !empty($item->value)) {
                return $item->value;
            }
        }
    }
    return ''; // kosong kalau gak ketemu
}
// $test = get_landing_title($value_landing, 'v_status1');
// var_dump($test);die();
?>
<body>
<nav class="bg-gray-200 border-b-4 border-gray-500 dark:bg-gray-900 fixed top-0 w-full z-30">
    <div class="flex items-center justify-between mx-auto p-4">
        <!-- Logo Column -->
        <div class="flex items-center">
            <div class="md:w-40 md:h-20 h-10 w-20">
                    <?php 
                    $sectorImg = get_landing_title($value_landing, 'v_header_img');
                    $imgHeader = !empty($sectorImg) 
                        ? base_url('src/assets/img/home-page/' . $sectorImg)
                        : base_url('src/assets/img/home-page/logo_baru.png'); // fallback image
                    ?>
                <img src="<?= $imgHeader ?>" alt="Image"
                    class="w-full h-full object-contain">
            </div>
        </div>

        <!-- Menu Column -->
        <div class="hidden md:flex md:items-center md:justify-between w-full md:w-auto" id="navbar-default">
            <ul class="flex flex-col md:flex-row md:space-x-8 items-center">
                <li>
                    <a href="<?php echo site_url('/'); ?>"
                        class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('/investment-op'); ?>"
                        class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <?php echo $language_data['menu_invest_in_west_java'] ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('/get-in-touch'); ?>"
                        class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        <?php echo $language_data['menu_contact'] ?>
                    </a>
                </li>
                <div class="item-centers">
                    <select id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        onchange="changeLanguage(this)">
                            <option value="<?php echo base_url('lang/EN'); ?>" <?php if ($this->session->userdata('locale') === 'EN') echo 'selected'; ?>>
                                EN
                            </option>
                            <option value="<?php echo base_url('lang/id'); ?>" <?php if ($this->session->userdata('locale') === 'id') echo 'selected'; ?>>
                                ID
                            </option>
                    </select>

                </div>

                <button class="font-roboto py-3 px-6 bg-blue-700 rounded-lg font-semibold text-white">
                </button>
            </ul>
        </div>
        <!-- Countdown Column -->
       <!--  <div id="countdown" class="flex items-center">
            <div class="timer">
                <span id="days"></span> days
            </div>
            <div class="timer">
                <span id="hours"></span> hours
            </div>
            <div class="timer">
                <span id="minutes"></span> minutes
            </div>
            <div class="timer">
                <span id="seconds"></span> seconds
            </div>
        </div> -->
     <!--    <div id="countdown" class="flex items-center" style="text-align: center;">
          <div class="timer" id="days-container">
            <span id="days"></span><br><br> days
          </div>
          <div class="timer">
            <span id="hours"></span><br> hours
          </div>
          <div class="timer">
            <span id="minutes"></span> <br> minutes
          </div>
          <div class="timer">
            <span id="seconds"></span><br> seconds
          </div>
        </div> -->

        <!-- Mobile Menu Toggle Button -->
        <button id="mobile-menu-toggle" type="button"
            class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</nav>
