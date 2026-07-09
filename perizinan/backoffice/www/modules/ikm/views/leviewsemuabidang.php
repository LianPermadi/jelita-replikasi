<?php
		header("Content-Type: application/vnd.ms-word");
   header("Expires: 0");
      header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
       //header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').doc");
   header("Content-disposition: attachment; filename=IKM total $tgla.xls");
		
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
			//echo br(2);
			?>
			<div><font size="12px">
      
        </div>
            
            <font  size="12px" color="#1A1A1A"><b><?php echo $page_name; ?></b>
		
        </div>

         <legend style="color: #045000" align="center"><b><font  size="12px" color="#1A1A1A"><center>
           <legend style="color: #045000" align="center"><b>
             <?php
			 $a=$tgla;
			 $b=$a-1;
			 $c=$a+1;
			 echo br();
            echo 'IKM Tahun '.$b; echo ' / '. $tgla; echo ' / '.$c;
			//echo ' Bidang '. $a;
             //echo br(2);
			?>
          </legend></b>
 
	
	
	
    <table cellpadding="1" cellspacing="0" border="1" class="display" id="reportgridx">
        <thead><tr class="title">
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Kode</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Unsur Pelayanan</b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b>Tahun <?php echo $b ?></b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b>Tahun <?php echo $a ?></b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b>Tahun <?php echo $c ?></b></font></th>
          
		   </tr >
		   <tr class="title">
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b><?php echo ' Semester 1'; echo br();echo 'Nilai Rata-Rata'; ?></b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b><?php echo ' Semester 2'; echo br();echo 'Nilai Rata-Rata'; ?></b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b><?php echo ' Semester 1'; echo br();echo 'Nilai Rata-Rata'; ?></b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b><?php echo ' Semester 2'; echo br();echo 'Nilai Rata-Rata'; ?></b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b><?php echo ' Semester 1'; echo br();echo 'Nilai Rata-Rata'; ?></b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b><?php echo ' Semester 2'; echo br();echo 'Nilai Rata-Rata'; ?></b></font></th>
          
       
   
    </tr>
	
	</thead></thead>
