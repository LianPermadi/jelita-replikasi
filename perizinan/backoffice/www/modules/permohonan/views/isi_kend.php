<?php
$base = base_url() . 'assets/css/default/';
$base_url = base_url() . 'assets/';
echo $this->lib_load_css_js->load_js($base_url, "js/slider/", "s3Slider.js");
echo $this->lib_load_css_js->load_css($base_url, "js/slider/css/", "slide.css");
echo $this->lib_load_css_js->load_js($base_url, "js/fancybox/", "jquery.mousewheel-3.0.4.pack.js");
echo $this->lib_load_css_js->load_js($base_url, "js/fancybox/", "jquery.fancybox-1.3.4.pack.js");
echo $this->lib_load_css_js->load_css($base_url,"js/fancybox/", "jquery.fancybox-1.3.4.css");


?>
<script>
  $(document).ready(function() {
    $('#slider').s3Slider({
      timeOut: 3000
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("a#example7").fancybox({
      'titlePosition' : 'inside'
    });
  });
</script>

<div class="isi2" >
  <h2>CEK NOMOR KENDARAAN</h2>
  <div class="isi_tiga" >
    <h3>Periksa Nomor Kendaraan</h3>
    <p style="line-height: 18px; margin-left: 5px;"><br>Masukkan Nomor Kendaraan Anda : contoh X 1234 XX</p><br>
    <?php echo form_open('main/cek_kend/get',"id='formID' class='formular'");?>  
    <input type="text" style="margin-left: 5px;" size="30" id="id_cak" name="id_cak"  class="validate[required] text-input"/>
    <br/><br/>
    <input type="submit"  class="button button-blue"  value="Cari" style="float: left; margin-left: 5px; " class="validate[required] text-input" />
    <div class="clear"></div>
    </form>
  </div>
  <div class="kiri" style="dispay:none;"></div>
  <div class="clear"></div>
</div>