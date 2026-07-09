<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
<div style="margin:10px; margin-right:100px">
    <h2>Form Input Text Area</h2>

    <form action="/jelita/backoffice/pengembangan/approve_action_back/<?php echo $id; ?>" method="post">
        <label for="pesan">Masukkan pesan Anda:</label>
        <br>
        <textarea id="pesan" name="pesan" rows="4" cols="50" class="input-wrc" style="border: 1px solid #ccc;padding: 8px;background-color:white;margin: 8px 0;box-sizing: border-box;width: 100%;"></textarea>
        <br>
        <input type="submit" class="button-wrc" value="Kirim">
    </form>
</div>
    </div>
  </div>
  <br style="clear: both;" />
</div>