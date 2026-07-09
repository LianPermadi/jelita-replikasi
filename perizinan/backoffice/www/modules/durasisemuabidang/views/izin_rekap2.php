
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
<title>Ketepatan Penyelesaian perizinan</title>
</head>
<!--<body onLoad="window.print()">-->
<body>
    <div id="content" style="width: 800px;">
    <div class="post">
        <div class="title" align="center">
		<?php
		
		$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
            <h2><b><?php //echo $page_name; echo br(); 
			echo 'Daftar Izin Selesai Bidang '; echo $a; ?></b></h2>
			
		
		
		<div align="center"><b><?php //echo 'Jumlah Izin Selesai Bidang :  '; echo $a;?></b></div>
		<?php
		}
		?>
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center"><b>
             <?php
			 echo br();
            echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
             echo br(2);
			?>
          </legend></b>
 <table  width="100%">
        <tr align="center">
            <td align="center">
           <?php
          $img_cetak = array(
                            'src' => base_url().'assets/images/icon/word.png',
                            'alt' => 'Cetak ke Ms Word',
                            'title' => 'Cetak ke Ms Word',
                           'onclick' => 'parent.location=\''. site_url('durasisemuabidang/lwperbidang').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        echo img($img_cetak);
      
           $img_cetak = array(
                            'src' => base_url().'assets/images/icon/excel.png',
                            'alt' => 'Cetak ke Ms Excel',
                            'title' => 'Cetak Ke Ms Excel',
                            'onclick' => 'parent.location=\''. site_url('durasisemuabidang/leperbidang').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        echo img($img_cetak);
		 ?>
</td><td>
			 <?php
			 
		 //$b= $this->input->post('tgla');
		   //echo form_open('pengaduantriwulan/lwpengaduantriwulan/triwulan');
		   //echo form_hidden('tgla',$b);
                   // $excel = array(
                   //'src' => base_url().'assets/images/icon/excel.png',
                    //'alt' => 'cetak ke excel',
                    //'title' => 'cetak ke excel',
					//'class' => 'button-wrc',
					//'type'=>'submit',
					//'value'=>'cetak to word'
                    //'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lwpengaduantriwulan/triwulan'). '\''
                    //);
					
                    //echo form_submit($excel);
					//echo form_close();
					?>
					</td><td>
					<?php
					 //echo form_open('durasiizin/lwdurasiizin/lword');
					 //echo form_hidden('bidangizin',$this->input->post('id'));
		   //echo form_hidden('tgla',$tgla);
		   //echo form_hidden('tglb',$tglb);
			//		$word = array(
              //     'src' => base_url().'assets/images/icon/excel.png',
                    //'alt' => 'cetak ke excel',
                    //'title' => 'cetak ke excel',
				//	'class' => 'button-wrc',
					//'type'=>'submit',
					//'value'=>'cetak to excel'
                    //'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lwpengaduantriwulan/triwulan'). '\''
                    //);
                    //echo form_submit($word);
            ?>
            </td>
        </tr>
		
		
    </table>
	
	
     <table cellpadding="1" cellspacing="0" border="0" class="display" id="reportgrid">
        <thead>
		<tr class="title">
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jenis Izin</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jumlah selesai</b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b>Durasi</b></font></th>
          
           
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jmlh Sesuai Durasi</b></font></th>
		   <!--<th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jmlh Tidak Sesuai Durasi</b></font></th>-->
		   <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Persen Penyelesaian</b></font></th>
		   <!--<th rowspan="2"><font  size="1" color="#1A1A1A"><b>Persen Keterlambatan</b></font></th>-->
     </tr>
     <tr>
           <th><font  size="1" color="#1A1A1A"><b>rata - rata Durasi</b></font></th>
           <!-- <th><font  size="1" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="1" color="#1A1A1A"><b>Belum Diambil</b></font></th>-->
           <th><font  size="1" color="#1A1A1A"><b>Target Durasi</b></font></th>
           <!-- <th><font  size="1" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="1" color="#1A1A1A"><b>Belum Diambil</b></font></th>
    </tr>-->
    </tr></thead>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			   //$bidangizin=$this->input->post('id');
                   
					$i = NULL;
                    $query_data = "
					select a.id,a.v_hari,a.n_perizinan, a.v_perizinan jumlah from trperizinan a
                                 inner join trperizinan_trsektor b on a.id = b.trperizinan_id where b.trsektor_id='$bidangizin'";
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
                        $i++;
                        $jumlah_masuk = 0;
                        $jumlah_terbit = 0;
                        $terbit_ambil = 0;
                        $terbit_proses = 0;
                        $jumlah_tolak = 0;
                        $tolak_ambil = 0;
                        $tolak_proses = 0;
						$totals=0;
$totk=0;
                        $jumlah_proses = 0;
						$ttselesai=0;
						$ttjumlahdurasi=0;
                        //$persen=0;
                        $query = "select  a.id jumlah from tmpermohonan a
                                 inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                 LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                 LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
								 
                                 where b.trperizinan_id = '".$data['id']."'
                                 and t7.id <> 1 
                                 and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_data = mysql_query($query);
                        $jumlah_masuk = mysql_num_rows(@$hasil_data);
                        $query2 = "select  a.id, a.c_izin_selesai, d.c_penetapan, d.status_bap, a.d_selesai_proses,a.d_terima_berkas from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where b.trperizinan_id = '".$data['id']."' and d.c_penetapan = 1

                                and t7.id <> 1 

                                and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_data2 = mysql_query($query2);
                        while ($rows_data2 = mysql_fetch_assoc(@$hasil_data2)){
						
                            if($rows_data2['status_bap'] == "1"){
                                $jumlah_terbit++;
                                if($rows_data2['c_izin_selesai'] == "1") $terbit_ambil++;
                                else $terbit_proses++;
                            }else if($rows_data2['status_bap'] == "2"){
                                $jumlah_tolak++;
                                if($rows_data2['c_izin_selesai'] == "1") $tolak_ambil++;
                                else $tolak_proses++;
                            }
                        }
						
                        $jumlah_proses = $jumlah_masuk - ($jumlah_terbit + $jumlah_tolak);
						//$persen= 100*($jumlah_terbit / $jumlah_tolak);
						if( $jumlah_terbit != 0  or $jumlah_tolak != 0 or $jumlah_masuk!=0 ){
 $persen=(( $jumlah_terbit + $jumlah_tolak)/$jumlah_masuk)*100;
					}elseif( $jumlah_terbit == 0  && $jumlah_tolak == 0 ){
    $persen = 0;
} ;
$jumlah_selesai = $jumlah_terbit + $jumlah_tolak;

$hari = $data['v_hari'];
$tanggal1=$rows_data2['d_terima_berkas'];
$tanggal2=$rows_data2['d_selesai_proses,'];?>
<?php 
//echo $tanggal1; 


//rata2 tanggal

$id2=$data['id'];

				   $q3 = "select  a.id, a.c_izin_selesai, e.n_perizinan,e.v_hari,AVG(DATEDIFF(a.d_selesai_proses,a.d_terima_berkas)) rata,
				   SUM(DATEDIFF(a.d_selesai_proses,a.d_terima_berkas)<=e.v_hari) tepat from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
				inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
where d.c_penetapan = 1 and e.id='$id2' and a.d_terima_berkas between '$tgla' and '$tglb'";
                    $exe3 = mysql_query($q3);
                   
                    while($row3 = mysql_fetch_assoc($exe3)){
					if($row3 >0){
					
         $t=$row3['tepat'];
		 $rt=$row3['rata'];
		 
		
	//$ps=$row['persensesuai'];
		 }}
		 if($jumlah_selesai !=0 && $t !=0){
		 $ps= $t/$jumlah_selesai*100 ;
		 }else if($jumlah_selesai ==0 || $t ==0){
		 $ps=0;
		 }
		 if($ps==0){
		 $ptr=0;
		 }else{
		 $ptr=100-round($ps);
}
 if($t==0){
		 $k=0;
		 }else{
		 $k=$jumlah_selesai -$t;
		 $totk=$totk+$k;
		 }
		 
		 
		 ?>
  
                    <tr>
                        <td align="center"><?php echo $i; ?></td>
                        <td><?php echo $data['n_perizinan']; ?></td>
                        <td align="center"><?php echo $jumlah_selesai; ?></td>
                        <td align="center"><?php echo round($rt) ; echo ' Hari'; ?></td>
                      
                        <td align="center"><?php echo $hari; echo ' Hari'; ?></td>
                     
                        <td align="center"><?php echo intval($t); ?></td>
						<!--<td align="center"><?//php echo intval($k); ?></td>-->
                        <td align="center"><?php echo round($ps) ; echo ' %'; ?></td>
						<!--<td align="center"><?//php echo round($ptr) ; echo ' %'; ?></td>-->
					
                    </tr>
                <?php
				//selesai
                        $tot=$jumlah_selesai;
						$ttselesai +=$tot;
				$jum[]=$ttselesai;
						$a=array_sum($jum);
						
						$total_selesai = number_format($a);
						
						//sesuai durasi
						
				 $totjumlahdurasi=$t;
						$ttjumlahdurasi +=$totjumlahdurasi;
				$jum2[]=$ttjumlahdurasi;
						$b=array_sum($jum2);
						
						$total_jumlahdurasi = round($b);
					
						//persen durasi
						if($total_jumlahdurasi== 0 || $total_selesai==0){
						$total_persen=0;
						}else{
					
						$total_persen = round(($total_jumlahdurasi/$total_selesai)*100);
					}
					if ($data['n_perizinan']==null){
					$total_persen = 0;
					}
                    }
					
					$totsemua=100-round($total_persen);
                ?>
				
<!---------------------------------------------------------------------------------------------------.-->
   
	 
	  <tr bgcolor="#d5dffe">
                        <td align="center"><?php echo $i+1; ?></b></td>
                        <td align="center"><b><?php echo 'TOTAL' ?></b></td>
						
                        <td align="center"><b><?php echo $total_selesai; ?></b></td>
                        <td align="center"><b><?php echo '-'; ?></b></td>           
                        <td align="center"><b><?php echo '-'; ?></b></td>
                        <td align="center"><b><?php echo $total_jumlahdurasi; ?></b></td>
						<?$totals = $total_selesai - $total_jumlahdurasi;?>
						 <!--<td align="center"><b><?//php echo $totals ?></b></td>-->
                        <td align="center"><b><?php echo $total_persen ; echo ' %'; ?></b></td>
						<!--<td align="center"><b><?//php echo $totsemua ; echo ' %'; ?></b></td>-->
					
                    </tr>
</table>
         </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
