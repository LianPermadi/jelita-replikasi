<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="syaratizin">
                <thead>
                    <tr>
                        <th width="2%">No</th>
						<th width="5%">Kode Izin</th>
                        <th width="90%">Jenis Izin</th>
						<th width="3%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
				    $cancel_syarat = array(
                        'name' => 'button',
                        'class' => 'button-wrc',
                        'content' => 'Kembali',
                        'onclick' => 'parent.location=\''. site_url('perizinan/persyaratanizin/create') . "/" . $id_izin  . '\''
                    );

                    $i = null;
                    foreach ($list as $data){
						$perizinan = new trperizinan();
                        $perizinan->get_by_id($data->trperizinan_id);
                        $i++;
                ?>
                        <tr>
                            <td><?php echo $i; ?></td>
    						<td><?php echo $perizinan->kd_izin; ?></td>
                            <td><?php echo $perizinan->n_perizinan;?></td>
							<td>
							    <?php 
					                $img_detail = array(
                                    'src' => base_url().'assets/images/icon/property.png',
                                    'alt' => 'Detail',
                                    'title' => 'Detail',
                                    'border' => '0',
                                );
                                echo anchor(site_url('perizinan/persyaratanizin/detail') .'/'. $data->trperizinan_id, img($img_detail));
                                echo "&nbsp;&nbsp;";
				                ?>
							</td>
                        </tr>
                        <?php
                    }
                        ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th width="2%">No</th>
						<th width="5%">Kode Izin</th>
                        <th width="90%">Jenis Izin</th>
						<th width="3%">Aksi</th>
                    </tr>
                </tfoot>
            </table>
		</div>
		<div class="contentForm" style="text-align: center; margin-top: 10px;">
            <?php
            echo form_button($cancel_syarat);
            ?>
		</div>
    </div>
    <br style="clear: both;" />
</div>