<!---------------------------------------------------------------------------------------------------.-->
               
			   <?php
			   //$bidangizin=$this->input->post('id');
                   
					//$i = 1;
					
					//$i++;
					//-------------------------------------------variable tahun 1 semester 1
					$s1 = 0;
					$totals1=0;
					$totals1=0;
					$pembagis1=0;
					$jumlahpembagis1=0;
					$rata2s1=0;
					
					$s2 = 0;
					$totals2=0;
					$totals2=0;
					$pembagis2=0;
					$jumlahpembagis2=0;
					$rata2s2=0;
					
					$s3 = 0;
					$totals3=0;
					$totals3=0;
					$pembagis3=0;
					$jumlahpembagis3=0;
					$rata2s3=0;
					
					$s4 = 0;
					$totals4=0;
					$totals4=0;
					$pembagis4=0;
					$jumlahpembagis4=0;
					$rata2s4=0;
					
					$s5 = 0;
					$totals5=0;
					$totals5=0;
					$pembagis5=0;
					$jumlahpembagis5=0;
					$rata2s5=0;
					
					$s6 = 0;
					$totals6=0;
					$totals6=0;
					$pembagis6=0;
					$jumlahpembagis6=0;
					$rata2s6=0;
					
					$s7 = 0;
					$totals7=0;
					$totals7=0;
					$pembagis7=0;
					$jumlahpembagis7=0;
					$rata2s7=0;
					
					$s8 = 0;
					$totals8=0;
					$totals8=0;
					$pembagis8=0;
					$jumlahpembagis8=0;
					$rata2s8=0;
					
					$s9 = 0;
					$totals9=0;
					$totals9=0;
					$pembagis9=0;
					$jumlahpembagis9=0;
					$rata2s9=0;
					
					$s10 = 0;
					$totals10=0;
					$totals10=0;
					$pembagis10=0;
					$jumlahpembagis10=0;
					$rata2s10=0;
					
					$s11 = 0;
					$totals11=0;
					$totals11=0;
					$pembagis11=0;
					$jumlahpembagis11=0;
					$rata2s11=0;
					
					$s12 = 0;
					$totals12=0;
					$totals12=0;
					$pembagis12=0;
					$jumlahpembagis12=0;
					$rata2s12=0;
					
					$s13 = 0;
					$totals13=0;
					$totals13=0;
					$pembagis13=0;
					$jumlahpembagis13=0;
					$rata2s13=0;
					
					$s14 = 0;
					$totals14=0;
					$totals14=0;
					$pembagis14=0;
					$jumlahpembagis14=0;
					$rata2s14=0;
					
					//-------------------------------------------variable tahun 1 semester 2
					
						$ss1 = 0;
					$totalss1=0;
					$totalss1=0;
					$pembagiss1=0;
					$jumlahpembagiss1=0;
					$rata2ss1=0;
					
					$ss2 = 0;
					$totalss2=0;
					$totalss2=0;
					$pembagiss2=0;
					$jumlahpembagiss2=0;
					$rata2ss2=0;
					
					$ss3 = 0;
					$totalss3=0;
					$totalss3=0;
					$pembagiss3=0;
					$jumlahpembagiss3=0;
					$rata2ss3=0;
					
					$ss4 = 0;
					$totalss4=0;
					$totalss4=0;
					$pembagiss4=0;
					$jumlahpembagiss4=0;
					$rata2ss4=0;
					
					$ss5 = 0;
					$totalss5=0;
					$totalss5=0;
					$pembagiss5=0;
					$jumlahpembagiss5=0;
					$rata2ss5=0;
					
					$ss6 = 0;
					$totalss6=0;
					$totalss6=0;
					$pembagiss6=0;
					$jumlahpembagiss6=0;
					$rata2ss6=0;
					
					$ss7 = 0;
					$totalss7=0;
					$totalss7=0;
					$pembagiss7=0;
					$jumlahpembagiss7=0;
					$rata2ss7=0;
					
					$ss8 = 0;
					$totalss8=0;
					$totalss8=0;
					$pembagiss8=0;
					$jumlahpembagiss8=0;
					$rata2ss8=0;
					
					$ss9 = 0;
					$totalss9=0;
					$totalss9=0;
					$pembagiss9=0;
					$jumlahpembagiss9=0;
					$rata2ss9=0;
					
					$ss10 = 0;
					$totalss10=0;
					$totalss10=0;
					$pembagiss10=0;
					$jumlahpembagiss10=0;
					$rata2ss10=0;
					
					$ss11 = 0;
					$totalss11=0;
					$totalss11=0;
					$pembagiss11=0;
					$jumlahpembagiss11=0;
					$rata2ss11=0;
					
					$ss12 = 0;
					$totalss12=0;
					$totalss12=0;
					$pembagiss12=0;
					$jumlahpembagiss12=0;
					$rata2ss12=0;
					
					$ss13 = 0;
					$totalss13=0;
					$totalss13=0;
					$pembagiss13=0;
					$jumlahpembagiss13=0;
					$rata2ss13=0;
					
					$ss14 = 0;
					$totalss14=0;
					$totalss14=0;
					$pembagiss14=0;
					$jumlahpembagiss14=0;
					$rata2ss14=0;
					
					//-------------------------------------------variable tahun 2 semester 1
					$sss1 = 0;
					$totalsss1=0;
					$totalsss1=0;
					$pembagisss1=0;
					$jumlahpembagisss1=0;
					$rata2sss1=0;
					
					$sss2 = 0;
					$totalsss2=0;
					$totalsss2=0;
					$pembagisss2=0;
					$jumlahpembagisss2=0;
					$rata2sss2=0;
					
					$sss3 = 0;
					$totalsss3=0;
					$totalsss3=0;
					$pembagisss3=0;
					$jumlahpembagisss3=0;
					$rata2sss3=0;
					
					$sss4 = 0;
					$totalsss4=0;
					$totalsss4=0;
					$pembagisss4=0;
					$jumlahpembagisss4=0;
					$rata2sss4=0;
					
					$sss5 = 0;
					$totalsss5=0;
					$totalsss5=0;
					$pembagisss5=0;
					$jumlahpembagisss5=0;
					$rata2sss5=0;
					
					$sss6 = 0;
					$totalsss6=0;
					$totalsss6=0;
					$pembagisss6=0;
					$jumlahpembagisss6=0;
					$rata2sss6=0;
					
					$sss7 = 0;
					$totalsss7=0;
					$totalsss7=0;
					$pembagisss7=0;
					$jumlahpembagisss7=0;
					$rata2sss7=0;
					
					$sss8 = 0;
					$totalsss8=0;
					$totalsss8=0;
					$pembagisss8=0;
					$jumlahpembagisss8=0;
					$rata2sss8=0;
					
					$sss9 = 0;
					$totalsss9=0;
					$totalsss9=0;
					$pembagisss9=0;
					$jumlahpembagisss9=0;
					$rata2sss9=0;
					
					$sss10 = 0;
					$totalsss10=0;
					$totalsss10=0;
					$pembagisss10=0;
					$jumlahpembagisss10=0;
					$rata2sss10=0;
					
					$sss11 = 0;
					$totalsss11=0;
					$totalsss11=0;
					$pembagisss11=0;
					$jumlahpembagisss11=0;
					$rata2sss11=0;
					
					$sss12 = 0;
					$totalsss12=0;
					$totalsss12=0;
					$pembagissspembagisss12=0;
					$jumlahpembagisss12=0;
					$rata2sss12=0;
					
					$sss13 = 0;
					$totalsss13=0;
					$totalsss13=0;
					$pembagisss13=0;
					$jumlahpembagisss13=0;
					$rata2sss13=0;
					
					$sss14 = 0;
					$totalsss14=0;
					$totalsss14=0;
					$pembagisss14=0;
					$jumlahpembagisss14=0;
					$rata2sss14=0;
					
					//--------------------------------------------------- variable tahun 2 semester 2
					$ssss1 = 0;
					$totalssss1=0;
					$totalssss1=0;
					$pembagisss1=0;
					$jumlahpembagissss1=0;
					$rata2ssss1=0;
					
					$ssss2 = 0;
					$totalssss2=0;
					$totalssss2=0;
					$pembagisss2=0;
					$jumlahpembagissss2=0;
					$rata2ssss2=0;
					
					$ssss3 = 0;
					$totalssss3=0;
					$totalssss3=0;
					$pembagisss3=0;
					$jumlahpembagissss3=0;
					$rata2ssss3=0;
					
					$ssss4 = 0;
					$totalssss4=0;
					$totalssss4=0;
					$pembagisss4=0;
					$jumlahpembagissss4=0;
					$rata2ssss4=0;
					
					$ssss5 = 0;
					$totalssss5=0;
					$totalssss5=0;
					$pembagisss5=0;
					$jumlahpembagissss5=0;
					$rata2ssss5=0;
					
					$ssss6 = 0;
					$totalssss6=0;
					$totalssss6=0;
					$pembagisss6=0;
					$jumlahpembagissss6=0;
					$rata2ssss6=0;
					
					$ssss7 = 0;
					$totalssss7=0;
					$totalssss7=0;
					$pembagisss7=0;
					$jumlahpembagissss7=0;
					$rata2ssss7=0;
					
					$ssss8 = 0;
					$totalssss8=0;
					$totalssss8=0;
					$pembagisss8=0;
					$jumlahpembagissss8=0;
					$rata2ssss8=0;
					
					$ssss9 = 0;
					$totalssss9=0;
					$totalssss9=0;
					$pembagisss9=0;
					$jumlahpembagissss9=0;
					$rata2ssss9=0;
					
					$ssss10 = 0;
					$totalssss10=0;
					$totalssss10=0;
					$pembagisss10=0;
					$jumlahpembagissss10=0;
					$rata2ssss10=0;
					
					$ssss11 = 0;
					$totalssss11=0;
					$totalssss11=0;
					$pembagisss11=0;
					$jumlahpembagissss11=0;
					$rata2ssss11=0;
					
					$ssss12 = 0;
					$totalssss12=0;
					$totalssss12=0;
					$pembagissss12=0;
					$jumlahpembagissss12=0;
					$rata2ssss12=0;
					
					$ssss13 = 0;
					$totalssss13=0;
					$totalssss13=0;
					$pembagisss13=0;
					$jumlahpembagissss13=0;
					$rata2ssss13=0;
					
					$ssss14 = 0;
					$totalssss14=0;
					$totalssss14=0;
					$pembagisss14=0;
					$jumlahpembagissss14=0;
					$rata2ssss14=0;
					
					//--------------------------------------------------- variable tahun 3 semester 1
					$sssss1 = 0;
					$totalsssss1=0;
					$totalsssss1=0;
					$pembagisss1=0;
					$jumlahpembagisssss1=0;
					$rata2sssss1=0;
					
					$sssss2 = 0;
					$totalsssss2=0;
					$totalsssss2=0;
					$pembagisss2=0;
					$jumlahpembagisssss2=0;
					$rata2sssss2=0;
					
					$sssss3 = 0;
					$totalsssss3=0;
					$totalsssss3=0;
					$pembagisss3=0;
					$jumlahpembagisssss3=0;
					$rata2sssss3=0;
					
					$sssss4 = 0;
					$totalsssss4=0;
					$totalsssss4=0;
					$pembagisss4=0;
					$jumlahpembagisssss4=0;
					$rata2sssss4=0;
					
					$sssss5 = 0;
					$totalsssss5=0;
					$totalsssss5=0;
					$pembagisss5=0;
					$jumlahpembagisssss5=0;
					$rata2sssss5=0;
					
					$sssss6 = 0;
					$totalsssss6=0;
					$totalsssss6=0;
					$pembagisss6=0;
					$jumlahpembagisssss6=0;
					$rata2sssss6=0;
					
					$sssss7 = 0;
					$totalsssss7=0;
					$totalsssss7=0;
					$pembagisss7=0;
					$jumlahpembagisssss7=0;
					$rata2sssss7=0;
					
					$sssss8 = 0;
					$totalsssss8=0;
					$totalsssss8=0;
					$pembagisss8=0;
					$jumlahpembagisssss8=0;
					$rata2sssss8=0;
					
					$sssss9 = 0;
					$totalsssss9=0;
					$totalsssss9=0;
					$pembagisss9=0;
					$jumlahpembagisssss9=0;
					$rata2sssss9=0;
					
					$sssss10 = 0;
					$totalsssss10=0;
					$totalsssss10=0;
					$pembagisss10=0;
					$jumlahpembagisssss10=0;
					$rata2sssss10=0;
					
					$sssss11 = 0;
					$totalsssss11=0;
					$totalsssss11=0;
					$pembagisss11=0;
					$jumlahpembagisssss11=0;
					$rata2sssss11=0;
					
					$sssss12 = 0;
					$totalsssss12=0;
					$totalsssss12=0;
					$pembagisssss12=0;
					$jumlahpembagisssss12=0;
					$rata2sssss12=0;
					
					$sssss13 = 0;
					$totalsssss13=0;
					$totalsssss13=0;
					$pembagisss13=0;
					$jumlahpembagisssss13=0;
					$rata2sssss13=0;
					
					$sssss14 = 0;
					$totalsssss14=0;
					$totalsssss14=0;
					$pembagisss14=0;
					$jumlahpembagisssss14=0;
					$rata2sssss14=0;
					
					//--------------------------------------------------- variable tahun 3 semester 2
					$ssssss1 = 0;
					$totalssssss1=0;
					$totalssssss1=0;
					$pembagisss1=0;
					$jumlahpembagissssss1=0;
					$rata2ssssss1=0;
					
					$ssssss2 = 0;
					$totalssssss2=0;
					$totalssssss2=0;
					$pembagisss2=0;
					$jumlahpembagissssss2=0;
					$rata2ssssss2=0;
					
					$ssssss3 = 0;
					$totalssssss3=0;
					$totalssssss3=0;
					$pembagisss3=0;
					$jumlahpembagissssss3=0;
					$rata2ssssss3=0;
					
					$ssssss4 = 0;
					$totalssssss4=0;
					$totalssssss4=0;
					$pembagisss4=0;
					$jumlahpembagissssss4=0;
					$rata2ssssss4=0;
					
					$ssssss5 = 0;
					$totalssssss5=0;
					$totalssssss5=0;
					$pembagisss5=0;
					$jumlahpembagissssss5=0;
					$rata2ssssss5=0;
					
					$ssssss6 = 0;
					$totalssssss6=0;
					$totalssssss6=0;
					$pembagisss6=0;
					$jumlahpembagissssss6=0;
					$rata2ssssss6=0;
					
					$ssssss7 = 0;
					$totalssssss7=0;
					$totalssssss7=0;
					$pembagisss7=0;
					$jumlahpembagissssss7=0;
					$rata2ssssss7=0;
					
					$ssssss8 = 0;
					$totalssssss8=0;
					$totalssssss8=0;
					$pembagisss8=0;
					$jumlahpembagissssss8=0;
					$rata2ssssss8=0;
					
					$ssssss9 = 0;
					$totalssssss9=0;
					$totalssssss9=0;
					$pembagisss9=0;
					$jumlahpembagissssss9=0;
					$rata2ssssss9=0;
					
					$ssssss10 = 0;
					$totalssssss10=0;
					$totalssssss10=0;
					$pembagisss10=0;
					$jumlahpembagissssss10=0;
					$rata2ssssss10=0;
					
					$ssssss11 = 0;
					$totalssssss11=0;
					$totalssssss11=0;
					$pembagisss11=0;
					$jumlahpembagissssss11=0;
					$rata2ssssss11=0;
					
					$ssssss12 = 0;
					$totalssssss12=0;
					$totalssssss12=0;
					$pembagissssss12=0;
					$jumlahpembagissssss12=0;
					$rata2ssssss12=0;
					
					$ssssss13 = 0;
					$totalssssss13=0;
					$totalssssss13=0;
					$pembagisss13=0;
					$jumlahpembagissssss13=0;
					$rata2ssssss13=0;
					
					$ssssss14 = 0;
					$totalssssss14=0;
					$totalssssss14=0;
					$pembagisss14=0;
					$jumlahpembagissssss14=0;
					$rata2ssssss14=0;
					
					
					
					$query_sektor = "select * from trsektor order by id asc";
                    $resultssektor = mysql_query($query_sektor);
                    while ($datasektor = mysql_fetch_assoc(@$resultssektor)){
					$bidangizin=$datasektor['id'];
					//echo $bidangizin;
                    
					$query_data = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=1 and a.tahun=$b";
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
					
					$s1 = $data['u1'];
					$totals1+=$s1;
					$pembagis1=count($s1);
					$jumlahpembagis1+=$pembagis1;
					
					$s2 = $data['u2'];
					$totals2+=$s2;
					$pembagis2=count($s2);
					$jumlahpembagis2+=$pembagis2;
					
					$s3 = $data['u3'];
					$totals3+=$s3;
					$pembagis3=count($s3);
					$jumlahpembagis3+=$pembagis3;
					
					$s4 = $data['u4'];
					$totals4+=$s4;
					$pembagis4=count($s4);
					$jumlahpembagis4+=$pembagis4;
					
					$s5 = $data['u5'];
					$totals5+=$s5;
					$pembagis5=count($s5);
					$jumlahpembagis5+=$pembagis5;
					
					$s6 = $data['u6'];
					$totals6+=$s6;
					$pembagis6=count($s6);
					$jumlahpembagis6+=$pembagis6;
					
					$s7 = $data['u7'];
					$totals7+=$s7;
					$pembagis7=count($s7);
					$jumlahpembagis7+=$pembagis7;
					
					$s8 = $data['u8'];
					$totals8+=$s8;
					$pembagis8=count($s8);
					$jumlahpembagis8+=$pembagis8;
					
					$s9 = $data['u9'];
					$totals9+=$s9;
					$pembagis9=count($s9);
					$jumlahpembagis9+=$pembagis9;
					
					$s10 = $data['u10'];
					$totals10+=$s10;
					$pembagis10=count($s10);
					$jumlahpembagis10+=$pembagis10;
					
					$s11 = $data['u11'];
					$totals11+=$s11;
					$pembagis11=count($s11);
					$jumlahpembagis11+=$pembagis11;
					
					$s12 = $data['u12'];
					$totals12+=$s12;
					$pembagis12=count($s12);
					$jumlahpembagis12+=$pembagis12;
					
					$s13 = $data['u13'];
					$totals13+=$s13;
					$pembagis13=count($s13);
					$jumlahpembagis13+=$pembagis13;
					
					$s14 = $data['u14'];
					$totals14+=$s14;
					$pembagis14=count($s14);
					$jumlahpembagis14+=$pembagis14;
		
	
		 }
		 
		 $query_data2 = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=2 and a.tahun=$b";
                    $results2 = mysql_query($query_data2);
                    while ($data2 = mysql_fetch_assoc(@$results2)){
					
					$ss1 = $data2['u1'];
					$totalss1+=$ss1;
					$pembagiss1=count($ss1);
					$jumlahpembagiss1+=$pembagiss1;
					
					$ss2 = $data2['u2'];
					$totalss2+=$ss2;
					$pembagiss2=count($ss2);
					$jumlahpembagiss2+=$pembagiss2;
					
					$ss3 = $data2['u3'];
					$totalss3+=$ss3;
					$pembagiss3=count($ss3);
					$jumlahpembagiss3+=$pembagiss3;
					
					$ss4 = $data2['u4'];
					$totalss4+=$ss4;
					$pembagiss4=count($ss4);
					$jumlahpembagiss4+=$pembagiss4;
					
					$ss5 = $data2['u5'];
					$totalss5+=$ss5;
					$pembagiss5=count($ss5);
					$jumlahpembagiss5+=$pembagiss5;
					
					$ss6 = $data2['u6'];
					$totalss6+=$ss6;
					$pembagiss6=count($ss6);
					$jumlahpembagiss6+=$pembagiss6;
					
					$ss7 = $data2['u7'];
					$totalss7+=$ss7;
					$pembagiss7=count($ss7);
					$jumlahpembagiss7+=$pembagiss7;
					
					$ss8 = $data2['u8'];
					$totalss8+=$ss8;
					$pembagiss8=count($ss8);
					$jumlahpembagiss8+=$pembagiss8;
					
					$ss9 = $data2['u9'];
					$totalss9+=$ss9;
					$pembagiss9=count($ss9);
					$jumlahpembagiss9+=$pembagiss9;
					
					$ss10 = $data2['u10'];
					$totalss10+=$ss10;
					$pembagiss10=count($ss10);
					$jumlahpembagiss10+=$pembagiss10;
					
					$ss11 = $data2['u11'];
					$totalss11+=$ss11;
					$pembagiss11=count($ss11);
					$jumlahpembagiss11+=$pembagiss11;
					
					$ss12 = $data2['u12'];
					$totalss12+=$ss12;
					$pembagiss12=count($ss12);
					$jumlahpembagiss12+=$pembagiss12;
					
					$ss13 = $data2['u13'];
					$totalss13+=$ss13;
					$pembagiss13=count($ss13);
					$jumlahpembagiss13+=$pembagiss13;
					
					$ss14 = $data2['u14'];
					$totalss14+=$ss14;
					$pembagiss14=count($ss14);
					$jumlahpembagiss14+=$pembagiss14;
					
		 }
		 //--------------------------------------------query tahun 2 semester 1
		 $query_data3 = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=1 and a.tahun=$a";
                    $results3 = mysql_query($query_data3);
                    while ($data3 = mysql_fetch_assoc(@$results3)){
					
					$sss1 = $data3['u1'];
					$totalsss1+=$sss1;
					$pembagisss1=count($sss1);
					$jumlahpembagisss1+=$pembagisss1;
					
					$sss2 = $data3['u2'];
					$totalsss2+=$sss2;
					$pembagisss2=count($sss2);
					$jumlahpembagisss2+=$pembagisss2;
					
					$sss3 = $data3['u3'];
					$totalsss3+=$sss3;
					$pembagisss3=count($sss3);
					$jumlahpembagisss3+=$pembagisss3;
					
					$sss4 = $data3['u4'];
					$totalsss4+=$sss4;
					$pembagisss4=count($sss4);
					$jumlahpembagisss4+=$pembagisss4;
					
					$sss5 = $data3['u5'];
					$totalsss5+=$sss5;
					$pembagisss5=count($sss5);
					$jumlahpembagisss5+=$pembagisss5;
					
					$sss6 = $data3['u6'];
					$totalsss6+=$sss6;
					$pembagisss6=count($sss6);
					$jumlahpembagisss6+=$pembagisss6;
					
					$sss7 = $data3['u7'];
					$totalsss7+=$sss7;
					$pembagisss7=count($sss7);
					$jumlahpembagisss7+=$pembagisss7;
					
					$sss8 = $data3['u8'];
					$totalsss8+=$sss8;
					$pembagisss8=count($sss8);
					$jumlahpembagisss8+=$pembagisss8;
					
					$sss9 = $data3['u9'];
					$totalsss9+=$sss9;
					$pembagisss9=count($sss9);
					$jumlahpembagisss9+=$pembagisss9;
					
					$sss10 = $data3['u10'];
					$totalsss10+=$sss10;
					$pembagisss10=count($sss10);
					$jumlahpembagisss10+=$pembagisss10;
					
					$sss11 = $data3['u11'];
					$totalsss11+=$sss11;
					$pembagisss11=count($sss11);
					$jumlahpembagisss11+=$pembagisss11;
					
					$sss12 = $data3['u12'];
					$totalsss12+=$sss12;
					$pembagisss12=count($sss12);
					$jumlahpembagisss12+=$pembagisss12;
					
					$sss13 = $data3['u13'];
					$totalsss13+=$sss13;
					$pembagisss13=count($sss13);
					$jumlahpembagisss13+=$pembagisss13;
					
					$sss14 = $data3['u14'];
					$totalsss14+=$sss14;
					$pembagisss14=count($sss14);
					$jumlahpembagisss14+=$pembagisss14;
		
	
		 }
		 //--------------------------------------------query tahun 2 semester 2
		 $query_data4 = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=2 and a.tahun=$a";
                    $results4 = mysql_query($query_data4);
                    while ($data4 = mysql_fetch_assoc(@$results4)){
					
					$ssss1 = $data4['u1'];
					$totalssss1+=$ssss1;
					$pembagissss1=count($ssss1);
					$jumlahpembagissss1+=$pembagissss1;
					
					$ssss2 = $data4['u2'];
					$totalssss2+=$ssss2;
					$pembagissss2=count($ssss2);
					$jumlahpembagissss2+=$pembagissss2;
					
					$ssss3 = $data4['u3'];
					$totalssss3+=$ssss3;
					$pembagissss3=count($ssss3);
					$jumlahpembagissss3+=$pembagissss3;
					
					$ssss4 = $data4['u4'];
					$totalssss4+=$ssss4;
					$pembagissss4=count($ssss4);
					$jumlahpembagissss4+=$pembagissss4;
					
					$ssss5 = $data4['u5'];
					$totalssss5+=$ssss5;
					$pembagissss5=count($ssss5);
					$jumlahpembagissss5+=$pembagissss5;
					
					$ssss6 = $data4['u6'];
					$totalssss6+=$ssss6;
					$pembagissss6=count($ssss6);
					$jumlahpembagissss6+=$pembagissss6;
					
					$ssss7 = $data4['u7'];
					$totalssss7+=$ssss7;
					$pembagissss7=count($ssss7);
					$jumlahpembagissss7+=$pembagissss7;
					
					$ssss8 = $data4['u8'];
					$totalssss8+=$ssss8;
					$pembagissss8=count($ssss8);
					$jumlahpembagissss8+=$pembagissss8;
					
					$ssss9 = $data4['u9'];
					$totalssss9+=$ssss9;
					$pembagissss9=count($ssss9);
					$jumlahpembagissss9+=$pembagissss9;
					
					$ssss10 = $data4['u10'];
					$totalssss10+=$ssss10;
					$pembagissss10=count($ssss10);
					$jumlahpembagissss10+=$pembagissss10;
					
					$ssss11 = $data4['u11'];
					$totalssss11+=$ssss11;
					$pembagissss11=count($ssss11);
					$jumlahpembagissss11+=$pembagissss11;
					
					$ssss12 = $data4['u12'];
					$totalssss12+=$ssss12;
					$pembagissss12=count($ssss12);
					$jumlahpembagissss12+=$pembagissss12;
					
					$ssss13 = $data4['u13'];
					$totalssss13+=$ssss13;
					$pembagissss13=count($ssss13);
					$jumlahpembagissss13+=$pembagissss13;
					
					$ssss14 = $data4['u14'];
					$totalssss14+=$ssss14;
					$pembagissss14=count($ssss14);
					$jumlahpembagissss14+=$pembagissss14;
		
	
		 }
		 //--------------------------------------------query tahun 3 semester 1
		 $query_data5 = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=1 and a.tahun=$c";
                    $results5 = mysql_query($query_data5);
                    while ($data5 = mysql_fetch_assoc(@$results5)){
					
					$sssss1 = $data5['u1'];
					$totalsssss1+=$sssss1;
					$pembagisssss1=count($sssss1);
					$jumlahpembagisssss1+=$pembagisssss1;
					
					$sssss2 = $data5['u2'];
					$totalsssss2+=$sssss2;
					$pembagisssss2=count($sssss2);
					$jumlahpembagisssss2+=$pembagisssss2;
					
					$sssss3 = $data5['u3'];
					$totalsssss3+=$sssss3;
					$pembagisssss3=count($sssss3);
					$jumlahpembagisssss3+=$pembagisssss3;
					
					$sssss4 = $data5['u4'];
					$totalsssss4+=$sssss4;
					$pembagisssss4=count($sssss4);
					$jumlahpembagisssss4+=$pembagisssss4;
					
					$sssss5 = $data5['u5'];
					$totalsssss5+=$sssss5;
					$pembagisssss5=count($sssss5);
					$jumlahpembagisssss5+=$pembagisssss5;
					
					$sssss6 = $data5['u6'];
					$totalsssss6+=$sssss6;
					$pembagisssss6=count($sssss6);
					$jumlahpembagisssss6+=$pembagisssss6;
					
					$sssss7 = $data5['u7'];
					$totalsssss7+=$sssss7;
					$pembagisssss7=count($sssss7);
					$jumlahpembagisssss7+=$pembagisssss7;
					
					$sssss8 = $data5['u8'];
					$totalsssss8+=$sssss8;
					$pembagisssss8=count($sssss8);
					$jumlahpembagisssss8+=$pembagisssss8;
					
					$sssss9 = $data5['u9'];
					$totalsssss9+=$sssss9;
					$pembagisssss9=count($sssss9);
					$jumlahpembagisssss9+=$pembagisssss9;
					
					$sssss10 = $data5['u10'];
					$totalsssss10+=$sssss10;
					$pembagisssss10=count($sssss10);
					$jumlahpembagisssss10+=$pembagisssss10;
					
					$sssss11 = $data5['u11'];
					$totalsssss11+=$sssss11;
					$pembagisssss11=count($sssss11);
					$jumlahpembagisssss11+=$pembagisssss11;
					
					$sssss12 = $data5['u12'];
					$totalsssss12+=$sssss12;
					$pembagisssss12=count($sssss12);
					$jumlahpembagisssss12+=$pembagisssss12;
					
					$sssss13 = $data5['u13'];
					$totalsssss13+=$sssss13;
					$pembagisssss13=count($sssss13);
					$jumlahpembagisssss13+=$pembagisssss13;
					
					$sssss14 = $data5['u14'];
					$totalsssss14+=$sssss14;
					$pembagisssss14=count($sssss14);
					$jumlahpembagisssss14+=$pembagisssss14;
		
	
		 }
		 //--------------------------------------------query tahun 3 semester 2
		 $query_data6 = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=2 and a.tahun=$c";
                    $results6 = mysql_query($query_data6);
                    while ($data6 = mysql_fetch_assoc(@$results6)){
					
					$ssssss1 = $data6['u1'];
					$totalssssss1+=$ssssss1;
					$pembagissssss1=count($ssssss1);
					$jumlahpembagissssss1+=$pembagissssss1;
					
					$ssssss2 = $data6['u2'];
					$totalssssss2+=$ssssss2;
					$pembagissssss2=count($ssssss2);
					$jumlahpembagissssss2+=$pembagissssss2;
					
					$ssssss3 = $data6['u3'];
					$totalssssss3+=$ssssss3;
					$pembagissssss3=count($ssssss3);
					$jumlahpembagissssss3+=$pembagissssss3;
					
					$ssssss4 = $data6['u4'];
					$totalssssss4+=$ssssss4;
					$pembagissssss4=count($ssssss4);
					$jumlahpembagissssss4+=$pembagissssss4;
					
					$ssssss5 = $data6['u5'];
					$totalssssss5+=$ssssss5;
					$pembagissssss5=count($ssssss5);
					$jumlahpembagissssss5+=$pembagissssss5;
					
					$ssssss6 = $data6['u6'];
					$totalssssss6+=$ssssss6;
					$pembagissssss6=count($ssssss6);
					$jumlahpembagissssss6+=$pembagissssss6;
					
					$ssssss7 = $data6['u7'];
					$totalssssss7+=$ssssss7;
					$pembagissssss7=count($ssssss7);
					$jumlahpembagissssss7+=$pembagissssss7;
					
					$ssssss8 = $data6['u8'];
					$totalssssss8+=$ssssss8;
					$pembagissssss8=count($ssssss8);
					$jumlahpembagissssss8+=$pembagissssss8;
					
					$ssssss9 = $data6['u9'];
					$totalssssss9+=$ssssss9;
					$pembagissssss9=count($ssssss9);
					$jumlahpembagissssss9+=$pembagissssss9;
					
					$ssssss10 = $data6['u10'];
					$totalssssss10+=$ssssss10;
					$pembagissssss10=count($ssssss10);
					$jumlahpembagissssss10+=$pembagissssss10;
					
					$ssssss11 = $data6['u11'];
					$totalssssss11+=$ssssss11;
					$pembagissssss11=count($ssssss11);
					$jumlahpembagissssss11+=$pembagissssss11;
					
					$ssssss12 = $data6['u12'];
					$totalssssss12+=$ssssss12;
					$pembagissssss12=count($ssssss12);
					$jumlahpembagissssss12+=$pembagissssss12;
					
					$ssssss13 = $data6['u13'];
					$totalssssss13+=$ssssss13;
					$pembagissssss13=count($ssssss13);
					$jumlahpembagissssss13+=$pembagissssss13;
					
					$ssssss14 = $data6['u14'];
					$totalssssss14+=$ssssss14;
					$pembagissssss14=count($ssssss14);
					$jumlahpembagissssss14+=$pembagissssss14;
		
	
		 }
		 }
		//-------------------------------------------------tahun pertama semester1
		$pembagis1=$jumlahpembagis1;
		if($totals1==0 || $pembagis1==0){
		$rata2s1=0;
		}else{
		$rata2s1=$totals1/$pembagis1;
		}
		
		$pembagis2=$jumlahpembagis2;
		if($totals2==0 || $pembagis2==0){
		$rata2s2=0;
		}else{
		$rata2s2=$totals2/$pembagis2;
		}
		
		$pembagis3=$jumlahpembagis3;
		if($totals3==0 || $pembagis3==0){
		$rata2s3=0;
		}else{
		$rata2s3=$totals3/$pembagis3;
		}
		
		$pembagis4=$jumlahpembagis4;
		if($totals4==0 || $pembagis4==0){
		$rata2s4=0;
		}else{
		$rata2s4=$totals4/$pembagis4;
		}
		
		$pembagis5=$jumlahpembagis5;
		if($totals5==0 || $pembagis5==0){
		$rata2s5=0;
		}else{
		$rata2s5=$totals5/$pembagis5;
		}
		
		$pembagis6=$jumlahpembagis6;
		if($totals6 == 0 || $pembagis6==0){
		$rata2s6=0;
		}else{
		$rata2s6=$totals6/$pembagis6;
		}
		
		$pembagis7=$jumlahpembagis7;
		if($totals7==0 || $pembagis7==0){
		$rata2s7=0;
		}else{
		$rata2s7=$totals7/$pembagis7;
		}
		
		$pembagis8=$jumlahpembagis8;
		if($totals8==0 || $pembagis8==0){
		$rata2s8=0;
		}else{
		$rata2s8=$totals8/$pembagis8;
		}
		
		$pembagis9=$jumlahpembagis9;
		if($totals9==0 || $pembagis9==0){
		$rata2s9=0;
		}else{
		$rata2s9=$totals9/$pembagis9;
		}
		
		$pembagis10=$jumlahpembagis10;
		if($totals10==0 || $pembagis10==0){
		$rata2s10=0;
		}else{
		$rata2s10=$totals10/$pembagis10;
		}
		
		$pembagis11=$jumlahpembagis11;
		if($totals11==0 || $pembagis11==0){
		$rata2s11=0;
		}else{
		$rata2s11=$totals11/$pembagis11;
		}
		
		$pembagis12=$jumlahpembagis12;
		if($totals12==0 || $pembagis12==0){
		$rata2s12=0;
		}else{
		$rata2s12=$totals12/$pembagis12;
		}
		
		$pembagis13=$jumlahpembagis13;
		if($totals13==0 || $pembagis13==0){
		$rata2s13=0;
		}else{
		$rata2s13=$totals13/$pembagis13;
		}
		
		$pembagis14=$jumlahpembagis14;
		if($totals14==0 || $pembagis14==0){
		$rata2s14=0;
		}else{
		$rata2s14=$totals14/$pembagis14;
		}
		//------------------------------------------------akhir tahun kategori 1 semester 1
		//-------------------------------------------------tahun pertama semester 2
		$pembagiss1=$jumlahpembagiss1;
		if($totalss1==0 || $pembagiss1==0){
		$rata2ss1=0;
		}else{
		$rata2ss1=$totalss1/$pembagiss1;
		}
		
		$pembagiss2=$jumlahpembagiss2;
		if($totalss2==0 || $pembagiss2==0){
		$rata2ss2=0;
		}else{
		$rata2ss2=$totalss2/$pembagiss2;
		}
		
		$pembagiss3=$jumlahpembagiss3;
		if($totalss3==0 || $pembagiss3==0){
		$rata2ss3=0;
		}else{
		$rata2ss3=$totalss3/$pembagiss3;
		}
		
		$pembagiss4=$jumlahpembagiss4;
		if($totalss4==0 || $pembagiss4==0){
		$rata2ss4=0;
		}else{
		$rata2ss4=$totalss4/$pembagiss4;
		}
		
		$pembagiss5=$jumlahpembagiss5;
		if($totalss5==0 || $pembagiss5==0){
		$rata2ss5=0;
		}else{
		$rata2ss5=$totalss5/$pembagiss5;
		}
		
		$pembagiss6=$jumlahpembagiss6;
		if($totalss6==0 || $pembagiss6==0){
		$rata2ss6=0;
		}else{
		$rata2ss6=$totalss6/$pembagiss6;
		}
		
		$pembagiss7=$jumlahpembagiss7;
		if($totalss7==0 || $pembagiss7==0){
		$rata2ss7=0;
		}else{
		$rata2ss7=$totalss7/$pembagiss7;
		}
		
		$pembagiss8=$jumlahpembagiss8;
		if($totalss8==0 || $pembagiss8==0){
		$rata2ss8=0;
		}else{
		$rata2ss8=$totalss8/$pembagiss8;
		}
		
		$pembagiss9=$jumlahpembagiss9;
		if($totalss9==0 || $pembagiss9==0){
		$rata2ss9=0;
		}else{
		$rata2ss9=$totalss9/$pembagiss9;
		}
		
		$pembagiss10=$jumlahpembagiss10;
		if($totalss10==0 || $pembagiss10==0){
		$rata2ss10=0;
		}else{
		$rata2ss10=$totalss10/$pembagiss10;
		}
		
		$pembagiss11=$jumlahpembagiss11;
		if($totalss11==0 || $pembagiss11==0){
		$rata2ss11=0;
		}else{
		$rata2ss11=$totalss11/$pembagiss11;
		}
		
		$pembagiss12=$jumlahpembagiss12;
		if($totalss12==0 || $pembagiss12==0){
		$rata2ss12=0;
		}else{
		$rata2ss12=$totalss12/$pembagiss12;
		}
		
		$pembagiss13=$jumlahpembagiss13;
		if($totalss13==0 || $pembagiss13==0){
		$rata2ss13=0;
		}else{
		$rata2ss13=$totalss13/$pembagiss13;
		}
		
		$pembagiss14=$jumlahpembagiss14;
		if($totalss14==0 || $pembagiss14==0){
		$rata2ss14=0;
		}else{
		$rata2ss14=$totalss14/$pembagiss14;
		}
		//------------------------------------------------akhir tahun kategori 1 semester 2
		
		//-------------------------------------------------tahun kedua semester 1
		$pembagisss1=$jumlahpembagisss1;
		if($totalsss1==0 || $pembagisss1==0){
		$rata2sss1=0;
		}else{
		$rata2sss1=$totalsss1/$pembagisss1;
		}
		
		$pembagisss2=$jumlahpembagisss2;
		if($totalsss2==0 || $pembagisss2==0){
		$rata2sss2=0;
		}else{
		$rata2sss2 = $totalsss2/$pembagisss2;
		}
		
		$pembagisss3=$jumlahpembagisss3;
		if($totalsss3==0 || $pembagisss3==0){
		$rata2sss3=0;
		}else{
		$rata2sss3=$totalsss3/$pembagisss3;
		}
		
		$pembagisss4=$jumlahpembagisss4;
		if($totalsss4==0 || $pembagisss4==0){
		$rata2sss4=0;
		}else{
		$rata2sss4=$totalsss4/$pembagisss4;
		}
		
		$pembagisss5=$jumlahpembagisss5;
		if($totalsss5==0 || $pembagisss5==0){
		$rata2sss5=0;
		}else{
		$rata2sss5=$totalsss5/$pembagisss5;
		}
		
		$pembagisss6=$jumlahpembagisss6;
		if($totalsss6==0 || $pembagisss6==0){
		$rata2sss6=0;
		}else{
		$rata2sss6=$totalsss6/$pembagisss6;
		}
		
		$pembagisss7=$jumlahpembagisss7;
		if($totalsss7==0 || $pembagisss7==0){
		$rata2sss7=0;
		}else{
		$rata2sss7=$totalsss7/$pembagisss7;
		}
		
		$pembagisss8=$jumlahpembagisss8;
		if($totalsss8==0 || $pembagisss8==0){
		$rata2sss8=0;
		}else{
		$rata2sss8=$totalsss8/$pembagisss8;
		}
		
		$pembagisss9=$jumlahpembagisss9;
		if($totalsss9==0 || $pembagisss9==0){
		$rata2sss9=0;
		}else{
		$rata2sss9=$totalsss9/$pembagisss9;
		}
		
		$pembagisss10=$jumlahpembagisss10;
		if($totalsss10==0 || $pembagisss10==0){
		$rata2sss10=0;
		}else{
		$rata2sss10=$totalsss10/$pembagisss10;
		}
		
		$pembagisss11=$jumlahpembagisss11;
		if($totalsss11==0 || $pembagisss11==0){
		$rata2sss11=0;
		}else{
		$rata2sss11=$totalsss11/$pembagisss11;
		}
		
		$pembagisss12=$jumlahpembagisss12;
		if($totalsss12==0 || $pembagisss12==0){
		$rata2sss12=0;
		}else{
		$rata2sss12=$totalsss12/$pembagisss12;
		}
		
		$pembagisss13=$jumlahpembagisss13;
		if($totalsss13==0 || $pembagisss13==0){
		$rata2sss13=0;
		}else{
		$rata2sss13=$totalsss13/$pembagisss13;
		}
		
		$pembagisss14=$jumlahpembagisss14;
		if($totalsss14==0 || $pembagisss14==0){
		$rata2sss14=0;
		}else{
		$rata2sss14=$totalsss14/$pembagisss14;
		}
		//------------------------------------------------akhir tahun kategori 2 semester 1
