<h2>Form Pemesanan Mobil</h2>

<form action="<?php echo site_url('peminjamanmobil/book_car'); ?>" method="post">
    <label for="car_id">Pilih Mobil:</label>
    <select name="car_id" id="car_id">
        <?php foreach ($cars as $car) : ?>
            <option value="<?php echo $car->id; ?>"><?php echo $car->nama_mobil; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="user_name">Nama Pemesan:</label>
    <input type="text" name="user_name" id="user_name">

    <label for="booking_date">Tanggal Pemesanan:</label>
    <input type="date" name="booking_date" id="booking_date">

    <button type="submit">Pesan</button>
</form>