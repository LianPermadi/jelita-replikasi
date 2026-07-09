<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author nirwan
 * Created : 22 Jul 2020
 *
 */

class M_barang extends Model
{
    // Function to update notification settings for a user
    public function updateNotificationSettings($userId, $whatsappEnabled, $emailEnabled) {
        $data = array(
            'whatsapp_enabled' => $whatsappEnabled,
            'email_enabled' => $emailEnabled
        );
        $this->db->where('user_id', $userId);
        $this->db->update('notification_settings', $data);
    }

    // Function to get notification settings for a user
    public function getNotificationSettings($userId) {
        $query = $this->db->get_where('notification_settings', array('user_id' => $userId));
        return $query->row_array();
    }


    public function get_all_recipients() {
        $query = $this->db->get('notification_settings');
        // return $query->result_array();
        return $query->result();
    }

    public function insert_recipient($data) {
try {
    $save = $this->db->insert('notification_settings', $data);

    if ($this->db->affected_rows() > 0) {
        // Insert berhasil
        echo "Insert berhasil.";
    } else {
        // Insert gagal, bisa jadi karena tidak ada baris yang dimasukkan
        echo "Insert gagal.";
    }
} catch (Exception $e) {
    // Tangkap kesalahan yang terjadi dan tampilkan pesan kesalahan
    echo "Kesalahan: " . $e->getMessage();
    $save = false; // Pastikan $save diatur sebagai false jika terjadi kesalahan
}

// var_dump($save);die();
return $save;

    }
    public function update_recipient($data, $id) {
try {
        $this->db->where('user_id', $id);
        $save = $this->db->update('notification_settings', $data);

    if ($this->db->affected_rows() > 0) {
        // Insert berhasil
        echo "update berhasil.";
    } else {
        // Insert gagal, bisa jadi karena tidak ada baris yang dimasukkan
        echo "update gagal.";
    }
} catch (Exception $e) {
    // Tangkap kesalahan yang terjadi dan tampilkan pesan kesalahan
    echo "Kesalahan: " . $e->getMessage();
    $save = false; // Pastikan $save diatur sebagai false jika terjadi kesalahan
}

// var_dump($save);die();
return $save;

    }

    // Function to get notification settings for all users
    public function getAllNotificationSettings() {
        $query = $this->db->get('notification_settings');
        // return $query->result_array();
        return $query->result();
    }