//-------------------------------------------------tahun kedua semester 2
		$pembagissss1=$jumlahpembagissss1;
		if($totalssss1==0 || $pembagissss1==0){
		$rata2ssss1=0;
		}else{
		$rata2ssss1=$totalssss1/$pembagissss1;
		}
		
		$pembagissss2=$jumlahpembagissss2;
		if($totalssss2==0 || $pembagissss2==0){
		$rata2ssss2=0;
		}else{
		$rata2ssss2=$totalssss2/$pembagissss2;
		}
		
		$pembagissss3=$jumlahpembagissss3;
		if($totalssss3==0 || $pembagissss3==0){
		$rata2ssss3=0;
		}else{
		$rata2ssss3=$totalssss3/$pembagissss3;
		}
		
		$pembagissss4=$jumlahpembagissss4;
		if($totalssss4==0 || $pembagissss4==0){
		$rata2ssss4=0;
		}else{
		$rata2ssss4=$totalssss4/$pembagissss4;
		}
		
		$pembagissss5=$jumlahpembagissss5;
		if($totalssss5==0 || $pembagissss5==0){
		$rata2ssss5=0;
		}else{
		$rata2ssss5=$totalssss5/$pembagissss5;
		}
		
		$pembagissss6=$jumlahpembagissss6;
		if($totalssss6==0 || $pembagissss6==0){
		$rata2ssss6=0;
		}else{
		$rata2ssss6=$totalssss6/$pembagissss6;
		}
		
		$pembagissss7=$jumlahpembagissss7;
		if($totalssss7==0 || $pembagissss7==0){
		$rata2ssss7=0;
		}else{
		$rata2ssss7=$totalssss7/$pembagissss7;
		}
		
		$pembagissss8=$jumlahpembagissss8;
		if($totalssss8==0 || $pembagissss8==0){
		$rata2ssss8=0;
		}else{
		$rata2ssss8=$totalssss8/$pembagissss8;
		}
		
		$pembagissss9=$jumlahpembagissss9;
		if($totalssss9==0 || $pembagissss9==0){
		$rata2ssss9=0;
		}else{
		$rata2ssss9=$totalssss9/$pembagissss9;
		}
		
		$pembagissss10=$jumlahpembagissss10;
		if($totalssss10==0 || $pembagissss10==0){
		$rata2ssss10=0;
		}else{
		$rata2ssss10=$totalssss10/$pembagissss10;
		}
		
		$pembagissss11=$jumlahpembagissss11;
		if($totalssss11==0 || $pembagissss11==0){
		$rata2ssss11=0;
		}else{
		$rata2ssss11=$totalssss11/$pembagissss11;
		}
		
		$pembagissss12=$jumlahpembagissss12;
		if($totalssss12==0 || $pembagissss12==0){
		$rata2ssss12=0;
		}else{
		$rata2ssss12=$totalssss12/$pembagissss12;
		}
		
		$pembagissss13=$jumlahpembagissss13;
		if($totalssss13==0 || $pembagissss13==0){
		$rata2ssss13=0;
		}else{
		$rata2ssss13=$totalssss13/$pembagissss13;
		}
		
		$pembagissss14=$jumlahpembagissss14;
		if($totalssss14==0 || $pembagissss14==0){
		$rata2ssss14=0;
		}else{
		$rata2ssss14=$totalssss14/$pembagissss14;
		}
		//------------------------------------------------akhir tahun kategori 2 semester 2		
		//-------------------------------------------------tahun ketiga semester 1
		$pembagisssss1=$jumlahpembagisssss1;
		if($totalsssss1==0 || $pembagisssss1==0){
		$rata2sssss1=0;
		}else{
		$rata2sssss1=$totalsssss1/$pembagisssss1;
		}
		
		$pembagisssss2=$jumlahpembagisssss2;
		if($totalsssss2==0 || $pembagisssss2==0){
		$rata2sssss2=0;
		}else{
		$rata2sssss2=$totalsssss2/$pembagisssss2;
		}
		
		$pembagisssss3=$jumlahpembagisssss3;
		if($totalsssss3==0 || $pembagisssss3==0){
		$rata2sssss3=0;
		}else{
		$rata2sssss3=$totalsssss3/$pembagisssss3;
		}
		
		$pembagisssss4=$jumlahpembagisssss4;
		if($totalsssss4==0 || $pembagisssss4==0){
		$rata2sssss4=0;
		}else{
		$rata2sssss4=$totalsssss4/$pembagisssss4;
		}
		
		$pembagisssss5=$jumlahpembagisssss5;
		if($totalsssss5==0 || $pembagisssss5==0){
		$rata2sssss5=0;
		}else{
		$rata2sssss5=$totalsssss5/$pembagisssss5;
		}
		
		$pembagisssss6=$jumlahpembagisssss6;
		if($totalsssss6==0 || $pembagisssss6==0){
		$rata2sssss6=0;
		}else{
		$rata2sssss6=$totalsssss6/$pembagisssss6;
		}
		
		$pembagisssss7=$jumlahpembagisssss7;
		if($totalsssss7==0 || $pembagisssss7==0){
		$rata2sssss7=0;
		}else{
		$rata2sssss7=$totalsssss7/$pembagisssss7;
		}
		
		$pembagisssss8=$jumlahpembagisssss8;
		if($totalsssss8==0 || $pembagisssss8==0){
		$rata2sssss8=0;
		}else{
		$rata2sssss8=$totalsssss8/$pembagisssss8;
		}
		
		$pembagisssss9=$jumlahpembagisssss9;
		if($totalsssss9==0 || $pembagisssss9==0){
		$rata2sssss9=0;
		}else{
		$rata2sssss9=$totalsssss9/$pembagisssss9;
		}
		
		$pembagisssss10=$jumlahpembagisssss10;
		if($totalsssss10==0 || $pembagisssss10==0){
		$rata2sssss10=0;
		}else{
		$rata2sssss10=$totalsssss10/$pembagisssss10;
		}
		
		$pembagisssss11=$jumlahpembagisssss11;
		if($totalsssss11==0 || $pembagisssss11==0){
		$rata2sssss11=0;
		}else{
		$rata2sssss11=$totalsssss11/$pembagisssss11;
		}
		
		$pembagisssss12=$jumlahpembagisssss12;
		if($totalsssss12==0 || $pembagisssss12==0){
		$rata2sssss12=0;
		}else{
		$rata2sssss12=$totalsssss12/$pembagisssss12;
		}
		
		$pembagisssss13=$jumlahpembagisssss13;
		if($totalsssss13==0 || $pembagisssss13==0){
		$rata2sssss13=0;
		}else{
		$rata2sssss13=$totalsssss13/$pembagisssss13;
		}
		
		$pembagisssss14=$jumlahpembagisssss14;
		if($totalsssss14==0 || $pembagisssss14==0){
		$rata2sssss14=0;
		}else{
		$rata2sssss14=$totalsssss14/$pembagisssss14;
		}
		//------------------------------------------------akhir tahun kategori 3 semester 1	
