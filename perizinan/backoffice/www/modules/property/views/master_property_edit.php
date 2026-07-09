<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
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
          $img_word = array('src' => 'assets/images/icon/word.png',
                            'alt' => 'Upload Template Laporan',
                            'title' => 'Upload Template Laporan',
                            'border' => '0');
          
          $img_plus = array('src' => 'assets/images/icon/plus.png',
                            'alt' => 'Tambah Property',
                            'title' => 'Tambah Property',
                            'border' => '0');
          
          $img_back = array('src' => 'assets/images/icon/back_alt.png',
                            'alt' => 'Back',
                            'title' => 'Back',
                            'border' => '0');
          
          echo anchor(site_url('property/master/Upload/').'/'.$id,img($img_word), 'class="page-help"');
          echo anchor(site_url('property/master/add/').'/'.$id,img($img_plus), 'class="page-help"');
          echo anchor(site_url('property/master/'),img($img_back), 'class="page-help"');
          ?>
        </p>
      </fieldset>
    </div>
    <?php
    if($ket_exist) {
      echo "<div class='entry' title='Silahkan cari di tab Tambah Property Database' align=center><b style='color: #FF0000;'>Nama property \"" . $ket_exist . "\" sudah ada di Database !!</b></div>";
    }
    ?>
    <div class="entry">
    	<?php
      $attr = array('name' => 'form', 'id' => 'form');
      echo form_open('property/master/savetampil', $attr);
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="property_list">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="3%">No Fild</th>
            <th width="20%">Nama Property</th>
            <th width="10%">Kategori</th>
            <th width="5%">Parent</th>
            <th width="5%">Urutan</th>
            <th width="7%">Tampil di<br>Surat Izin</th>
            <th width="7%">Tampil di<br>Pemohon Online</th>
            <th width="7%">Tampil di<br>Pencabutan</th>
            <th width="7%">Tampil di<br>Tinjauan Lapangan / BAP</th>
            <th width="7%">Type</th>
            <th width="10%">Combo Item</th>
            <th width="5%">Aktif</th>
            <!--<th width="5%">Tampil di Pemohon</th>-->
            <th width="5%">Aksi</th>
          </tr>
        </thead>    
        <tbody>
          <?php
          $i = 1;
          $text = $this->lib_date->data_property($id,'2');
          $list = explode (",",$text);
          foreach ($list as $data) {
            //if(array_key_exists($list[12], $list)) $tampil = $this->lib_date->array_property('12',$data); else $tampil = 'Ya';  // cek undifine array
            ?>
            <tr>
              <td>        <?php echo $i; ?></td>
        	    <td>        <?php echo $this->lib_date->array_property('0' ,$data); ?></td>
        	    <td>        <?php echo $this->lib_date->array_property('1' ,$data); ?></td>
        	    <td>        <?php echo $this->lib_date->array_property('2' ,$data); ?></td>
        	    <td>        <?php echo $this->lib_date->array_property('3' ,$data); ?></td>
        	    <td><center><?php echo $this->lib_date->array_property('4' ,$data); ?></center></td>
        	    <td><center><?php echo $this->lib_date->array_property('5' ,$data); ?></center></td>
        	    <td><center><?php echo $this->lib_date->array_property('6' ,$data); ?></center></td>
        	    <td><center><?php echo $this->lib_date->array_property('7' ,$data); ?></center></td>
        	    <td><center><?php echo $this->lib_date->array_property('8' ,$data); ?></center></td>
        	    <td><center><?php echo $this->lib_date->array_property('9' ,$data); ?></center></td>
        	    <td>        <?php echo $this->lib_date->array_property('10',$data); ?></td>
        	    <td><center><?php echo $this->lib_date->array_property('11',$data); ?></center></td>
        	    <!--<td><center><?php echo $tampil; ?></center></td>-->
        	    <!--
        	    <td>
  						  <center>
                  <?php 
                  if($this->lib_date->array_property('11',$data) == "Ya") { 
                  	if($this->lib_date->array_property('11',$data) == "Ya"){
                  	  ?>
                      <select name="view_ol[]">
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                      </select>
                      <?php
                    }else{
                  	  ?>
                      <select name="view_ol[]">
                        <option value="Tidak">Tidak</option>
                        <option value="Ya">Ya</option>
                      </select>
                      <?php
                    }
                  }else{
                  	?>
                    <input type="text" class = "input-wrc" value="Tidak" name="view_ol[]" style="width: 70%; text-align: left;" readonly>
                    <?php
                  }
                  ?>
                </center>
				    	</td>
				    	-->
              <td>
        	      <center>
                  <?php
        	        $cek_id_property = $this->lib_date->array_property('0' ,$data);
                  $img_edit = array('src' => 'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => 'Edit',
                                    'border' => '0');
                  echo anchor(site_url('property/master/property/').'/'.$id."/".$i."/". $cek_id_property,img($img_edit), 'class="page-help"');

                  $confirm_text = 'Apakah Anda yakin akan menghapusnya?';
                  $img_cancel = array('src' => 'assets/images/icon/cross.png',
                                      'alt' => 'Hapus',
                                      'title' => 'Delete',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\'' . $confirm_text . '\')');
                  ?>
        	      </center>
              </td>
            </tr>
            <?php
            echo form_hidden('end_property', $i);
            $i++;
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>No Fild</th>
            <th>Nama Property</th>
            <th>Kategori</th>
            <th>Parent</th>
            <th>Urutan</th>
            <th>Tampil di<br>Surat Izin</th>
            <th>Tampil di<br>Pemohon Online</th>
            <th>Tampil di<br>SKRD</th>
            <th>Tampil di<br>Tinjauan Lapangan / BAP</th>
            <th>Type</th>
            <th>Combo Item</th>
            <th>Aktif</th>
            <!--<th>Tampil di Pemohon</th>-->
            <th>Aksi</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>