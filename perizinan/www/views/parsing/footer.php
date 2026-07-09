  <div class="footer-wrapper">
          <div class="container">
            <div class="row">
              <div class="col-md-5">
                
          	 <?php 
              $db_backoffice = $this->load->database('otherdb', TRUE);
              $backoffice = $db_backoffice->database;
              $sql = "SELECT * FROM $backoffice.settings WHERE name = 'app_kantor'";
              $app_kantor = $this->db->query($sql)->first_row();
              $sql_app_alamat = "SELECT * FROM $backoffice.settings WHERE name = 'app_alamat'";
              $app_alamat = $this->db->query($sql_app_alamat)->first_row();
            ?>
				<strong><?= $app_kantor->value ?><br />(DPMPTSP)</strong>
                <br><br>
               <?= $app_alamat->value ?><br />
               <i class="fa fa-phone"></i> (022) 7351 5000 <i class="fa fa-fax"></i> (022) 7351 5151
               <br><br>
                  <img class="img2" alt="JELITA" title="Jabar ELectronic Information Assistance" src="https://dpmptsp.jabarprov.go.id/web/themes/default/images/logo_jelita.png"  style="width:100px;height:50px;right: 0px;">
                   <a  href="https://play.google.com/store/apps/details?id=hantek.bsre.pdfverify" title="Balai Sertifikasi Elektronik" target="_blank"><img class="img2" alt="Balai Sertifikasi Elektronik" src="https://dpmptsp.jabarprov.go.id/web/themes/default/images/logo_BSrE_3.png"  style="width:120px;height:50px;right: 0px;"></a>  
                      <a  href="https://play.google.com/store/apps/details?id=com.sicantik.simpatikjabar" title="Simpatik Android" target="_blank"><img class="img2" alt="Simpatik Android" src="https://dpmptsp.jabarprov.go.id/web/themes/default/images/android/simpatik_googleplay.png"  style="width:120px;height:50px;right: 0px;"></a>  
              </div>


              <hr class="hidden-md hidden-lg">
              <div class="col-md-1"> </div>
                
              <div class="col-md-3">
                <strong>STATISTIK PENGUNJUNG</strong>
                <br><br>
                    Hari ini : 92<?php //echo @$statistikperhari;?><br>
                    Bulan ini : 798<?php //echo @$statistikperbulan;?><br>
                    Total Pengunjung : 954<?php //echo @$statistikpertahun;?><br>
              </div>
              
              <div class="col-md-3">
                <strong>Media Sosial </strong>
                <br><br>
          	 <?php 
              $sql = "SELECT * FROM $backoffice.settings WHERE name = 'app_right'";
              $app_right = $this->db->query($sql)->first_row();
              $sql_app_alamat = "SELECT * FROM $backoffice.settings WHERE name = 'app_provinsi1'";
              $app_provinsi1 = $this->db->query($sql_app_alamat)->first_row();
            ?>
                     <ul class="quick-menu">
                        <li ><a href="https://www.instagram.com/bpmpt_jabar/" title="YouTube" target="_blank"><i class="fa fa-instagram mr10"></i> <?= $app_right->value ?></a></li>
                      <li><a href="https://www.facebook.com/BPMPT-Provinsi-Jawa-Barat-1512359602352969/" title="Facebook" target="_blank"><i class="fa fa-facebook-official mr10"></i> <?= $app_right->value ?><</a></li>
                    <li><a href="https://twitter.com/bpmpt_jabar" title="Twitter" target="_blank"><i class="fa fa-twitter mr10"></i><?= $app_provinsi1->value ?></a> </li>
                    <li ><a href="https://www.youtube.com/channel/UCg4DrzfaOPyK6iRF-6IQREQ" title="YouTube" target="_blank"><i class="fa fa-youtube mr10"></i><?= $app_right->value ?><</a></li>
         
                    
                </ul>
              </div>
            </div>            
          </div>
        </div>
        
        <div class="bottom">
          <div class="container">
            <div class="copyright text-center">
                Copyright &copy;2017 DPMPTSP Jawa Barat, All Right Reserved
            </div>
          </div>
        </div>
