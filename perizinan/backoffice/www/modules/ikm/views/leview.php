<?php
$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
}
		header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
       header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
       //header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').doc");
        header("Content-disposition: attachment; filename=IKM Bidang $a $tgla.xls");
		
	?>
<script language="javascript" type="text/javascript">
    function popup_link(site, targetDiv){
        $.ajax({url: site,success: function(response){$(targetDiv).html(response);}, dataType: "html"});
    }

    $(document).ready(function() {
        oTable = $('#reportgrid').dataTable({
                "bJQueryUI": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers"
        });

    } );
	</script>

<html>
<head>
<title></title>
</head>
<body>
    <div id="content">
    <div class="post">
        <div class="title" align="center">
		    <div>
			<?php 
			echo br();
			
			 $img_cetak = array(
                          'src' => base_url().'assets/images/icon/logo Jawa_Barat.png');
              echo img($img_cetak);
			?>
			
			<font size="12px"><b>
			<?php
			
			echo 'BADAN PELAYANAN PERIZINAN TERPADU PROVINSI TASIKMALAYA';
			echo br();
			?>
			</b>
			</div>
			<div>
			<?php
			echo 'Jalan Phh Mustafa Nomor 22 - Telp. (022)7217744 Fax (022)7217755';
			echo br();
			echo 'TASIKMALAYA - TASIKMALAYA';
			?>
			</b></td></font>
			</div><div>
			<?php 
			
			echo '=======================================================================';
			echo br();
			?>
			<div><font size="12px">
      
        </div>
            <font  size="12px" color="#1A1A1A"><b><?php echo $page_name; ?></b>
			<?php
		
		$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
		
		
		
		<?php
		}
		?>
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center"><b><font  size="12px" color="#1A1A1A"><center>
             <?php
			 echo br();
            echo 'Tahun '. $tgla;
			echo ' Bidang '. $a;
             echo br(2);
			?>
          </legend></b>
 
	
	
	
    <table cellpadding="1" cellspacing="0" border="1" class="display" id="reportgridx">
        <thead><tr class="title">
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>No</b></font></th>
           <!--<th rowspan="2"><font  size="1" color="#1A1A1A"><b>Kode</b></font></th>-->
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Unsur Pelayanan</b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b><?php echo 'Tahun '.$tgla;  echo ' Semester 1'; echo br(); ?></b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b><?php echo 'Tahun '.$tgla;  echo ' Semester 2'; echo br(); ?></b></font></th>
          
       
   
    </tr>
	<tr>
	<th rowspan="1"><font  size="1" color="#1A1A1A"><b>Nilai Rata Rata</b></font></th>
	<th rowspan="1"><font  size="1" color="#1A1A1A"><b>Kinerja</b></font></th>
	<th rowspan="1"><font  size="1" color="#1A1A1A"><b>Nilai Rata Rata</b></font></th>
	<th rowspan="1"><font  size="1" color="#1A1A1A"><b>kinerja</b></font></th>
	</tr>
	</thead>
