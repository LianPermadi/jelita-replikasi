<!doctype html>
<html lang="en">

<head>
    <title>West Java Investment Partnership</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Icons -->
    <link href="src/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="src/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

    <link rel="icon" href="src/img/investasi-favicon.png" type="image/png">

    <link href="src/css/app.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree&display=swap" rel="stylesheet">


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
</head>

<body>
    <nav class="bg-white border-gray-200 dark:bg-gray-900 fixed top-0 w-full z-30">
        <div class="w-4/5 flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="" class="flex items-center">
                <div class="md:w-40 md:h-20 h-10 w-20">
                    <img src="src/assets/img/home-page/logo_baru.png" alt="Image"
                        class="w-full h-full object-contain">
                </div>

            </a>
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
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700  items-center">
                    <li>
                        <a href=""
                            class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.get.touch.v2') }}"
                            class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        </a>
                    </li>

                    <!-- <div class="item-centers">
                        <select id="countries"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="location = this.value;">
                            <option value="{{ route('setlanguage', ['key' => 'EN']) }}" @if (Lang::locale() === 'EN')
                            selected
                                    @endif
                            >
                                EN
                            </option>
                            <option
                                    value="{{ route('setlanguage', ['key' => 'id']) }}"
                                    @if (Lang::locale() === 'id')
                                    selected @endif>
                                ID
                            </option>
                        </select>
                    </div> -->

                    <button class="font-roboto
        py-3 px-6 bg-blue-700 rounded-lg font-semibold text-white">WJIS</button>
    </ul>
    </div>
    </div>
    </nav>
    <div class="hidden md:flex justify-end mt-32 mb-4 w-4/5 mx-auto px-4">
        <ul class="flex gap-10 font-semibold text-base">

            <li class="font-roboto text-blue-800 cursor-pointer">
                <a href="">Presentation Book</a>
            </li>
            <li class="font-roboto text-blue-800">
                <a href="">News</a>
            </li>

        </ul>
    </div>
    <div id="mobile-menu" class="fixed top-6 right-4 z-50 bg-white rounded-lg p-4 hidden w-1/2">
        <ul class="space-y-4 text-sm ">
            <li>
                <a href=""
                    class="font-roboto font-semibold block py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100">Why
                    invest in West Java</a>
            </li>
            <li>
                <a href="#"
                    class="block font-roboto font-semibold  py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100">Contact</a>
            </li>
            <li>
                <a href=""
                    class="block font-roboto font-semibold  py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100">Presentation
                    Book</a>
            </li>
            <li>
                <a href="#"
                    class="block font-roboto font-semibold  py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100">
                    News</a>
            </li>
            <li>
                <a href="#"
                    class="block font-roboto font-semibold  py-2 pl-3 pr-4 text-blue-800 rounded hover:bg-gray-100">
                    About us</a>
            </li>
            <div class="flex">
                <select id="countries"
                    class="bg-gray-50 border border-blue-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-blue-800">
                    <option selected class="text-blue-700">ID</option>
                    <option value="US" class="text-blue-700">EN</option>
                </select>
            </div>


            <button class="font-roboto py-3 px-6 bg-blue-700 rounded-lg font-semibold text-white">WJIS</button>
        </ul>
    </div>


    <div>
	<div class="w-full mx-auto relative md:h-700 h-400">
                <img src="src/assets/img/home-page/banner-2.jpg" alt="Image" class="w-full h-full object-cover">
        
                <div class="absolute bottom-20 left-0 w-4/5 lg:w-1/2 bg-green-800 bg-opacity-75 rounded-r-lg">
                    <div class="flex flex-col justify-start gap-4 px-4 py-8 sm:px-8 lg:py-16 lg:px-16 lg:pr-24">
                        <h1 class="lg:text-4xl text-white font-bold font-roboto">Invest In West Java</h1>
                        <div>
                            <p class="text-white md:text-lg text-sm font-roboto">
                                West Java investment Partnership Project Display Page
                            </p>
                        </div>
                    </div>
        
                </div>
            </div>
            <div class="w-4/5 mx-auto md:mt-32 mt-10 mb-20">
                <div class="grid md:grid-cols-2 p-4 md:gap-32 gap-6">
                    <div class="flex flex-col md:pt-10 pt-4 gap-4 justify-center">
                        <p class="text-4xl md:text-5xl font-bold font-roboto tracking-tight text-blue-800">
                            Why Invest in the West Java ?
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="md:text-lg text-sm font-roboto text-blue-800">
                            West Java offers world-class talent, high investment and a robust, business-friendly
                            environment to
                            reliably expand, trade and invest.
                        </p>
                        <div>
                            <button class="bg-hijau text-white text-xl px-4 py-2 rounded-2xl font-semibold font-roboto">
                                <a href="">
                                    Discover More
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="w-full md:h-400 h-300 py-4 order-first md:order-last">
                        <img src="src/assets/img/home-page/frame2.png" alt="Image"
                            class="w-full h-full object-cover rounded-2xl ">
        
                    </div>
                </div>
            </div>
            <div class="w-4/5 mx-auto md:my-10 my-4">
                <div class="grid md:grid-cols-2 p-4 md:gap-32 gap-6">
        
                    <div class="w-full md:h-400 h-300 py-4 ">
                        <img src="src/assets/img/home-page/frame3.png" alt="Image"
                            class="w-full h-full object-cover rounded-2xl ">
        
                    </div>
                    <div class="flex flex-col md:pt-10 pt-4 gap-4 justify-center">
                        <p class="text-4xl md:text-5xl font-bold font-roboto tracking-tight text-blue-800">
                            West Java Sector
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="text-lg font-roboto text-blue-800">
                            West Java Investment Atlas showcases all sectors and opportunities across West Java.
                        </p>
                        <div>
                            <button class="bg-hijau text-white text-xl px-4 py-2 rounded-2xl font-semibold font-roboto">
                                <a href="">
                                    Discover More
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
                            West Java Region
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="text-lg font-roboto text-blue-800">
                            The economic power and diversity of West Java regions offer global businesses one of the best ecosystems
                            in the world to grow innovative companies.
                        </p>
                        <div>
                            <button class="bg-hijau text-white text-xl px-4 py-2 rounded-2xl font-semibold font-roboto">
                                <a href="">
                                    Discover More
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="w-full md:h-600 h-300 py-4 md:order-last order-first">
                        <img src="src/assets/img/home-page/frame4.png" alt="Image"
                            class="w-full h-full object-contain rounded-2xl ">
        
                    </div>
                </div>
            </div>
            <div class="w-full mx-auto py-10 bg-hijau ">
                <div class="w-4/5 mx-auto grid md:grid-cols-2 p-4 gap-20">
                    <div class="flex flex-col pt-10 gap-4">
                        <p class="text-5xl font-bold text-white">
                            Find your investment opportunities
                        </p>
                        <div class="flex">
                            <hr class="border border-biru w-10 h-1 bg-biru">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="text-lg text-white">
                            We have selected a range of attractive large capital and foreign direct investment opportunities to meet
                            your needs.
                        </p>
                        <div>
                            <button class="bg-yellow-500 text-white text-xl px-4 py-2 rounded-2xl font-semibold">
                                <a href="">
                                    Discover More
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="w-full h-400 py-4 hidden md:flex">
                        <img src="src/assets/img/section5.png" alt="Image" class="w-full h-full object-cover rounded-2xl ">
        
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
                    <div class="flex flex-col md:justify-between gap-4 md:gap-0 md:col-span-3 col-span-1">
                        <div class="flex items-center gap-5 border-4 border-hijau rounded-lg py-10 pl-6">
                            <div class="flex flex-col gap-2">
                                <p class="text-blue-600 font-bold md:text-2xl text-xl">
                                    Inflasi/Inflation
                                </p>
                                <p class="text-blue-800 md:text-2xl text-xl font-bold">
                                    {{ $stats->inflation }}
                                </p>
                                {{-- <p class="text-blue-600 font-bold text-xl">
                                    ({{ $stats->inflationDate->format('M Y') }})
                                </p>
                                <p class="text-black text-sm">
                                    {{ $stats->updated_at->format('d M Y') }}
                                </p> --}}
                            </div>
        
                        </div>
                        <div class="flex items-center gap-5 border-4 border-hijau rounded-lg py-10 pl-6">
                            <div class="flex flex-col gap-2">
                                <p class="text-blue-600 font-bold md:text-2xl text-xl">
                                    LPE/Economic Growth
                                </p>
                                {{-- <p class="text-blue-600 font-bold text-xl">
                                    ({{ $stats->economicGrowthDate->format('M Y') }})
                                </p>
                                <p class="text-black text-sm">
                                    {{ $stats->updated_at->format('d M Y') }}
                                </p> --}}
                                <p class="text-blue-800 md:text-2xl text-xl font-bold">
                           
                                </p>
                            </div>
        
                        </div>
                        <div class="flex items-center gap-5 border-4 border-hijau rounded-lg py-10 pl-6">
                            <div class="flex flex-col gap-2">
                                <p class="text-blue-600 font-bold md:text-2xl text-xl">
                                    West Java Export
                                </p>
                                {{-- <p class="text-blue-600 font-bold text-xl">
                                    ({{ $stats->westJavaExportDate->format('M Y') }})
                                </p>
                                <p class="text-black text-sm">
                                    {{ $stats->updated_at->format('d M Y') }}
                                </p> --}}
                                <p class="text-blue-800 md:text-2xl text-xl font-bold">
                               
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
                            How we can help
                        </p>
                        <div class="flex">
                            <hr class="border border-biru w-10 h-1 bg-biru">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="text-lg text-white font-roboto">
                            Our international network provides a global reach in 170 countries. Staff work to ensure global
                            businesses can invest successfully in the West Java, whether directly in creating a West Java entity or
                            indirectly investing capital in a West Java business or development.
                        </p>
                        <div>
                            <button class="bg-yellow-500 text-white text-xl px-4 py-2 rounded-2xl font-semibold font-roboto">
                                Discover More
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col items-start border-l-8 border-kuning">
                        <div class="w-200 h-200 py-4 ml-10">
                            <img src="src/assets/img/LogoBIPutih.png" alt="Image"
                                class="w-full h-full object-contain rounded-2xl ">
        
                        </div>
                        <div class="w-200 h-200 py-4 ml-10">
                            <img src="src/assets/img/LogoPMPTSP.png" alt="Image"
                                class="w-full h-full object-contain rounded-2xl ">
        
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="md:h-24 md:w-full bg-white my-24 w-4/5 mx-auto md:mx-0">
                <div class="flex md:justify-between">
                    <div class="flex flex-col gap-12 md:ml-48">
                        <div class="flex flex-col md:flex-row gap-4 flex-grow">
                            <p class="text-hijau font-semibold underline font-roboto cursor-pointer hover:text-kuning">
                                <a href="">
                                    Why Invest in West Java?
                                </a>
                            </p>
                            <p class="text-hijau font-semibold underline font-roboto cursor-pointer hover:text-kuning">
                                <a href="">
                                    West Java regions
                                </a>
            
                            </p>
                            <p class="text-hijau font-semibold underline font-roboto cursor-pointer hover:text-kuning">
                                <a href="">
                                    Sectors
                                </a>
            
                            </p>
                            <p class="text-hijau font-semibold underline font-roboto cursor-pointer hover:text-kuning">
                                <a href="">
                                    Investment opportunities
                                </a>
            
                            </p>
                        </div>
                        <div class="flex flex-col md:flex-row gap-4">
                            <p class="text-hijau font-semibold underline font-roboto cursor-pointer hover:text-kuning">
                                <a href="">
                                    How we can help
                                </a>
                            </p>
                            <p class="text-hijau font-semibold underline font-roboto cursor-pointer hover:text-kuning">
                                <a href="">
                                    Event
                                </a>
                            </p>
                            <p class="text-hijau font-semibold underline font-roboto cursor-pointer hover:text-kuning">
                                <a href="">
                                    Commodity
                                </a>
                            </p>
                            <p class="text-hijau font-semibold underline font-roboto cursor-pointer hover:text-kuning">
                                <a href="">
                                    UMKM
                                </a>
            
                            </p>
            
                        </div>
                    </div>
                    <div class="hidden md:flex md:justify-end">
                        <div class="w-full h-24 bg-green-600 py-2 flex items-center">
                            <div>
                                <p class="text-4xl font-bold text-white ml-8">
                                    GREAT WEST JAVA
                                </p>
                            </div>
                        </div>
                        <div class="w-24 h-24 bg-yellow-500"></div>
                    </div>
                </div>
            </div>
            
        
            <div class="w-full bg-white py-4 bottom-0 ">
                <div class="max-w-7xl mx-auto flex justify-end px-4 mt-12">
                    <p class="text-blue-800 text-sm md:text-lg font-roboto tracking-tight">
                        © 2023 West Java Investment. All rights reserved.
                    </p>
                </div>
            </div>
            
        
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <!-- <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($date),
                            datasets: [{
                                data: @json($value),
                                fill: false,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                pointStyle: 'circle',
                                pointRadius: 10,
                                pointHoverRadius: 15
                            }]
                        },
                        options: {
                            scales: {
        
                                y: {
                                    suggestedMin: 15000,
                                    suggestedMax: 16000,
                                    stepSize: 100,
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltips: {
                                    callbacks: {
                                        title: function(tooltipItem, data) {
                                            // Display the date as the title
                                            return data.labels[tooltipItem[0].index];
                                        },
                                        label: function(tooltipItem, data) {
                                            // Display "rate usd" as the label
                                            return "rate usd: " + tooltipItem.formattedValue;
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script> -->
    </div>


    <script>
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    </body>

</html>