    public function getAllNotificationSettings_ex() {
        // return $query->result_array();
        $sql = "SELECT * FROM notification_settings WHERE whatsapp_enabled LIKE '1'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data()
    {
        $sql = "SELECT * FROM list_barang  
                    ORDER BY list_barang.date DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_katalog_barang()
    {
        $sql = "SELECT * FROM katalog_barang  
                ORDER BY katalog_barang.nama_barang DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_tahun_sekarang($bulan, $tahun)
    {
        $sql = "SELECT 
                    id,nama_barang, satuan, harga, SUM(jumlah_barang) as jumlah, SUM(jumlah_asli) as total 
                FROM barang_log 
                WHERE YEAR(date) = $tahun
                ORDER BY barang_log.nama_barang, barang_log.date DESC";
        $result = $this->db->query($sql)->result();  // Ambil hasil query

        $data = [];
        foreach ($result as $r) {
            // Menghapus semua karakter selain angka dari harga
            $harga = preg_replace("/[^0-9]/", "", $r->harga);  // Menghilangkan karakter non-angka
            
            // Key pengelompokan: gabungan nama_barang, harga, dan satuan
            $key = $r->nama_barang . '-' . $harga . '-' . $r->satuan;

            // Jika key sudah ada, jumlahkan jumlah_barang dan jumlah_asli
            if (isset($data[$key])) {
                $data[$key]['jumlah'] += $r->jumlah;
                $data[$key]['total'] += $r->total;
            } else {
                // Jika key belum ada, buat data baru
                $data[$key] = [
                    'id' => $r->id,
                    'jumlah' => $r->jumlah,
                    'total' => $r->total
                ];
            }
        }

        $data = array_values($data);  // Membuat index ulang jika perlu
        return $data;
    }

    public function get_jumlah_saldo_awal($nama_barang,$harga,$satuan,$tahun){
        $data = '0';
        // $nama_barang = ' Dispenser Tape Cutter TD-103';
        // $tahun = 2025;
        $sql = "SELECT * FROM barang_master WHERE nama_barang LIKE '%$nama_barang%' AND YEAR(timestamp) < $tahun";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        // var_dump($sql);die();
        $jumlah_data = 0;
        if (!empty($data) && is_array($data)) {
            foreach ($data as $r) {

                $items = explode("<br>",$r->nama_barang);

                // Inisialisasi array kosong
                $data = array();

                foreach ($items as $item) {
                    if (trim($item) == "") continue; // Lewati jika kosong

                    // Ambil teks tanpa tag HTML
                    $cleanItem = strip_tags($item);

                    // Pecah berdasarkan pola regex
                    preg_match('/^(.*?) Merk (.*?) Dengan Jumlah <b>(.*?)<\/b>$/', $item, $matches);

                    if (strpos($matches[1], "$nama_barang") !== false) {
                        if (count($matches) == 4) {
                            // Ambil angka dari jumlah
                            preg_match('/(\d+)/', $matches[3], $jumlahMatches);
                            $jumlah = isset($jumlahMatches[1]) ? (int)$jumlahMatches[1] : 0;

                            // Masukkan ke array
                            $data[] = array(
                                "nama" => trim($matches[1]),
                                "merk" => trim($matches[2]),
                                "jumlah" => $jumlah
                            );
                        }
                    }
                }

                // Fungsi untuk menjumlahkan jumlah barang
                $totalJumlah = array_sum(array_column($data, 'jumlah'));
                $jumlah_data = $jumlah_data + $totalJumlah;
                
            }
        }else{
            $jumlah_data = 0;
        }
        return $jumlah_data;
    }

    public function get_pembelian_barang($nama_barang, $harga, $satuan, $tahun) {
        $data = array(); // Default nilai sebagai array kosong

        // Query SQL biasa
        $sql = "SELECT * 
                FROM barang_log 
                WHERE nama_barang = ? 
                AND YEAR(date) = ? 
                AND satuan = ?";

        // Jalankan query dengan parameter binding
        $query = $this->db->query($sql, array($nama_barang, (int)$tahun, $satuan));

        // Periksa apakah ada hasil
        if ($query->num_rows() > 0) {
            $data = $query->result_array(); // Mengembalikan semua hasil dalam bentuk array asosiatif
        }
        return $data;
    }

    public function get_jumlah_pembelian_perbulan($nama_barang, $harga, $satuan, $tahun, $bulan) {
            // Ubah nama barang ke huruf kecil
    // $nama_barang_lower = strtolower($nama_barang);

    // // Query SQL untuk mendapatkan data
    // $sql = "SELECT * 
    //         FROM db_sicantik_backoffice.barang_log 
    //         WHERE LOWER(nama_barang) = ? 
    //         AND YEAR(date) = ? 
    //         AND MONTH(date) = ?";

    // // Jalankan query dengan parameter binding
    // $query = $this->db->query($sql, array($nama_barang_lower, (int)$tahun, $bulan));
    // // $query = $this->db->query($sql, array($nama_barang_lower, 2024, $bulan));

    // // Cek jumlah hasil yang ditemukan
    // if ($query->num_rows() > 0) {
    //     // Tampilkan data untuk debugging
    //     $data = $query->result();
    //     foreach($data as $rr){
    //         $harga_barang_log = $rr->harga;
    //         $number = preg_replace('/[^0-9]/', '', $harga_barang_log);
    //         if($number == $harga){
    //             $harga = $harga_barang_log;
    //             break;
    //         }
    //     }
    // } else {
    //     $harga = $harga;
    // }

        $data = array(); // Default nilai sebagai array kosong
        // Ubah nama_barang menjadi huruf kecil
        $nama_barang_lower = strtolower($nama_barang);

        // Query SQL biasa
        $sql = "SELECT * 
                FROM db_sicantik_backoffice.barang_log 
                WHERE LOWER(nama_barang) = ? 
                AND YEAR(date) = ? 
                AND harga = ?
                AND MONTH(date) = ?";
        // Jalankan query dengan parameter binding
        $query = $this->db->query($sql, array($nama_barang, (int)$tahun, $harga, $bulan));
        // $query = $this->db->query($sql, array($nama_barang, 2024, $harga, $bulan));

        // Periksa apakah ada hasil
        if ($query->num_rows() > 0) {
            $data = $query->result(); // Mengembalikan semua hasil dalam bentuk array asosiatif
        }
        $jumlah_data = 0;
        foreach ($data as $v) {
            $jumlah_data = $jumlah_data + $v->jumlah_barang;
        }
        return $jumlah_data;
    }

    public function get_jumlah_pengeluaran($nama_barang,$harga,$satuan,$tahun){
        $data = '0';
        // $nama_barang = ' Dispenser Tape Cutter TD-103';
        // $tahun = 2025;
        $sql = "SELECT * FROM barang_master WHERE nama_barang LIKE '%$nama_barang%' AND YEAR(timestamp) <= $tahun";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        // var_dump($sql);die();
        $jumlah_data = 0;
        if (!empty($data) && is_array($data)) {
        foreach ($data as $r) {

            $items = explode("<br>",$r->nama_barang);

            // Inisialisasi array kosong
            $data = array();

            foreach ($items as $item) {
                if (trim($item) == "") continue; // Lewati jika kosong

                // Ambil teks tanpa tag HTML
                $cleanItem = strip_tags($item);

                // Pecah berdasarkan pola regex
                preg_match('/^(.*?) Merk (.*?) Dengan Jumlah <b>(.*?)<\/b>$/', $item, $matches);

                if (strpos($matches[1], "$nama_barang") !== false) {
                    if (count($matches) == 4) {
                        // Ambil angka dari jumlah
                        preg_match('/(\d+)/', $matches[3], $jumlahMatches);
                        $jumlah = isset($jumlahMatches[1]) ? (int)$jumlahMatches[1] : 0;

                        // Masukkan ke array
                        $data[] = array(
                            "nama" => trim($matches[1]),
                            "merk" => trim($matches[2]),
                            "jumlah" => $jumlah
                        );
                    }
                }
            }

            // Fungsi untuk menjumlahkan jumlah barang
            $totalJumlah = array_sum(array_column($data, 'jumlah'));
            $jumlah_data = $jumlah_data + $totalJumlah;
            
        }
    }else{
        $jumlah_data = 0;
    }
        return $jumlah_data;
    }

    public function get_jumlah_pengeluaran_perbulan($nama_barang,$harga,$satuan,$tahun,$bulan){
        $data = '0';
        // $nama_barang = ' Dispenser Tape Cutter TD-103';
        // $tahun = 2025;
        // $sql = "SELECT * FROM db_sicantik_backoffice.barang_master WHERE LOWER(nama_barang) LIKE '%$nama_barang%' AND YEAR(timestamp) = $tahun AND MONTH(timestamp) = $bulan";
$sql = "SELECT * FROM db_sicantik_backoffice.barang_master WHERE LOWER(nama_barang) LIKE ? AND YEAR(timestamp) = ? AND MONTH(timestamp) = ?";
$query = $this->db->query($sql, array('%' . strtolower($nama_barang) . '%', $tahun, $bulan));
        if($query){
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        $jumlah_data = 0;
        if (!empty($data) && is_array($data)) {
        foreach ($data as $r) {

            $items = explode("<br>",$r->nama_barang);

            // Inisialisasi array kosong
            $data = array();

            foreach ($items as $item) {
                if (trim($item) == "") continue; // Lewati jika kosong

                // Ambil teks tanpa tag HTML
                $cleanItem = strip_tags($item);

                // Pecah berdasarkan pola regex
                // Eksekusi regex untuk mendapatkan nama, merk, dan jumlah
                preg_match('/^\d+\.\s*(.*?) Merk (.*?) Dengan Jumlah <b>(.*?)<\/b>$/', $item, $matches);

                // Debugging output

                // Pastikan bahwa nama_barang ada dalam nama produk
                if (isset($matches[1]) && strpos(strtolower($matches[1]), strtolower($nama_barang)) !== false) {
                    // Cek jika kita memiliki data yang lengkap
                    if (count($matches) == 4) {
                        // Ambil angka dari jumlah, menggunakan regex lagi jika perlu
                        preg_match('/(\d+)\s*-\s*([a-zA-Z]+)/', $matches[3], $jumlahMatches);

                        // Menentukan jumlah yang ditemukan, jika ada
                        $jumlah = isset($jumlahMatches[1]) ? (int)$jumlahMatches[1] : 0;

                        // Masukkan ke array jika data sudah valid
                        $data[] = array(
                            "nama" => trim($matches[1]),
                            "merk" => trim($matches[2]),
                            "jumlah" => $jumlah
                        );
                    }
                }

                // Output untuk melihat hasilnya
            }

            // Fungsi untuk menjumlahkan jumlah barang
            $totalJumlah = array_sum(array_column($data, 'jumlah'));
            $jumlah_data = $jumlah_data + $totalJumlah;
            
        }
    }else{
        $jumlah_data = 0;
    }
}else{
        $jumlah_data = 0;
}
        return $jumlah_data;
    }

    public function get_jumlah_pengeluaran_tahun_ini($nama_barang,$harga,$satuan,$tahun){
        $data = '0';
        // $nama_barang = ' Dispenser Tape Cutter TD-103';
        // $tahun = 2025;
        $sql = "SELECT * FROM barang_master WHERE nama_barang LIKE '%$nama_barang%' AND YEAR(timestamp) = $tahun";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        // var_dump($sql);die();
        $jumlah_data = 0;
        if (!empty($data) && is_array($data)) {
        foreach ($data as $r) {

            $items = explode("<br>",$r->nama_barang);

            // Inisialisasi array kosong
            $data = array();

            foreach ($items as $item) {
                if (trim($item) == "") continue; // Lewati jika kosong

                // Ambil teks tanpa tag HTML
                $cleanItem = strip_tags($item);

                // Pecah berdasarkan pola regex
                preg_match('/^(.*?) Merk (.*?) Dengan Jumlah <b>(.*?)<\/b>$/', $item, $matches);

                if (strpos($matches[1], "$nama_barang") !== false) {
                    if (count($matches) == 4) {
                        // Ambil angka dari jumlah
                        preg_match('/(\d+)/', $matches[3], $jumlahMatches);
                        $jumlah = isset($jumlahMatches[1]) ? (int)$jumlahMatches[1] : 0;

                        // Masukkan ke array
                        $data[] = array(
                            "nama" => trim($matches[1]),
                            "merk" => trim($matches[2]),
                            "jumlah" => $jumlah
                        );
                    }
                }
            }

            // Fungsi untuk menjumlahkan jumlah barang
            $totalJumlah = array_sum(array_column($data, 'jumlah'));
            $jumlah_data = $jumlah_data + $totalJumlah;
            
        }
    }else{
        $jumlah_data = 0;
    }
        return $jumlah_data;
    }

    public function get_tahun_lalu($nama_barang,$harga,$satuan,$tahun)
    {
        $sql = "SELECT 
                    id,nama_barang, satuan, harga, SUM(jumlah_barang) as jumlah, input, SUM(jumlah_asli) as total 
                FROM barang_log 
                WHERE YEAR(date) = $tahun
                AND nama_barang = '$nama_barang'
                AND satuan = '$satuan'
                ORDER BY barang_log.nama_barang, barang_log.date DESC";
        $result = $this->db->query($sql)->first_row();  // Ambil hasil query

        $data = [];
        $r = $result;
            // Menghapus semua karakter selain angka dari harga
            $harga = preg_replace("/[^0-9]/", "", $r->harga);  // Menghilangkan karakter non-angka
            
            // Key pengelompokan: gabungan nama_barang, harga, dan satuan
            $key = $r->nama_barang . '-' . $harga . '-' . $r->satuan;

            // Jika key sudah ada, jumlahkan jumlah_barang dan jumlah_asli
            if (isset($data[$key])) {
                $data[$key]['jumlah'] += $r->jumlah;
                $data[$key]['total'] += $r->total;
            } else {
                // Jika key belum ada, buat data baru
                $data[$key] = [
                    'id' => $r->id,
                    'jumlah' => $r->jumlah,
                    'total' => $r->total
                ];
            }

        // Ubah $data ke dalam format array yang lebih mudah digunakan jika diperlukan
        $data = array_values($data);  // Membuat index ulang jika perlu
        return $data;
    }

    public function get_data_kategory($bulan, $tahun)
    {
        $sql = "SELECT 
                     barang_log.id, barang_log.log, barang_log.date, barang_log.status, barang_log.nama_barang, barang_log.satuan, barang_log.harga, barang_log.merk, barang_log.jumlah_barang as jumlah, barang_log.input, barang_log.jumlah_asli as total, list_barang.kategori
                FROM barang_log 
                INNER JOIN list_barang ON
                list_barang.nama_barang = barang_log.nama_barang
                ORDER BY list_barang.kategori, list_barang.nama_barang, barang_log.date DESC";
        $result = $this->db->query($sql)->result();  // Ambil hasil query

        $data = [];
        foreach ($result as $r) {
            // Menghapus semua karakter selain angka dari harga
            $harga = preg_replace("/[^0-9]/", "", $r->harga);  // Menghilangkan karakter non-angka
            
            // Key pengelompokan: gabungan nama_barang, harga, dan satuan
            $key = $r->nama_barang . '-' . $harga . '-' . $r->satuan;

            // Jika key sudah ada, jumlahkan jumlah_barang dan jumlah_asli
            if (isset($data[$key])) {
                $data[$key]['jumlah'] += $r->jumlah;
                $data[$key]['total'] += $r->total;
            } else {
                // Jika key belum ada, buat data baru
                $data[$key] = [
                    'id' => $r->id,
                    'log' => $r->log,
                    'date' => $r->date,
                    'status' => $r->status,
                    'nama_barang' => $r->nama_barang,
                    'satuan' => $r->satuan,
                    'harga' => $harga,  // Gunakan harga yang sudah dibersihkan
                    'merk' => $r->merk,
                    'jumlah' => $r->jumlah,
                    'input' => $r->input,
                    'total' => $r->total,
                    'kategori' => $r->kategori
                ];
            }
        }

        // Ubah $data ke dalam format array yang lebih mudah digunakan jika diperlukan
        $data = array_values($data);  // Membuat index ulang jika perlu
        // var_dump($data);die();
        return $data;
    }

    public function jumlah_pembelian($nama, $merk, $hasil_rupiah, $satuan){
        $data = '0';
        $jumlah = $this->db->select('jumlah')
            ->from('list_barang')
            ->where('nama_barang', $nama)
            ->where('merk', $merk)
            ->where('satuan', $satuan)
            ->get()->row();

        if (!empty($jumlah->jumlah)) {
            $data = $jumlah->jumlah;
        }
        return $data;
    }

    public function get_data_laporan($tahun){
        $data = '0';
        $sql = "SELECT * FROM data_$tahun.laporan_permintaan_barang WHERE tahun = '$tahun'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        return $data;
    }

    public function get_data_laporan_one($tahun, $nama_barang, $harga, $satuan){
        $data = '0';
        $jumlah = $this->db->select('id')
            ->from("data_$tahun.laporan_permintaan_barang")
            ->where('nama_barang', $nama_barang)
            ->where('harga_satuan_sa', $harga)
            ->where('satuan', $satuan)
            ->get()->row();

        if (!empty($jumlah->id)) {
            $data = $jumlah->id;
        }
        return $data;
    }

    public function cek_db($id){
                // $tahun = date('Y');
                $dbname = "data_$id"; // Nama database yang ingin dicek

                // Koneksi ke MySQL tanpa database
                $this->load->database();
                $db_check = $this->db->query("SHOW DATABASES LIKE '$dbname'");

                if ($db_check->num_rows() == 0) {
                    // Jika database tidak ada, buat database baru
                    $create_db = "CREATE DATABASE $dbname";
                    if ($this->db->query($create_db)) {
                        return "Database '$dbname' berhasil dibuat.<br>";
                    } else {
                        return "Gagal membuat database '$dbname'.<br>";
                    }
                } else {
                    return "Database '$dbname' sudah ada.<br>";
                }
    }

    public function cek_table($id){
            $dbname = "data_$id"; // Nama database yang ingin dicek

            // Koneksi ke MySQL tanpa database
            $this->load->database();
            
            // Cek apakah database ada
            $db_check = $this->db->query("SHOW DATABASES LIKE '$dbname'");
            
            if ($db_check->num_rows() == 0) {
                // Jika database tidak ada, buat database baru
                $create_db = "CREATE DATABASE $dbname";
                if ($this->db->query($create_db)) {
                    return "Database '$dbname' berhasil dibuat.<br>";
                } else {
                    return "Gagal membuat database '$dbname'.<br>";
                }
            }

            // Pilih database yang sudah ada atau baru dibuat
            $this->db->query("USE $dbname");

            // Cek apakah tabel laporan_permintaan_barang sudah ada
            $table_check = $this->db->query("SHOW TABLES LIKE 'laporan_permintaan_barang'");

            if ($table_check->num_rows() == 0) {
                // Jika tabel tidak ada, buat tabel dengan struktur yang diinginkan
                $create_table = "
                    CREATE TABLE laporan_permintaan_barang (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        nama_barang VARCHAR(254),
                        unit_sa VARCHAR(32),
                        satuan VARCHAR(32),
                        harga_satuan_sa VARCHAR(32),
                        jumlah_sa VARCHAR(32),
                        jan_beli VARCHAR(32),
                        feb_beli VARCHAR(32),
                        mar_beli VARCHAR(32),
                        apr_beli VARCHAR(32),
                        mei_beli VARCHAR(32),
                        jun_beli VARCHAR(32),
                        jul_beli VARCHAR(32),
                        ags_beli VARCHAR(32),
                        sep_beli VARCHAR(32),
                        okt_beli VARCHAR(32),
                        nov_beli VARCHAR(32),
                        des_beli VARCHAR(32),
                        unit_beli VARCHAR(32),
                        harga_satuan_beli VARCHAR(32),
                        jumlah_beli VARCHAR(32),
                        unit_keluar VARCHAR(32),
                        harga_satuan_keluar VARCHAR(32),
                        jumlah_keluar VARCHAR(32),
                        jan_keluar VARCHAR(32),
                        feb_keluar VARCHAR(32),
                        mar_keluar VARCHAR(32),
                        apr_keluar VARCHAR(32),
                        mei_keluar VARCHAR(32),
                        jun_keluar VARCHAR(32),
                        jul_keluar VARCHAR(32),
                        ags_keluar VARCHAR(32),
                        sep_keluar VARCHAR(32),
                        okt_keluar VARCHAR(32),
                        nov_keluar VARCHAR(32),
                        des_keluar VARCHAR(32),
                        unit_sak VARCHAR(32),
                        harga_satuan_sak VARCHAR(32),
                        jumlah_sak VARCHAR(32),
                        tahun VARCHAR(254),
                        kategori VARCHAR(254)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                ";

                if ($this->db->query($create_table)) {
                    return "Tabel 'laporan_permintaan_barang' berhasil dibuat di database '$dbname'.<br>";
                } else {
                    return "Gagal membuat tabel 'laporan_permintaan_barang' di database '$dbname'.<br>";
                }
            } else {
                return "Tabel 'laporan_permintaan_barang' sudah ada di database '$dbname'.<br>";
            }
    }

    public function get_cetak_saldo_awal($tahun,$nama,$satuan){
        $data = '0';
        $clean_data = '0';
        $sql = "SELECT * FROM data_$tahun.laporan_permintaan_barang WHERE tahun = '$tahun' AND nama_barang = '$nama' AND satuan = '$satuan'";
        $query = $this->db->query($sql);
            if($query){
                if ($query->num_rows() > 0) {
                    $data = $query->result();
                    $clean_data = array();

                    if (!empty($data)) {
                        foreach ($data as $row) {
                            $clean_data[] = array(
                                'id' => (int) $row->id,
                                'unit_sa' => (int) preg_replace('/\D/', '', $row->unit_sak),
                                'harga_satuan_sa' => preg_replace('/\D/', '', $row->harga_satuan_sak) ?: 0,
                                'jumlah_sa' => preg_replace('/\D/', '', $row->jumlah_sak) ?: 0
                            );
                        }
                    }
                }
            }else{
                $tahun_sekarang = $tahun+1;
                $sql1 = "SELECT * FROM data_$tahun_sekarang.laporan_permintaan_barang WHERE tahun = '$tahun_sekarang' AND nama_barang = '$nama' AND satuan = '$satuan'";
                $query1= $this->db->query($sql1);
                if ($query1->num_rows() > 0) {
                    $data = $query1->result();
                    $clean_data = array();
                    if (!empty($data)) {
                        foreach ($data as $row) {
                            $clean_data[] = array(
                                'id' => (int) $row->id,
                                'unit_sa' => (int) preg_replace('/\D/', '', $row->unit_sa),
                                'harga_satuan_sa' => preg_replace('/\D/', '', $row->harga_satuan_sa) ?: 0,
                                'jumlah_sa' => preg_replace('/\D/', '', $row->jumlah_sa) ?: 0
                            );
                        }
                    }else{
                            $clean_data[] = array(
                                'id' => 0,
                                'unit_sa' => 0,
                                'harga_satuan_sa' => 0,
                                'jumlah_sa' => 0
                            );
                    }
                }

            }
                // Cek hasilnya
                // print_r($clean_data);die();
        return $clean_data[0];
    }

    public function get_cetak_pembelian($tahun,$nama,$satuan){
        $data = '0';
        $clean_data = '0';
        $sql = "SELECT * FROM data_$tahun.laporan_permintaan_barang WHERE tahun = '$tahun' AND nama_barang = '$nama' AND satuan = '$satuan'";
        $query = $this->db->query($sql);
            if($query){
                if ($query->num_rows() > 0) {
                    $data = $query->result();
                    $clean_data = array();

                    if (!empty($data)) {
                        foreach ($data as $row) {
                            $clean_data[] = array(
                                'id' => (int) $row->id,
                                'unit_beli' => (int) preg_replace('/\D/', '', $row->unit_beli),
                                'harga_satuan_beli' => preg_replace('/\D/', '', $row->harga_satuan_beli) ?: 0,
                                'jumlah_beli' => preg_replace('/\D/', '', $row->jumlah_beli) ?: 0
                            );
                        }
                    }
                }
            }else{
                $tahun_sekarang = $tahun+1;
                $sql1 = "SELECT * FROM data_$tahun_sekarang.laporan_permintaan_barang WHERE tahun = '$tahun_sekarang' AND nama_barang = '$nama' AND satuan = '$satuan'";
                $query1= $this->db->query($sql1);
                if ($query1->num_rows() > 0) {
                    $data = $query1->result();
                    $clean_data = array();
                    if (!empty($data)) {
                        foreach ($data as $row) {
                            $clean_data[] = array(
                                'id' => (int) $row->id,
                                'unit_beli' => (int) preg_replace('/\D/', '', $row->unit_beli),
                                'harga_satuan_beli' => preg_replace('/\D/', '', $row->harga_satuan_beli) ?: 0,
                                'jumlah_beli' => preg_replace('/\D/', '', $row->jumlah_beli) ?: 0
                            );
                        }
                    }else{
                            $clean_data[] = array(
                                'id' => 0,
                                'unit_sa' => 0,
                                'harga_satuan_sa' => 0,
                                'jumlah_sa' => 0
                            );
                    }
                }
            }
        return $clean_data[0];
    }

public function data_cek_one($nama_barang, $harga, $satuan, $tahun){
    $data = '0';

    // Menyusun query SQL biasa
    $sql = "SELECT id, log, date, status, nama_barang, satuan, harga, merk, jumlah_barang as jumlah, input, jumlah_asli as total FROM barang_log 
            WHERE nama_barang = '$nama_barang' AND satuan = '$satuan' AND YEAR(date) = $tahun ORDER BY date DESC";
            // var_dump($sql);die();
    
    // Menjalankan query dengan parameter untuk mencegah SQL injection
    $query = $this->db->query($sql);

    // Mengecek hasil query
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

public function data_cek_lalu($nama_barang, $harga, $satuan, $tahun){
    $data = '0';

    // Menyusun query SQL biasa
    $sql = "SELECT id, log, date, status, nama_barang, satuan, harga, merk, SUM(jumlah_barang) as jumlah, input, SUM(jumlah_asli) as total FROM barang_log 
            WHERE nama_barang = '$nama_barang' AND satuan = '$satuan' AND YEAR(date) <= $tahun";
    
    // Menjalankan query dengan parameter untuk mencegah SQL injection
    $query = $this->db->query($sql);

    // Mengecek hasil query
    if ($query->num_rows() > 0) {
        $data = $query->result();
    }
    return $data;
}

    public function cek_data_notifikasi($user_id){
        $data = '0';
        $jumlah = $this->db->select('user_id')
            ->from('notification_settings')
            ->where('user_id', $user_id)
            ->get()->row();

        if (!empty($jumlah->user_id)) {
            $data = $jumlah->user_id;
        }
        return $data;
    }

    public function get_data_jumlah()
    {
        $sql = "SELECT * FROM list_barang WHERE id = 201";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_validation_double($barang, $merk, $satuan)
    {
        $sql = "SELECT * FROM `list_barang` WHERE nama_barang = '$barang' AND merk = '$merk' AND satuan = '$satuan'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_search($merk)
    {
        $sql = "SELECT * FROM list_barang WHERE kategori LIKE '$merk'
                    ORDER BY list_barang.date DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_search_barang($barang)
    {
        $sql = "SELECT * FROM list_barang WHERE nama_barang LIKE '$barang'
                    ORDER BY list_barang.date DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_pengajuan()
    {
        $sql = "SELECT * FROM barang_list_user  
                    ORDER BY barang_list_user.date DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_user()
    {
        $sql = "SELECT * FROM list_barang  
                    ORDER BY list_barang.date DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }


    public function get_barang()
    {
        $sql = "SELECT * 
                FROM list_barang";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_barang_user($id_user)
    {
        $sql = "SELECT *  FROM `permintaan` WHERE `id_user` = $id_user";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_checkout_per_barang($id) 
    {
        $sql = "SELECT *  FROM `permintaan` WHERE `no_id` = $id";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_barang_id($id)
    {
        $sql = "SELECT * 
                FROM list_barang WHERE id = '$id'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_user()
    {
        $sql = "SELECT * 
                FROM tmpegawai";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_user_dpmptsp()
    {
        $sql = "SELECT * 
                FROM tmpegawai WHERE unitkerja_id LIKE 1";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_pegawai_user($id_user)
    {
        $sql = "SELECT * 
                FROM tmpegawai_user INNER JOIN tmpegawai ON tmpegawai_user.tmpegawai_id = tmpegawai.id WHERE user_id = $id_user LIMIT 1";
        $result = $this->db->query($sql)->first_row();
        // var_dump($result);die();
        return $result;
    }

    public function get_pegawai_user2($user_id)
    {
        // var_dump($user_id);die();
        // $sql = "SELECT * 
        //         FROM tmpegawai INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id WHERE tmpegawai_id = $user_id";
        // $result = $this->db->query($sql)->result();
        // return $result;
        $data = '-';
        $jumlah = $this->db->select('user_id')
            ->from('tmpegawai_user')
            ->where('tmpegawai_id', $user_id)
            ->get()->row();

        if (!empty($jumlah->user_id)) {
            $data = $jumlah->user_id;
        }
        return $data;
    }

    public function get_pegawai_user_n_pegawai($id_user)
    {
        $jumlah = $this->db->select('tmpegawai_id')
            ->from('tmpegawai_user')
            ->where('user_id', $id_user)
            ->get()->row();

        if (!empty($jumlah->tmpegawai_id)) {
            $data = $jumlah->tmpegawai_id;
            return $data;
        }
    }

    public function save_data($id_user, $barang, $jumlah, $satuan, $kategori, $harga, $date, $merk, $simpan, $file)
    {
        $data = array(
            'nama_barang' => $barang,
            'jumlah' => $jumlah,
            'merk' => $merk,
            'satuan' => $satuan,
            'date' => $date,
            'penerima' => $id_user,
            'simpan' => $simpan,
            'foto' => $file,
            'kategori' => $kategori,
            'harga' => $harga
        );
        $save = $this->db->insert('list_barang', $data);
        return $result;
    }

    public function put_barang($barang, $merk, $satuan, $id, $simpan, $harga, $kategori, $file, $jumlah, $barang_log_harga)
    {
        $data = array(
            'nama_barang' => $barang,
            'jumlah' => $jumlah,
            'merk' => $merk,
            'satuan' => $satuan,
            'simpan' => $simpan,
            'foto' => $file,
            'kategori' => $kategori,
            'harga' => $harga
        );
        $this->db->where('id', $id);
        $save = $this->db->update('list_barang', $data);

        $data1 = array(
            'harga' => $harga
        );
        $this->db->where('id', $barang_log_harga);
        $save1 = $this->db->update('barang_log', $data1);
    }

    public function save_log($id_user, $barang, $jumlah, $satuan, $kategori, $harga, $date, $merk, $simpan, $nama_user)
    {
        $data = array(
            'log' => 'Barang masuk',
            'date' => $date,
            'status' => '1',
            'nama_barang' => $barang,
            'jumlah_barang' => $jumlah,
            'merk' => $merk,
            'input' => $nama_user,
            'harga' => $harga,
            'satuan' => $satuan,
            'jumlah_asli' => $jumlah
        );
        $save = $this->db->insert('barang_log', $data);
        return $result;
    }

    public function save_order($id_user, $id, $jumlah, $hasil)
    {
        $data = array(
            'id_user' => $id_user,
            'id_barang' => $id,
            'jumlah_barang' => $jumlah
        );
        // $total = 'SELECT sum(counter) as total FROM counterdb';
        $save = $this->db->insert('permintaan', $data);
        // $data2 = array(
        //     'jumlah_asli' => $keterangan
        // );
        // $this->db->where('id_user', $url);
        // $save2 = $this->db->update('barang_log', $data2);
        $data1 = array(
            'jumlah' => $hasil
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('list_barang', $data1);
        $sql = "SELECT * FROM tmpegawai_user INNER JOIN tmpegawai ON tmpegawai_user.tmpegawai_id = tmpegawai.id WHERE user_id = $id_user";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function save_order_pengolah($id_user, $id, $jumlah, $hasil)
    {
        $data = array(
            'id_user' => $id_user,
            'id_barang' => $id,
            'jumlah_barang' => $jumlah,
            'level_akun' => 1
        );
        // $total = 'SELECT sum(counter) as total FROM counterdb';
        $save = $this->db->insert('permintaan', $data);
        // $data2 = array(
        //     'jumlah_asli' => $keterangan
        // );
        // $this->db->where('id_user', $url);
        // $save2 = $this->db->update('barang_log', $data2);
        $data1 = array(
            'jumlah' => $hasil
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('list_barang', $data1);
        $sql = "SELECT * FROM tmpegawai_user INNER JOIN tmpegawai ON tmpegawai_user.tmpegawai_id = tmpegawai.id WHERE user_id = $id_user";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_checkout()
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM permintaan INNER JOIN list_barang ON list_barang.id = permintaan.id_barang WHERE id_user LIKE '$id_user' AND level_akun LIKE '0'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_checkout_pengolah()
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM permintaan INNER JOIN list_barang ON list_barang.id = permintaan.id_barang WHERE id_user LIKE '$id_user' AND level_akun LIKE '1'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_check($id)
    {
        // $id_user      = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM permintaan INNER JOIN list_barang ON list_barang.id = permintaan.id_barang WHERE id_user LIKE '$id'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_checkout_barang()
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM permintaan";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_permintaan()
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM permintaan WHERE id_user LIKE '$id_user'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_jumlah_awal($id)
    {
        $sql = "SELECT jumlah FROM list_barang WHERE id = $id";
        $jumlah = $this->db->select('jumlah')
            ->from('list_barang')
            ->where('id', $id)
            ->get()->row();

        if (!empty($jumlah->jumlah)) {
            $data = $jumlah->jumlah;
        }
        return $data;
        $result = $this->db->query($sql)->result();
    }

    public function get_hapus_barang($id)
    {
        $this->db->delete('list_barang', array('id' => $id));
    }

    public function hapus_checkout($id, $id_barang, $hasil)
    {
        $data1 = array(
            'jumlah' => $hasil
        );
        $this->db->where('id', $id_barang);
        $save1 = $this->db->update('list_barang', $data1);
        $up = $this->db->delete('permintaan', array('no_id' => $id));
    }

    public function save_checkout($pemberi, $barang, $penerima, $status, $langkah, $data_barang)
    {

        $id_user = $this->session->userdata('id_auth');
        if ($langkah == '0') {
        $data = array(
            'nama_barang' => $barang,
            'pemberi_barang' => $id_user,
            'penerima_barang' => $penerima,
            'data_barang' => $data_barang,
            'status' => $status,
            'date' => date('Y-m-d G:i:s')
        );
        $save = $this->db->insert('barang_master', $data);
            $up = $this->db->delete('permintaan', array('no_id' => $penerima));
        } else {
            $sql = "DELETE FROM `permintaan` WHERE `permintaan`.`id_user` = $penerima AND `permintaan`.`status` = '0' OR `permintaan`.`status` = '6'";
        $result = $this->db->query($sql)->result();
        }
        // var_dump($sql);die();
        return $result;
    }

    public function get_data_master($tgla=null, $tglb=null)
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT *
                FROM `barang_master`
                WHERE `timestamp` BETWEEN '$tgla 00:00:00' AND '$tglb 23:59:50'
                ORDER BY `timestamp` DESC;";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_master2()
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM `barang_master` ORDER BY barang_master.timestamp ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_barang_master($id)
    {
        $sql = "SELECT * FROM `barang_master` WHERE `id` LIKE '$id'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_master_permintaan($id_user, $tgla, $tglb)
    {
        $sql = "SELECT *
                FROM `barang_master`
                WHERE `penerima_barang` LIKE '$id_user'
                AND `timestamp` BETWEEN '$tgla 00:00:00' AND '$tglb 23:59:50'
                ORDER BY `timestamp` DESC;";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_user_master()
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM `barang_list_user` ORDER BY barang_list_user.date DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function permintaan_list($id_user)
    {
        $sql = "SELECT * FROM `barang_list_user` WHERE id_user = $id_user";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_barang_nama_barang($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('nama_barang')
            ->from('list_barang')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->nama_barang)) {
            $data = $pegawai->nama_barang;
        }
        return $data;
    }

    public function get_data_barang_merk_barang($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('merk')
            ->from('list_barang')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->merk)) {
            $data = $pegawai->merk;
        }
        return $data;
    }

    public function get_data_barang_stok_barang($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('jumlah')
            ->from('list_barang')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->jumlah)) {
            $data = $pegawai->jumlah;
        }
        return $data;
    }

    public function get_data_user_n_pegawai($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_pegawai')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
        return $data;
    }

    public function get_data_user_telepon($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('telepon')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->telepon)) {
            $data = $pegawai->telepon;
        }
        return $data;
    }

    public function get_pemberi_barang($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_pegawai')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
        return $data;
    }

    public function get_kategori($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('kategori')
            ->from('kategory_barang')
            ->where('no', $id)
            ->get()->row();

        if (!empty($pegawai->kategori)) {
            $data = $pegawai->kategori;
        }
        return $data;
    }

    public function get_kategori_nama($nama)
    {
        $data = " - ";
        $pegawai = $this->db->select('kategori')
            ->from('list_barang')
            ->where('kategori', $nama)
            ->get()->row();

        if (!empty($pegawai->kategori)) {
            $data = $pegawai->kategori;
        }
        return $data;
    }
    public function get_penerima_barang($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_pegawai')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
        return $data;
    }

    public function get_penerima_nip($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('nip')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->nip)) {
            $data = $pegawai->nip;
        }
        return $data;
    }


    public function get_penerima_jabatans($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_jabatan')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_jabatan)) {
            $data = $pegawai->n_jabatan;
        }
        return $data;
    }

    public function get_log()
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM `barang_log` ORDER BY `barang_log`.`merk` ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_log_detail($namabarang = NULL)
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM `barang_log` WHERE `nama_barang` LIKE '$namabarang' ORDER BY `barang_log`.`date`  ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function find_id_log($barang, $merk){
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM `barang_log` WHERE `nama_barang` LIKE '$barang' AND  `merk` LIKE '$merk'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function find_id_log_harga($barang, $merk){
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM `barang_log` WHERE `nama_barang` LIKE '$barang' AND  `merk` LIKE '$merk' ORDER BY `barang_log`.`date` DESC LIMIT 1";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_barang_log_barang($id_barang = NULL, $id_user = NULL)
    {
        // var_dump($id_user);die();
        $data = " - ";
        $pegawai = $this->db->select('jumlah_barang')
            ->from('permintaan')
            ->where('id_barang', $id_barang)
            ->where('id_user', $id_user)
            ->get()->row();

        if (!empty($pegawai->jumlah_barang)) {
            $data = $pegawai->jumlah_barang;
        }
        return $data;
    }

    // public function get_data_barang_log_barang($id_barang = NULL, $id_user = NULL)
    // {
    //     $sql = "SELECT jumlah_barang  FROM `permintaan` WHERE `id_user` = id_user AND `id_barang` = id_barang LIMIT 1";
    //     $result = $this->db->query($sql)->result();
    //     return $result;
    // }

    public function barang_log()
    {
        $id_user = $this->session->userdata('id_auth');
        $sql = "SELECT * FROM `barang_log` ORDER BY `barang_log`.`date`  ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    // 20 februari 2023

    public function edit_nomor($id, $tableHtml){
    $data = array(
            'data_barang' => $tableHtml
        );
        $this->db->where('id', $id);
        $save = $this->db->update('barang_master', $data);

    }

    public function get_ubah_permintaan($id_user, $jumlah1, $jumlah2, $idpermintaan, $idbarang, $hasil, $akhir, $keterangan, $url)
    {
    $data = array(
            'jumlah' => $akhir
        );
        $this->db->where('id', $idbarang);
        $save = $this->db->update('list_barang', $data);

    $data1 = array(
            'jumlah_barang' => $jumlah2,
            'keterangan' => $keterangan
        );
        $this->db->where('no_id', $idpermintaan);
        $save1 = $this->db->update('permintaan', $data1);

    $data2 = array(
            'keterangan' => $keterangan
        );
        $this->db->where('id_user', $url);
        $save2 = $this->db->update('barang_list_user', $data2);
    }

    public function get_update_barang($id, $hasil, $text, $jumlah2, $barang, $merk, $harga, $penginput, $date, $satuan)
    {
        $data1 = array(
            'jumlah' => $hasil,
            'date' => $date,
            'tambah' => $text,
            'harga' => $harga,
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('list_barang', $data1);

        $data = array(
            'log' => 'Tambah Barang Yang sudah ada',
            'date' => $date,
            'status' => '1',
            'nama_barang' => $barang,
            'jumlah_barang' => $jumlah2,
            'merk' => $merk,
            'input' => $penginput,
            'harga' => $harga,
            'satuan' => $satuan,
            'jumlah_asli' => $jumlah2
        );
        $save = $this->db->insert('barang_log', $data);
        // $sql = "UPDATE `db_sicantik_backoffice`.`list_barang` SET `jumlah` = $hasil, 'date' => '$date', `tambah` = '$text', `harga` = '$harga' WHERE `list_barang`.`id` = $id";
        // $result = $this->db->query($sql)->result();
        // return $result;
    }

    public function save_checkout_barang($pemberi, $barang, $penerima, $status, $data_barang)
    {
        $id_user = $this->session->userdata('id_auth');
        $data = array(
            'nama_barang' => $barang,
            'pemberi_barang' => $id_user,
            'penerima_barang' => $penerima,
            'data_barang' => $data_barang,
            'status' => $status,
            'date' => date('Y-m-d G:i:s')
        );
        $save = $this->db->insert('barang_master', $data);
        $up = $this->db->delete('permintaan', array('id_user' => $id_user));
    }

    public function save_checkout_barang_pengolah($pemberi, $barang, $penerima, $status, $langkah, $data_barang)
    {
        $id_user = $this->session->userdata('id_auth');
        $data = array(
            'nama_barang' => $barang,
            'pemberi_barang' => $id_user,
            'penerima_barang' => $penerima,
            'data_barang' => $data_barang,
            'status' => $status,
            'date' => date('Y-m-d G:i:s')
        );
        $save = $this->db->insert('barang_master', $data);
        // $up = $this->db->delete('permintaan', array('id_user' => $id_user));
        $this->db->where('id_user', $id_user);
        $this->db->where('level_akun', 1);
        $this->db->delete('permintaan');
    }


    public function save_checkout_barang_masuk($jumlah_asli, $id)
    {
        $data1 = array(
            'jumlah_asli' => $jumlah_asli
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('barang_log', $data1);
    }

    public function save_checkout_barang_user($pemberi, $barang, $penerima, $status, $id)
    {
        // var_dump($penerima);die();

        $id_user = $this->session->userdata('id_auth');
        $data = array(
            'nama_barang' => $barang,
            'pemberi_barang' => $id_user,
            'penerima_barang' => $penerima,
            'status' => $status,
            'date' => date('Y-m-d G:i:s')
        );
        $save = $this->db->insert('barang_master', $data);
        $up = $this->db->delete('permintaan', array('id_user' => $penerima));
        $this->db->delete('barang_list_user', array('id' => $id));
    }

    public function save_checkout_barang_user2($pemberi, $barang, $penerima, $status, $id, $id_user, $date, $keterangan, $data_barang, $no)
    {
        $id_user = $this->session->userdata('id_auth');
        $day = date("d", strtotime($date));
        $bulan = date("m", strtotime($date));
        $data = array(
            'no_ba' => $no,
            'tanggal' => $day,
            'bulan' => $bulan,
            'nama_barang' => $barang,
            'data_barang' => $data_barang,
            'pemberi_barang' => $pemberi,
            'penerima_barang' => $penerima,
            'status' => $status,
            'keterangan' => $keterangan,
            'date' => $date
        );
        $save = $this->db->insert('barang_master', $data);
        $up = $this->db->delete('permintaan', array('id_user' => $penerima));
        $this->db->delete('barang_list_user', array('id_user' => $penerima));
    }

    public function post_pengajuan($pemberi, $barang, $penerima, $status, $id_user)
    {
        // $data = array(
        //     'nama_barang' => $barang,
        //     'pemberi_barang' => $pemberi,
        //     'penerima_barang' => $penerima,
        //     'status' => $status,
        //     'date' => date('Y-m-d G:i:s')
        // );
        // $this->db->insert('barang_master', $data);
        $id_user = $this->session->userdata('id_auth');
        $data2 = array(
            'id_barang' => NULL,
            'id_user' => $id_user,
            'status' => 2,
            'date' => date('Y-m-d G:i:s')
        );
        $this->db->insert('barang_list_user', $data2);
        $data1 = array(
            'status' => $status,
            'date_masuk'  => date('Y-m-d G:i:s')
        );
        $this->db->where('id_user', $id_user);
        $save1 = $this->db->update('permintaan', $data1);
        // $up         = $this->db->delete('permintaan', array('id_user' => $id_user));
    }

    public function approved_barang($status, $id, $date, $approve, $kirim)
    {
        if($kirim == '1'){
        $data = array(
            'status' => $status,
            'tanggal_kirim_barang' => $date
        );
        }else{
        $data = array(
            'status' => $status,
            'tanggal_permintaan' => $date
        );
        }
        $this->db->where('no_id', $id);
        $save1 = $this->db->update('permintaan', $data);
    }

    public function terima_barang($approve, $date, $url)
    {
        // $sql = "UPDATE `barang_list_user` SET `status` = '$approve', `tanggal_approve` = '$date' WHERE `barang_list_user`.`id_user` = $url";
        // $result = $this->db->query($sql)->result();
        // return $result;
        $id_user = $this->session->userdata('id_auth');

        if ($approve == '3') {

            $data = array(
                'status' => $approve,
                'pemberi_barang' => $id_user,
                'tanggal_approve' => $date
            );
            $this->db->where('id_user', $url);
            $save1 = $this->db->update('barang_list_user', $data);

        } elseif ($approve == '5') {

            $data = array(
                'status' => $approve,
                'tanggal_kirim' => $date
            );
            $this->db->where('id_user', $url);
            $save1 = $this->db->update('barang_list_user', $data);
            // var_dump($save1);die();

        } else {

            $data = array(
                'status' => $approve,
            );
            $this->db->where('id_user', $url);
            $save1 = $this->db->update('barang_list_user', $data);

        }
    }

    public function diterima_barang($approve, $date, $penerima)
    {
        // var_dump($id);die();
        $id_user = $this->session->userdata('id_auth');
        $data = array(
            'status' => $approve,
            'tanggal_terima' => $date
        );
        $this->db->where('id_user', $id_user);
        $save1 = $this->db->update('barang_list_user', $data);
    }

    public function reject($id){
        $this->db->delete('barang_list_user', array('id_user' => $id));
    }
}