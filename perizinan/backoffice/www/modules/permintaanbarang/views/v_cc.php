<div id="content">
    <div class="post">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
        <form action="">
            <input type="hidden" name="langkah" value="0">
            <select class="input-wrc" name="penerima" style="width:100%; background-color:white; border: 2px solid greenyellow;">
                <option value="-">-</option>
                <?php foreach ($user as $row) { ?>
                <option value="<?php echo $row->id; ?>">
                    <?php echo $row->n_pegawai; ?>
                </option>
                <?php } ?>
            </select>
        </form>
    </div>
</div>