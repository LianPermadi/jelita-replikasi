<script>
  $(document).ready(function() { 
  });
  
  function validasi() {
    var tgl1 = document.getElementById('inputTanggal1').value;
    var tgl2 = document.getElementById('inputTanggal2').value;
    return true;
  }
  
  function ceksumber(sumber) {
    if(sumber=='PASSPORT') {
      $("input[name=no_refer]").attr("class", 'input-wrc required');
    }else{
      $("input[name=no_refer]").attr("class", 'input-wrc required digits');
    }
  }
  
  function cheker() { 
    $('#form').validate();
    var a = document.getElementsByName("pilih_cetak[]");
    /*var b = document.getElementsByName("keaslian_syarat_wajib[]");
      var c = document.getElementsByName("keaslian_syarat_lainnya[]");
      var d = document.getElementsByName("kode_keterangan_wajib[]");
      var jml ='<?php echo $jml_syarat; ?>';
    */
    var group ='<?php echo $group; ?>';
    var total=0;
    for(var i=0; i < jml; i++){
      if(a[i].checked) {
        total++;
      }
    }
    if(validasi()==false) {
      document.forms[0].submit.disabled=true;
    }else{
      if(total == jml || group == 3) {
        document.forms[0].submit.disabled=false;
        $('#coba').html('');
        //$('#test').html('');
      }else{
        document.forms[0].submit.disabled=true;
        $('#coba').html("<p id='eror'>* Lengkapi Persyaratan Untuk Mengaktifkan Tombol Simpan</p>");
      }
    }
  }
    
  window.onload = cheker;
  $(function() {
    var validator = $('#form').validate();
    var tabs = $( "#tabs" ).tabs({
      select: function(event, ui){
        var valid = true;
        var current = $(this).tabs("option","selected");
        $('#form').find(':input.required, select.notSelect').each(function(){
          console.log(valid);
          if(!validator.element(this) && valid){
            valid = false;     
          }
        });
        if(valid == false){
          $('#test').html('Data Belum Lengkap, Silahkah Diisi');
        }else{
          $('#test').html('');
        }               
      }
    });
  });
</script>

<style>
  #eror {
    color:#FF0000;
    font-weight:bold;
    text-align:center;
  }
  
  #eror1 {
    color:#FF0000;
    font-weight:bold;
  }
  
  .field_error {
    color:#FF0000;
    position:relative;
    font-size: 9px;
    margin: -4% 0 0 74%;
    padding: 0 0 2% 0 ;
  }
