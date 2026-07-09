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
    <title>Realisasi Penerimaan</title>
  </head>
  <!--<body onLoad="window.print()">-->
  <body>
    <div id="content">
      <div class="post">
        <div class="title" align="center">
          <?php
          if($lokasi == 'OPD Teknis'){
            $bidangizin=$cek_sektor;
          }else{
            $bidangizin=$this->input->post('id');
          }
          $q = "Select * from trsektor where id='$bidangizin' ";
          $exe = mysql_query($q);
          while($row = mysql_fetch_assoc($exe)){
            if($row >0) $a=$row['n_sektor'];
            ?>
            <div align="center">
          	  <h2>
          	    <b>
          	      <?php 
          	      echo $page_name . $a;
                  echo br();
                  echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." s/d ".$this->lib_date->mysql_to_human($tglb);
                  ?>
          	    </b>
          	  </h2>
          	</div>
            <?php
          }
          ?>
        </div>
        <form name="form1" method="post">
          <!--<fieldset>-->
          <table align=left>
            <tr>
              <td align="center">
                <?php
                $Back_data = array('src' => base_url().'assets/images/icon/back_alt.png',
                                   'alt' => 'Lihat di HTML to Openoffice',
                                   'title' => 'Kembali',
                                   'onclick' => 'parent.location=\''. site_url('durasiizin/izin'). '\''
                                  );
                echo img($Back_data);
                $img_cetak = array('src' => base_url().'assets/images/icon/excel.png',
                                   'alt' => 'Cetak ke Ms Excel',
                                   'title' => 'Cetak Ke Ms Excel',
                                   'onclick' => 'parent.location=\''. site_url('durasiizin/izin/leizin').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                                  );
                echo img($img_cetak);
                ?>
              </td>
            </tr>
          </table>
          <!--<table cellpadding="1" cellspacing="0" border="0" class="display" id="reportgrid">-->
          <table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
            <thead>
              <tr class="title">
                <th width="3%" rowspan="2"><font  size="2" color="#1A1A1A"><b>No</b></font></th>
                <th width="62%" rowspan="2"><font  size="2" color="#1A1A1A"><b>Jenis Izin</b></font></th>
                <th width="7%" rowspan="2"><font  size="2" color="#1A1A1A"><b>Jumlah selesai</b></font></th>
                <th width="14%" colspan="2"><font  size="2" color="#1A1A1A"><b>Durasi</b></font></th>
                <th width="7%" rowspan="2"><font  size="2" color="#1A1A1A"><b>Jmlh Sesuai Durasi</b></font></th>
                <th width="7%" rowspan="2"><font  size="2" color="#1A1A1A"><b>Tingkat <?php echo br();?> Penyelesaian</b></font></th>
              </tr>
              <tr class="title">
                <th><font width="7%" size="2" color="#1A1A1A"><b>Rata-Rata Proses Izin</b></font></th>
                <th><font width="7%" size="2" color="#1A1A1A"><b>Target Durasi</b></font></th>
              </tr>
            </thead>
            <!---------------------------------------------------------------------------------------------------.-->
            <?php
            //  $bidangizin=$sektor_id;
            $i = NULL;
            $rata=0;
            $hari=0;
            $query_data = "select a.id,a.v_hari,a.n_perizinan, a.v_perizinan jumlah from trperizinan a
                           inner join trperizinan_trsektor b on a.id = b.trperizinan_id where b.trsektor_id='$bidangizin'";
            $results = mysql_query($query_data);
            while($data = mysql_fetch_assoc(@$results)){
              $izinjenis=$data['n_perizinan'];
              $i++;
              $jumlah_masuk = 0;
              $ttsesuai=0;
              $jumlah_terbit = 0;
              $terbit_ambil = 0;
              $terbit_proses = 0;
              $jumlah_tolak = 0;
              $tolak_ambil = 0;
              $tolak_proses = 0;
              $totals=0;
              $totrealisasi=0;
              $totk=0;
              $jumlah_proses = 0;
              $ttselesai=0;
              $ttjumlahdurasi=0;
              $tt=0;
              $total_sesuai=0;
              //$persen=0;
              $query = "select  a.id jumlah from tmpermohonan a
                        inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                        LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                        LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                        where b.trperizinan_id = '".$data['id']."'
                        and t7.id <> 1 
                        and a.d_terima_berkas between '$tgla' and '$tglb' AND a.status_berkas != 'Izin Ditolak FO'";
              $hasil_data = mysql_query($query);
              $jumlah_masuk = mysql_num_rows(@$hasil_data);
              $query2 = "select  a.id, a.c_izin_selesai, d.c_penetapan, d.status_bap, a.d_selesai_proses,i.tgl_surat,i.tgl_surat_edit,a.d_terima_berkas from tmpermohonan a
                         inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                         inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                         inner join tmbap d on d.id = c.tmbap_id
                         inner join trperizinan e on e.id = b.trperizinan_id
                         inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
                         inner join tmsk i on h.tmsk_id = i.id
                         LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                         LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                         where b.trperizinan_id = '".$data['id']."' and d.c_penetapan = 1
                         and t7.id <> 1 
                         and a.d_terima_berkas between '$tgla' and '$tglb' AND a.status_berkas != 'Izin Ditolak FO' and status_bap=1";
              $hasil_data2 = mysql_query($query2);
              while($rows_data2 = mysql_fetch_assoc(@$hasil_data2)){
                if($rows_data2['status_bap'] == "1"){
                  $jumlah_terbit++;
                  if($rows_data2['c_izin_selesai'] == "1") $terbit_ambil++;
                  else $terbit_proses++;
                }else if($rows_data2['status_bap'] == "2"){
                  $jumlah_tolak++;
                  if($rows_data2['c_izin_selesai'] == "1") $tolak_ambil++;
                  else $tolak_proses++;
                }
                $tanggal1=$rows_data2['d_terima_berkas'];
                $tanggalselesai1=$rows_data2['tgl_surat'];
                //echo $tanggalselesai1;
                $tanggalselesai2=$rows_data2['tgl_surat_edit'];
                //echo $tanggalselesai2;
                if($tanggalselesai2=='0000-00-00'){
                  $tanggal2=$rows_data2['tgl_surat'];
                }else{
                  $tanggal2=$rows_data2['tgl_surat_edit'];
                }
                //----------------holiday---------------------------------------
                $qholiday="select count(date) libur from tmholiday where date between '$tanggal1' and '$tanggal2'";
                $exeholiday = mysql_query($qholiday);
                while($rowholiday = mysql_fetch_assoc($exeholiday)){
                	$holidayperizin = $rowholiday['libur'];
                	$date1 = new DateTime($tanggal2); 
                	$date2 = new DateTime($tanggal1); 
                	$interval = $date2->diff($date1);
                	$selisihhari = $interval->format('%R%a');
                	$sharilibur = substr($selisihhari, 1,5);
                	if($tanggal2=="0000-00-00"){
                	  $realisasi = $data['v_hari'];
                	}else{
                	  $realisasi = $sharilibur - $holidayperizin;
                  }
                  if($realisasi <= $data['v_hari'] ){
                    $sesuai = $realisasi <= $data['v_hari'];
                    $tot=count($sesuai);
                    $tt +=$tot;
                  }else{
                  }
             	  }
                //echo $realisasi.'/';
                 $totrealisasi+=$realisasi;
                if($jumlah_terbit==""){
                }else if($jumlah_terbit !="" && $totrealisasi==0){
                  $rata = 1;
                }else{
                  $rata = $totrealisasi /($jumlah_terbit); 
                }
                //$rata = $totrealisasi /($jumlah_terbit + $jumlah_tolak);
              }
              //------------------akhir holiday
              $hari = $data['v_hari'];
              //echo $hari;
              //$jumlah_selesai = $jumlah_terbit + $jumlah_tolak;
              $jumlah_selesai = $jumlah_terbit;
              if($jumlah_selesai==0 or $tt==0){
                $persenrata=0;
              }else{
                $persenrata=$tt/$jumlah_selesai*100;
              }
              ?>
              <tr>
                <td align="center"><font   color="#1A1A1A"><?php echo $i; ?></td>
                <td><font color="#1A1A1A"><?php echo $data['n_perizinan']; ?></td>
                <td align="center"><font  color="#1A1A1A"><?php echo $jumlah_selesai; ?></td>
                <td align="center"><font  color="#1A1A1A"><?php echo round($rata) ; echo ' Hari'; ?></td>
                <td align="center"><font  color="#1A1A1A"><?php echo $hari; echo ' Hari'; ?></td>
                <td align="center"><font  color="#1A1A1A"><?php echo intval($tt); ?></td>
                <!--<td align="center"><?//php echo intval($k); ?></td>-->
                <td align="center"><font  color="#1A1A1A"><?php echo round($persenrata) ; echo ' %'; ?></td>
                <!--<td align="center"><?//php echo round($ptr) ; echo ' %'; ?></td>-->
              </tr>
              <?php
              $rata=0;
              //selesai
              $tot=$jumlah_selesai;
              $ttselesai +=$tot;
              $jum[]=$ttselesai;
              $a=array_sum($jum);
              $total_selesai = number_format($a);
              		
              //sesuai
              $totsesuai=$tt;
              $ttsesuai +=$totsesuai;
              $jumsesuai[]=$ttsesuai;
              $asesuai=array_sum($jumsesuai);
              $total_sesuai = number_format($asesuai);
            }					
            /* //sesuai durasi
              $totjumlahdurasi=$t;
              $ttjumlahdurasi +=$totjumlahdurasi;
              $jum2[]=$ttjumlahdurasi;
              $b=array_sum($jum2);
              		
              $total_jumlahdurasi = round($b);
              		
              //persen durasi
              if(empty($total_jumlahdurasi) || empty($total_selesai) ){
                $total_persen=0;
                }else{
                  $total_persen = round(($total_jumlahdurasi/$total_selesai)*100);
                }
                if ($data['n_perizinan']==null){
                  $total_persen = 0;
                }
              }
              $totsemua=100-round($total_persen);
            */  
            //if($data['n_perizinan']==0){
            //}else{
            //echo $izinjenis;
            ?>
            <!---------------------------------------------------------------------------------------------------.-->
            <tr bgcolor="#d5dffe">
              <td align="center"><font   color="#1A1A1A"><?php //echo $i+1; ?></b></td>
              <td align="center"><font  color="#1A1A1A"><b><?php echo 'TOTAL' ?></b></td>
              <td align="center"><font  color="#1A1A1A"><b><?php echo $total_selesai; ?></b></td>
              <td align="center"><font  color="#1A1A1A"><b><?php echo '-'; ?></b></td>           
              <td align="center"><font   color="#1A1A1A"><b><?php echo '-'; ?></b></td>
              <td align="center"><font  color="#1A1A1A"><b><?php echo $total_sesuai; ?></b></td>
              <?
              if($total_sesuai==0 or $total_selesai==0){
                $totalpersen=0;
              }else{					
                $totalpersen = $total_sesuai/$total_selesai*100;
              }
              ?>
              <!--<td align="center"><b><?//php echo $totals ?></b></td>-->
              <!--<td align="center"><font  size="12px" color="#1A1A1A"><b><?php echo round($totalpersen) ; echo ' %'; ?></b></td>-->
              <!--<td align="center"><b><?//php echo $totsemua ; echo ' %'; ?></b></td>-->
              <?		
              //	}
              ?>
              <td align="center"><font color="#1A1A1A">
                <b>
                  <?php
                  if($total_sesuai != 0){
                   // echo round((int)$total_sesuai/(int)$total_selesai*100); echo ' %';
				 echo round(str_replace(',', '', $total_sesuai)/str_replace(',', '', $total_selesai)*100); echo '%';
                  }else{
                  	echo '0 %';
                  }
                  ?>
                </b>
              </td>
            </tr>
          </table>
          <!--</fieldset>-->
        </form>
        <?php echo br();?>
      </div>
    </div>
  </body>
</html>
