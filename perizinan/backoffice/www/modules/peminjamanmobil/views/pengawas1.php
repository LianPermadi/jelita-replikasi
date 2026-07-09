<?php
    $i = 1;
    $n_file = '';
    $id = '';
    $n_file = '';
    $n_file_draft = '';
    $tgl_entry = '';
    $page = '';
    $no_surat = '';
    $tgl_surat = '';
	  $id_ess2 = '';
	  $id_sekdis = '';
	  $id_ess3 = '';
	  $id_ess4 = '';
    $id_jfah = '';
    $analis_hukum = '';
	  $id_konseptor = '';
?>
<head>
    <!-- <meta charset="utf-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <!-- <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/css/stylemodal.css"> -->
  <!-- <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/fonts.css" rel="stylesheet">
  <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/materialize_new.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/> -->
  <style>
    /* Gaya umum */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 5px;
    width: 60%;
}

.close {
    float: right;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}
  </style>
</head>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <style>
        /* CSS styles here */
    </style>
</head>
    <?php
// Fetch data from PHP
$mobil = $this->m_mobil->pengawas();

// Modify the data to include 'tanggal_pinjam' and 'tanggal_kembali'
foreach ($mobil as &$row) {
    $data_jadwal = $this->m_mobil->get_data_list_peminjaman_pengawas($row->id);
    $row->tanggal_pinjam = '';
    $row->tanggal_kembali = '';
    foreach ($data_jadwal as $data) {
        $row->tanggal_pinjam = $data->tanggal_pinjam;
        $row->tanggal_kembali = $data->tanggal_kembali;
    }
}

// Encode PHP array as JSON
$mobilJSON = json_encode($mobil);
?>
<body>
    <div id="content">
        <div class="post">
            <div class="title">
                <h2><span style="font-family: Cursive; color: navy;"><b><span id="page_name"></span></b></span></h2>
            </div>

            <div id="alert_success" style="display: none;">
                <br>
                <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center></center></div>
            </div>

            <div id="alert_error" style="display: none;">
                <br>
                <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center></center></div>
            </div>
    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
    
            <div style="margin:10px">
<a href="/jelita/backoffice/peminjamanmobil/pengawas_mobil" class="button-wrc">Beranda</a>
<a href="/jelita/backoffice/peminjamanmobil/history_pengawas" class="button-wrc">History</a>
<br>
            </div>
            <div class="entry">
                <div id="barang">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
                        <thead>
                            <tr>
                                <th width="2%">No</th>
                                <th width="14%">Mobil</th>
                                <th width="14%">Plat</th>
                                <th width="10%">Tahun</th>
                                <th width="10%">Jenis Transmisi</th>
                                <th width="20%">Kondisi</th>
                                <th width="20%">Akan Di Gunakan Dari Tanggal s/d Tanggal</th>
                                <th width="20%">Foto</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_body">
                            <?php 
                            $i = 1;
                            foreach($mobil as $row){ 
                                $gunakan = ''; ?>
                            <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row->nama_mobil; ?></td>
        <td><?php echo $row->plat; ?></td>
        <td><?php echo $row->tahun; ?></td>
        <td><?php echo $row->jenis; ?></td>
        <td>
                <?php if($row->kondisi == '1') {
                    echo '<span style="color:green;">Mobil Dalam Keadaan ready</span>';
                    }elseif($row->kondisi == '2') {
                    echo '<span style="color:blue;">Mobil Team of Team '.$row->tot.'</span>';
                    }else{
                    echo '<span style="color:red;">Mobil Dalam Keadaan not ready</span>';
                    } ?>
        </td>
        <td>
<?php
$gunakan = $this->m_mobil->get_data_list_peminjaman_pengawas2($row->id); 
// var_dump($row->id);
// var_dump($gunakan);
$id_peminjaman = '';
if(!empty($gunakan)){
if($gunakan[0]->mobil == $row->id){
$tanggal_pinjam = $gunakan[0]->tanggal_pinjam;
$tanggal_kembali = $gunakan[0]->tanggal_kembali;

// Membuat objek DateTime untuk tanggal_pinjam
$tanggal_pinjam_obj = new DateTime($tanggal_pinjam);

// Membuat objek DateTime untuk tanggal_kembali
$tanggal_kembali_obj = new DateTime($tanggal_kembali);

$tanggal_pinjam_formatted = $tanggal_pinjam_obj->format('j F Y');
$tanggal_kembali_formatted = $tanggal_kembali_obj->format('j F Y');

// Menggunakan objek DateTime
echo 'Tanggal Pinjam: <span style="color:green;">' . $tanggal_pinjam_formatted . '</span><br>';
echo 'Tanggal Kembali: <span style="color:red;">' . $tanggal_kembali_formatted . '</span><br>';
echo 'Oleh : <span style="color:blue;">' . $gunakan[0]->bagian . '</span><br>';
echo 'Tujuan : <span style="color:blue;">' . $gunakan[0]->tujuan . '</span>';
$id_peminjaman = $gunakan[0]->id;
}
}
?>
        </td>
        <td><img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/<?php echo $row->foto; ?>" width="100px" alt="Gambar Mobil"></td>
        <td>
           <?php 
           if($row->kondisi != 0){
           if($row->pengawas == '0'){
                    if($id_peminjaman == ''){

                    }else{
                        echo '<a href="/jelita/backoffice/peminjamanmobil/keluar/'.$row->id.'/'.$id_peminjaman.'" title="Konfirmasi Mobil sudah Keluar"><img src="https://th.bing.com/th/id/R.56bdbeb85832f9970985c8402e65d8a7?rik=jmMrZBOlf00SRg&riu=http%3a%2f%2fpngimg.com%2fuploads%2fexit%2fexit_PNG30.png&ehk=GdbaGCbJBzhNQqyQ0Xs1nSegBL6jNmmpvFRFhRWIhyw%3d&risl=&pid=ImgRaw&r=0" width="25px" alt="gambar"></a>';
                    }
                }else{ echo '<a href="/jelita/backoffice/peminjamanmobil/infokeberangkatan/'.$row->id_pengawas.'" title="Info Keberangkatan"><img src="https://upload.wikimedia.org/wikipedia/commons/4/43/Minimalist_info_Icon.png" width="25px" alt="gambar"></a>
                <a href="/jelita/backoffice/peminjamanmobil/mobil_kembali/'.$row->id.'/'.$row->id_pengawas.'/'.$id_peminjaman.'" title="Konfirmasi Mobil sudah Kembali"><img src="https://www.pinclipart.com/picdir/big/571-5719987_transparent-refresh-button-png-icon-kembali-clipart.png" width="25px" alt="gambar"></a>';
            }
        }
                ?>
        </td>
        </tr>
        <?php $i++; } ?>
                            <!-- Table rows will be added here using JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script>
