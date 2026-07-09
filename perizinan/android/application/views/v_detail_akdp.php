<style type="text/css">
	td,th{
		font-size: 11px;
	}
</style>

<?php 
if($this->session->userdata("nama") == null){
    redirect('login');
}else{
?>
    <body>
    <?php include 'v_header.php'; ?>
    <div class="container" style="margin-top: 30px;">
        <div class="section">
            <div class="row">
                <?php
   				$i=1;
    			if (count($detail_cetak)>0) {
   					foreach ($detail_cetak as $data):
  				?>
    					<form action="<?php echo site_url('akdp_cetak/update_multiple'); ?>" method="post">
       						<h5><center>DETAIL PERMOHONAN IZIN TRAYEK</center></h5>
	        				<?php
			        		$iduser =  $this->session->userdata("id");
					        ?>
                            <input type="hidden" name="no_sk" value="<?php echo $data->no_sk;?>">

                            <input type="hidden" name="tgl_penetapan" value="<?php echo $data->tgl_penetepan;?>">
                            <input type="hidden" name="tgl_penetapan_kp" value="<?php echo $data->tgl_penetapan_kp;?>">
                            <input type="hidden" name="no_kend" value="<?php echo $data->no_kend;?>">
                            <input type="hidden" name="akdpkendaraan_id" value="<?php echo $data->akdpkendaraan_id;?>">
                            <input type="hidden" name="msg[]" value="<?php echo $data->id;?>">
                            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">

                            <?php
                            if ( $iduser == 175 || $iduser == 176 || $iduser == 178){
                            ?>
                                <center><input type="submit" name="submit"  value="Approve"  class="btn">
                                <?php
                                if ( $iduser == 175 || $iduser == 176){
                                  ?>
                                <input type="submit" name="submit"  value="Revisi"  class="btn">
                                <?php
                              }
                            }
                                ?>
                            <a href="<?php echo site_url('akdp_cetak'); ?> " class="btn" >Kembali</a></center>
   						</form>
					    <?php
						if(strtotime($data->masa_berlaku) > strtotime(date('d-m-Y'))){
                            $b = ''; $be = '';
                        } else {
                            $b = '<span style="color: Red">'; $be = '</span>';
                        }
						if(strtotime($data->tgl_kp_akhir) > strtotime(date('d-m-Y'))){
                            $b1 = ''; $be1 = '';
                        } else {
                            $b1 = '<span style="color: Red">'; $be1 = '</span>';
                        }

						$trayek = $this->load->database('otherdb',TRUE);
                		$akdptrayek = $trayek->get_where("akdptrayek",array("kode_trayek"=>$data->kode_trayek))->first_row();
                   		$trayek = $akdptrayek->trayek;



                  echo '<label><center>Nama Perusahaan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->nama_perusahaan.'</p>';
                  echo '<label><center>Nama Pimpinan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->nama_pimpinan.'</p>';
                  echo '<label><center>Alamat Perusahaan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->alamat_perusahaan.'</p>';
                  echo '<label><center>Alamat Pimpinan Perusahaan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->alamat_pimpinan.'</p>';
                  echo '<label><center>Nomor Induk Perusahaan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->no_induk.'</p>';
                  echo '<label><center>Nomor Induk Kendaraan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->no_induk_kend.'</p>';
                  echo '<label><center>Nomor Kendaraan / Nomor Uji</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->no_kend.' / '.$data->no_uji.'</p>';
                  echo '<label><center>Merk / Tahun</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->merek.' / '.$data->tahun.'</p>';
                  echo '<label><center>Daya Angkut Penumpang / Barang</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->daya_angkut_org.' orang / '.$data->daya_angkut_brg.' kg</p>';
                  echo '<label><center>Bahan Bakar</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->bahan_bakar.'</p>';
                  echo '<label><center>Jenis Kendaraan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->jenis_kend.'</p>';
                   echo '<label><center>Lintasan Trayek</center></label>';
                 if($data->trayek == ''){
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.'Data trayek dengan kode '.$data->kode_trayek.' tidak ditemukan di tabel trayek</p>';
                   }else{
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->trayek.'</p>';
                     }
                  echo '<label><center>Kode Trayek</center></label>';
                 
                    echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->kode_trayek.'</p>';
                  echo '<label><center>Jenis Pelayanan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->sifat_pel.'</p>';
                  echo '<label><center>Masa Berlaku</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->masa_berlaku.'</p>';
                  echo '<label><center>Keterangan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->ket.'</p>';


						      echo '<label><center>Nomor SK</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->no_sk.'</p>';
                  echo '<label><center>Tanggal SK</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.date('d-m-Y', strtotime($data->tgl_sk)).'</p>';
                  echo '<label><center>Penetapan SK</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.date('d-m-Y', strtotime($data->tgl_penetepan)).'</p>';
                  echo '<label><center>Masa Berlaku SK</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$b.
                  date('d-m-Y', strtotime($data->tgl_sk)) .' s/d '. date('d-m-Y', strtotime($data->masa_berlaku)).
               $be.'</p>';
                  echo '<label><center>Jenis Pelayanan</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->jenis_pel.'</p>';
                  
                  
                  
                  
                  
                  
                  
                  echo '<label><center>Nama Pemilik</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->nama_pemilik.'</p>';
                  echo '<label><center>Alamat Pemilik</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->alamat_pemilik.'</p>';
                  
                  
                 

                  echo '<label><center>Nomor KP</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$data->no_kp.'</p>';
                  
                  echo '<label><center>Penetapan KP</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.date('d-m-Y', strtotime($data->tgl_penetapan_kp)).'</p>';

                  echo '<label><center>Masa Berlaku KP</center></label>';
                  echo '<p style="border-bottom:1px dotted gray;text-align:center;">'.$b1.
               date('d-m-Y', strtotime($data->tgl_kp_awal)) .' s/d '. date('d-m-Y', strtotime($data->tgl_kp_akhir)).
               $be1.'</p>';

?>
    					<form action="<?php echo site_url('akdp_cetak/update_multiple'); ?>" method="post">
       						<h5> </h5>
	        				<?php
			        		$iduser =  $this->session->userdata("id");
					        ?>
                            <input type="hidden" name="no_sk" value="<?php echo $data->no_sk;?>">

                            <input type="hidden" name="tgl_penetapan" value="<?php echo $data->tgl_penetepan;?>">
                            <input type="hidden" name="tgl_penetapan_kp" value="<?php echo $data->tgl_penetapan_kp;?>">
                            <input type="hidden" name="no_kend" value="<?php echo $data->no_kend;?>">
                            <input type="hidden" name="akdpkendaraan_id" value="<?php echo $data->akdpkendaraan_id;?>">
                            <input type="hidden" name="msg[]" value="<?php echo $data->id;?>">
                            <input type="hidden" value="<?php echo $this->session->userdata("id");?>"  name="id">

                            <?php
                            if ( $iduser == 175 || $iduser == 176 || $iduser == 178){
                            ?>
                                <center><input type="submit" name="submit"  value="Approve"  class="btn">
                                <?php
                                if ( $iduser == 175 || $iduser == 176){
                                  ?>
                                <input type="submit" name="submit"  value="Revisi"  class="btn">
                                <?php
                              }
                            }
                                ?>
                            <a href="<?php echo site_url('akdp_cetak'); ?> " class="btn" >Kembali</a></center>
   						</form>
					    <?php

 		  
				    endforeach;
				    $i++;
			    }
				?>
			</div>
        </div>
    </div>
	<?php
}
    ?>

<footer class="page-footer teal" style="visibility: hidden;">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5 class="white-text">Tentang BPMPT</h5>
                <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Provinsi Kalimantan Utara berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
            </div>
        </div>
    </div>
</footer>

<footer class="page-footer teal">
    <div class="footer-copyright">
        <div class="container">
            2017 Â© DPMPTSP Provinsi Kalimantan Utara v 1.5
        </div>
    </div>
</footer>

<!--  Scripts-->
<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
<script src="<?php echo base_url(); ?>assets/js/init.js"></script>