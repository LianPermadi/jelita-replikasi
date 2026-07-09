<?php
	$connect	= mysqli_connect("localhost", "root", "develop3Rptsp", "db_sicantik_backoffice");
	if(mysqli_connect_error()){
		echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
	}
?>