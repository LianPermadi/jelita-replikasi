<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>

    
    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
    
    <div class="entry">        
      <div id="tabs">
          <ul>
            <li><a href="barang">List Persediaan</a></li>
            <li><a href="logbarang">Log Barang</a></li>
            <li><a href="activity">Activity Barang</a></li>
            <li><a href="permintaanbarang">Permintaan Barang</a></li>
          </ul>


</div>
  <br style="clear: both;" />
</div>