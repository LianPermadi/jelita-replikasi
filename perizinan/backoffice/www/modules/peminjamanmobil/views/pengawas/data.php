<?php
    include "koneksi.php";
    $sql	=mysqli_query($connect, "SELECT * FROM tb_pegawai");
    $result	=array();
    while ($row	=mysqli_fetch_assoc($sql)) {
        $data[]	=$row;
    }
    echo json_encode(array("result" => $data));
?>