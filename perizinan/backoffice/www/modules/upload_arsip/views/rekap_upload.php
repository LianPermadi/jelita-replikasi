<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/addSMSGateway/jquery.ui.dialog.js"></script>
<form id="smsdialog" action="<?php echo base_url(); ?>pelayanan/ambilsk/sendSMSGateway" method="post" style="display:none">
Apa anda yakin akan mengirim SMS ke no ini ?<br />
    <b>No Telp :</b><span id="spanno"></span><input type="hidden" size="15" maxlength="15" id="txtno" name="txtno" value=""  />
    <input type="hidden" name="txtisi" id="txtisi" value=""  /><br />
    <input type="submit" value="Kirim" name="tblkirim" id="tblkirim"  />&nbsp;&nbsp;
	<input type="reset" value="Batal" name="tblreset" id="tblreset"  />
    <span id="warning"></span>
</form>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Filter Data</legend>
                <?php 
					$attr = array(
                        'class' => 'searchForm',
                        'id' => 'searchForm'
                    );
                    echo form_open("upload_arsip/rekapupload", $attr);
				?>
                
				

                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tanggal Awal','d_tahun');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $periodeawal_input = array(
                            'name'  => 'tgla',
                            'value' => $tgla,
                            'readOnly'=>TRUE,
                            'class' => 'input-wrc',
                            'class' => 'monbulan'
                        );
                        echo form_input($periodeawal_input);
                        ?>
                    </div>
                </div>
                
				<div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tgl Akhir','d_tahun');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $periodeakhir_input = array(
                            'name'  => 'tglb',
                            'value' => $tglb,
                            'readOnly'=>TRUE,
                            'class' => 'input-wrc',
                            'class' => 'monbulan'
                        );
                        echo form_input($periodeakhir_input);
                        ?>
                    </div>
                </div>
                
				<div id="statusRail">
                    <div id="leftRail"></div>
                    <div id="rightRail">
                        <?php
                        $filter_data = array(
                            'name' => 'button',
                            'class' => 'button-wrc',
                            'content' => 'Filter',
                            'value' => 'Filter'
                        );
                        echo form_submit($filter_data);
						
                        ?>
                    </div>
                </div>

                <?php
                echo form_close();
                ?>
				
            </fieldset>
        </div>
		<b> <?php
                    echo "<center>Jumlah FIle Yang Diupload : ".number_format($jum_upload)."<br><br></center>"; 
                ?>
                </b>
      
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="penyerahan">
                <thead>
                    <tr>
                        <th width="">No</th>
                       
                        <th width="">Nama File</th>
                        <th width="">Tanggal Upload</th>
                        <th width="">User</th>
                        <th width="">Jenis File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                          $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
                        //$id_pendaftaran = $rows['id_pendaftaran'];
                        $nama_file = $rows['nama_file'];
                        $keterangan = $rows['keterangan'];
                        $user = $rows['user'];
                        $tg_upload = $rows['tg_upload'];
                        ?>
                        <tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo $nama_file; ?></td>
                            <td><?php echo $tg_upload; ?></td>
                            <td><?php echo $user; ?></td>
                            <td><?php echo $keterangan; ?></td>

                        </tr>
                        <?php
$i++;
                    }
                        ?>

                        
                </tbody>
            </table>
        </div>

    </div>
    <br style="clear: both;" />
</div>
