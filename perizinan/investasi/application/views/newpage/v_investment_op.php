<div class="bg-gray-200 w-full mt-4">
    <div class="w-4/5 mx-auto">
        <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
            <div class="col-span-1 md:my-20 mt-20 mb-2 p-4">
                <div class="flex flex-col justify-center gap-4 bg-white p-4">
                    <p class="font-roboto font-bold text-4xl text-blue-800">
                        Investment Opportunities
                    </p>
                    <div class="flex gap-20 items-center">
                        <div class="radio-item">
                            <input type="radio" id="ritema" name="ritem" value="ropt1" checked>
                            <label for="ritema">List</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="ritemb" name="ritem" value="ropt2" data-link="<?php echo base_url('investment-map'); ?>">
                            <label for="ritemb">Map</label>
                        </div>
                    </div>
                    <div class="mt-10">
                        <p class="font-robot text-2xl font-bold text-blue-800">
                            Choose investment type
                        </p>
                    </div>
                    <div class="flex flex-col justify-center">
                        <ul class="text-lg text-blue-800 font-roboto flex flex-col gap-4">
                            <?php 
                            foreach ($sector as $item) { ?>
                                <a href="<?php echo base_url('/investment-op?sector=' . $item->Id); ?>">
                                    <div class="flex items-center justify-between cursor-pointer">
                                        <li><?php echo $item->title; ?></li>
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                    </div>
                                </a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-span-2 my-20 p-4">
                <div class="flex justify-start mt-10">
                    <p class="font-robot text-lg text-blue-700">
                        <?php echo $investasi_total ?> opportunities found
                    </p>
                    
                </div>
                <?php 
                foreach ($investasi as $item) { ?>
                    <div class="grid md:grid-cols-2 grid-cols-1 mt-10 bg-white p-4 gap-4">
                        <div class="h-40 w-full">
                            <img src="<?php echo base_url('src/assets/invest/thumbnail/' . $item['image']); ?>" alt="" class="object-cover h-full w-full">
                        </div>
                        <div class="flex flex-col justify-evenly">
                            <p class="font-bold font-robot text-2xl text-blue-800">
                                <a href="<?php echo base_url('investmentop/show/' . $item['invest_id']); ?>">
                                    <?php echo $item['judul_investasi']; ?>
                                </a>
                            </p>
                            <p class="font-roboto text-blue-800">
                                <?php echo $item['mini_deskripsi']; ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>


                <div class="grid grid-cols-2 mt-10 justify-items-end items-center">
                    <p class="font-roboto text-lg text-blue-800 font-semibold">
                        Page <?php echo $pagination['current_page']; ?> of <?php echo $pagination['last_page']; ?>
                    </p>
                    <div>
                        <?php if (isset($pagination['prev_page_url'])) { ?>
                            <a href="<?php echo $pagination['prev_page_url']; ?>">
                                <button class="px-8 py-2 bg-black text-white font-roboto font-semibold">
                                    Prev
                                </button>
                            </a>
                        <?php } ?>
                        <?php if (isset($pagination['next_page_url'])) { ?>
                            <a href="<?php echo $pagination['next_page_url']; ?>">
                                <button class="px-8 py-2 bg-black text-white font-roboto font-semibold">
                                    Next
                                </button>
                            </a>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[type="radio"]').click(function() {
            if ($(this).is(':checked')) {
                var link = $(this).data('link');
                window.location.href = link;
            }
        });
    });
</script>
