<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
</head>

<style type="text/css">
  td,th{
    font-size: 11px;
  }
</style>
<?php

if(!empty($tgla)){
  if(!empty($tglb)){
  }
}else{
  $tgla = date('Y')."-01-01";
  $tglb = date('Y')."-12-31";
}

include 'v_header.php';?>
<div class="container" style="margin-top: 30px;">
  <div class="section">
    <div class="row">
      <center>
        <h4>Rekapitulasi Perjalanan Dinas Pegawai DPMPTSP (e-Perdin)</h4>
      </center>
      <table>
        <?php
        $xFunc = "index";
        ?>
        <form action="<?php echo site_url('eperdin/'.$xFunc); ?>" method="post"> 
          <div class="row">
            <div class="input-field col s12">
              <input type="date" placeholder="Range 1" style="text-align: center" name="tgla" value="<?php echo $tgla;?>">
              <input type="date" placeholder="Range 2" style="text-align: center" name="tglb" value="<?php echo $tglb;?>">
              <center>
              <input type="submit" name="submit" value="submit" class="btn">&nbsp;&nbsp; 
              </center>
            </div> 
          </div>
        </form>
      </table>
      <table id="example" class="table table-striped" style="width:100%">
        <thead>
          <tr>
            <td align='center'><?php echo 'NO'; ?></td>
            <td align='center'><?php echo 'Nama' ; ?></td>
            <td align='center'><?php echo 'Jumlah'; ?></td>
            <td style='background-color:#fce4d6' align='center'><?php echo 'Nominal'; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php
          $i=1;
          foreach ($list_perdin as $row){
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $this->m_perdin->get_n_pegawai($row->id_pegawai); ?></td>
              <td><?php echo $this->m_perdin->get_total_jumlahperjalanan($row->id_pegawai, $tgla, $tglb); ?></td>
              <td style='background-color:#fce4d6' class="amount"><?php 
                $hasil_rupiah = "Rp. " . number_format($this->m_perdin->get_total_uangperjalanan($row->id_pegawai, $tgla,$tglb),0,',','.');
                echo $this->m_perdin->get_total_uangperjalanan($row->id_pegawai, $tgla,$tglb); 
                ?>
              </td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>  
    </div>
  </div>
</div>    

<script type="text/javascript">
  $(document).ready(function () {
    $('#example').DataTable();
  });
  
  function formatRupiah() {
    var amountCells = document.getElementsByClassName('amount');
    var formatter = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR'
    });
    
    for (var i = 0; i < amountCells.length; i++) {
      var amount = parseInt(amountCells[i].textContent);
      var formattedAmount = formatter.format(amount);
      amountCells[i].textContent = formattedAmount;
    }
  }
  formatRupiah();
</script>