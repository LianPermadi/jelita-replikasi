<!--<div class="kanan_menu">
    <h3>Pencarian Info</h3>
    
        <?php echo form_open('main/info_publik/search'); ?>
            <input type="text" style="width: 250px; margin-left: 4px;" name="id"/>
              <input type="submit" value="Cari Info" class="button button-blue" style="float: left; margin-left: 4px;"/>
        </form>
 
    <div class="clear"/></div>
</div>

<div class="kanan_menu">
    <h3>Jajak Pendapat</h3>
    <?php
    
    $dt_jajak=new Tmjajak();
    $dt_piljajak=new Tmjajak_det();
    $get_jajak=$dt_jajak->where("STATUS = 1 and (D_PRD_AWAL <= now() and D_PRD_AKHIR >= now()) limit 1")->get();  
    $id=$get_jajak->C_JAJAK;
    if($id!=NULL)
    {           
          echo form_open('main/view_jajak');
          $get_pil=$dt_piljajak->where("C_JAJAK = $id")->get();
          echo form_hidden("pertayaan", $get_jajak->C_JAJAK);    
        ?>
       <p><?php echo $get_jajak->N_TANYA?></p>
        <?php
        foreach ($get_pil as $row) {
            if($row->N_PILIHAN!="")
                echo '<p>'.form_radio(array('name'=>'pilihan', "value"=>$row->C_PILJAJAK)).' '.$row->N_PILIHAN.'</p>';
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
        echo "<i style='color: #000;font-size: 14px; text-align: center; margin-top: 10px;'>Tidak ada jajak yang aktif</i>";
    }
    ?>
    
    
</div>-->

