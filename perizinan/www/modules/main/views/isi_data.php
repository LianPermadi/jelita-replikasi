<?php
$base = base_url() . 'assets/css/default/';
$base_url = base_url() . 'assets/';
echo $this->lib_load_css_js->load_js($base_url, "js/slider/", "s3Slider.js");
echo $this->lib_load_css_js->load_css($base_url, "js/slider/css/", "slide.css");

echo $this->lib_load_css_js->load_js($base_url, "js/fancybox/", "jquery.mousewheel-3.0.4.pack.js");
echo $this->lib_load_css_js->load_js($base_url, "js/fancybox/", "jquery.fancybox-1.3.4.pack.js");
echo $this->lib_load_css_js->load_css($base_url,"js/fancybox/", "jquery.fancybox-1.3.4.css");


?>
<!-- <script>
    $(document).ready(function() {
        $('#slider').s3Slider({
            timeOut: 3000
        });
    });
</script>

<script type="text/javascript">
        $(document).ready(function() {
                $("a#example7").fancybox({
                        'titlePosition'	: 'inside'
                });
        });
</script> -->





<div class="isi2" >

    <h2>CEK STATUS PERMOHONAN</h2>
   <!-- <div class="berita_atas">

        <div id="slider" style="float: left;">
            <ul id="sliderContent">
                
                <?php
                    $x=0;
                    foreach ($data_berita as $data){
                        $x++;
                        if($x<=3) {

                            $des=  str_replace("../../assets/", "assets/", $data->N_ISI_BERITA);

                            $ambil_gambarx= strrpos($des, '<img');
                            
                            $ambil_gambary= strrpos($des, ' alt=');
                           
                            $data_gambar= substr($des, $ambil_gambarx,$ambil_gambary-2);
							$data_gambar=$data_gambar."width=410 height=320 />";
//                            $data_gambar=$data_gambar."width=670 height=320 />";
//                            
//                            $data_gambar=  str_replace("alt=\"\"", "width=670 height=320 />", $data_gambar);
//                            
                            $data_gambar=  str_replace("margin-left:", "", $data_gambar);
                            
                            $data_gambar=  str_replace("margin-right:", "", $data_gambar);
                            
                          

                            if($ambil_gambarx>0){
                                echo"<li class='sliderImage'>";
                                    echo"<a href='#'>$data_gambar</a>";
                                    echo"<span class='top'><a href='".base_url()."main/info_publik/lihat_detail/".$data->C_BERITA."'><strong>$data->N_JUDUL_BERITA</strong></a><br /></span>";
                                echo"</li>";   
                            }
                        
                        }             
                        
                    }
                    
//                        echo"<li class='sliderImage'>";
//                            echo"<a href=''><img src='".$base."images/berita/02.jpg' alt=''  /></a>";
//                            echo"<span class='top'><a href='".base_url()."main/info_publik/lihat_detail/".$data->C_BERITA."'><strong>$data->N_JUDUL_BERITA</strong></a><br /></span>";
//                        echo"</li>";                      
                ?>
                

                <div class="clear sliderImage"></div>
            </ul>
        </div>-->

        <!--<div class="isi_tiga" style="width: 270px;" >
            <ul>
                <?php
                    foreach ($data_berita as $data){
                        echo"<li><a href='".base_url()."main/info_publik/lihat_detail/".$data->C_BERITA."'>".$data->N_JUDUL_BERITA."</a></li>";
                    }
                ?>
           <li><a href="#">Malaysia Hentikan Expor CPO</a></li>
                <li><a href="#">BUMN Harus Punya Arah</a></li>
                <li><a href="#">SBY Minta BUMN Bantu Kurang Kemiskinan</a></li>
                <li><a href="#">Dahlan Targetkan 20 BUMN Merger Tahun Ini</a></li>
                <li><a href="#">Presiden SBY Meminta Perampingan BUMN Dilakukan Hati-hati</a></li>
                <li><a href="#">BUMN Harus Punya Arah</a></li>
                <li><a href="#">Malaysia Hentikan Expor CPO</a></li>
                <li><a href="#">SBY Minta BUMN Bantu Kurang Kemiskinan</a></li>
                <li><a href="#">Dahlan Targetkan 20 BUMN Merger Tahun Ini</a></li>
            </ul>
        </div>-->

        <!--<div class="isi_tiga" style="width: 260px; margin: 0px; margin-left: 15px; background: #f8f8f8; ">