<!---------------------------------------------------------------------------------------------------.-->
               
			   <?php
			   //$bidangizin=$this->input->post('id');
                   
					//$i = 1;
					
					//$i++;
					$s1 = 0;
					$s2 = 0;
					$s3 = 0;
					$s4 = 0;
					$s5 = 0;
					$s6 = 0;
					$s7 = 0;
					$s8 = 0;
					$s9 = 0;
					$s10 = 0;
					$s11 = 0;
					$s12 = 0;
					$s13 = 0;
					$s14 = 0;
					
					$ss1 = 0;
					$ss2 = 0;
					$ss3 = 0;
					$ss4 = 0;
					$ss5 = 0;
					$ss6 = 0;
					$ss7 = 0;
					$ss8 = 0;
					$ss9 = 0;
					$ss10 = 0;
					$ss11 = 0;
					$ss12 = 0;
					$ss13 = 0;
					$ss14 = 0;
					
                    $query_data = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=1 and a.tahun=$tgla";
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
					$s1 = $data['u1'];
					$s2 = $data['u2'];
					$s3 = $data['u3'];
					$s4 = $data['u4'];
					$s5 = $data['u5'];
					$s6 = $data['u6'];
					$s7 = $data['u7'];
					$s8 = $data['u8'];
					$s9 = $data['u9'];
					$s10 = $data['u10'];
					$s11 = $data['u11'];
					$s12 = $data['u12'];
					$s13 = $data['u13'];
					$s14 = $data['u14'];
					
		 }
		 
		 $query_data2 = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=2 and a.tahun=$tgla";
                    $results2 = mysql_query($query_data2);
                    while ($data2 = mysql_fetch_assoc(@$results2)){
					
					$ss1 = $data2['u1'];
					$ss2 = $data2['u2'];
					$ss3 = $data2['u3'];
					$ss4 = $data2['u4'];
					$ss5 = $data2['u5'];
					$ss6 = $data2['u6'];
					$ss7 = $data2['u7'];
					$ss8 = $data2['u8'];
					$ss9 = $data2['u9'];
					$ss10 = $data2['u10'];
					$ss11 = $data2['u11'];
					$ss12 = $data2['u12'];
					$ss13 = $data2['u13'];
					$ss14 = $data2['u14'];
					
		 }
		 ?>
		 <tr>
                       <!-- <td align="center"><?php echo '1' ; ?></td>-->
                        <td align="center"><?php echo 'U1'; ?></td>
                         <td align="left"><?php echo 'PROSEDUR PELAYANAN'; ?></td>
                        <td align="center"><?php echo $s1; ?></td>
                        <td align="center">
						<?php 
						if($s1 > 0 and $s1<=1.75){
						$kinerja1= 'TIDAK BAIK';
						}else if ($s1 >=1.76 and $s1 <=2.50) {
						$kinerja1= 'KURANG BAIK';
						}else if ($s1 >=2.51 and $s1 <=3.25) {
						$kinerja1= 'BAIK';
						}else if ($s1 >=3.26) {
						$kinerja1= 'SANGAT BAIK';
						}else if($s1 == 0){
						$kinerja1=' - ';
						}
						echo $kinerja1;
						?>
						</td>
						
						<td align="center"><?php echo $ss1; ?></td>
					<td align="center">
						<?php 
						if($ss1 > 0 and $ss1<=1.75){
						$k1= 'TIDAK BAIK';
						}else if ($ss1 >=1.76 and $ss1 <=2.50) {
						$k1= 'KURANG BAIK';
						}else if ($ss1 >=2.51 and $ss1 <=3.25) {
						$k1= 'BAIK';
						}else if ($ss1 >=3.26) {
						$k1= 'SANGAT BAIK';
						}else if($ss1 == 0){
						$k1=' - ';
						}
						echo $k1;
						?>
						</td>
                    </tr>
					 <tr>
                        <!--<td align="center"><?php echo '2'; ?></td>-->
                        <td align="center"><?php echo 'U2'; ?></td>
                         <td align="left"><?php echo 'PERSYARATAN PELAYANAN'; ?></td>
                        <td align="center"><?php echo $s2; ?></td>
						<td align="center">
						<?php 
						if($s2 > 0 and $s2<=1.75){
						$kinerja2= 'TIDAK BAIK';
						}else if ($s2 >=1.76 and $s2 <=2.50) {
						$kinerja2= 'KURANG BAIK';
						}else if ($s2 >=2.51 and $s2 <=3.25) {
						$kinerja2= 'BAIK';
						}else if ($s2 >=3.26) {
						$kinerja2= 'SANGAT BAIK';
						}else if($s2 == 0){
						$kinerja2=' - ';
						}
						echo $kinerja2;
						?>
						</td>
					<td align="center"><?php echo $ss2; ?></td>
					<td align="center">
						<?php 
						if($ss2 > 0 and $ss2<=1.75){
						$k2= 'TIDAK BAIK';
						}else if ($ss2 >=1.76 and $ss2 <=2.50) {
						$k2= 'KURANG BAIK';
						}else if ($ss2 >=2.51 and $ss2 <=3.25) {
						$k2= 'BAIK';
						}else if ($ss2 >=3.26) {
						$k2= 'SANGAT BAIK';
						}else if($ss2 == 0){
						$k2=' - ';
						}
						echo $k2;
						?>
						</td>
                    </tr>
					 <tr>
                        <!--<td align="center"><?php echo '3'; ?></td>-->
                        <td align="center"><?php echo 'U3'; ?></td>
                         <td align="left"><?php echo 'KEJELASAN PETUGAS PELAYANAN'; ?></td>
                      
						
                        <td align="center"><?php echo $s3;?></td>
						<td align="center">
						<?php 
						if($s3 > 0 and $s3<=1.75){
						$kinerja3= 'TIDAK BAIK';
						}else if ($s3 >=1.76 and $s3 <=2.50) {
						$kinerja3= 'KURANG BAIK';
						}else if ($s3 >=2.51 and $s3 <=3.25) {
						$kinerja3= 'BAIK';
						}else if ($s3 >=3.26) {
						$kinerja3= 'SANGAT BAIK';
						}else if($s3 == 0){
						$kinerja3=' - ';
						}
						echo $kinerja3;
						?>
						</td>
					<td align="center"><?php echo $ss3;?></td>
					<td align="center">
						<?php 
						if($ss3 > 0 and $ss3<=1.75){
						$k3= 'TIDAK BAIK';
						}else if ($ss3 >=1.76 and $ss3 <=2.50) {
						$k3= 'KURANG BAIK';
						}else if ($ss3 >=2.51 and $ss3 <=3.25) {
						$k3= 'BAIK';
						}else if ($ss3 >=3.26) {
						$k3= 'SANGAT BAIK';
						}else if($ss3 == 0){
						$k3=' - ';
						}
						echo $k3;
						?>
						</td>
                    </tr>
					 <tr>
                       <!-- <td align="center"><?php echo '4'; ?></td>-->
                        <td align="center"><?php echo 'U4'; ?></td>
                         <td align="left"><?php echo 'KEDISIPLINAN PETUGAS PELAYANAN'; ?></td>
                      
						
                        <td align="center"><?php echo $s4; ?></td>
						<td align="center">
						<?php 
						if($s4 > 0 and $s4<=1.75){
						$kinerja4= 'TIDAK BAIK';
						}else if ($s4 >=1.76 and $s4 <=2.50) {
						$kinerja4= 'KURANG BAIK';
						}else if ($s4 >=2.51 and $s4 <=3.25) {
						$kinerja4= 'BAIK';
						}else if ($s4 >=3.26) {
						$kinerja4= 'SANGAT BAIK';
						}else if($s4 == 0){
						$kinerja4=' - ';
						}
						echo $kinerja4;
						?>
						</td>
					<td align="center"><?php echo $ss4;?></td>
					<td align="center">
						<?php 
						if($ss4 > 0 and $ss4<=1.75){
						$k4= 'TIDAK BAIK';
						}else if ($ss4 >=1.76 and $ss4 <=2.50) {
						$k4= 'KURANG BAIK';
						}else if ($ss4 >=2.51 and $ss4 <=3.25) {
						$k4= 'BAIK';
						}else if ($ss4 >=3.26) {
						$k4= 'SANGAT BAIK';
						}else if($ss4 == 0){
						$k4=' - ';
						}
						echo $k4;
						?>
						</td>
                    </tr>
					 <tr>
                        <!--<td align="center"><?php echo '5'; ?></td>-->
                        <td align="center"><?php echo 'U5'; ?></td>
                         <td align="left"><?php echo 'TANGGUNG JAWAB PELAYANAN'; ?></td>
                       
						
                        <td align="center"><?php echo $s5; ?></td>
						<td align="center">
						<?php 
						if($s5 > 0 and $s5<=1.75){
						$kinerja5= 'TIDAK BAIK';
						}else if ($s5 >=1.76 and $s5 <=2.50) {
						$kinerja5= 'KURANG BAIK';
						}else if ($s5 >=2.51 and $s5 <=3.25) {
						$kinerja5= 'BAIK';
						}else if ($s5 >=3.26) {
						$kinerja5= 'SANGAT BAIK';
						}else if($s5 == 0){
						$kinerja5=' - ';
						}
						echo $kinerja5;
						?>
						</td>
					<td align="center"><?php echo $ss5;?></td>
					<td align="center">
						<?php 
						if($ss5 > 0 and $ss5<=1.75){
						$k5= 'TIDAK BAIK';
						}else if ($ss5 >=1.76 and $ss5 <=2.50) {
						$k5= 'KURANG BAIK';
						}else if ($ss5 >=2.51 and $ss5 <=3.25) {
						$k5= 'BAIK';
						}else if ($ss5 >=3.26) {
						$k5= 'SANGAT BAIK';
						}else if($ss5 == 0){
						$k5=' - ';
						}
						echo $k5;
						?>
						</td>
                    </tr>
					 <tr>
                        <!--<td align="center"><?php echo '6'; ?></td>-->
                        <td align="center"><?php echo 'U6'; ?></td>
                         <td align="left"><?php echo 'KEMAMPUAN PETUGAS PELAYANAN'; ?></td>
                        
						
                        <td align="center"><?php echo $s6; ?></td>
						<td align="center">
						<?php 
						if($s6 > 0 and $s6<=1.75){
						$kinerja6= 'TIDAK BAIK';
						}else if ($s6 >=1.76 and $s6 <=2.50) {
						$kinerja6= 'KURANG BAIK';
						}else if ($s6 >=2.51 and $s6 <=3.25) {
						$kinerja6= 'BAIK';
						}else if ($s6 >=3.26) {
						$kinerja6= 'SANGAT BAIK';
						}else if($s6 == 0){
						$kinerja6=' - ';
						}
						echo $kinerja6;
						?>
						</td>
					<td align="center"><?php echo $ss6;?></td>
					<td align="center">
						<?php 
						if($ss6 > 0 and $ss6<=1.75){
						$k6= 'TIDAK BAIK';
						}else if ($ss6 >=1.76 and $ss6 <=2.50) {
						$k6= 'KURANG BAIK';
						}else if ($ss6 >=2.51 and $ss6 <=3.25) {
						$k6= 'BAIK';
						}else if ($ss6 >=3.26) {
						$k6= 'SANGAT BAIK';
						}else if($ss6 == 0){
						$k6=' - ';
						}
						echo $k6;
						?>
						</td>
                    </tr>
					 <tr>
                        <!--<td align="center"><?php echo '7'; ?></td>-->
                        <td align="center"><?php echo 'U7'; ?></td>
                         <td align="left"><?php echo 'KECEPATAN PELAYANAN'; ?></td>
                        <td align="center"><?php echo $s7; ?></td>
						<td align="center">
						<?php 
						if($s7 > 0 and $s7<=1.75){
						$kinerja7= 'TIDAK BAIK';
						}else if ($s7 >=1.76 and $s7 <=2.50) {
						$kinerja7= 'KURANG BAIK';
						}else if ($s7 >=2.51 and $s7 <=3.25) {
						$kinerja7= 'BAIK';
						}else if ($s7 >=3.26) {
						$kinerja7= 'SANGAT BAIK';
						}else if($s7 == 0){
						$kinerja7=' - ';
						}
						echo $kinerja7;
						?>
						</td>
                       <td align="center"><?php echo $ss7;?></td>
					   <td align="center">
						<?php 
						if($ss7 > 0 and $ss7<=1.75){
						$k7= 'TIDAK BAIK';
						}else if ($ss7 >=1.76 and $ss7 <=2.50) {
						$k7= 'KURANG BAIK';
						}else if ($ss7 >=2.51 and $ss7 <=3.25) {
						$k7= 'BAIK';
						}else if ($ss7 >=3.26) {
						$k7= 'SANGAT BAIK';
						}else if($ss7 == 0){
						$k7=' - ';
						}
						echo $k7;
						?>
						</td>
					
                    </tr>
					 <tr>
                       <!-- <td align="center"><?php echo '8'; ?></td>-->
                        <td align="center"><?php echo 'U8'; ?></td>
                         <td align="left"><?php echo 'KEADILAN MENDAPAT PELAYANAN'; ?></td>
                        <td align="center"><?php echo $s8; ?></td>
						<td align="center">
						<?php 
						if($s8 > 0 and $s8<=1.75){
						$kinerja8= 'TIDAK BAIK';
						}else if ($s8 >=1.76 and $s8 <=2.50) {
						$kinerja8= 'KURANG BAIK';
						}else if ($s8 >=2.51 and $s8 <=3.25) {
						$kinerja8= 'BAIK';
						}else if ($s8 >=3.26) {
						$kinerja8= 'SANGAT BAIK';
						}else if($s8 == 0){
						$kinerja8=' - ';
						}
						echo $kinerja8;
						?>
						</td>
						<td align="center"><?php echo $ss8;?></td>
					<td align="center">
						<?php 
						if($ss8 > 0 and $ss8<=1.75){
						$k8= 'TIDAK BAIK';
						}else if ($ss8 >=1.76 and $ss8 <=2.50) {
						$k8= 'KURANG BAIK';
						}else if ($ss8 >=2.51 and $ss8 <=3.25) {
						$k8= 'BAIK';
						}else if ($ss8 >=3.26) {
						$k8= 'SANGAT BAIK';
						}else if($ss8 == 0){
						$k8=' - ';
						}
						echo $k8;
						?>
						</td>
                    </tr>
					 <tr>
                       <!-- <td align="center"><?php echo '9'; ?></td>-->
                        <td align="center"><?php echo 'U9'; ?></td>
                         <td align="left"><?php echo 'KESOPANAN DAN KERAMAHAN PETUGAS'; ?></td>
                        <td align="center"><?php echo $s9; ?></td>
						<td align="center">
						<?php 
						if($s9 > 0 and $s9<=1.75){
						$kinerja9= 'TIDAK BAIK';
						}else if ($s9 >=1.76 and $s9 <=2.50) {
						$kinerja9= 'KURANG BAIK';
						}else if ($s9 >=2.51 and $s9 <=3.25) {
						$kinerja9= 'BAIK';
						}else if ($s9 >=3.26) {
						$kinerja9= 'SANGAT BAIK';
						}else if($s9 == 0){
						$kinerja9=' - ';
						}
						echo $kinerja9;
						?>
						</td>
						<td align="center"><?php echo $ss9;?></td>
						<td align="center">
						<?php 
						if($ss9 > 0 and $ss9<=1.75){
						$k9= 'TIDAK BAIK';
						}else if ($ss9 >=1.76 and $ss9 <=2.50) {
						$k9= 'KURANG BAIK';
						}else if ($ss9 >=2.51 and $ss9 <=3.25) {
						$k9= 'BAIK';
						}else if ($ss9 >=3.26) {
						$k9= 'SANGAT BAIK';
						}else if($ss9 == 0){
						$k9=' - ';
						}
						echo $k9;
						?>
						</td>
                    </tr>
					
					 <tr>
                        <!--<td align="center"><?php echo '10'; ?></td>-->
                        <td align="center"><?php echo 'U10'; ?></td>
                        <td align="left"><?php echo 'KEWAJARAN BIAYA PELAYANAN'; ?></td>
                        <td align="center"><?php echo $s10; ?></td>
						<td align="center">
						<?php 
						if($s10 > 0 and $s10<=1.75){
						$kinerja10= 'TIDAK BAIK';
						}else if ($s10 >=1.76 and $s10 <=2.50) {
						$kinerja10= 'KURANG BAIK';
						}else if ($s10 >=2.51 and $s10 <=3.25) {
						$kinerja10= 'BAIK';
						}else if ($s10 >=3.26) {
						$kinerja10= 'SANGAT BAIK';
						}else if($s10 == 0){
						$kinerja10=' - ';
						}
						echo $kinerja10;
						?>
						</td>
						<td align="center"><?php echo $ss10;?></td>
						<td align="center">
						<?php 
						if($ss10 > 0 and $ss10<=1.75){
						$k10= 'TIDAK BAIK';
						}else if ($ss10 >=1.76 and $ss10 <=2.50) {
						$k10= 'KURANG BAIK';
						}else if ($ss10 >=2.51 and $ss10 <=3.25) {
						$k10= 'BAIK';
						}else if ($ss10 >=3.26) {
						$k10= 'SANGAT BAIK';
						}else if($ss10 == 0){
						$k10=' - ';
						}
						echo $k10;
						?>
						</td>
                    </tr>
					 <tr>
                        <!--<td align="center"><?php echo '11'; ?></td>-->
                        <td align="center"><?php echo 'U11'; ?></td>
                         <td align="left"><?php echo 'KEPASTIAN BIAYA PELAYANAN'; ?></td>
                        <td align="center"><?php echo $s11; ?></td>
						<td align="center">
						<?php 
						if($s11 > 0 and $s11<=1.75){
						$kinerja11= 'TIDAK BAIK';
						}else if ($s11 >=1.76 and $s11 <=2.50) {
						$kinerja11= 'KURANG BAIK';
						}else if ($s11 >=2.51 and $s11 <=3.25) {
						$kinerja11= 'BAIK';
						}else if ($s11 >=3.26) {
						$kinerja11= 'SANGAT BAIK';
						}else if($s11 == 0){
						$kinerja11=' - ';
						}
						echo $kinerja11;
						?>
						</td>
						<td align="center"><?php echo $ss11;?></td>
						<td align="center">
						<?php 
						if($ss11 > 0 and $ss11<=1.75){
						$k11= 'TIDAK BAIK';
						}else if ($ss11 >=1.76 and $ss11 <=2.50) {
						$k11= 'KURANG BAIK';
						}else if ($ss11 >=2.51 and $ss11 <=3.25) {
						$k11= 'BAIK';
						}else if ($ss11 >=3.26) {
						$k11= 'SANGAT BAIK';
						}else if($ss11 == 0){
						$k11=' - ';
						}
						echo $k11;
						?>
						</td>
                    </tr>
					 <tr>
                       <!-- <td align="center"><?php echo '12'; ?></td>-->
                        <td align="center"><?php echo 'U12'; ?></td>
                         <td align="left"><?php echo 'KEPASTIAN JADWAL PELAYANAN'; ?></td>
                        <td align="center"><?php echo $s12; ?></td>
						<td align="center">
						<?php 
						if($s12 > 0 and $s12<=1.75){
						$kinerja12= 'TIDAK BAIK';
						}else if ($s12 >=1.76 and $s12 <=2.50) {
						$kinerja12= 'KURANG BAIK';
						}else if ($s12 >=2.51 and $s12 <=3.25) {
						$kinerja12= 'BAIK';
						}else if ($s12 >=3.26) {
						$kinerja12= 'SANGAT BAIK';
						}else if($s12 == 0){
						$kinerja12=' - ';
						}
						echo $kinerja12;
						?>
						</td>
						<td align="center"><?php echo $ss12;?></td>
						<td align="center">
						<?php 
						if($ss12 > 0 and $ss12<=1.75){
						$k12= 'TIDAK BAIK';
						}else if ($ss12 >=1.76 and $ss12 <=2.50) {
						$k12= 'KURANG BAIK';
						}else if ($ss12 >=2.51 and $ss12 <=3.25) {
						$k12= 'BAIK';
						}else if ($ss12 >=3.26) {
						$k12= 'SANGAT BAIK';
						}else if($ss12 == 0){
						$k12=' - ';
						}
						echo $k12;
						?>
						</td>
                    </tr>
					 <tr>
                        <!--<td align="center"><?php echo '13'; ?></td>-->
                        <td align="center"><?php echo 'U13'; ?></td>
                         <td align="left"><?php echo 'KENYAMANAN LINGKUNGAN'; ?></td>
                        <td align="center"><?php echo $s13; ?></td>
						<td align="center">
						<?php 
						if($s13 > 0 and $s13<=1.75){
						$kinerja13= 'TIDAK BAIK';
						}else if ($s13 >=1.76 and $s13 <=2.50) {
						$kinerja13= 'KURANG BAIK';
						}else if ($s13 >=2.51 and $s13 <=3.25) {
						$kinerja13= 'BAIK';
						}else if ($s13 >=3.26) {
						$kinerja13= 'SANGAT BAIK';
						}else if($s13 == 0){
						$kinerja13=' - ';
						}
						echo $kinerja13;
						?>
						</td>
						<td align="center"><?php echo $ss13;?></td>
						<td align="center">
						<?php 
						if($ss13 > 0 and $ss13<=1.75){
						$k13= 'TIDAK BAIK';
						}else if ($ss13 >=1.76 and $ss13 <=2.50) {
						$k13= 'KURANG BAIK';
						}else if ($ss13 >=2.51 and $ss13 <=3.25) {
						$k13= 'BAIK';
						}else if ($ss13 >=3.26) {
						$k13= 'SANGAT BAIK';
						}else if($ss13 == 0){
						$k13=' - ';
						}
						echo $k13;
						?>
						</td>
                    </tr>
					 <tr>
                       <!-- <td align="center"><?php echo '14'; ?></td>-->
                        <td align="center"><?php echo 'U14'; ?></td>
                        <td align="left"><?php echo 'KEAMANAN PELAYANAN'; ?></td>
                        <td align="center"><?php echo $s14; ?></td>
						<td align="center">
						<?php 
						if($s14 > 0 and $s14<=1.75){
						$kinerja14= 'TIDAK BAIK';
						}else if ($s14 >=1.76 and $s14 <=2.50) {
						$kinerja14= 'KURANG BAIK';
						}else if ($s14 >=2.51 and $s14 <=3.25) {
						$kinerja14= 'BAIK';
						}else if ($s14 >=3.26) {
						$kinerja14= 'SANGAT BAIK';
						}else if($s14 == 0){
						$kinerja14=' - ';
						}
						echo $kinerja14;
						?>
						</td>
						<td align="center"><?php echo $ss14;?></td>
						<td align="center">
						<?php 
						if($ss14 > 0 and $ss14<=1.75){
						$k14= 'TIDAK BAIK';
						}else if ($ss14 >=1.76 and $ss14 <=2.50) {
						$k14= 'KURANG BAIK';
						}else if ($ss14 >=2.51 and $ss14 <=3.25) {
						$k14= 'BAIK';
						}else if ($ss14 >=3.26) {
						$k14= 'SANGAT BAIK';
						}else if($ss14 == 0){
						$k14=' - ';
						}
						echo $k14;
						?>
						</td>
                    </tr>
					<tr>
                        <!--<td align="center"><?php echo ''; ?></td>-->
                        <td align="center"><?php echo ''; ?></td>
                        <td align="left"><b><?php echo 'JUMALAH RATA - RATA TERIMBANG'; ?></b></td>
                        <td align="center"><b></td>
						<td align="center"><b><?php 
						$ratanilais1= ($s1+$s2+$s3+$s4+$s5+$s6+$s7+$s8+$s9+$s10+$s11+$s12+$s13+$s14)/14;
						echo substr($ratanilais1,0,4);  ?></b></td>
						<td align="center"><b></td>
						<td align="center"><b>
						<?php 
					
						$ratanilais2= ($ss1+$ss2+$ss3+$ss4+$ss5+$ss6+$ss7+$ss8+$ss9+$ss10+$ss11+$ss12+$ss13+$ss14)/14;
						echo substr($ratanilais2,0,4); 
						?>
						</b></td>
                    </tr>
					<tr>
                        <!--<td align="center"><?php echo ''; ?></td>-->
                        <td align="center"><?php echo ''; ?></td>
                        <td align="left"><b><?php echo 'JUMLAH IKM'; ?></b></td>
