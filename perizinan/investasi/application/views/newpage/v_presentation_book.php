<div class="hidden md:flex justify-end mt-32 mb-4 w-4/5 mx-auto px-4">
        <ul class="flex gap-10 font-semibold text-base">

            <li class="font-roboto text-blue-800 cursor-pointer">
                <a href="">
                    <?php echo $language_data['menu_presentation_book'] ?>
                </a>
            </li>
            <li class="font-roboto text-blue-800">
                <a href="<?= base_url('/news') ?>">
                    <?php echo $language_data['menu_news'] ?>
                
                </a>
            </li>

        </ul>
    </div>
    <div class="w-full bg-gray-100">
        <div class="w-full h-350">
            <img src="<?= base_url('src/assets/img/banner/' . html_escape($banner->image)) ?>" alt="" class="object-cover h-full w-full bg-center">
        </div>

        <div class="w-4/5 mx-auto">
            <div class="flex flex-col w-3/4 gap-2 mt-12 bg-gray-100">
                <p class="text-4xl md:text-5xl font-bold font-roboto tracking-tighter text-blue-900 bg-gray-100 tracking-wide">
                    Publication
                </p>
                <div class="flex bg-gray-100">
                    <hr class="border border-hijau w-10 h-1 bg-hijau">
                    <hr class="border border-kuning w-10 h-1 bg-kuning">
                </div>
            </div>

            <div class="grid md:grid-cols-4 grid-cols-2 gap-12 py-20 bg-gray-100">
                <?php foreach ($publikasi as $item): ?>
                    <div class="flex flex-col gap-2 bg-white">
                        <div class="w-full h-200">
                            <?php if(empty($item->image)): ?>
                                <img src="<?= base_url('src/assets/img/default-image.png') ?>" alt="Image" class="w-full h-full object-cover">
                            <?php else: ?>
                                <img src="<?= base_url('src/assets/img/pub/thumbnail/' . html_escape($item->image)) ?>" alt="Image" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                        <p class="text-2xl font-roboto text-blue-900 font-semibold px-2">
                            <?= html_escape($item->judul) ?>
                        </p>

                        <div class="flex items-center justify-center mt-5">
                            <a href="<?= base_url('PresentationBook/show/' . html_escape($item->slug)) ?>">
                                <p class="text-lg font-roboto text-blue-800 px-2">
                                    View Details
                                </p>
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