<h3>Jajak Pendapat</h3>
 <?php    
    $dt_jajak=new Tmjajak();   
    $get_jajak=$dt_jajak->where("STATUS = 1 and (D_PRD_AWAL <= now() and D_PRD_AKHIR >= now()) limit 1")->get();
     $dt_piljajak=new Tmjajak_det();
    $id=$get_jajak->C_JAJAK;
    if($id!=NULL)
    {   
    echo form_open('main/view_jajak');
    $get_pil=$dt_piljajak->where("C_JAJAK = $id")->get();
    echo form_hidden("pertayaan", $get_jajak->C_JAJAK);    
    ?>

    <p style="line-height: 25px;"><?php echo $get_jajak->N_TANYA?></p>
    <?php
    foreach ($get_pil as $row) {
         if($row->N_PILIHAN!="")
        echo '<p style=\'line-height:25px\';>'.form_radio(array('name'=>'pilihan', "value"=>$row->C_PILJAJAK)).' '.$row->N_PILIHAN.'</p>';
    }
    ?>   
    
    
    <br/>
    <input type="submit" class="button button-blue" value="vote" style="float: left; margin-right: 5px; margin-left: 5px;"/>
    <a href="<?php echo base_url().'main/view_jajak'; ?>" class="button button-blue"  style="float: left; padding: 8px 20px;">Lihat Hasil</a>
    <div class="clear"></div>
    
    </form>            
    <?php
    }
    else
    {
        echo "<i style='color: #000;font-size: 14px;text-align: center; margin-top: 10px;'>Tidak ada jajak yang aktif</i>";
    }
    ?>
        </div>
    </div>-->

    <div class="isi_tiga" >
        <div class="col-sm-12">
            <h3>Periksa Status Permohonan</h3>
        </div>
        <?php 
            $error = $this->session->flashdata("error");
            if(!empty($error)){
            ?>
            <div class="col-sm-12">
                <div id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                    <center><?php echo $error; ?></center>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-sm-12">
                <p style="line-height: 18px; margin-left: 5px;"><br>Untuk mengetahui status permohonan yang telah anda lakukan, masukan Nomor Pendaftaran anda : </p>
            </div>
        </div>
     <?php echo form_open('main/cek_status/get2',"id='formID' class='formular'");?>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" style="margin-left: 5px;" size="30" id="id_cak" name="id_cak"  class="validate[required] text-input"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                &nbsp;
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="g-recaptcha" data-sitekey="6LcPEK0mAAAAANk0sSXsrrAxKPbgHBWtrMI8eMN4" data-callback="enableBtn" data-expired-callback="disableBtn"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <br/>
                <input type="submit" class="btn btn-primary" id="btnSubmit" value="Cari" style="float: left; margin-left: 5px; " class="validate[required] text-input" disabled="disabled" />
            </div>
        </div>
        
        
        <div class="clear"></div>
    <?php echo form_close(); ?>
    <!-- </form> -->
    </div>

    <!--<div class="isi_tiga">
        <h3 style="margin-bottom:4px;">Gallery Photo</h3>
        
        <?php
            foreach ($data_galeri as $data){
                echo"<a id='example7' href='".base_url()."uploads/galeri/$data->N_ALAMAT_GALLERY' id='example7' title='$data->N_KETERANGAN_GALLERY'><img src='".base_url()."uploads/galeri/". $data->N_ALAMAT_GALLERY."'width='100' height='80' style='margin:1px;'/></a>";
            }
        ?>          


    </div>-->

    <!--<div class="isi_tiga">
        <h3>Daftar Download</h3>
        <ul>
                <?php
                    foreach ($data_download as $data){
                        echo"<li><a style='color:#000000;' target='_blank' href='".base_url()."uploads/admin_upload/".$data->N_ALAMAT_DOWNLOAD."''>".$data->N_KETERANGAN_DOWNLOAD."</a></li>";
                    }
                ?>            
            <li><a href="#" >Malaysia Hentikan Expor CPO</a></li>
            <li><a href="#" style="color:#000000;">BUMN Harus Punya Arah</a></li>
            <li><a href="#" style="color:#000000;">SBY Minta BUMN Bantu Kurang Kemiskinan</a></li>
            <li><a href="#" style="color:#000000;">Dahlan Targetkan 20 BUMN Merger Tahun Ini</a></li>
            <li><a href="#" style="color:#000000;">Presiden SBY Meminta Perampingan BUMN Dilakukan Hati-hati</a></li>
            <li><a href="#" style="color:#000000;">BUMN Harus Punya Arah</a></li>
            <li><a href="#" style="color:#000000;">Malaysia Hentikan Expor CPO</a></li>
            <li><a href="#" style="color:#000000;">SBY Minta BUMN Bantu Kurang Kemiskinan</a></li>
            <li><a href="#" style="color:#000000;">Dahlan Targetkan 20 BUMN Merger Tahun Ini</a></li>
        </ul>
    </div>-->
    
    <div class="kiri" style="dispay:none;"></div>
    

    <div class="clear"></div>
</div>

<script>
    function enableBtn(){
        document.getElementById("btnSubmit").disabled = false;
    }

    function disableBtn(){
        document.getElementById("btnSubmit").disabled = true;
    }
</script>