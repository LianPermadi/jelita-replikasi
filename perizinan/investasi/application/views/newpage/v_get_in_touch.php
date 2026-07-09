<?php
$bannerImage = (!empty($banner) && isset($banner->image) && $banner->image != '')
    ? base_url('src/assets/img/banner/' . $banner->image)
    : base_url('src/assets/img/banner/default-banner.jpg'); // fallback image
?>
<div class="w-full bg-gray-100">
    <div class="w-full h-350">
        <img src="<?php echo $bannerImage; ?>" alt="Banner"
             class="object-cover h-full w-full bg-center">
    </div>


        <div class="w-4/5 mx-auto">
            <div class="flex flex-col w-3/4 gap-2 mt-12 bg-gray-100">
                <p class="text-4xl md:text-5xl font-bold font-roboto tracking-tighter text-blue-900 bg-gray-100">
                    Get in touch
                </p>
                <div class="flex bg-gray-100">
                    <hr class="border border-hijau w-10 h-1 bg-hijau">
                    <hr class="border border-kuning w-10 h-1 bg-kuning">
                </div>

                <p class="text-lg font-roboto text-justify text-blue-900 mt-10 bg-gray-100">
                    Interested in west java projects? Get in touch. You can also contact us about expanding your business to West Java or contact us about buying goods from West Java.
                </p>
            </div>

            <div class="grid md:grid-cols-2 grid-cols-1 gap-14 items-center py-12" id="section1">

                <div class="flex flex-col">
                    <form action="{{ route('register') }}" method="POST">
                    
                        <div class="flex flex-col gap-8">
                            <div class="">
                                <label for="name" class="font-bold text-gray-700 mb-1 font-roboto">Name:</label>
                                <input type="text" id="name" name="name"
                                    class="w-full border-blue-800 border rounded-lg px-3 py-2 font-roboto" required>
                            </div>
                            <div class="">
                                <label for="name" class="font-bold text-gray-700 mb-1 font-roboto">Email:</label>
                                <input type="text" id="email" name="email"
                                    class="w-full border-blue-800 border rounded-lg px-3 py-2 font-roboto" required>
                            </div>
                            <div class="">
                                <label for="name" class="font-bold text-gray-700 mb-1 font-roboto">Position:</label>
                                <input type="text" id="position" name="position"
                                    class="w-full border-blue-800 border rounded-lg px-3 py-2 font-roboto" required>
                            </div>
                            <div class="">
                                <label for="name" class="font-bold text-gray-700 mb-1 font-roboto">Company:</label>
                                <input type="text" id="company" name="company"
                                    class="w-full border-blue-800 border rounded-lg px-3 py-2 font-roboto" required>
                            </div>
                            <div class="">
                                <label for="name" class="font-bold text-gray-700 mb-1 font-roboto">Country:</label>
                                <select class="w-full border-blue-800 border rounded-lg px-3 py-2 font-roboto" name="country">
                                    <option value="" selected disabled hidden>Choose here</option>
                                    <?php foreach ($countries as $item): ?>
                                        <option value="<?php echo $item->country_code; ?>"><?php echo $item->name; ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                            <div>
                                <button id="submitBtn" class="px-4 py-2 bg-biru text-white custom-font font-semibold"
                                    type="submit">
                                    Submit
                                </button>
                            </div>

                    </form>

                </div>



            </div>
        </div>
    </div>

    </div>