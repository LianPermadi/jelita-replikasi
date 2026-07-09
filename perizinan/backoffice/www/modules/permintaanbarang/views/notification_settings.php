<!-- application/views/notification_settings.php -->

<div id="content">
    <div class="post" style="background-color: #fffaf0;">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
    <div class="entry">
    <div class="container">
        <h2>Notification Settings</h2>

<div id="content">
    <div class="container">
        <h2>WhatsApp Notification Recipients</h2>
        
    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

        <!-- Tambah Tombol -->
        <div style="margin-bottom: 10px;">
            <a href="permintaanbarang/add_recipient" class="btn btn-primary">Tambah Penerima</a>
        </div>
        <div style="margin-bottom: 10px;">
            <a href="permintaanbarang/test_notifikasi" class="btn btn-primary">Test Notifikasi</a>
        </div>
        
        <?php if (!empty($notificationSettings)) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Phone whatsapp_enabled</th>
                        <th>Phone email_enabled</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notificationSettings as $recipient) { ?>
                        <tr>
                            <td><?php echo $this->m_barang->get_data_user_n_pegawai($recipient->user_id); ?></td>
                            <td><?php 
                            $statuswa = $recipient->whatsapp_enabled; 
                            if($statuswa == 1){
                                $whatsapp = 'Aktif';
                            }else{
                                $whatsapp = 'Tidak Aktif';
                            }
                            echo $whatsapp;
                            ?></td>
                            <td><?php 
                            $statusemail = $recipient->email_enabled; 
                            if($statusemail == 1){
                                $email = 'Aktif';
                            }else{
                                $email = 'Tidak Aktif';
                            }
                            echo $email; 
                            ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No recipients found.</p>
        <?php endif; ?>
        
    </div>
</div>
    </div>
        </div>
    </div>
    <br style="clear: both;" />
</div>
<!-- application/views/add_whatsapp_notification_recipient.php -->

<style>
</style>
   <style>
    .container {
        margin: 10 auto;
        border-radius: 8px;
        /* padding : 10px; */
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }
    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        text-decoration: none;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .table th {
        background-color: #f2f2f2;
    }
</style>
