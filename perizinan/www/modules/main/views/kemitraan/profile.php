   
<div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                  <div class="row">
   <div class="container">
		<?php 
			$error 		= $this->session->flashdata("error");
			$success 	= $this->session->flashdata("success");
			if(!empty($error)){
		?>	
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> <?php echo $error; ?>
			</div>
		<?php
			}else if(!empty($success)){
		?>	
			<p style="color:green;"><?php echo $success; ?></p>
		<?php
			}else{
		?>
			<p>
				error
			</p>
		<?php } ?>
        <h1 class="mt-4">Profil <?php echo $n_perusahaan; ?></h1>

        <div class="jumbotron">
            <p>Selamat datang di halaman profil Anda.</p>
            
            <h2>Informasi <?php echo $n_perusahaan; ?></h2>
            <p><strong>Nama Perusahaan :</strong> <?php echo $n_perusahaan; ?></p>
            <p><strong>Email :</strong> <?php echo $email; ?></p>
            <p><strong>Nib :</strong> <?php echo $nib; ?></p>
            <p><strong>Alamat :</strong> <?php echo $alamat_perusahaan; ?></p>
            <p><strong>Kota/Kabupaten :</strong> <?php echo $kabkota; ?></p>
        </div>

        <!-- Tambahkan menu lainnya, seperti Edit Profil, Ganti Password, dsb. -->
        <?php
        if($username == NULL || $username == ''){
        ?>
<form action="/jelita/main/kemitraan/cek_nib" method="post">
                <input type="hidden" class="form-control" name="nib" value="<?php echo $nib; ?>">
            <button type="submit"  class="btn btn-primary">
                Klaim Akun
            </button>
        <?php
        }else{
        ?>
        <a class="btn btn-success" href="ganti_password.php">Login</a>
        <?php 
        }
        ?>

        <!-- Tautan Logout (sesuai dengan kebutuhan aplikasi) -->
        <a class="btn btn-danger" href="javascript:history.back()">kembali</a>

    </div>
    </div>
    </div>
    </div>