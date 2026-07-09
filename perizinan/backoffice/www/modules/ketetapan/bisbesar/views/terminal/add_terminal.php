<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">




<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_terminal/tambah_aksi" enctype="multipart/form-data">
             <input type="hidden" name ="TERMINAL_I" class="form-control" required>

            <br style="clear: both" />
            <label>TERMINAL / LINTASAN</label>
            <input type="text" name ="NAMA_TERMI" class="form-control" required>

            <br style="clear: both" />
            <label>KAPASITAS</label>
            <input type="number" name ="KAPASITAS" class="form-control" min ="0" required>
           
          
            <br style="clear: both" />
            <label>TYPE</label>
            <select name ="JENIS" class="form-control select" required>
            <option value = 'A'>A</option>
           <option value = 'B'>B</option>
           <option value = 'C'>C</option>
           </select>
            <!--<br style="clear: both" />
  

            <label>KOTA / KAB</label>-->
            <select style="display: none;" name ="KODYA_ID" class="form-control select" required>
            <?php //echo $kodya; ?>
            <option selected value = '-'>-</option>
            </select> 
       
            <!--<br style="clear: both" />
            <label>ALAMAT</label>-->
            <textarea name="ALAMAT" class="input-area-wrc required" style="display: none;" required>-</textarea>
        
            <br style="clear: both" />
            
            





            <button class="button-wrc" style="margin-left: 100px;">Simpan</button>
            <a href = <?php echo base_url().'bisbesar/c_terminal';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="terminal" >
                <thead>
                    <tr>
                        <th width="">No</th>
                        <!--<th width="">KODE TERMINAL</th>-->
                        <th width="">NAMA TERMINAL</th>
                       <!-- <th width="">ALAMAT TERMINAL</th>
                        <th width="">KABUPATEN / KOTA</th>-->
                        <th width="">KAPASITAS</th>
                        <th width="">TYPE</th>
                        <th width="">Aksi</th>
                    </tr>
                </thead>
                <?php
        if($terminal_table !== "")
        {

            echo $terminal_table;

        }
        else
        {
        ?>

            <tr>
            <td colspan="6"><center>Tidak ada data</center></td>
            </tr>
            <?php } ?>
        </tbody>
                </table>


       </div>
       </div>
       </div>


