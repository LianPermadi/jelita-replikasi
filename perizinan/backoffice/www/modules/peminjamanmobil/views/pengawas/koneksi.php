<?php
	$connect	=mysqli_connect("localhost", "root", "", "tutorial");
	if(mysqli_connect_error()){
		echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
	}
?>