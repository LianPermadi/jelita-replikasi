<script>
  var $jnoc = jQuery.noConflict();
      $jnoc(document).ready(function() {
  	    $jnoc('#dataTables').DataTable();
      } );
</script>

<div class="isi">
  <div id="entry">
    <h2><?php echo "$title" ?></h2>
    <div class="kiri">
      <div class="izin">
        <br/>
        <!-- <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">-->
        <?php
        if(!empty($print)){
          // Menyimpan data tabel HTML dalam format Excel
          header("Content-Type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=data_excel.xls");
        }else{
          echo "<a href='jenis_perizinan/printer'>Print</a>";
        }
        ?>
        <table width="100%" cellpadding="0" cellspacing="0" id="dataTables">
          <thead>
            <tr>
              <th width="5%"><b>NO </b>  </th>
              <th width="60%"><b>Nama Kegiatan </b>  </th>
              <th width="20%"><b>Nomor SOP</b>  </th>
              <th width="15%"><b>DOWNLOAD</b></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $n = 1;

            // Iterate through each object in the array
            foreach ($data_table as $row) {
              // Replace spaces with underscores for the filename
              // Generate a link to view the file
              $file_link = "https://dpmptsp.jabarprov.go.id/web/application/modules/arsip/files/bahan_publikasi_sop/" . $row->Nama_File .".pdf";
              // Output table row with object data
              $file = FALSE;
              if(file_exists('../web/application/modules/arsip/files/bahan_publikasi_sop/'.$row->Nama_File .'.pdf')){
                $file = TRUE;	
              }
              echo "<tr>
                      <td style='text-align:center;'>".$n."</td>
                      <td>".$row->Nama_kegiatan."</td>
                      <td style='text-align:right;'>".$row->Nomor_Sop."</td>
                      <td style='text-align:center;'>
                        <a href='".$file_link."' target='_blank'>Lihat SOP</a>
                      </td>
                    </tr>";
                  
              $n++; // Increment row number
            }
            ?>
            <!-- <tr>
              <td>
                  1
              </td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </div>
    <div class="kanan">
      <?php //echo "$menu" ?>
      <?php //echo "$menu1" ?>
    </div>
  </div>
  <div class="clear"></div>
</div>