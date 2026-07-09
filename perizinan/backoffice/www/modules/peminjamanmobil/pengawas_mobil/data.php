<?php
    include "koneksi.php";
    $sql	=mysqli_query($connect, "SELECT * FROM mobil");
    $data	=array();
    while ($row	= mysqli_fetch_assoc($sql)) {
        $data[]	= $row;
    }
    echo json_encode(array("result" => $data));

    // $date = date('Y-m-d');
    // $tanggal = date('Y-m-d', strtotime($date . ' -1 day'));
    // $tanggalSetelah = date('Y-m-d', strtotime($date . ' +1 month'));
    // $sql = "SELECT *  FROM `peminjaman_mobil` WHERE `tanggal_pinjam` BETWEEN '$tanggal 22:00:00' AND '$tanggalSetelah 23:59:59' AND mobil = $id";
?>