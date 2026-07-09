<style>
  .text{
    padding-top:7px!important;
    text-align:right;
  }
  .text2{
    *padding-top:7px!important;
    text-align:right;
  }
  .buton{
    font-weight:bold;
  }
  .buton:hover{
    text-decoration:none
  }
</style>
<?php 
if ($integrasi != 0) { ?>
  <script>
    $(document).ready(function() {
      $('#dataTables').DataTable();

    $("#reset").click(function(){
    document.getElementById('dkp').value= "";
    document.getElementById('iddkp').value= "";
  });

  } );
  </script>
<?php }
 ?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
      <li >Permohonan</li>
      <li class="active">Baru</li>
      <li class="active">Step 3</li>
    </ol>
  </div><!--/.row-->
  
  <div class="row">
    <div class="col-lg-12">
      <!--h1 class="page-header"></h1-->
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-9">Petunjuk Penggunaan</div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
            Jika sudah melengkapi dokumen legalitas, silahkan mengajukan permohonan perizinan dengan petunjuk sebagai berikut.<br>
          <ol type='1'>
          <li>Klik tombol <a class="buton">Permohonan Baru</a> kemudian pilih bidang perizinan yang akan anda ajukan kemudian klik <a class="buton">Lanjutkan</a></li>
          <li>Pilih jenis izin yang akan diajukan, klik <a class="buton">Lanjutkan</a></li>
          <li>Isi data teknis permohonan, Gunakan Peta yang tersedia untuk mengisi Longitude/Latitude Titik Lokasi Izin anda, jika izin tidak memiliki lokasi, silahkan arahkan titik lokasi ke alamat perusahaan/pemohon, lalu klik <a class="buton">Lanjutkan</a></li>
          <li>Silakan mengunggah dokumen persyaratan, isi nomor, tanggal, dan masa berlaku jika terlampir pada dokumen. Dokumen yang diunggah harus berbentuk file <b>.pdf</b> berdasarkan hasil scan <b>DOKUMEN ASLI</b></li>
          <li>Mohon periksa kembali Dokumen Persyaratan yang diunggah.</li>
          <li>klik <a class="buton">Lanjutkan</a> apabila sudah yakin silahkan pilih <a class="buton">YA</a>.</li>
          <li>Permohonan diterima oleh DPMPTSP apabila nomor pendaftaran sudah diberikan oleh DPMPTSP yang dapat dilihat pada halaman <b>Status Proses</b></li> 
          <li>Jika Nomor Pendaftaran belum diberikan oleh DPMPTSP, maka akan diperlukan perbaikan persyaratan permohonan yang dikonfirmasi melalui SMS dan fitur messenger pada aplikasi</li>
          <li>Setelah mengajukan permohonan izin anda dapat mengajukan permohonan kembali. Pilih <a class="buton">YA</a> apabila ingin mengajukan permohonan lain atau pilih <a class="buton">Tidak</a> jika anda ingin menyelesaikan proses permohonan izin baru.</li>
          </ol>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-10">Permohonan Izin Baru Step 3</div>
            <div class="col-md-2">
              <?php echo anchor('main/permohonan/step2/'.$id_sektor, 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
            <!-- <form role="form" method="post" action="<?php echo base_url() . 'main/permohonan/step4/'.$id.''; ?>"> -->
            <form role="form" method="post" action="<?php echo base_url() . 'main/permohonan/savestep3/'.$id.''; ?>">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input type="hidden" name="jml_properti" value="<?php echo $jml; ?>">
              <input type="hidden" name="sektor" value="<?php echo $sektor; ?>">
              <input type="hidden" name="uuid" value="<?php echo $uuid; ?>">
              <input type="hidden" name="integrasi" value="<?php echo $integrasi; ?>">
              
              <div class="form-group">
                <div class="col-md-12">
                  <label class="col-md-3 text2">Bidang Perizinan :</label>
                  <label class="col-md-9"  style="*padding-bottom:40px"><?php echo $sektor; ?></label>
                </div>
              </div>
              
              <div class="form-group">
              	<div class="col-md-12">
              		<label class="col-md-3 text2">Perizinan yang Dipilih :</label>
              		<label class="col-md-9" class="text2"  style="padding-bottom:40px"><?php echo $judul->n_perizinan; ?></label>
              	</div>
              </div>
              
              <?php /*<input type="hidden" name="jml_properti" value="<?php echo $jml; ?>"> */?>
              
              <?php /*foreach($property as $data){ ?>
              <div class="form-group">
                <label class="col-md-3 text"><?php echo $data->n_property.'tampil dimana ini'; ?></label>
                <div class="col-md-9">
                  <input class="form-control" placeholder="<?php echo $data->n_property; ?>" name="<?php echo $data->id; ?>" value="" required><br>
                </div>
              </div>
              <?php } */ ?>
              
              <center class="notif" >
                <h4>
                  <span style="color: Red">Data wajib diisi dan pastikan format data sudah benar, lalu klik tombol Lanjutkan</span>
                </h4>
              </center>
              <br>
              
              <div class="form-group">
                <label class="col-md-3 text">
                  Nomor Induk Berusaha (NIB)
                </label>
                <div class="col-md-9">
                <input type="text" class="form-control" name="nib" required><br>  
                </div>
              </div>
              
              <?php 
              	
              $no=1;
              $jumlah_semua = 1;
              $eksis	= $this->db->query("select * from tmpermohonan_portal where uuid='".$uuid."' order by id desc")->first_row();
              while($no<=100){
                $tek = "var_teknis".$no;
                $dt_teknis = "dt_teknis".$no;
                $prop = $property[$tek];
              
                if(empty($prop)){
                  break;
                }
                if($uuid == ''){
                  $dt_teknis1 = '';
                }else{
                  $cek_posisi = strpos($eksis->dt_teknis1,'^'); 
                  $dt_teknis1 = substr($eksis->dt_teknis1,0,$cek_posisi);
                }
                
                $array = explode("^",$prop);
                ?>
                <!--<input type="hidden" name="status_<?php echo $no; ?>" value="<?php echo $array[11]; ?>">-->
                <?php 
                if($array[11]=="Ya" && $array[6] == "Ya"){ ?>
                  <div class="form-group">
                    <label class="col-md-3 text"><?php echo $array[1]; if($array[9]=="Integer"){ echo "<br><i>*input hanya angka</i>";} ?></label>
                    <div class="col-md-9">
                      <?php 
                      if($array[9]=="TextBox"){ ?>
                        <!--<input class="form-control" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>-->
                        <input class="form-control" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>
                        <?php
                      }else{
                        if($array[9]=="Integer"){ ?>
                          <!--<input class="form-control numberonly" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>-->
                          <input class="form-control numberonly" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>
                          <?php
                        }else{
                          if($array[9]=="ComboBox"){ 
                            $option = explode(";",$array[10]);
                            ?>
                            <select class="form-control" name="var_teknis<?php echo $array[0]; ?>" required>
                              <?php
                              foreach($option as $op){ ?>
                                <option value="<?php echo $op; ?>"><?php echo $op; ?></option>
                                <?php 
                              } ?>
                            </select><br>
                            <?php 
                          }else{
                            if($array[9]=="Tanggal"){ ?>
                              <!--<input class="form-control datepicker" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>-->
                              <input class="form-control datepicker" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>
                              <?php
                            }else{ ?>
                              <?php echo $array[9];?>
                              <?php
                            } 
                          }
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <?php 
                }else{
                  ?>	
                  <div class="form-group">
                    <input class="form-control" type="hidden" name="var_teknis<?php echo $array[0]; ?>" value=" ">
                  </div>
                  <?php 
                } 
                $no++;
              }
              ?>
              <br>

              <?php if ($integrasi == 1 && $this->session->userdata("username") == "nirwan") { //$integrasi 1 = sireon ?>
                <div class="form-group">
                  <label class="col-md-3 text">Rekomendasi DKP</label>
                  <div class="col-md-9">
                  <table width="100%" cellpadding="0" cellspacing="0" id="dataTables">
                    <thead>
                      <tr>
                        <th ><b>NO </b>  </th>
                        <th><b>NOMOR PENDAFTARAN </b>  </th>
                        <th><b>NAMA PEMOHON</b> </th>
                        <th><b>JENIS REKOMENDASI</b></th>
                        <th><b>AKSI</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $n=1;
                      foreach($datintegrasi as $row) {
                            echo "<tr>
                                    <td style='text-align:center;'>".$n."</td>
                                    <td id='link".$row->id."'><input type='hidden' id='int".$row->id."' value='".$row->id."'>".$row->no_pendaftaran."</td>
                                    <td>".$row->pemohon."</td>
                                    <td>".$row->jenis."</td>
                                    <td> <button type='button' class='btn btn-primary' onclick='txtValDisp($row->id);'>Pilih</button></td>
                                  </tr>
                                 ";
                            $n++;
                      }
                      ?>
                    </tbody>
                  </table>
                  <br>
                </div>
                <label class="col-md-3 text">&nbsp;</label>
                <div class="col-md-8">
                  <input type="hidden" id="iddkp" name="iddkp">
                  <input type="text" id="dkp" name="dkp" class="form-control" onkeypress="return false;" onpaste="return false;" style="background: #D3D3D3;" placeholder="Silahkan Pilih Data Diatas" required>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-warning" id="reset">Reset</button>
                </div>
                <br>
              </div>
              <br>
              <br>
              <div class="form-group">
                <div class="col-md-12">
                  &nbsp;
                </div>
              </div>
              <?php } ?>

              <center><h4>Lokasi/Alamat Perizinan</h4></center>
              <div class="form-group">
                <label class="col-md-3 text">Provinsi :</label>
                <div class="col-md-9">
                  <select class="form-control provinsi" name="provinsi" required>
                    <?php foreach($provinsi as $prov){ ?>
                      <option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==12){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
                    <?php } ?>
                  </select><br>
                </div>
              </div>
              
              <script>
              $(function(){
                $('.provinsi').on('change', function(e){
                  var provinsi = $(".provinsi").val();
                  $.ajax({
                    url : "../../pendaftaranbaru/getkabupaten",
                    type: "post",
                    data:{"data":provinsi},
                    success : function(data){
                      $(".kabupaten").html('');
                      var myarray = JSON.parse(data);
                      var myarray = myarray.split(",");

                      for (i=0;i<myarray.length;i++)
                      {
                        if(myarray[i] != myarray[i+1])
                        {
                          var myarray2 = myarray[i].split("|");
                          var optn2 = document.createElement("OPTION");
                          
                          optn2.text = myarray2[1];
                          optn2.value = myarray2[0];
                          $(".kabupaten").append(optn2);
                        }
                      }
                    }
                  });
                  
                  $(".kecamatan").html('');
                  var optn2 = document.createElement("OPTION");
                  optn2.text = "------------------------ Pilih Kecamatan ------------------------";
                  optn2.value = "";
                  $(".kecamatan").append(optn2);
                  
                  $(".kelurahan").html('');
                  var optn2 = document.createElement("OPTION");
                  optn2.text = "------------------------ Pilih Kelurahan ------------------------";
                  optn2.value = "";
                  $(".kelurahan").append(optn2);
                  
                });
              });
            </script>
              
              <div class="form-group">
                <label class="col-md-3 text">Kabupaten / Kota :</label>
                <div class="col-md-9">
                  <select class="form-control kabupaten" name="kabupaten" required>
                    <option  value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
                
                    <?php foreach($kabupaten as $kab){ ?>
                      <option value="<?php echo $kab->id; ?>"><?php echo $kab->n_kabupaten; ?></option>
                    <?php } ?>
                  </select><br>
                </div>
              </div>
              
              <script>
                $(function(){
                  $('.kabupaten').on('change', function(e){
                    var kabupaten = $(".kabupaten").val();
                    $.ajax({
                      url : "../../pendaftaranbaru/getkecamatan",
                      type: "post",
                      data: "data="+kabupaten,
                      success : function(data){
                        $(".kecamatan").html('');
                        var myarray = JSON.parse(data);
                        var myarray = myarray.split(",");

                        for (i=0;i<myarray.length;i++)
                        {
                          if(myarray[i] != myarray[i+1])
                          {
                            var myarray2 = myarray[i].split("|");
                            var optn2 = document.createElement("OPTION");
                            
                            optn2.text = myarray2[1];
                            optn2.value = myarray2[0];
                            $(".kecamatan").append(optn2);
                          }
                        }
                      }
                    });
                    
                    $(".kelurahan").html('');
                    var optn2 = document.createElement("OPTION");
                    optn2.text = "------------------------ Pilih Kelurahan ------------------------";
                    optn2.value = "";
                    $(".kelurahan").append(optn2);
                    
                  });
                });
              </script>
              
              <div class="form-group">
                <label class="col-md-3 text">Kecamatan :</label>
                <div class="col-md-9">
                  <select class="form-control kecamatan" name="kecamatan" required>
                    <option  value="">------------------------ Pilih Kecamatan ------------------------</option>
                    <!-- Generate Data From Ajax -->
                  </select><br>
                </div>
              </div>
              
              <script>
                $(function(){
                  $('.kecamatan').on('change', function(e){
                    var kecamatan = $(".kecamatan").val();
                    $.ajax({
                      url : "../../pendaftaranbaru/getkelurahan",
                      type: "post",
                      data: "data="+kecamatan,
                      success : function(data){
                        $(".kelurahan").html('');
                        var myarray = JSON.parse(data);
                        var myarray = myarray.split(",");

                        for (i=0;i<myarray.length;i++)
                        {
                          if(myarray[i] != myarray[i+1])
                          {
                            var myarray2 = myarray[i].split("|");
                            var optn2 = document.createElement("OPTION");
                            
                            optn2.text = myarray2[1];
                            optn2.value = myarray2[0];
                            $(".kelurahan").append(optn2);
                          }
                        }
                      }
                    });
                  });
                });
              </script>
              
              <div class="form-group">
                <label class="col-md-3 text">Kelurahan / Desa :</label>
                <div class="col-md-9">
                  <select class="form-control kelurahan" name="kelurahan" required>
                    <option  value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
                    <!-- Generate Data From Ajax -->
                  </select><br>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 text">Titik Lokasi</label>
                <div class="col-md-9">
                  <div id="map_div" style="height: 350px;"></div>
                  <br><small>Geser penanda merah <img src="<?php echo base_url(); ?>assets/images/za_marker.png">&nbsp; ke titik lokasi yang dituju kemudian klik penanda tersebut untuk memilih Longitude / Latitude lokasi anda (LOKASI HARUS DI JAWA BARAT)</small>
                </div>
              </div>
              <br><br>
              <div class="form-group">
                <label class="col-md-3 text">Long / Lat</label>
                <div class="col-md-4">
                  
                  <input type="number" step="any" id="maps_longitude" name="maps_longitude" min="106.393405" max="108.837612"  class="form-control" onkeypress="return false;" onpaste="return false;" style="background: #D3D3D3;" placeholder="Gunakan Peta diatas untuk mengisi Longitude" required>
                  
                </div>

                <div class="col-md-4">
                <input type="number" id="maps_latitude" step="any" min="-7.818470" max="-5.917956"  name="maps_latitude" class="form-control" onkeypress="return false;" onpaste="return false;" style="background: #D3D3D3;" placeholder="Gunakan Peta diatas untuk mengisi Latitude" required>
                <br>
                </div>
              </div> 

                <br>
               
              <div class="form-group">
                <label class="col-md-3 text"><?php echo ($judul->indeks == "AKDP" ? "Nomor Kendaraan / Nomor Uji / Lintasan Trayek <br> (Contoh : D 123 EF / BKS252 / TERM CILEUNYI - TERM CICAHEUM PP)" : "Lokasi / Objek Izin"); ?></label>
                <div class="col-md-9">
                  <?php if ($judul->indeks == "AKDP") { ?>
                    <textarea class="form-control"  name="lokasi_izin" rows="5" style="resize:vertical;" placeholder="Nomor Kendaraan / Nomor Uji / Lintasan Trayek (Untuk Angkutan Online, jika tidak ada nomor uji, silahkan isi dengan angka 0)" required></textarea>
                  <?php } else { ?>
                    <textarea class="form-control"  name="lokasi_izin" rows="5" style="resize:vertical" required></textarea>
                  <?php } ?>
                </div>
              </div>
              <br>
              <script>
                $(function(){
                  $('.numberonly').keyup(function () { 
                    this.value = this.value.replace(/[^0-9\.]/g,'');
                  });
                });
              </script>
              <?php
              if($no==1){ ?>
                <center><h2>Tidak Ada Data Properti yang Harus Anda Lengkapi, Silahkan Klik Tombol Lanjutkan</h2></center>
                <?php
              } ?>
              
              <input type="hidden" name="jml_properti" value="<?php echo $no-1; ?>">
              <div class="form-group">
                <label class="col-md-12 text">&nbsp;</label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-9 text">&nbsp;</label>
                <div class="col-md-3">
                  <button type="submit" class="btn btn-block btn-primary">Lanjutkan</button>
                  <?php //echo anchor("main/permohonan/step3/".$id."", 'Lanjutkan',array("class"=>"btn btn-block btn-primary")) ?>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div><!-- /.col-->
  </div><!-- /.row -->
</div><!--/.main-->

  </div>
</div>
<script>
  $(function () {
    $('.datepicker').datepicker()
  });
</script>
<script type="text/javascript">
function txtValDisp(rowID){
    var linkVal = document.getElementById('link'+rowID+'').innerHTML.replace(/<\/?[^>]+(>|$)/g, "\n");
    var intVal  = document.getElementById('int'+rowID+'').value;
    document.getElementById("dkp").value = linkVal;
    document.getElementById("iddkp").value = intVal;
    }
</script>
