<div id="content">
    <div class="post">
        <div class="title">
            <h2>Upload Template Laporan</h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Jenis Perizinan</legend>
                <div id="statusRail">
                    <div id="leftRail" class="bg-grid">
                        <?php
                        echo 'Nama Perizinan ';
                        ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php
                        echo $nama_izin;
                        ?>
                    </div>
                </div>        
                <p style="text-align: right">
                    <?php
                    $img_back = array(
                        'src' => 'assets/images/icon/back_alt.png',
                        'alt' => 'Back',
                        'title' => 'Back',
                        'border' => '0',
                    );
                    ?>
                    <a class="page-help" href="<?php echo site_url('property/master/detail/' . $id); ?>">
                        <?php echo img($img_back); ?></a>
                </p>
            </fieldset>

            <fieldset id="half">
                <legend>Upload Template Laporan</legend>
                    <form action="<?php echo site_url('property/master/upload2/' .$id); ?>" method="post" enctype="multipart/form-data">
						<select name="jenis" class="input-select-wrc valid">
							<option value="kabad">Template Kabad</option>
							<option value="gubernur">Template Gubernur</option>
						</select><br>
                        <input type="file" name="fileToUpload" id="fileToUpload" class="submit-wrc" value="Pilih file" required>
                        <input type="submit" class="submit-wrc" style="text-decoration:none; float:right; width:100px;" value="NEXT" />
                    </form>        
            </fieldset>
            <p style="margin-top:23em;"></p>
        </div>

    </div>
    <br style="clear: both;" />
</div>
