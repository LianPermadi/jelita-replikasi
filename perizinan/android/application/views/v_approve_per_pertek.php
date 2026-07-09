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
  <body>
    <?php  include 'v_header.php';
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
    ?>

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
            <!-- end cari pemohon---->
          </form>
          <?php
          if(count($hasilakdp_cetak)>0) {
            foreach($hasilakdp_cetak as $data):
              $bidang = $data->bidang;
            endforeach;
          }

          $otherdb->select('ttd_nota,no_pertek_akhir');
          $otherdb->from('trsektor');
          //$otherdb->where('id',$data->trsektor_id);
          $ambilttd =  $otherdb->get();
          $bidang_pertek = '';
          if($ambilttd->num_rows() > 0) {
            foreach($ambilttd->result() as $data2) {
              $ambilttd = $data2->ttd_nota;
              $bidang_pertek = str_replace(' ','',$data2->no_pertek_akhir);
          	}
          	$ambilttd2 = $ambilttd;
          }
          $otherdb->select('email');
          $otherdb->from('user');
          $otherdb->join('tmpegawai_user','tmpegawai_user.user_id = user.id','left');
          $otherdb->where('tmpegawai_user.tmpegawai_id',$ambilttd2);
          $ambilemail =  $otherdb->get();
          if($ambilemail->num_rows() > 0) {
            foreach ($ambilemail->result() as $data2) {
              $email = $data2->email;
            }
          }
          if($h == '5'){
            ?>
            <form action="<?php echo site_url('approve_per_pertek/notifikasi'); ?>" method="post">
              <input type="hidden" name="email" value="">
              <input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
            </form>
            <?php
          }
          if($h == '3'){
            ?>
            <form action="<?php echo site_url('approve_per_pertek/notifikasi'); ?>" method="post">
              <input type="hidden" name="email" value="">
              <input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
            </form>
            <?php
          }
          if($h == '4'){
            ?>
            <form action="<?php echo site_url('approve_per_pertek/notifikasi'); ?>" method="post">
              <input type="hidden" name="email" value="<?php echo $email;?>">
              <input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
            </form>
            <?php
          }
          ?>
          <form action="<?php echo site_url('approve_per_pertek/update_multiple'); ?>" method="post">
            <?php
            echo '<h5><center>APPROVE SURAT PERMOHONAN PERTIMBANGAN TEKNIS</center></h5>';
            echo '<center>'.$this->session->userdata("oriname").'</center>';
            ?>
            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id_user">
            <?php
            $iduser =  $this->session->userdata("id");
            //if($h==4 || $h==3){
            if($h==4){	
              ?>
              <center>
                <br><input type="submit" name="submit"  value="Approve Permohonan"  class="btn">
              </center>
              <?php
            // }else if($h==3){
            }else if($h==3 || $h==5){
              ?>
              <!-- Modal Trigger -->
              <center>
                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve Esign</a>
              </center>  
              
              <!-- Modal Structure -->
              <div id="modal1" class="modal">
                <div class="modal-content">
                  <center>KODE Passphrase</center>
                  <input type="password" name="passphrase">
                  <br>
                  <center><input type="submit" name="submit" autofocus required="true" value="Proses"  class="btn">
                    <!--<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>-->
                    <a href="" class="btn" >Kembali</a>
                  </center>  
                </div>
                <div class="progress">
                  <div class="indeterminate"></div>
                </div>
              </div>
              <?php
            }else{}
            ?>
            <p></p>
            <table border="0" id="myTable" >
              <thead>
                <tr>
                  <?php
                  // if($h==4 || $h==3 || $h==2){
                    if($h==5 || $h==4 || $h==3 || $h==2){
                    ?>
                    <th>
                      <input type="checkbox" id="checkAll" name="checkAll">
                      <label style="font-size: 11px;" for="checkAll">No</label>
                    </th>
                    <?php
                  }else{}
                  ?>
                  <th>No Surat<br>Tanggal<br>Tujuan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                if(count($hasilakdp_cetak)>0) {
                	$no_surat1 = '';
                  foreach ($hasilakdp_cetak as $data){
                  	$no_surat2 = $data->no_pertek_awal.$data->no_surat.$data->no_pertek_akhir.$data->tgl_surat;
                  	//if(date('Y',strtotime($data->tgl_surat))=='2019' && $no_surat1 != $no_surat2){
                  	if($no_surat1 != $no_surat2){		
                  		$no_surat1 = $data->no_pertek_awal.$data->no_surat.$data->no_pertek_akhir.$data->tgl_surat;
                	    ?>
                	    <tr>
                	      <?php
                	      // if($h==4 || $h==3 || $h==2){
                        if($h==5 || $h==4 || $h==3 || $h==2){
                	        ?>
                	        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                	          <input type="checkbox" id="<?php echo $i;?>" name="msg[]" value="<?php echo $data->id; ?>">
                	          <label style="font-size: 11px;" for="<?php echo $i;?>">
                	            <?php
                	              echo $i++;
                	              //create nama file
                	              //$i_urut = strlen($data->no_surat);
                                //$bcno_urut_pertek = $data->no_surat;
                                //for($ii = 5; $i > $i_urut; $ii--) {
                                //  $bcno_urut_pertek = "0" . $bcno_urut_pertek;
                                //}
                                //$cod_bar_thn = $bcno_urut_pertek.date("Y",strtotime($data->tgl_surat));
                                //$n_file = 'PT_'. $cod_bar_thn.'.pdf';
                	              //EOF() create nama file
                	            ?>
                	          </label>
                	          <!--input type="hidden" name="n_file[]" value="<?php echo $n_file; ?>">-->
                	        </td>
                	        <?php
                	      }
                	      ?>
                	      <td>
                	        <?php
                	          echo $data->no_pertek_awal.$data->no_surat.$data->no_pertek_akhir;
                	        ?>
                	      </td>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <form>
                            <!--<a href="<?php echo site_url('approve_per_pertek').'/detail_permohonan/'.$data->id; ?>" class="btn">Detail</a><br><br>-->
                            <a href="<?php echo site_url('approve_per_pertek').'/preview/'.$data->id; ?>" class="btn">preview sk</a>
                          </form>	
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php
                          $tgl = $data->tgl_surat;
                          $tgl = date("d",strtotime($tgl)).' - '.date("M",strtotime($tgl)).' - '.date("Y",strtotime($tgl)).' '.
                                 date("H",strtotime($tgl)).':'.date("i",strtotime($tgl)).':'.date("s",strtotime($tgl));
                          echo $tgl;
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="border-bottom: 1px solid silver;border-collapse: none;">
                          <?php echo $data->kepada; ?>
                        </td>
                      </tr>
                      <?php
  					        }
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
            <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Kabupaten Tasikmalaya berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
          </div>
        </div>
      </div>
    </footer>
    
    <footer class="page-footer teal">
      <div class="footer-copyright">
        <div class="container">
          2017 © DPMPTSP Kabupaten Tasikmalaya v 1.5
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