//         // Use the PHP data in JavaScript
//         var mobilData = <?php echo $mobilJSON; ?>;
        
//         // Example: Loop through the data and create table rows
//         var tableBody = document.getElementById('table_body');
//         tableBody.innerHTML = '';
        
//         var rowNum = 1; // Nomor urut awal

//         mobilData.forEach(function (rowData) {
//             var row = createTableRow(rowData);
//             tableBody.appendChild(row);
//             rowNum++; // Tambah nomor urut setiap kali membuat baris baru
//         });

//         // Define the 'createTableRow' function to create rows based on your data
// function createTableRow(rowData) {
//     var row = document.createElement('tr');
//     row.innerHTML = '
//         <td>${rowNum}</td>
//         <td>${rowData.nama_mobil}</td>
//         <td>${rowData.plat}</td>
//         <td>${rowData.tahun}</td>
//         <td>${rowData.jenis}</td>
//         <td>
//             ${
//                 rowData.kondisi === '1'
//                     ? '<span style="color:green;">Mobil Dalam Keadaan ready</span>'
//                     : '<span style="color:red;">Mobil Dalam Keadaan not ready</span>'
//             }
//         </td>
//         <td>
//         </td>
//         <td><img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/${rowData.foto}" width="100px" alt="Gambar Mobil"></td>
//         <td>
//             ${
//                 rowData.pengawas === '0'
//                     ? '<a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/keluar/${rowData.id}" title='Konfirmasi Mobil sudah Keluar'><img src="https://th.bing.com/th/id/R.56bdbeb85832f9970985c8402e65d8a7?rik=jmMrZBOlf00SRg&riu=http%3a%2f%2fpngimg.com%2fuploads%2fexit%2fexit_PNG30.png&ehk=GdbaGCbJBzhNQqyQ0Xs1nSegBL6jNmmpvFRFhRWIhyw%3d&risl=&pid=ImgRaw&r=0" width="25px" alt="gambar"></a>'
//                     : '<a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/infokeberangkatan/${rowData.id_pengawas}" title='Info Keberangkatan'><img src="https://upload.wikimedia.org/wikipedia/commons/4/43/Minimalist_info_Icon.png" width="25px" alt="gambar"></a><a href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/mobil_kembali/${rowData.id}/${rowData.id_pengawas}" title='Konfirmasi Mobil sudah Kembali'><img src="https://www.pinclipart.com/picdir/big/571-5719987_transparent-refresh-button-png-icon-kembali-clipart.png" width="25px" alt="gambar"></a>'
//             }
//         </td>
//     ';
//     return row;
// }

// function formatTanggal(dateTimeString) {
//   // Parsing tanggal dan waktu
//   var dateTime = new Date(dateTimeString);

//   // Memeriksa apakah tanggal yang diberikan valid
//   if (isNaN(dateTime.getTime())) {
//     return '<span style="color:red;">Tidak ada aktifitas</span>'; // Tampilkan pesan kesalahan jika tanggal tidak valid
//   }

//   // Daftar bulan dalam bahasa Indonesia
//   var months = [
//     "Januari",
//     "Februari",
//     "Maret",
//     "April",
//     "Mei",
//     "Juni",
//     "Juli",
//     "Agustus",
//     "September",
//     "Oktober",
//     "November",
//     "Desember"
//   ];

//   // Mendapatkan komponen tanggal, bulan, tahun, jam, dan menit
//   var day = dateTime.getDate();
//   var month = months[dateTime.getMonth()];
//   var year = dateTime.getFullYear();
//   var hours = dateTime.getHours();
//   var minutes = dateTime.getMinutes();

//   // Membuat format yang diinginkan dalam bahasa Indonesia
//   var formattedDateTime = '<span style="color:green;">${hours}:${minutes} / ${day} ${month} ${year}</span>';

//   return formattedDateTime;
// }
//     </script>
//     <script>
//       const array1 = [1, 2, 3];
//       const array2 = ['a', 'b', 'c'];

//       array1.forEach(function(item1) {
//           console.log(item1);
//         array2.forEach(function(item2) {
//           console.log(item2);
//         });
//       });
    </script>
<?php
        // <td>
        //   ${formatTanggal(rowData.tanggal_pinjam)} Sampai ${formatTanggal(rowData.tanggal_kembali)}
        // </td>
?>