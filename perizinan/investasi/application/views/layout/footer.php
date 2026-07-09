        
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

       <!-- <footer class="bg-blue-900 text-lg text-white border-t-4 fixed inset-x-0 bottom-4 rounded-xl mx-4 md:mx-24"> -->
            <!-- <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-2 md:grid-cols-3 md:gap-3 items-center justify-center"> -->
                <!-- Logo Section -->
                <!-- <div class="items-center justify-center">
                    <img src="<?= base_url('src/assets/img/home-page/logo_baru.png') ?>" alt="Image" class="mx-auto h-20 md:h-auto md:w-40">
                </div> -->

                <!-- Countdown Timer -->
                <!-- <div id="countdown" class="flex space-x-1 md:space-x-2 content-center justify-center sm:grid-cols-2 sm:gap-2">
                    <div class="text-center mr-4" style="margin-right: 20px;">
                        <span id="days" class="block gradient-text"></span><span class="text-sm">days</span>
                    </div>
                    <div class="text-center mr-8" style="margin-right: 20px;">
                        <span id="hours" class="block gradient-text"></span><span class="text-sm">hours</span>
                    </div>
                    <div class="text-center" style="margin-right: 20px;">
                        <span id="minutes" class="block gradient-text" ></span><span class="text-sm">minutes</span>
                    </div>
                    <div class="text-center">
                        <span id="seconds" class="block gradient-text"></span><span class="text-sm">seconds</span>
                    </div>
                </div> -->

                <!-- Register Button -->
                <!-- <div class="text-center md:text-center">
                    <a href="wjis/LandingPageController" class="font-roboto py-3 px-6 bg-blue-700 rounded-lg font-semibold text-white">Register WJIS</a>
                </div> -->
            <!-- </div> -->
        <!-- </footer> -->







        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
              // Set the date we're counting down to (July 10, 2024 10:00:00 WIB)
              var countDownDate = new Date("September 19, 2024 09:53:00 GMT+0700").getTime();

              // Update the countdown every 1 second
              var x = setInterval(function() {
                // Get current date and time in WIB
                var now = new Date().getTime() + (7 * 60 * 60 * 1000); // Adding 7 hours to convert to WIB

                // Calculate the distance between now and the countdown date
                var distance = countDownDate - now;

                // Handle the case when countdown is over
                if (distance <= 0) {
                  clearInterval(x);
                  $("#countdown").html("<div class='timer'>Countdown is over!</div>");
                  return; // Exit the function to stop further countdown updates
                }

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));

                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                console.log(days);
                // Display the result in the corresponding elements
                if (days > 0) {
                  $("#days").text(days).addClass("text-4xl");
                  $("#days-container").show(); // Ensure days container is visible
                } else {
                  $("#days-container").hide(); // Hide days container if days is 0
                }

               $("#hours").text(hours).addClass("text-4xl");
                $("#minutes").text(minutes).addClass("text-4xl");
                $("#seconds").text(seconds).addClass("text-4xl");

              }, 1000);
            });

        </script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($date); ?>,
                            datasets: [{
                                data: <?php echo json_encode($value); ?>,
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
            </script>

            <script>
                const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
                const mobileMenu = document.getElementById('mobile-menu');

                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            </script>
            <script>
                function changeLanguage(select) {
                    var selectedUrl = select.value;
                    window.location.href = selectedUrl;
                }
            </script>
    </body>

</html>