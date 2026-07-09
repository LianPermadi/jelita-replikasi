<style type="text/css">
  td,th{
    font-size: 11px;
  }
</style>
<?php
if($this->session->userdata("nama") == null){
  redirect('login');
}else{
  ?>
    <?php  include 'v_header.php';?>
<body>
    <?php
    $email = '';
    $bidang = '';
    $ambilttd = '';
    $ambilttd2 = '';
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$this->session->userdata("id"));
    $ambileselon =  $otherdb->get();
    if($ambileselon->num_rows() > 0) {
      foreach ($ambileselon->result() as $data2) {
  	    $h = $data2->eselon;
  	  }
  	}else{
  	  $h = '9';
  	  //echo $h;
  	}
  	$otherdb->select('user_auth_id');
    $otherdb->from('user_user_auth');
    $otherdb->where('user_id', $this->session->userdata("id"));
    $otherdb->where('user_auth_id', '24');  // Peran Approve
    $ambilapprove = $otherdb->get();
    $dat_approve = $ambilapprove->row();
    $stat_approve = FALSE;
    if (!empty($dat_approve)) {
      $stat_approve = TRUE;
    }
    ?>
    
    <div class="container" style="margin-top: 30px;">
      <div class="section">
        <div class="row">
          <form action="<?php echo site_url('approve_per_pertek/cari_data_surat'); ?>" method="post">
            <div class="row">
              <div class="input-field col s12">
                <input type="text" class="" placeholder="Masukan Nomor Surat" style="text-align: center" name="no_surat" value="<?php echo $no_surat;?>" >
                <center> <input type="submit" name="submit"  value="Cari" class="btn"></center>
              </div>
            </div>
            <!-- end cari pemohon -->
          </form>
          <?php 
            $alert = $this->session->flashdata("success");
            if(!empty($alert)){
          ?>
            <script type="text/javascript">console.log('<?php echo $alert; ?>');</script>
          <?php } ?>

          <?php 
            $alert = $this->session->flashdata("error");
            if(!empty($alert)){
          ?>
            <script type="text/javascript">console.log('<?php echo $alert; ?>');</script>
          <?php } ?>
          
          <form action="<?php echo site_url('approve_surat/update_multiple'); ?>" method="post">
            <?php
            echo '<h5><center>APPROVE PERSURATAN
                              <span style="color:green">d</span>|<span style="color:blue">Sign</span>
                      </center>
                  </h5>';
            echo '<center>User Login : '.$this->session->userdata("oriname").'</center>';
            ?>
            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id_user">
            <?php
            $iduser =  $this->session->userdata("id");
            //if($h==4 || $h==3){
            //if(($h == 4 || $h == 3) && $stat_approve) {	
              ?>
              <!-- <center>
                <br><input type="submit" name="submit"  value="Approve"  class="btn">
              </center> -->
              <?php
            //} else if($h==2 && $stat_approve) { 
              ?>
              <!-- Modal Trigger -->
              <center>
                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve</a>
              </center>  
              
              <!-- Modal Structure -->
              <div id="modal1" class="modal">
                <div class="modal-content">
                  <center>PASSPHRASE</center>
                  <input type="password" name="passphrase">
                  <br>
                  <center>
                    <input type="submit" name="submit" autofocus required="true" value="Proses" class="btn">
                    <a href="" class="btn" >Kembali</a>
                  </center>  
                </div>
                <div class="progress">
                  <div class="indeterminate"></div>
                </div>
              </div>
              <?php
            //}
            ?>
            <p></p>
            <table border="0" id="myTable" >
              <thead>
                <tr>
                  <?php
                  if(($h==4 || $h==3 || $h==2)){
                    ?>
                    <th>
                      <input type="checkbox" id="checkAll" name="checkAll">
                      <label style="font-size: 11px;" for="checkAll">No</label>
                    </th>
                    <?php
                  }
                  ?>
                  <th style="width: 30%;">No Surat<br>Tanggal<br>Kepada</th>
                  <th style="width: 40%;">Sifat<br>Lampiran<br>Hal</th>
                  <th style="width: 30%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                if(count($data_surat) > 0) {
                  foreach ($data_surat as $data){
                	    ?>
                	    <tr>
                	      <?php
                	      if($h==4 || $h==3 || $h==2 || $h==5){
                	        ?>
                	        <td style="border-bottom: 1px solid silver;border-collapse: none;">
                            <?php 
                            $n_file = 'SRT_'.$data->id.'.pdf';
                            $php_self = $_SERVER['SCRIPT_NAME'];
                            $url_self = str_replace("/android/index.php", "", $php_self);
                            $url_domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_self;
                            $filename  = $_SERVER['DOCUMENT_ROOT'] .$url_self.'/backoffice/assets/pdf-surat/'.$n_file;
                            // var_dump($filename);

                            if (file_exists($filename)) { ?>
                              <input type="checkbox" id="<?php echo $i;?>" name="msg[]" value="<?php echo $data->id; ?>">
                            <?php } 
                            //else { ?>
                            <!-- <input type="hidden" id="<?php //echo $i;?>" name="msg[]" value="<?php //echo $data->id; ?>"> -->
                            <?php //echo ""; } ?>
                	          
                	          <label style="font-size: 11px;" for="<?php echo $i;?>">
                	            <?php
                	              echo $i++;
                	            ?>
                	          </label>
                	        </td>
                	        <?php
                	      }
                	      ?>
                	      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                	        <?php
                	          echo $data->nomor_surat
                            ."<br>&nbsp;<br>".
                            date('d-m-Y', strtotime($data->tgl_surat))
                            ."<br>&nbsp;<br>".
                            $data->kepada;
                	        ?>
                	      </td>
                        <td style="border-bottom: 1px solid silver;border-collapse: none;">
                          <?php
                            echo $data->sifat_surat
                            ."<br>&nbsp;<br>".
                            $data->lampiran
                            ."<br>&nbsp;<br>".
                            $data->hal;
                          ?>
                        </td>
                        <td style="border-bottom: 1px solid silver;border-collapse: none;">
                          <?php if (file_exists($filename)) { ?>
                            <a href="<?php echo site_url('approve_surat').'/preview/'.$data->id; ?>" class="btn">preview surat</a>
                          <?php } else { ?>
                            <label style="color: red;">Dokumen PDF Tidak Ditemukan</label>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php
  					      }
                  $i++;
                }else{
                  echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </form>
          <script type="text/javascript">
            $('.datepicker').pickadate({
              selectMonths: true, // Creates a dropdown to control month
              selectYears: 15 // Creates a dropdown of 15 years to control year
            });
          </script>
        </div>
      </div>
    </div>

    <footer class="page-footer teal" style="visibility: hidden;">
      <div class="container">
        <div class="row">
          <div class="col s12">
            <h5 class="white-text">Tentang DPMPTSP</h5>
            <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Provinsi Jawa Barat berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
          </div>
        </div>
      </div>
    </footer>
    
    <footer class="page-footer teal">
      <div class="footer-copyright">
        <div class="container">
          2017 © DPMPTSP Provinsi Jawa Barat v 1.5
        </div>
      </div>
    </footer>
    
    <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/init.js"></script>
    <script type="text/javascript" src="<?php echo base_url(''); ?>assets/js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript">
      var u = jQuery.noConflict();
      u(document).ready(function() {
      	u("input[name='checkAll']").click(function() {
      		var checked = u(this).attr("checked");
      		u("#myTable tr td input:checkbox").attr("checked", checked);
      	});
      });
    </script>	
  </body>
  <?php
}
?>