    <script type='text/javascript' src='<?php echo base_url();?>assets/autocomplete/js/jquery-1.8.2.min.js'></script>
    <script type='text/javascript' src='<?php echo base_url();?>assets/autocomplete/js/jquery.autocomplete.js'></script>
    <link href='<?php echo base_url();?>assets/autocomplete/js/jquery.autocomplete.css' rel='stylesheet' />
   <!--<link href='<?php  echo base_url();?>assets/autocomplete/css/default.css' rel='stylesheet' />-->

    <script type='text/javascript'>
        var site = "<?php echo site_url();?>";
        $(function(){
            $('.autocomplete').autocomplete({
                serviceUrl: site+'/autocomplete/search',
                onSelect: function (suggestion) {
                    $('#v_nim').val(''+suggestion.nim);
                    $('#v_jurusan').val(''+suggestion.jurusan);
                }
            });
        });
    </script>

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
<form action="<?php echo site_url('admin/c_admin/add_orders'); ?>" method="post">
    <div class="wrap">
    <table>
        <tr>
            <td><small>Nama :</small><br><input type="search" class='autocomplete nama' id="autocomplete1" name="nama_customer"/></td>
        </tr>
        <tr>
            <td><small>Jurusan :</small><br><input type="text" class='autocomplete' id="v_jurusan" name="nama_customer"/></td>
        </tr>
        <tr>
            <td><small>NIM :</small><br><input type="text" class='autocomplete' id="v_nim" name="nama_customer"/></td>
        </tr>
    </div>
</form>
<br style="clear: both" />
</div>
</div>
</div>

