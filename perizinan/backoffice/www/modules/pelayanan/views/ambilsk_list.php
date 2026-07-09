<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/addSMSGateway/jquery.ui.dialog.js"></script>
<form id="smsdialog" action="<?php echo base_url(); ?>pelayanan/ambilsk/sendSMSGateway" method="post" style="display:none">
  Apa anda yakin akan mengirim SMS ke no ini ?<br />
  <b>No Telp :</b><span id="spanno"></span><input type="hidden" size="15" maxlength="15" id="txtno" name="txtno" value=""  />
  <input type="hidden" name="txtisi" id="txtisi" value=""  /><br />
  <input type="submit" value="Kirim" name="tblkirim" id="tblkirim"  />&nbsp;&nbsp;
  <input type="reset" value="Batal" name="tblreset" id="tblreset"  />
  <span id="warning"></span>
</form>

<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
  
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Nomor Pendaftaran</legend>
        <?php echo form_open('pelayanan/ambilsk'); ?>
        <div id="statusRail">
          <div id="rightRail">
            <div id="leftRail">
              <?php echo form_label('Nomor Pendaftaran', 'kt_cari');?>
            </div>
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
            <?php
            $cari_data = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => 'Cari Data',
                               'value' => 'Cari Data'
                              );
            echo form_submit($cari_data);
            ?>
          </div>
        </div>
        <?php
        echo form_hidden('kd_filter', '1');
        echo form_close();
        ?>
      </fieldset>
    </div>
    
    <div class="entry">
      <fieldset>
        <legend>Filter Data Berdasarkan Tanggal</legend>
        <?php echo form_open('pelayanan/ambilsk'); ?>
        <div id="statusRail">
          <div id="leftRail">
                    <?php echo form_label('Tgl Permohonan Awal','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
                                       'class' => 'monbulan'
                                      );
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tgl Permohonan Akhir','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan'
                                       );
            echo form_input($periodeakhir_input);
    	      echo ' ';
    	      $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter'
                                );
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php
    	  echo form_hidden('kd_filter', '2');
        echo form_close();
        ?>
      </fieldset>
    </div>
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="penyerahan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="10%">No Pendaftaran<br>Tanggal Daftar<br>Asal Permohonan</th>
            <th width="20%">Nama Pemohon<br>Nama Perusahaan</th>
            <th width="23%">Jenis Izin</th>
            <th width="23%">Objek Izin</th>
    		    <th width="18%">Nomor SK<br>Tanggal SK</th>
            <th width="4%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $results = mysql_query($list);
          while($rows = mysql_fetch_assoc(@$results)){
            $status_bap = $rows['status_bap'];
            $no_surat = $rows['no_surat'];
    		    $i_ok='T';
    		    if($no_surat == 'Ditolak') $i_ok='F';
    		    if($rows['no_surat_edit'] == '') {
              $tgl_surat = $rows['tgl_surat'];
    		    }else{
              $no_surat = $rows['no_surat_edit'];
              $tgl_surat = $rows['tgl_surat_edit'];
    		    }
            $c_cetak = $rows['c_cetak'];
            $idkelompok = $rows['idkelompok'];
    		    $s_serah = $rows['siap_serah'];
    		    $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
            $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
    	      $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
    		    $perusahaan = new tmperusahaan();
    		    $perusahaan->where('id', $perusahaan_id)->get();
    		    $n_perusahaan = $perusahaan->n_perusahaan;
    		    $e_mail = $perusahaan->email;
    		    if($e_mail == '') $e_mail = '-'; 
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php 
    		        echo $rows['pendaftaran_id'].'<br>';
                if($rows['idjenis'] == '1') $tgl_permohonan = $rows['d_terima_berkas'];
                else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                if($tgl_permohonan){
                  if($tgl_permohonan != '0000-00-00') echo $this->lib_date->mysql_to_human($tgl_permohonan).'<br>';
                }
    				    echo $rows['kd_gerai'];
    	          ?>
    			    </td>
              <td><?php echo $rows['n_pemohon'] .'<br>'. $n_perusahaan; ?></td>
              <td><?php echo $rows['n_perizinan'];?></td>
              <td>
                <?php 
    		        if($rows['keterangan'] == '')
    		          echo $rows['a_izin'];
    	          else
    	            echo $rows['a_izin'].'<br>[ Ket : '.$rows['keterangan'].' ]';
    	          ?>
              </td>
              <!--<td><?php echo $no_surat;?></td>-->
              <td><?php
    			      echo $no_surat . '<br>';
                if($tgl_surat){
                  if($tgl_surat != '0000-00-00') echo $this->lib_date->mysql_to_human($tgl_surat);
                }
                ?>
    			    </td>
              <td nowrap="nowrap">
                                <?php
    			    	$confirm_text = 'Apakah Anda Yakin Izin / Berkas Siap Diserahkan?';
                $img_aktif1 = array('src' => base_url().'assets/images/icon/tick.png',
                                    'alt' => 'Izin / Berkas Siap Diserahkan',
                                    'title' => 'Izin / Berkas Siap Diserahkan',
                                    'border' => '0',
                                    'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                   );
              
                $confirm_text = 'Apakah Anda Yakin Izin / Berkas Akan Diserahkan?';
                $img_aktif2 = array('src' => base_url().'assets/images/icon/tick.png',
                                    'alt' => 'Penyerahan Izin / Berkas',
                                    'title' => 'Penyerahan Izin / Berkas',
                                    'border' => '0',
                                    //'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                   );
              
                $confirm_text = 'Apakah Anda Yakin Mengirim SMS Surat Izin?';
                $img_aktif3 = array('src' => base_url().'assets/images/icon/smartphone_key.png',
                                    'alt' => 'Kirim Ulang SMS & e-mail',
                                    'title' => 'Kirim Ulang SMS & e-mail',
                                    'border' => '0'
                                   );
              
                if($s_serah == 'TIDAK') {
                  echo anchor(site_url('pelayanan/ambilsk/siap_diserahkan') .'/1/'. $rows['id'].'/'.$i_ok, img($img_aktif1))."&nbsp;"; // 1 = pertama kali
    			    	}else{
                  if($status_bap == 2 || $rows['c_status_bayar'] == 1 || $idkelompok !== '4') {
    			    	    echo anchor(site_url('pelayanan/ambilsk/input_data').'/'.$rows['id'].'/'.$rows['idizin'],img($img_aktif2), 'class="link2-wrc"');
    			    	    $pesan = "DPMPTSP: Izin dg no pendaftaran: " . $rows['pendaftaran_id'];
    			    	    if($i_ok=='T')
                      $pesan .= ' DISETUJUI, dan bisa di ambil di tempat anda mendaftar';
                    else
                      $pesan .= ' DITOLAK, mohon utk mengambil berkas permohonan di tempat anda mendaftar';
    			    	    echo anchor(site_url('pelayanan/ambilsk/siap_diserahkan') .'/2/'. $rows['id'].'/'.$i_ok, img($img_aktif3)); // 2 info berikut
                  }
    			    	}
                ?>
              </td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
    
    <!-- Create PBS -->
    <?php
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->session->userdata('lokasi');
    ?>
    <div class="post">
      <div class="title" style="width:100%;text-align:center;">
    	  <h3>
    	  	<a class="page-help" href="<?php echo site_url('monitoring/cetak_penyerahan_izin/1/'.$tgla.'/'.$tglb)?>">
    	      <?php
    		    //if ($lokasi_user === "Pusat") { // Untuk daerah lain
            if($lokasi_user === 'DPMPTSP Prov. Jabar' || $lokasi_user === 'BPMPT Prov. Jabar' || $lokasi_user === 'BPPT Prov. Jabar') {
    		      echo 'CETAK BERITA ACARA PENYERAHAN BERKAS PERMOHONAN ';
            }
    		    ?>
    		  </a>
    	  </h3>
      </div>
    </div>
    <!-- EOF PBS -->
  </div>
  <br style="clear: both;" />
</div>
