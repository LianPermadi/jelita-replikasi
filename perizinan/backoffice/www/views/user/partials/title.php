 <?php
        $this->tr_instansi = new Tr_instansi();
        
        $logo = $this->tr_instansi->get_by_id(14);
        $img = array('src'=>'uploads/logo/' . $logo->value,
                     'width'=>'60',
                     'height'=>'70');
   ?>
<div id="header">
    <div class="instansi">
    <?php echo img($img); ?>
        <p>
        <?php
            //$provinsi = $this->tr_instansi->get_by_id(17);
			//echo "<font size='4'>".$provinsi->value."</font>";
			$sotk = $this->tr_instansi->get_by_id(9);
			echo "<font size='4'>".$sotk->value."</font>";
            echo  br(1)."<font size='4'>"."DATA DAN STATISTIK"."</font>";
			
        ?>
        </p>
    </div>
</div>