
<div id="content">
    <div class="post">
        <div class="title">
            <h2>Upload Template Laporan</h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Jenis Perizinan</legend>
                <div id="statusRail">
                    <div id="leftRail" class="bg-grid">
                        <?php
                        echo 'Nama Perizinan ';
                        ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php
                        echo $nama_izin;
                        ?>
                    </div>
                </div>        
                <p style="text-align: right">
                    <?php
                    $img_back = array(
                        'src' => 'assets/images/icon/back_alt.png',
                        'alt' => 'Back',
                        'title' => 'Back',
                        'border' => '0',
                    );
                    ?>
                    <a class="page-help" href="<?php echo site_url('property/master/upload/' .$id); ?>">
                        <?php echo img($img_back); ?></a>
                </p>
            </fieldset>

        </div>

        <div class="entry">
        <form action="<?php echo site_url('property/master/template/' . $id); ?>" method="POST">
			<input type="hidden" name="jenis" value="<?php echo $jenis; ?>">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="property_list">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <td width="10%" class="ui-state-default" style="border-bottom:1px solid black;"><center><b>All</b> <input type="checkbox" class="submit-wrc" name="allbox" value="check" onclick="checkAll(0);" checked /></center></td>
                        <th width="45%">Nama Property</th>
                        <th width="20%">Judul Property</th>
                        <th width="20">Value Property</th>
                    </tr>
                </thead>    
                <tbody>
                   <?php
                    $no = 1;
                    $jumlah_semua = 1;
                    while($no<=100){

                    $tek = "var_teknis".$no;
                    $prop = $properti[$tek];
                    
                    
                    if(empty($prop)){
                        break;
                    }
                    
                    
                    $array = explode("^",$prop);    

                    ?>          
                        <!--<input type="hidden" name="status_<?php echo $no4; ?>" value="<?php echo $array[11]; ?>">-->
                        <?php if($array[11]=="Ya"){ ?>  
    
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><input type="checkbox" name="cek_<?php echo $no; ?>" value="Yes" checked></td>
                            <td><?php echo $array[1]; ?><input type="hidden" value="<?php echo $no; ?>" name="property_id_<?php echo $no; ?>"></td>
                            <td>
                                <center>
                                    <select name="judul_<?php echo $no; ?>" id="combo-01">
                                        <?php echo $pilihan; ?>
                                    </select>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <select name="value_<?php echo $no; ?>" id="combo-01">
                                        <?php echo $pilihan2; ?>
                                    </select>
                                </center>
                            </td>
                        </tr>
                       <?php
                        }else{
                            echo "<input type='hidden' name='cek_$no'>";
                        }
                       $no++;
                    }
                    ?>
                </tbody>
            </table>
            <input type='hidden' name='file' value="<?php echo basename($_FILES["fileToUpload"]["name"]); ?>"><br/>
            <input type='hidden' name='id' value=" <?php echo $id; ?>">
            <input type="hidden" value="<?php echo $nama_izin; ?>" name="namaizin">
            <input type="hidden" value="<?php echo $no-1; ?>" name="nomor">
            <center><input type="submit" class="submit-wrc" value="SIMPAN" name="kirim" style="width:100px; margin-top:10px;"></center>
            </form>
        </div>
    </div>
    <br style="clear: both;" />
</div>

<script type="text/javascript"> 
//check all checkbox
function checkAll(form){
    for (var i=0;i<document.forms[form].elements.length;i++)
    {
        var e=document.forms[form].elements[i];
        if ((e.name !='allbox') && (e.type=='checkbox'))
        {
            e.checked=document.forms[form].allbox.checked;
        }
    }
}
</script>