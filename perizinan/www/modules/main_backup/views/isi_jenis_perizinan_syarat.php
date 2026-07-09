<div class="isi">
    <div id="entry">
        <h2><?php echo "$title" ?></h2>

        <div class="kiri">
            <div class="izin">
                <br/>
                <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th style="width:80%">DAFTAR SYARAT UNTUK  <?php echo '&nbsp;'.strtoupper($nama_jenis);?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($list as $row) {

                            echo "<tr>";
                            if($row['syarat_perizinan']=="Belum Tersedia Syarat Perizinan")
                              echo "<td>-</td>";  
                            else
                              echo "<td>$n</td>";
                              echo "<td>" . $row['syarat_perizinan'] . "</td>";
                            echo "</tr>";
                            $n++;
                        }
                        ?>


                    </tbody>
                </table>
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
