<!--<div class="kanan_menu">
    <?php
    $dt = new Tmjajak();
    ?>
    <h3>Periksa Status Permohonan</h3>
    <p style="line-height: 18px; margin-left: 5px; ">Untuk mengetahui status permohonan yang telah anda lakukan, masukan Nomor Pendaftaran anda : </p>
    <form id="my_cek" method="post" action="#" name="my_cek" class="formular">
        <input type="text" style="margin-left: 5px;" size="26" id="id_cak" name="id_cak"/>
        <br/><br/>
        <input type="submit"  class="button button-blue" value="Cari" style="float: left; margin-left: 5px; " class="validate[required] text-input" />
        <div class="clear"></div>
    </form>

    <script>
        jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
              $("#my_cek").submit(
              function(){
                 var id_cak= $("#id_cak").val();
                  if ($("#id_cak").val() == ''){
                      alert(" Nomor Pendaftaran Tidak Boleh Kosong");
                  }else{
                     $("#entry h2").html('Cek Status Izin');
                     $(".kiri").load(site+'main/cek_status/get/'+id_cak);
                  }
                  return false;
              });
        });
    </script>



</div>

<div class="kanan_menu">
    <h3>Statistik User</h3>
    <?php
         $dt = new Tm_konter();
         $get_jumlah= $dt->get()->count();
    ?>
    <p>Total pengunjung : <b><?php echo $get_jumlah ?> User</b></p>
 
    <div class="clear"/></div>
</div>-->