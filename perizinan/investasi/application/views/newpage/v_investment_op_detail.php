<div class="hidden md:flex justify-end mt-32 mb-4 w-4/5 mx-auto px-4">
        <ul class="flex gap-10 font-semibold text-base">

            <li class="font-roboto text-blue-800 cursor-pointer">
                <a href="">
                    <?php echo $language_data['menu_presentation_book'] ?>
                </a>
            </li>
            <li class="font-roboto text-blue-800">
                <a href="">
                    <?php echo $language_data['menu_news'] ?>
                
                </a>
            </li>

        </ul>
    </div>
<div class="w-full bg-white mt-10">
    <div class="w-4/5 mx-auto">

        <div class="flex flex-col gap-4">
            <p class="text-blue-800 text-5xl font-bold font-roboto">
                <?php echo $investasi->judul_investasi; ?>
            </p>
            <div class="flex">
                <hr class="border border-hijau w-20 h-2 bg-hijau">
                <hr class="border border-kuning w-20 h-2 bg-kuning">
            </div>
        </div>

        <div class="md:grid-cols-3 grid-cols-1 grid mt-5 gap-8">
            <div class="col-span-3">
                <div class="flex flex-col gap-2">
                    <p class="text-blue-800 text-xl font-bold">
                        Share
                    </p>
                    <div class="flex md:flex-row flex-col gap-4 md:items-center ">
                        <div class="flex items-center gap-4">
                            <a href="mailto:?subject=Check out this investment opportunity&amp;body=<?php echo urlencode(current_url()); ?>">
                                <img src="<?php echo base_url('src/assets/img/icons/mail.png'); ?>" alt="" class=" h-8 w-8 ">
                            </a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode('Check out this investment opportunity: ' . current_url()); ?>">
                                <img src="<?php echo base_url('src/assets/img/icons/whatsapp.png'); ?>" alt="" class=" h-8 w-8 ">
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(current_url()); ?>">
                                <img src="<?php echo base_url('src/assets/img/icons/linkedin.png'); ?>" alt="" class=" h-8 w-8 ">
                            </a>
                        </div>

                        <div class="md:ml-8 ml-0">
                            <!-- <p class="text-white bg-blue-800 font-bold px-4 py-2 rounded-xl">Total Dilihat - <?php echo $countView; ?> </p> -->
                        </div>
                        <div class="md:ml-8 ml-0">
                            <p class="text-white bg-blue-800 font-bold px-4 py-2 rounded-xl">Update Terakhir - <?php echo date('d M Y', strtotime($investasi->updated_at)); ?> </p>
                        </div>
                    </div>

                </div>

            </div>
            <div class="md:col-span-2">
                <div class="w-full md:h-500 h-300">
                    <img src="<?php echo base_url('src/assets/invest/thumbnail/' . $investasi->image); ?>" alt="" class="object-cover h-full w-full">
                </div>
            </div>
            <div class="md:col-span-1">
                <div class="w-full rounded-2xl bg-gray-300 p-4">

                    <div class="grid grid-cols-3 justify-items-center items-center ">
                        <div class="col-span-1">
                            <div class="w-24 h-24">
                                <img src="<?php echo base_url('src/assets/img/person-pic.jpeg'); ?>" alt="" class="object-cover h-full w-full rounded-full">
                            </div>

                        </div>
                        <div class="col-span-2 place-self-start self-center">
                            <div class="flex flex-col">
                                <p class="font-roboto text-lg text-blue-800 font-semibold">
                                    Mentari
                                </p>
                                <p class="font-roboto text-sm text-blue-800 font-semibold">
                                    Investment Propositions Adviser
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 px-6">
                        <hr class="border border-hijau w-full ">
                    </div>

                    <div class="flex items-center px-6 py-4 gap-6">
                        <p class="font-roboto font-bold text-lg text-blue-900">
                            Contact the opportunity lead
                        </p>
                        <div class="flex">
                            <a href="<?php echo site_url('front/get_touch/v2'); ?>">
                                <button class="px-4 py-2 bg-hijau font-roboto text-white text-lg rounded-2xl">
                                    Get in touch
                                </button>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="text-justify mt-10">
            <?php echo $investasi->project_desc; ?>
        </div>


    </div>
    <div class="w-full bg-gray-300 py-12 mt-10">
        <div class="w-4/5 mx-auto">
            <div class="grid md:grid-cols-4 grid-cols-1 gap-6">
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-2">
                        <p class="font-roboto md:text-4xl text-2xl text-blue-800 font-bold">
                            Location :
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="font-roboto md:text-2xl text-2xl text-blue-800 font-bold">
                            <?php echo $investasi->lokasi; ?>
                        </p>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-2">
                        <p class="font-roboto md:text-4xl text-2xl text-blue-800 font-bold">
                            Investment Schema :
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="font-roboto md:text-2xl text-2xl text-blue-800 font-bold">
                            <?php echo $investasi->investment_type; ?>
                        </p>
                    </div>

                </div>
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-2">
                        <p class="font-roboto md:text-4xl text-2xl text-blue-800 font-bold">
                            Sector :
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <!-- <p class="font-roboto md:text-2xl text-2xl text-blue-800 font-bold">
                            <?php echo $investasi->sector->title; ?>
                        </p> -->
                    </div>

                </div>
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-2">
                        <p class="font-roboto md:text-4xl text-2xl text-blue-800 font-bold">
                            Investment Value :
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="font-roboto md:text-2xl text-2xl text-blue-800 font-bold">
                            <?php echo ($investasi->project_value); ?>
                        </p>
                    </div>

                </div>
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-2">
                        <p class="font-roboto md:text-4xl text-2xl text-blue-800 font-bold">
                            IRR :
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="font-roboto md:text-2xl text-2xl text-blue-800 font-bold">
                            <?php echo $investasi->irr; ?>
                        </p>
                    </div>

                </div>
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-2">
                        <p class="font-roboto md:text-4xl text-2xl text-blue-800 font-bold">
                            NPV :
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="font-roboto md:text-2xl text-2xl text-blue-800 font-bold">
                            <?php echo $investasi->npv; ?>
                        </p>
                    </div>

                </div>
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-2">
                        <p class="font-roboto md:text-4xl text-2xl text-blue-800 font-bold">
                            Payback Period :
                        </p>
                        <div class="flex">
                            <hr class="border border-hijau w-10 h-1 bg-hijau">
                            <hr class="border border-kuning w-10 h-1 bg-kuning">
                        </div>
                        <p class="font-roboto md:text-2xl text-2xl text-blue-800 font-bold">
                            <?php echo $investasi->payback_period; ?>
                        </p>
                    </div>

                </div>
            </div>

        </div>


    </div>
</div>
