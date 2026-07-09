<div class="isi">
  <div id="entry">
    <h2><?php echo "$title" ?></h2>
    <div class="kiri">
      <div class="izin">
        <br/>
        <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
          <thead>
            <?php echo '<b>'.strtoupper($nama_jenis).' (PERMOHONAN BARU)</b>';?>
            <tr bgcolor="#CBE5EB">
              <th width="5%">NO</th>
              <th style="width:85%">DAFTAR SYARAT</th>
              <th style="width:10%"><center>FORM</center></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $n = 1;
            foreach ($list as $row) {
              $rule = strval(decbin($row['c_show_type']));
              if($row['status_new'] == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
              if(strlen($rule) < $plv) {
                $len = $plv - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
              }
              if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
              $arr_rule = str_split($rule);
              if($plv == 4){
                $c_baru         = $arr_rule[1];
                $c_daftar_ulang = $arr_rule[0];
              }else{
                $c_baru         = $arr_rule[0];
                $c_daftar_ulang = $arr_rule[1];
              }
              $c_perpanjangan = $arr_rule[2];
              $c_ubah         = $arr_rule[3];
              $c_pencabutan   = $arr_rule[4]; 
              $c_penutupan    = $arr_rule[5];
              if($c_baru == '1'){
                echo "<tr>";
                if($row['syarat_perizinan']=="Belum Tersedia Syarat Perizinan"){
                  echo "<td>-</td>";
      			      echo "<td>-</td>";
      			      echo "<td>-</td>";
                }else{
                  echo "<td>$n</td>";
                  echo "<td>" . $row['syarat_perizinan'] . "</td>";
      	          if($row['nama_formulir'] != ''){
                    if(file_exists('assets/userassets/formulir/'.$row['nama_formulir'])){  
                                            echo "<td> <a href='".base_url()."assets/userassets/formulir/".$row['nama_formulir']."' target='_blank'> Download </a> </td>"; 
                    } else {
                        echo "<td>" . 'Download' . "</td>";
                    }
                  } else {
                    echo "<td>&nbsp;</td>";
                  }
      	        }
                echo "</tr>";
                $n++;
              }
            }
            if($n == 1){
              echo "<tr>";
              echo "<td>-</td>";
              echo "<td>-</td>";
              echo "<td>-</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
        <br/>
        
        <!--    <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
                <thead>
					<?php echo '<b>'.strtoupper($nama_jenis).' (DAFTAR ULANG)</b>';?>
                        <tr bgcolor="#CBE5EB">
                            <th width="5%">NO</th>
                            <th style="width:85%">DAFTAR SYARAT</th>
							<th style="width:10%"><center>FORM</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($list as $row) {
                            $rule = strval(decbin($row['c_show_type']));
			                if($row['status_new'] == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                            if (strlen($rule) < $plv) {
                                $len = $plv - strlen($rule);
                                $rule = str_repeat("0", $len) . $rule;
                            }
                            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
                            $arr_rule = str_split($rule);
                            if($plv == 4){
                                $c_baru         = $arr_rule[1];
                                $c_daftar_ulang = $arr_rule[0];
                            }else{
                     		    $c_baru         = $arr_rule[0];
                                $c_daftar_ulang = $arr_rule[1];
                     		}
                            $c_perpanjangan = $arr_rule[2];
                            $c_ubah         = $arr_rule[3];
                            $c_pencabutan   = $arr_rule[4]; 
                            $c_penutupan    = $arr_rule[5];
                            
							if($c_daftar_ulang == '1'){
                                echo "<tr>";
                                if($row['syarat_perizinan']=="Belum Tersedia Syarat Perizinan"){
                                    echo "<td>-</td>";
		    					    echo "<td>-</td>";
			    				    echo "<td>-</td>";
                                }else{
                                    echo "<td>$n</td>";
                                    echo "<td>" . $row['syarat_perizinan'] . "</td>";
							        echo "<td>" . 'download' . "</td>";
							    }
                                echo "</tr>";
                                $n++;
							}
                        }
						if($n == 1){
							echo "<tr>";
							echo "<td>-</td>";
							echo "<td>-</td>";
					        echo "<td>-</td>";
							echo "</tr>";
						}
                        ?>
                    </tbody>
                </table>

				<br/>
                <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
                    <thead>
					<?php echo '<b>'.strtoupper($nama_jenis).' (PERPANJANGAN)</b>';?>
                        <tr bgcolor="#CBE5EB">
                            <th width="5%">NO</th>
                            <th style="width:85%">DAFTAR SYARAT</th>
							<th style="width:10%"><center>FORM</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($list as $row) {
                            $rule = strval(decbin($row['c_show_type']));
			                if($row['status_new'] == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                            if (strlen($rule) < $plv) {
                                $len = $plv - strlen($rule);
                                $rule = str_repeat("0", $len) . $rule;
                            }
                            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
                            $arr_rule = str_split($rule);
                            if($plv == 4){
                                $c_baru         = $arr_rule[1];
                                $c_daftar_ulang = $arr_rule[0];
                            }else{
                     		    $c_baru         = $arr_rule[0];
                                $c_daftar_ulang = $arr_rule[1];
                     		}
                            $c_perpanjangan = $arr_rule[2];
                            $c_ubah         = $arr_rule[3];
                            $c_pencabutan   = $arr_rule[4]; 
                            $c_penutupan    = $arr_rule[5];
                            
							if($c_perpanjangan == '1'){
                                echo "<tr>";
                                if($row['syarat_perizinan']=="Belum Tersedia Syarat Perizinan"){
                                    echo "<td>-</td>";
		    					    echo "<td>-</td>";
			    				    echo "<td>-</td>";
                                }else{
                                    echo "<td>$n</td>";
                                    echo "<td>" . $row['syarat_perizinan'] . "</td>";
							        echo "<td>" . 'download' . "</td>";
							    }
                                echo "</tr>";
                                $n++;
							}
                        }
						if($n == 1){
							echo "<tr>";
							echo "<td>-</td>";
							echo "<td>-</td>";
					        echo "<td>-</td>";
							echo "</tr>";
						}
                        ?>
                    </tbody>
                </table>

				<br/>
                <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
                    <thead>
					<?php echo '<b>'.strtoupper($nama_jenis).' (PERUBAHAN)</b>';?>
                        <tr bgcolor="#CBE5EB">
                            <th width="5%">NO</th>
                            <th style="width:85%">DAFTAR SYARAT</th>
							<th style="width:10%"><center>FORM</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($list as $row) {
                            $rule = strval(decbin($row['c_show_type']));
			                if($row['status_new'] == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                            if (strlen($rule) < $plv) {
                                $len = $plv - strlen($rule);
                                $rule = str_repeat("0", $len) . $rule;
                            }
                            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
                            $arr_rule = str_split($rule);
                            if($plv == 4){
                                $c_baru         = $arr_rule[1];
                                $c_daftar_ulang = $arr_rule[0];
                            }else{
                     		    $c_baru         = $arr_rule[0];
                                $c_daftar_ulang = $arr_rule[1];
                     		}
                            $c_perpanjangan = $arr_rule[2];
                            $c_ubah         = $arr_rule[3];
                            $c_pencabutan   = $arr_rule[4]; 
                            $c_penutupan    = $arr_rule[5];
                            
							if($c_ubah == '1'){
                                echo "<tr>";
                                if($row['syarat_perizinan']=="Belum Tersedia Syarat Perizinan"){
                                    echo "<td>-</td>";
		    					    echo "<td>-</td>";
			    				    echo "<td>-</td>";
                                }else{
                                    echo "<td>$n</td>";
                                    echo "<td>" . $row['syarat_perizinan'] . "</td>";
							        echo "<td>" . 'download' . "</td>";
							    }
                                echo "</tr>";
                                $n++;
							}
                        }
						if($n == 1){
							echo "<tr>";
							echo "<td>-</td>";
							echo "<td>-</td>";
					        echo "<td>-</td>";
							echo "</tr>";
						}
                        ?>
                    </tbody>
                </table>

				<br/>
                <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
                    <thead>
					<?php echo '<b>'.strtoupper($nama_jenis).' (PENCABUTAN)</b>';?>
                        <tr bgcolor="#CBE5EB">
                            <th width="5%">NO</th>
                            <th style="width:85%">DAFTAR SYARAT</th>
							<th style="width:10%"><center>FORM</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($list as $row) {
                            $rule = strval(decbin($row['c_show_type']));
			                if($row['status_new'] == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                            if (strlen($rule) < $plv) {
                                $len = $plv - strlen($rule);
                                $rule = str_repeat("0", $len) . $rule;
                            }
                            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
                            $arr_rule = str_split($rule);
                            if($plv == 4){
                                $c_baru         = $arr_rule[1];
                                $c_daftar_ulang = $arr_rule[0];
                            }else{
                     		    $c_baru         = $arr_rule[0];
                                $c_daftar_ulang = $arr_rule[1];
                     		}
                            $c_perpanjangan = $arr_rule[2];
                            $c_ubah         = $arr_rule[3];
                            $c_pencabutan   = $arr_rule[4]; 
                            $c_penutupan    = $arr_rule[5];
                            
							if($c_pencabutan == '1'){
                                echo "<tr>";
                                if($row['syarat_perizinan']=="Belum Tersedia Syarat Perizinan"){
                                    echo "<td>-</td>";
		    					    echo "<td>-</td>";
			    				    echo "<td>-</td>";
                                }else{
                                    echo "<td>$n</td>";
                                    echo "<td>" . $row['syarat_perizinan'] . "</td>";
							        echo "<td>" . 'download' . "</td>";
							    }
                                echo "</tr>";
                                $n++;
							}
                        }
						if($n == 1){
							echo "<tr>";
							echo "<td>-</td>";
							echo "<td>-</td>";
					        echo "<td>-</td>";
							echo "</tr>";
						}
                        ?>
                    </tbody>
                </table>

				<br/>
                <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
                    <thead>
					<?php echo '<b>'.strtoupper($nama_jenis).' (PENUTUPAN)</b>';?>
                        <tr bgcolor="#CBE5EB">
                            <th width="5%">NO</th>
                            <th style="width:85%">DAFTAR SYARAT</th>
							<th style="width:10%"><center>FORM</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($list as $row) {
                            $rule = strval(decbin($row['c_show_type']));
			                if($row['status_new'] == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                            if (strlen($rule) < $plv) {
                                $len = $plv - strlen($rule);
                                $rule = str_repeat("0", $len) . $rule;
                            }
                            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
                            $arr_rule = str_split($rule);
                            if($plv == 4){
                                $c_baru         = $arr_rule[1];
                                $c_daftar_ulang = $arr_rule[0];
                            }else{
                     		    $c_baru         = $arr_rule[0];
                                $c_daftar_ulang = $arr_rule[1];
                     		}
                            $c_perpanjangan = $arr_rule[2];
                            $c_ubah         = $arr_rule[3];
                            $c_pencabutan   = $arr_rule[4]; 
                            $c_penutupan    = $arr_rule[5];
                            
							if($c_penutupan == '1'){
                                echo "<tr>";
                                if($row['syarat_perizinan']=="Belum Tersedia Syarat Perizinan"){
                                    echo "<td>-</td>";
		    					    echo "<td>-</td>";
			    				    echo "<td>-</td>";
                                }else{
                                    echo "<td>$n</td>";
                                    echo "<td>" . $row['syarat_perizinan'] . "</td>";
							        echo "<td>" . 'download' . "</td>";
							    }
                                echo "</tr>";
                                $n++;
							}
                        }
						if($n == 1){
							echo "<tr>";
							echo "<td>-</td>";
							echo "<td>-</td>";
					        echo "<td>-</td>";
							echo "</tr>";
						}
                        ?>
                    </tbody>
                </table>
        -->
      </div>
    </div>

    <div class="kanan">
      <?php echo "$menu" ?>
      <?php echo "$menu1" ?>
    </div>
  </div>
  <div class="clear"></div>
  <p style="margin-left: 300px; padding-bottom: 20px; " > 
    <a href="<?php echo base_url()."main/jenis_perizinan" ?>" style="color: #0091c6;  font-weight: bold; font-size: 14px;"> Kembali </a>
  </p>
</div>