<td align="center"><b></td>                       
					   <td align="center"><b><?php 
						//$nilais1= ($s1+$s2+$s3+$s4+$s5+$s6+$s7+$s8+$s9+$s10+$s11+$s12+$s13+$s14);
						$nilais1=$ratanilais1*25;
						echo substr($nilais1,0,5);  ?></b></td>
						<td align="center"><b></td>
						<td align="center"><b>
						<?php 
					
						//$nilais2= ($ss1+$ss2+$ss3+$ss4+$ss5+$ss6+$ss7+$ss8+$ss9+$ss10+$ss11+$ss12+$ss13+$ss14);
						$nilais2=$ratanilais2*25;
						echo substr($nilais2,0,5); 
						?>
						</b>
						</td>
						
						</tr>
					<tr>
                        <!--<td align="center"><?php echo ''; ?></td>-->
                        <td align="center"><?php echo ''; ?></td>
                        <td align="left"><b><?php echo 'HURUF MUTU PELAYANAN'; ?></b></td>
                        <td align="center"><b></td>
						<td align="center"><b><?php 
						if($ratanilais1 > 0 and $ratanilais1<=43.75){
						$mutu1= 'TIDAK BAIK';
						}else if ($ratanilais1 >=43.76 and $ratanilais1 <=62.50) {
						$mutu1= 'KURANG BAIK';
						}else if ($ratanilais1 >=62.51 and $ratanilais1 <=81.25) {
						$mutu1= 'BAIK';
						}else if ($ratanilais1 >=81.26) {
						$mutu1= 'SANGAT BAIK';
						}else if($ratanilais1 == 0){
						$mutu1=' - ';
						}
						echo $mutu1;  ?></b></td>
						<td align="center"><b></td>
						<td align="center"><b>
						<?php 
					if($ratanilais2 > 0 and $ratanilais2<=43.75){
						$mutu2= 'TIDAK BAIK';
						}else if ($ratanilais2 >=43.76 and $ratanilais2 <=62.50) {
						$mutu2= 'KURANG BAIK';
						}else if ($ratanilais2 >=62.51 and $ratanilais2 <=81.25) {
						$mutu2= 'BAIK';
						}else if ($ratanilais2 >=81.26) {
						$mutu2= 'SANGAT BAIK';
						}else if($ratanilais2 == 0){
						$mutu2=' - ';
						}
						echo $mutu2;  ?></b>
                    </tr>
					<tr>
                        <!--<td align="center"><?php echo ''; ?></td>-->
                        <td align="center"><?php echo ''; ?></td>
                        <td align="left"><b><?php echo 'KINERJA PELAYANAN'; ?></b></td>
                        <td align="center"><b></td>
						<td align="center"><b><?php 
						if($ratanilais1 > 0 and $ratanilais1<=43.75){
						$kmutu1= 'D';
						}else if ($ratanilais1 >=43.76 and $ratanilais1 <=62.50) {
						$kmutu1= 'C';
						}else if ($ratanilais1 >=62.51 and $ratanilais1 <=81.25) {
						$kmutu1= 'B';
						}else if ($ratanilais1 >=81.26) {
						$kmutu1= 'A';
						}else if($ratanilais1 == 0){
						$kmutu1=' - ';
						}
						echo $kmutu1;  ?></b></td>
						<td align="center"><b></td>
						<td align="center"><b>
						<?php 
					if($ratanilais2 > 0 and $ratanilais2<=43.75){
						$kmutu2= 'D';
						}else if ($ratanilais2 >=43.76 and $ratanilais2 <=62.50) {
						$kmutu2= 'C';
						}else if ($ratanilais2 >=62.51 and $ratanilais2 <=81.25) {
						$kmutu2= 'B';
						}else if ($ratanilais2 >=81.26) {
						$kmutu2= 'A';
						}else if($ratanilais2 == 0){
						$kmutu2=' - ';
						}
						echo $kmutu2;  ?></b>
                    </tr>
		 
		 
  
                    
                       
                
               
				
	 
</table>
<?php echo br(3);?>
         </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