//-------------------------------------------------tahun ketiga semester 2
		$pembagissssss1=$jumlahpembagissssss1;
		if($totalssssss1==0 || $pembagissssss1==0){
		$rata2ssssss1=0;
		}else{
		$rata2ssssss1=$totalssssss1/$pembagissssss1;
		}
		
		$pembagissssss2=$jumlahpembagissssss2;
		if($totalssssss2==0 || $pembagissssss2==0){
		$rata2ssssss2=0;
		}else{
		$rata2ssssss2=$totalssssss2/$pembagissssss2;
		}
		
		$pembagissssss3=$jumlahpembagissssss3;
		if($totalssssss3==0 || $pembagissssss3==0){
		$rata2ssssss3=0;
		}else{
		$rata2ssssss3=$totalssssss3/$pembagissssss3;
		}
		
		$pembagissssss4=$jumlahpembagissssss4;
		if($totalssssss4==0 || $pembagissssss4==0){
		$rata2ssssss4=0;
		}else{
		$rata2ssssss4=$totalssssss4/$pembagissssss4;
		}
		
		$pembagissssss5=$jumlahpembagissssss5;
		if($totalssssss5==0 || $pembagissssss5==0){
		$rata2ssssss5=0;
		}else{
		$rata2ssssss5=$totalssssss5/$pembagissssss5;
		}
		
		$pembagissssss6=$jumlahpembagissssss6;
		if($totalssssss6==0 || $pembagissssss6==0){
		$rata2ssssss6=0;
		}else{
		$rata2ssssss6=$totalssssss6/$pembagissssss6;
		}
		
		$pembagissssss7=$jumlahpembagissssss7;
		if($totalssssss7==0 || $pembagissssss7==0){
		$rata2ssssss7=0;
		}else{
		$rata2ssssss7=$totalssssss7/$pembagissssss7;
		}
		
		$pembagissssss8=$jumlahpembagissssss8;
		if($totalssssss8==0 || $pembagissssss8==0){
		$rata2ssssss8=0;
		}else{
		$rata2ssssss8=$totalssssss8/$pembagissssss8;
		}
		
		$pembagissssss9=$jumlahpembagissssss9;
		if($totalssssss9==0 || $pembagissssss9==0){
		$rata2ssssss9=0;
		}else{
		$rata2ssssss9=$totalssssss9/$pembagissssss9;
		}
		
		$pembagissssss10=$jumlahpembagissssss10;
		if($totalssssss10==0 || $pembagissssss10==0){
		$rata2ssssss10=0;
		}else{
		$rata2ssssss10=$totalssssss10/$pembagissssss10;
		}
		
		$pembagissssss11=$jumlahpembagissssss11;
		if($totalssssss11==0 || $pembagissssss11==0){
		$rata2ssssss11=0;
		}else{
		$rata2ssssss11=$totalssssss11/$pembagissssss11;
		}
		
		$pembagissssss12=$jumlahpembagissssss12;
		if($totalssssss12==0 || $pembagissssss12==0){
		$rata2ssssss12=0;
		}else{
		$rata2ssssss12=$totalssssss12/$pembagissssss12;
		}
		
		$pembagissssss13=$jumlahpembagissssss13;
		if($totalssssss13==0 || $pembagissssss13==0){
		$rata2ssssss13=0;
		}else{
		$rata2ssssss13=$totalssssss13/$pembagissssss13;
		}
		
		$pembagissssss14=$jumlahpembagissssss14;
		if($totalssssss14==0 || $pembagissssss14==0){
		$rata2ssssss14=0;
		}else{
		$rata2ssssss14=$totalssssss14/$pembagissssss14;
		}
		//------------------------------------------------akhir tahun kategori 3 semester 2				
		 ?>
		 <tr>
                        <td align="center"><?php echo '1' ; ?></td>
                        <td align="center"><?php echo 'U1'; ?></td>
                         <td align="left"><?php echo 'PROSEDUR PELAYANAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s1,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ss1,0,5); ?></td>
						<td align="center"><?php echo substr($rata2sss1,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ssss1,0,5); ?></td>
						<td align="center"><?php echo substr($rata2sssss1,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ssssss1,0,5); ?></td>
					
                    </tr>
					 <tr>
                        <td align="center"><?php echo '2'; ?></td>
                        <td align="center"><?php echo 'U2'; ?></td>
                         <td align="left"><?php echo 'PERSYARATAN PELAYANAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s2,0,5); ?></td>
					<td align="center"><?php echo substr($rata2ss2,0,5); ?></td>
					<td align="center"><?php echo substr($rata2sss2,0,5); ?></td>
					<td align="center"><?php echo substr($rata2ssss2,0,5); ?></td>
					<td align="center"><?php echo substr($rata2sssss2,0,5); ?></td>
					<td align="center"><?php echo substr($rata2ssssss2,0,5); ?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '3'; ?></td>
                        <td align="center"><?php echo 'U3'; ?></td>
                         <td align="left"><?php echo 'KEJELASAN PETUGAS PELAYANAN'; ?></td>
                      
						
                        <td align="center"><?php echo substr($rata2s3,0,5);?></td>
					<td align="center"><?php echo substr($rata2ss3,0,5);?></td>
					<td align="center"><?php echo substr($rata2sss3,0,5);?></td>
					<td align="center"><?php echo substr($rata2ssss3,0,5);?></td>
					<td align="center"><?php echo substr($rata2sssss3,0,5);?></td>
					<td align="center"><?php echo substr($rata2ssssss3,0,5);?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '4'; ?></td>
                        <td align="center"><?php echo 'U4'; ?></td>
                         <td align="left"><?php echo 'KEDISIPLINAN PETUGAS PELAYANAN'; ?></td>
                      
						
                        <td align="center"><?php echo substr($rata2s4,0,5); ?></td>
					<td align="center"><?php echo substr($rata2ss4,0,5);?></td>
					<td align="center"><?php echo substr($rata2sss4,0,5);?></td>
					<td align="center"><?php echo substr($rata2ssss4,0,5);?></td>
					<td align="center"><?php echo substr($rata2sssss4,0,5);?></td>
					<td align="center"><?php echo substr($rata2ssssss4,0,5);?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '5'; ?></td>
                        <td align="center"><?php echo 'U5'; ?></td>
                         <td align="left"><?php echo 'TANGGUNG JAWAB PELAYANAN'; ?></td>
                       
						
                        <td align="center"><?php echo substr($rata2s5,0,5); ?></td>
					<td align="center"><?php echo substr($rata2ss5,0,5);?></td>
					<td align="center"><?php echo substr($rata2sss5,0,5);?></td>
					<td align="center"><?php echo substr($rata2ssss5,0,5);?></td>
					<td align="center"><?php echo substr($rata2sssss5,0,5);?></td>
					<td align="center"><?php echo substr($rata2ssssss5,0,5);?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '6'; ?></td>
                        <td align="center"><?php echo 'U6'; ?></td>
                         <td align="left"><?php echo 'KEMAMPUAN PETUGAS PELAYANAN'; ?></td>
                        
						
                        <td align="center"><?php echo substr($rata2s6,0,5); ?></td>
					<td align="center"><?php echo substr($rata2ss6,0,5);?></td>
					<td align="center"><?php echo substr($rata2sss6,0,5);?></td>
					<td align="center"><?php echo substr($rata2ssss6,0,5);?></td>
					<td align="center"><?php echo substr($rata2sssss6,0,5);?></td>
					<td align="center"><?php echo substr($rata2ssssss6,0,5);?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '7'; ?></td>
                        <td align="center"><?php echo 'U7'; ?></td>
                         <td align="left"><?php echo 'KECEPATAN PELAYANAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s7,0,5); ?></td>
						
                       <td align="center"><?php echo substr($rata2ss7,0,5);?></td>
                       <td align="center"><?php echo substr($rata2sss7,0,5);?></td>
                       <td align="center"><?php echo substr($rata2ssss7,0,5);?></td>
                       <td align="center"><?php echo substr($rata2sssss7,0,5);?></td>
                       <td align="center"><?php echo substr($rata2ssssss7,0,5);?></td>
					
                    </tr>
					 <tr>
                        <td align="center"><?php echo '8'; ?></td>
                        <td align="center"><?php echo 'U8'; ?></td>
                         <td align="left"><?php echo 'KEADILAN MENDAPAT PELAYANAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s8,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ss8,0,5);?></td>
						<td align="center"><?php echo substr($rata2sss8,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssss8,0,5);?></td>
						<td align="center"><?php echo substr($rata2sssss8,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssssss8,0,5);?></td>
					
                    </tr>
					 <tr>
                        <td align="center"><?php echo '9'; ?></td>
                        <td align="center"><?php echo 'U9'; ?></td>
                         <td align="left"><?php echo 'KESOPANAN DAN KERAMAHAN PETUGAS'; ?></td>
                        <td align="center"><?php echo substr($rata2s9,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ss9,0,5);?></td>
						<td align="center"><?php echo substr($rata2sss9,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssss9,0,5);?></td>
						<td align="center"><?php echo substr($rata2sssss9,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssssss9,0,5);?></td>
                    </tr>
					
					 <tr>
                        <td align="center"><?php echo '10'; ?></td>
                        <td align="center"><?php echo 'U10'; ?></td>
                        <td align="left"><?php echo 'KEWAJARAN BIAYA PELAYANAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s10,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ss10,0,5);?></td>
						<td align="center"><?php echo substr($rata2sss10,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssss10,0,5);?></td>
						<td align="center"><?php echo substr($rata2sssss10,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssssss10,0,5);?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '11'; ?></td>
                        <td align="center"><?php echo 'U11'; ?></td>
                         <td align="left"><?php echo 'KEPASTIAN BIAYA PELAYANAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s11,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ss11,0,5);?></td>
						<td align="center"><?php echo substr($rata2sss11,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssss11,0,5);?></td>
						<td align="center"><?php echo substr($rata2sssss11,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssssss11,0,5);?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '12'; ?></td>
                        <td align="center"><?php echo 'U12'; ?></td>
                         <td align="left"><?php echo 'KEPASTIAN JADWAL PELAYANAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s12,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ss12,0,5);?></td>
						<td align="center"><?php echo substr($rata2sss12,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssss12,0,5);?></td>
						<td align="center"><?php echo substr($rata2sssss12,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssssss12,0,5);?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '13'; ?></td>
                        <td align="center"><?php echo 'U13'; ?></td>
                         <td align="left"><?php echo 'KENYAMANAN LINGKUNGAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s13,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ss13,0,5);?></td>
						<td align="center"><?php echo substr($rata2sss13,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssss13,0,5);?></td>
						<td align="center"><?php echo substr($rata2sssss13,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssssss13,0,5);?></td>
                    </tr>
					 <tr>
                        <td align="center"><?php echo '14'; ?></td>
                        <td align="center"><?php echo 'U14'; ?></td>
                        <td align="left"><?php echo 'KEAMANAN PELAYANAN'; ?></td>
                        <td align="center"><?php echo substr($rata2s14,0,5); ?></td>
						<td align="center"><?php echo substr($rata2ss14,0,5);?></td>
						<td align="center"><?php echo substr($rata2sss14,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssss14,0,5);?></td>
						<td align="center"><?php echo substr($rata2sssss14,0,5);?></td>
						<td align="center"><?php echo substr($rata2ssssss14,0,5);?></td>
                    </tr>
					<tr>
                        <td align="center"><?php echo ''; ?></td>
                        <td align="center"><?php echo ''; ?></td>
                        <td align="left"><b><?php echo 'JUMALAH RATA - RATA TERIMBANG'; ?></b></td>
                        <td align="center"><b><?php 
						$ratanilais1= ($rata2s1+$rata2s2+$rata2s3+$rata2s4+$rata2s5+$rata2s6+$rata2s7+$rata2s8+$rata2s9+$rata2s10+$rata2s11+$rata2s12+$rata2s13+$rata2s14)/14;
						echo substr($ratanilais1,0,4);  ?></b></td>
						<td align="center"><b>
						<?php 
					
						$ratanilais2= ($rata2ss1+$rata2ss2+$rata2ss3+$rata2ss4+$rata2ss5+$rata2ss6+$rata2ss7+$rata2ss8+$rata2ss9+$rata2ss10+$rata2ss11+$rata2ss12+$rata2ss13+$rata2ss14)/14;
						echo substr($ratanilais2,0,4); 
						?>
						</b></td>
						<td align="center"><b>
						<?php 
					
						$ratanilais3= ($rata2sss1+$rata2sss2+$rata2sss3+$rata2sss4+$rata2sss5+$rata2sss6+$rata2sss7+$rata2sss8+$rata2sss9+$rata2sss10+$rata2sss11+$rata2sss12+$rata2sss13+$rata2sss14)/14;
						echo substr($ratanilais3,0,4); 
						?>
						</b></td>
						<td align="center"><b>
						<?php 
					
						$ratanilais4= ($rata2ssss1+$rata2ssss2+$rata2ssss3+$rata2ssss4+$rata2ssss5+$rata2ssss6+$rata2ssss7+$rata2ssss8+$rata2ssss9+$rata2ssss10+$rata2ssss11+$rata2ssss12+$rata2ssss13+$rata2ssss14)/14;
						echo substr($ratanilais4,0,4); 
						?>
						</b></td>
						<td align="center"><b>
						<?php 
					
						$ratanilais5= ($rata2sssss1+$rata2sssss2+$rata2sssss3+$rata2sssss4+$rata2sssss5+$rata2sssss6+$rata2sssss7+$rata2sssss8+$rata2sssss9+$rata2sssss10+$rata2sssss11+$rata2sssss12+$rata2sssss13+$rata2sssss14)/14;
						echo substr($ratanilais5,0,4); 
						?>
						</b></td>
						<td align="center"><b>
						<?php 
					
						$ratanilais6= ($rata2ssssss1+$rata2ssssss2+$rata2ssssss3+$rata2ssssss4+$rata2ssssss5+$rata2ssssss6+$rata2ssssss7+$rata2ssssss8+$rata2ssssss9+$rata2ssssss10+$rata2ssssss11+$rata2ssssss12+$rata2ssssss13+$rata2ssssss14)/14;
						echo substr($ratanilais6,0,4); 
						?>
						</b></td>
                    </tr>
					<tr>
                        <td align="center"><?php echo ''; ?></td>
                        <td align="center"><?php echo ''; ?></td>
                        <td align="left"><b><?php echo 'JUMLAH IKM'; ?></b></td>
                        <td align="center"><b><?php 
						//$nilais1= ($rata2s1+$rata2s2+$rata2s3+$rata2s4+$rata2s5+$rata2s6+$rata2s7+$rata2s8+$rata2s9+$rata2s10+$rata2s11+$rata2s12+$rata2s13+$rata2s14);
						$nilais1=$ratanilais1*25;
						echo substr($nilais1,0,5);  
						//echo round($nilais1);  ?></b></td>
						<td align="center"><b>
						<?php 
					
						//$nilais2= ($rata2ss1+$rata2ss2+$rata2ss3+$rata2ss4+$rata2ss5+$rata2ss6+$rata2ss7+$rata2ss8+$rata2ss9+$rata2ss10+$rata2ss11+$rata2ss12+$rata2ss13+$rata2ss14);
						$nilais2=$ratanilais2*25;
						echo substr($nilais2,0,5); 
						?>
						</b>
						</td>
						<td align="center"><b>
						<?php 
					
						//$nilais3= ($rata2sss1+$rata2sss2+$rata2sss3+$rata2sss4+$rata2sss5+$rata2sss6+$rata2sss7+$rata2sss8+$rata2sss9+$rata2sss10+$rata2sss11+$rata2sss12+$rata2sss13+$rata2sss14);
						$nilais3=$ratanilais3*25;
						echo substr($nilais3,0,5); 
						?>
						</b>
						</td>
						<td align="center"><b>
						<?php 
					
						//$nilais4= ($rata2ssss1+$rata2ssss2+$rata2ssss3+$rata2ssss4+$rata2ssss5+$rata2ssss6+$rata2ssss7+$rata2ssss8+$rata2ssss9+$rata2ssss10+$rata2ssss11+$rata2ssss12+$rata2ssss13+$rata2ssss14);
						$nilais4=$ratanilais4*25;
						echo substr($nilais4,0,5); 
						?>
						</b>
						</td>
						<td align="center"><b>
						<?php 
					
						//$nilais5= ($rata2sssss1+$rata2sssss2+$rata2sssss3+$rata2sssss4+$rata2sssss5+$rata2sssss6+$rata2sssss7+$rata2sssss8+$rata2sssss9+$rata2sssss10+$rata2sssss11+$rata2sssss12+$rata2sssss13+$rata2sssss14);
						$nilais5=$ratanilais5*25;
						echo substr($nilais5,0,5); 
						?>
						</b>
						</td>
						<td align="center"><b>
						<?php 
					
						//$nilais6= ($rata2ssssss1+$rata2ssssss2+$rata2ssssss3+$rata2ssssss4+$rata2ssssss5+$rata2ssssss6+$rata2ssssss7+$rata2ssssss8+$rata2ssssss9+$rata2ssssss10+$rata2ssssss11+$rata2ssssss12+$rata2ssssss13+$rata2ssssss14);
						$nilais6=$ratanilais6*25;
						echo substr($nilais6,0,5); 
						?>
						</b>
						</td>
						
						
					<tr>
                        <td align="center"><?php echo ''; ?></td>
                        <td align="center"><?php echo ''; ?></td>
                        <td align="left"><b><?php echo 'HURUF MUTU PELAYANAN'; ?></b></td>
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
						echo $mutu2;  ?></b></td>
						
						<td align="center"><b>
						<?php 
						if($ratanilais3 > 0 and $ratanilais3<=43.75){
						$mutu3= 'TIDAK BAIK';
						}else if ($ratanilais3 >=43.76 and $ratanilais3 <=62.50) {
						$mutu3= 'KURANG BAIK';
						}else if ($ratanilais3 >=62.51 and $ratanilais3 <=81.25) {
						$mutu3= 'BAIK';
						}else if ($ratanilais3 >=81.26) {
						$mutu3= 'SANGAT BAIK';
						}else if($ratanilais3 == 0){
						$mutu3=' - ';
						}
						echo $mutu3;  ?></b></td>
						
						<td align="center"><b>
						<?php 
						if($ratanilais4 > 0 and $ratanilais4<=43.75){
						$mutu4= 'TIDAK BAIK';
						}else if ($ratanilais4 >=43.76 and $ratanilais4 <=62.50) {
						$mutu4= 'KURANG BAIK';
						}else if ($ratanilais4 >=62.51 and $ratanilais4 <=81.25) {
						$mutu4= 'BAIK';
						}else if ($ratanilais4 >=81.26) {
						$mutu4= 'SANGAT BAIK';
						}else if($ratanilais4 == 0){
						$mutu4=' - ';
						}
						echo $mutu4;  ?></b></td>
						<td align="center"><b>
						<?php 
						if($ratanilais5 > 0 and $ratanilais5<=43.75){
						$mutu5= 'TIDAK BAIK';
						}else if ($ratanilais5 >=43.76 and $ratanilais5 <=62.50) {
						$mutu5= 'KURANG BAIK';
						}else if ($ratanilais5 >=62.51 and $ratanilais5 <=81.25) {
						$mutu5= 'BAIK';
						}else if ($ratanilais5 >=81.26) {
						$mutu5= 'SANGAT BAIK';
						}else if($ratanilais5 == 0){
						$mutu5=' - ';
						}
						echo $mutu5;  ?></b></td>
						<td align="center"><b>
						<?php 
						if($ratanilais6 > 0 and $ratanilais6<=43.75){
						$mutu6= 'TIDAK BAIK';
						}else if ($ratanilais6 >=43.76 and $ratanilais6 <=62.50) {
						$mutu6= 'KURANG BAIK';
						}else if ($ratanilais6 >=62.51 and $ratanilais6 <=81.25) {
						$mutu6= 'BAIK';
						}else if ($ratanilais6 >=81.26) {
						$mutu6= 'SANGAT BAIK';
						}else if($ratanilais6 == 0){
						$mutu6=' - ';
						}
						echo $mutu6;  ?></b></td>
                    </tr>
					<tr>
                        <td align="center"><?php echo ''; ?></td>
                        <td align="center"><?php echo ''; ?></td>
                        <td align="left"><b><?php echo 'KINERJA PELAYANAN'; ?></b></td>
                        <td align="center"><b><?php 
						if($ratanilais1 > 0 and $ratanilais1<=43.75){
						$mutu1= 'D';
						}else if ($ratanilais1 >=43.76 and $ratanilais1 <=62.50) {
						$mutu1= 'C';
						}else if ($ratanilais1 >=62.51 and $ratanilais1 <=81.25) {
						$mutu1= 'B';
						}else if ($ratanilais1 >=81.26) {
						$mutu1= 'A';
						}else if($ratanilais1 == 0){
						$mutu1=' - ';
						}
						echo $mutu1;  ?></b></td>
						<td align="center"><b>
						<?php 
					if($ratanilais2 > 0 and $ratanilais2<=43.75){
						$mutu2= 'D';
						}else if ($ratanilais2 >=43.76 and $ratanilais2 <=62.50) {
						$mutu2= 'C';
						}else if ($ratanilais2 >=62.51 and $ratanilais2 <=81.25) {
						$mutu2= 'B';
						}else if ($ratanilais2 >=81.26) {
						$mutu2= 'A';
						}else if($ratanilais2 == 0){
						$mutu2=' - ';
						}
						echo $mutu2;  ?></b></td>
						
						<td align="center"><b>
						<?php 
						if($ratanilais3 > 0 and $ratanilais3<=43.75){
						$mutu3= 'D';
						}else if ($ratanilais3 >=43.76 and $ratanilais3 <=62.50) {
						$mutu3= 'C';
						}else if ($ratanilais3 >=62.51 and $ratanilais3 <=81.25) {
						$mutu3= 'B';
						}else if ($ratanilais3 >=81.26) {
						$mutu3= 'A';
						}else if($ratanilais3 == 0){
						$mutu3=' - ';
						}
						echo $mutu3;  ?></b></td>
						
						<td align="center"><b>
						<?php 
						if($ratanilais4 > 0 and $ratanilais4<=43.75){
						$mutu4= 'D';
						}else if ($ratanilais4 >=43.76 and $ratanilais4 <=62.50) {
						$mutu4= 'C';
						}else if ($ratanilais4 >=62.51 and $ratanilais4 <=81.25) {
						$mutu4= 'B';
						}else if ($ratanilais4 >=81.26) {
						$mutu4= 'A';
						}else if($ratanilais4 == 0){
						$mutu4=' - ';
						}
						echo $mutu4;  ?></b></td>
						<td align="center"><b>
						<?php 
						if($ratanilais5 > 0 and $ratanilais5<=43.75){
						$mutu5= 'D';
						}else if ($ratanilais5 >=43.76 and $ratanilais5 <=62.50) {
						$mutu5= 'C';
						}else if ($ratanilais5 >=62.51 and $ratanilais5 <=81.25) {
						$mutu5= 'B';
						}else if ($ratanilais5 >=81.26) {
						$mutu5= 'A';
						}else if($ratanilais5 == 0){
						$mutu5=' - ';
						}
						echo $mutu5;  ?></b></td>
						<td align="center"><b>
						<?php 
						if($ratanilais6 > 0 and $ratanilais6<=43.75){
						$mutu6= 'D';
						}else if ($ratanilais6 >=43.76 and $ratanilais6 <=62.50) {
						$mutu6= 'C';
						}else if ($ratanilais6 >=62.51 and $ratanilais6 <=81.25) {
						$mutu6= 'B';
						}else if ($ratanilais6 >=81.26) {
						$mutu6= 'A';
						}else if($ratanilais6 == 0){
						$mutu6=' - ';
						}
						echo $mutu6;  ?></b></td>
                    </tr>
		 
  
                    
                       
                
               
				
	 
</table>
</html>
