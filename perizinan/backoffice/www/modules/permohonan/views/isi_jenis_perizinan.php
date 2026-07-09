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
                <th ><b>NO </b>  </th>
                <th><b>DAFTAR JENIS PERIZINAN </b>  </th>
                <th><b>DURASI</b> </th>
                 <th><b>BIAYA</b> </th>
                <th><b> </b></th>
                <th><b> </b></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $n=1;
               // $list[] = array('id' => '9',
               //                'jenis_perizinan' =>'9',
               //                'v_hari' => '9',
               //                'c_aktif' => '9',
               //                'c_online' =>'9'
               //               );

              foreach($list as $row) {
                $x = str_replace(' ', "_", $row['jenis_perizinan']);
                $link = anchor('main/jenis_perizinan/syarat/' . $row['id'], 'Lihat Persyaratan');
          	    $link2 = anchor('main/jenis_perizinan/cetak_syarat/' . $row['id'], 'Cetak Persyaratan');
          	    if($row['c_aktif'] == '1') $nn = '|'; else $nn = '||';
          	    if($row['id'] <> '237'){
          		    if($row['c_aktif'] == '0' || $row['c_online'] == '0'){
                    echo "<tr>
          				          <td style='text-align:center;'>".$n."</td>
          				          <td>".$row['jenis_perizinan']."</td>
                            <td>".$row['v_hari']." hari </td>
                            <td>GRATIS </td>
                            <td>$link</td>
                            <td>$link2</td>
                          </tr>
                         ";
                    $n++;
          	      }
              	}
              }
              ?>
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