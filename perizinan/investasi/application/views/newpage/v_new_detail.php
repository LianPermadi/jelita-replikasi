
    <div class="hidden md:flex justify-end mt-32 mb-4 w-4/5 mx-auto px-4">
        <ul class="flex gap-10 font-semibold text-base">
            <li class="font-roboto text-blue-800">
                <a href="<?= base_url('/news') ?>">
                    Kembali
                </a>
            </li>

        </ul>
    </div>
   
    <div class="w-full bg-white md:mt-10 mt-20">
        <div class="w-4/5 mx-auto">

            <div class="flex flex-col gap-4">
                <p class="text-blue-800 md:text-5xl text-3xl font-bold">
                    <?= html_escape($news->judul) ?>
                </p>
                <div class="flex">
                    <hr class="border border-hijau w-20 h-2 bg-hijau">
                    <hr class="border border-kuning w-20 h-2 bg-kuning">
                </div>
            </div>

            <div class="md:grid-cols-3 grid-cols-1 grid mt-10 gap-8">
                <div class="md:col-span-2">
                    <div class="w-full md:h-500 h-300">
                        <img src="<?= base_url('src/assets/img/artikel/' . html_escape($news->image)) ?>" alt="" class="object-cover h-full w-full">
                    </div>
                </div>
                <div></div>
            </div>

            <div class="text-justify md:my-10 my-2">
                <?= $news->konten ?>
            </div>

        </div>
    </div>