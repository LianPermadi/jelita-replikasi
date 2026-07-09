 <?php
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(14);
        $app_name = $this->db->select('value')
                        ->where('name', 'app_name')
                        ->get('settings')
                        ->row();

        if ($app_name) {
            $app_name_value = $app_name->value;
        } else {
            $app_name_value = 'Nama aplikasi tidak ditemukan';
        }

        $img = array('src'=>'uploads/logo/' . $logo->value,
                     'width'=>'60',
                     'height'=>'65');
   ?>
<div id="header">
    <div class="instansi">
    <?php echo img($img); ?>
        <p>
        <?php
            //$provinsi = $this->tr_instansi->get_by_id(17);
			//echo "<font size='4'>".$provinsi->value."</font>";
			$sotk = $this->tr_instansi->get_by_id(9);
			echo "<font size='5'>".$sotk->value."</font>";
            echo  br(1)."<font size='5'>"."$app_name_value"."</font>";
			//echo  "<font size='2'>"." Versi Jawa Barat"."</font>";
        ?>
        </p>
    </div>
</div>