</style>

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <?php
    $attr = array('class' => 'searchForm',
                  'id' => 'searchForm');
    //$attr = array('name' => 'form', 'id' => 'form', 'onsubmit' => 'return validasi()');
    $attr = array('name' => 'form', 'id' => 'form');
    echo form_open('pendataan/print_pertek', $attr);
    if($lokasi == 'OPD Teknis') {
      $lihat = FALSE;
    }else{
      $lihat = TRUE;
    }
    ?>
  
    <div style="text-align:right">
      <?php
      $add_daftar = array('name' => 'submit',
                          'class' => 'submit-wrc',
                          'content' => 'APPROVE',
                          'type' => 'submit',
                          'value' => 'APPROVE');
      
      $kembali = array('name' => 'button',
                       'class' => 'submit-wrc',
                       'content' => 'Kembali',
                       'value' => 'Kembali',
                       'onclick' => 'parent.location=\''. site_url('pendataan') . '\'');
      
      if($lihat) echo form_submit($add_daftar);
      echo form_button($kembali);
      ?>
    </div>
    
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="cetakizin">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="9%">No Pendaftaran<br>Tanggal Permohonan<br>Asal Permohonan</th>
            <th width="25%">Nama Pemohon<br>Alamat Pemohon</th>
            <th width="25%">Nama Perusahaan<br>Alamat Perusahaan</th>
            <th width="34%">Jenis Izin<br>Objek Izin</th>
            <!--<th width="9%">No Per.Pertek<br>Tgl Per.Pertek</th>-->
            <th width="8%">Cetak</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
                    
          //if($lihat) {
          foreach ($list as $data) {
            $entry_data = new tmpermohonan_tmproperty_jenisperizinan();
            $jumlah_entry = $entry_data->where('tmpermohonan_id', $data->id)->count();
            $kelompok = new trkelompok_perizinan_trperizinan();
            $kelompok->where('trperizinan_id', $data->idizin)->get();
            
            $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
            $permohonan_perusahaan->where('tmpermohonan_id', $data->id)->get();
            $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
            $perusahaan = new tmperusahaan();
            $perusahaan->where('id', $perusahaan_id)->get();
            $n_perusahaan = $perusahaan->n_perusahaan;
            $a_perusahaan = $perusahaan->a_perusahaan;

            if($data->dt_teknis1 == '') $cek_teknis = FALSE; else $cek_teknis = TRUE;
            $ctk=FALSE;
            if($jumlah_entry || $cek_teknis) {
              if($group <> "4" && $kelompok->trkelompok_perizinan_id != '1' 
                               && $kelompok->trkelompok_perizinan_id != '3'
                               && $kelompok->trkelompok_perizinan_id != '5' // Evaluator dan kelompok tanpa tinjauan lapangan
                               || $data->indeks == 'AKDP'){//|| ($data->kd_izin == '051011' || $data->kd_izin == '051012' || $data->kd_izin == '051013' )){ // Untuk AKDP 
                $ctk=TRUE;
                $i++;
              }
            }
            $b = ''; $be = '';
            
            if($ctk){
              ?>
              <tr>
                <td valign='top'><?php echo $i; ?></td>
                <td valign='top'><?php 
                  //echo $b . '' .$be; 
                  echo $data->pendaftaran_id."<br>";
                  if($data->idjenis == '1') $tgl_permohonan = $data->d_terima_berkas; 
                  else if($data->idjenis == '2') $tgl_permohonan = $data->d_perubahan;
                  else if($data->idjenis == '3') $tgl_permohonan = $data->d_perpanjangan;
                  else if($data->idjenis == '4') $tgl_permohonan = $data->d_daftarulang;
                  if($tgl_permohonan){
                    if($tgl_permohonan != '0000-00-00') echo $this->lib_date->mysql_to_human($tgl_permohonan)."<br>";
                  }
                  echo $data->kd_gerai;
                  ?>
                </td>
                <td valign='top'><?php echo $b.$data->n_pemohon.'<br>'.$data->a_pemohon.$be; ?></td>
                <!--<td valign='top'><?php echo $b.$data->n_perusahaan.'<br>'.$data->a_perusahaan.$be; ?></td> -->
                <td valign='top'><?php echo $b.$n_perusahaan.'<br>'.$a_perusahaan.$be; ?></td>
                <td valign='top'><?php echo $b.$data->n_perizinan.'<br>'.$data->a_izin.$be; ?></td>
                <!--<td valign='top'>
                  <?php
                    if($data->no_per_pertek == '') {
                      $no_pertek = '-';
                  	}else{
                      $no_urut_pertek = $data->no_per_pertek;
                          $i_urut = strlen($no_urut_pertek);
                                          for ($i = 5; $i > $i_urut; $i--) {
                                              $no_urut_pertek = "0" . $no_urut_pertek;
                                          }
                  		$no_pertek = $no_awal_pertek.$no_urut_pertek.$no_akhir_pertek;
                  	}
                  	if($data->tg_per_pertek == '0000-00-00 00:00:00') 
                  		$tg_pertek = '-';
                  	else 
                  		$tg_pertek = $this->lib_date->mysql_to_human($data->tg_per_pertek);
                    echo $b.$no_pertek.'<br>'.$tg_pertek.$be.$be; 
                  ?>
                </td>-->
                <td valign='top'><?php
                  $set = array('name' => 'pilih_cetak[]',
                               'id' => 'chek',
                               'value' => $data->id,
                               'checked' => $checked,
                               'onClick' => 'cheker()');
                	if($data->bid_teknis == '') echo 'BIDANG BELUM VALID'.'<br>';
                	if($data->no_per_pertek == '' && $data->bid_teknis != ''){
                	  echo "<center>".form_checkbox($set)."</center>";
                	}
                  ?>
                </td>
              </tr>
              <?php
            }
          }
          //}
          ?>
        </tbody>
      </table>
    </div>
    <div style="text-align:right">
      <?php
      $add_daftar = array('name' => 'submit',
                          'class' => 'submit-wrc',
                          'content' => 'APPROVE',
                          'type' => 'submit',
                          'value' => 'APPROVE');
      $kembali = array('name' => 'button',
                       'class' => 'submit-wrc',
                       'content' => 'Kembali',
                       'value' => 'Kembali',
                       'onclick' => 'parent.location=\''. site_url('pendataan') . '\'');
      if($lihat) echo form_submit($add_daftar);
      echo form_button($kembali);
      ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>