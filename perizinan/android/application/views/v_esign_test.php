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
          <form action="<?php echo site_url('approve_esign/cari_data_no_pendaftaran'); ?>" method="post">
            <div class="row">
              <div class="input-field col s12">
                <input type="text" class="" placeholder="Masukan Kata Kunci" style="text-align: center" name="no_pendaftaran" value="<?php echo $no_pendaftaran;?>" >
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
          $otherdb->distinct();
          $otherdb->select('ttd_nota');
          $otherdb->from('trsektor');
          $otherdb->where('n_sektor',$bidang);
          $ambilttd =  $otherdb->get();
          if($ambilttd->num_rows() > 0) {
            foreach($ambilttd->result() as $data2) {
              $ambilttd = $data2->ttd_nota;
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
          if($h == '3'){
            ?>
            <form action="<?php echo site_url('approve_esign/notifikasi'); ?>" method="post">
              <input type="hidden" name="email" value="">
              <input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
            </form>
            <?php
          }
          if($h == '4'){
            ?>
            <form action="<?php echo site_url('approve_esign/notifikasi'); ?>" method="post">
              <input type="hidden" name="email" value="<?php echo $email;?>">
              <input type="submit" name="" value="KIRIM NOTIFIKASI" class="btn red">
            </form>
            <?php
          }
          ?>
          <form action="<?php echo site_url('approve_esign/update_multiple_test'); ?>" method="post">
            <?php
            echo '<h5><center>APPROVE PERMOHONAN IZIN ESIGN</center></h5>';
            echo '<center>'.$this->session->userdata("oriname").'</center>';
            ?>
            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">
              <center>
                <br><input type="submit" name="submit"  value="Approve Permohonan"  class="btn">
              </center>
              <!-- Modal Trigger -->
              <center>
                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Approve Esign</a>
              </center>  
              
              <!-- Modal Structure -->
              <div id="modal1" class="modal">
                <div class="modal-content">
                  <center>KODE E-SIGN</center>
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
            <p></p>
            <table border="0" id="myTable" >
              <thead>
                <tr>
                    <th><!--<input type="checkbox" id="checkAll" name="checkAll">-->
                      <input type="checkbox" id="checkAll" name="checkAll">
                      <label style="font-size: 11px;" for="checkAll">No</label>
                    </th>
                  <th>No/Jenis/Perusahaan/Tgl Berkas</th>
                  <!--<th >Tgl Berkas</th>-->
                  <th>Aksi</th>
                  <!--<th ><center>Approve</center></th>-->
                </tr>
              </thead>
              <tbody>
                <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_1.pdf')) { ?>
                  <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="1" name="msg[]" value="1">
                          <label style="font-size: 11px;" for="1">
                          1</label>
                          <input type="hidden" name="nodaftar[]" value="1">
                        </td>
                      <td>1</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/1'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/1/1'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 123</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 123
                        01-01-2019
                      </td>
                    </tr>
                <?php } ?>
                	  
                <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_2.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="2" name="msg[]" value="2">
                          <label style="font-size: 11px;" for="2">
                          2</label>
                          <input type="hidden" name="nodaftar[]" value="2">
                        </td>
                      <td>2</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/2'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/2/2'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 234</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 234
                        02-02-2019
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_3.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="3" name="msg[]" value="3">
                          <label style="font-size: 11px;" for="3">
                          3</label>
                          <input type="hidden" name="nodaftar[]" value="3">
                        </td>
                      <td>3</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/3'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/3/3'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 345</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 345
                        03-03-2019
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_4.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="4" name="msg[]" value="4">
                          <label style="font-size: 11px;" for="4">
                          4</label>
                          <input type="hidden" name="nodaftar[]" value="4">
                        </td>
                      <td>4</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/4'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/4/4'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 456</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 456
                        04-04-2019
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_5.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="5" name="msg[]" value="5">
                          <label style="font-size: 11px;" for="5">
                          5</label>
                          <input type="hidden" name="nodaftar[]" value="5">
                        </td>
                      <td>5</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/5'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/5/5'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 567</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 567
                        05-05-2019
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_6.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="6" name="msg[]" value="6">
                          <label style="font-size: 11px;" for="6">
                          6</label>
                          <input type="hidden" name="nodaftar[]" value="6">
                        </td>
                      <td>6</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/6'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/6/6'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 678</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 678
                        06-06-2019
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_7.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="7" name="msg[]" value="7">
                          <label style="font-size: 11px;" for="7">
                          7</label>
                          <input type="hidden" name="nodaftar[]" value="7">
                        </td>
                      <td>7</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/7'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/7/7'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 789</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 789
                        07-07-2019
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_8.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="8" name="msg[]" value="8">
                          <label style="font-size: 11px;" for="8">
                          8</label>
                          <input type="hidden" name="nodaftar[]" value="8">
                        </td>
                      <td>8</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/8'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/8/8'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 8910</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 8910
                        08-08-2019
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_9.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="9" name="msg[]" value="9">
                          <label style="font-size: 11px;" for="9">
                          9</label>
                          <input type="hidden" name="nodaftar[]" value="9">
                        </td>
                      <td>9</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/9'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/9/9'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 91011</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 91011
                        09-09-2019
                      </td>
                    </tr>
                    <?php } ?>

                    <?php if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esigntest/SK_10.pdf')) { ?>
                    <tr>
                        <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                          <input type="checkbox" id="10" name="msg[]" value="10">
                          <label style="font-size: 11px;" for="10">
                          10</label>
                          <input type="hidden" name="nodaftar[]" value="10">
                        </td>
                      <td>10</td>
                      <td rowspan="3" style="border-bottom: 1px solid silver;border-collapse: none;">
                        <form action="<?php echo site_url('approve_esign/detail_permohonan').'/10'; ?>" method="post">
                          <input type="submit" name="submit"  value="Detail"  class="btn">
                          </br></br><a href="<?php echo site_url('approve_esign').'/preview/10/10'; ?>" class="btn">preview sk</a>
                        </form> 
                      </td>
                    </tr>
                    <tr>
                      <td>Izin 101112</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid silver;border-collapse: none;">
                        PT 101112
                        10-10-2019
                      </td>
                    </tr>
                    <?php } ?>
              </tbody>
            </table>
          </form>  <!-- 2 -->
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
            <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Provinsi Kalimantan Utara berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
          </div>
        </div>
      </div>
    </footer>
    
    <footer class="page-footer teal">
      <div class="footer-copyright">
        <div class="container">
          2017 © DPMPTSP Provinsi Kalimantan Utara v 1.5
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