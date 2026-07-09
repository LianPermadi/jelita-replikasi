<?php $this->load->view("partial/head.php") ?>

<center>
    <div class="col-xs-4 col-xs-offset-4">
<?php if ($this->session->flashdata('success')){ ?>            
    <div class="alert alert-success" role="alert" style="text-align:center;">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php if ($this->session->flashdata('error')){ ?>            
    <div class="alert alert-danger" role="alert" style="text-align:center;">
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
        <h3><a href="<?php echo base_url().'absensi/index/'.$kegiatan->id; ?>" style="color: #007bff;"><u>Kembali Ke Halaman Utama</u></a></h3>
    </div>
</center>                    
                            
<?php $this->load->view("partial/foot.php") ?>