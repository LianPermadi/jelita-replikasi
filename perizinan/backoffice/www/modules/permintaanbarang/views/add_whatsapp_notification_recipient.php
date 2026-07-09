<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    .card {
        margin: 20px auto;
        max-width: 600px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px;
    }

    h2 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="checkbox"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 12px 20px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
        width: 100%;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
        display: block;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<div id="content">
    <div class="post" style="background-color: #fffaf0;">
        <div class="title">
            <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
        <div class="entry">
            <div id="content">
                <div class="card">
                    <h2>Tambah Penerima WhatsApp</h2>

                    <form action="<?php echo site_url('permintaanbarang/save_recipient'); ?>" method="post">
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <select id="user_id" name="user_id" class="pilihan" required>
                                <option value="">Pilih User ID</option>
                                <?php foreach ($users as $user){ ?>
                                    <option value="<?php echo $user->id; ?>"><?php echo $user->n_pegawai; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="whatsapp_enabled" value="1">
                                Terima pemberitahuan via WhatsApp
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="email_enabled" value="1">
                    Terima pemberitahuan via Email
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        
    </div>
</div>
        </div>
    </div>
    <br style="clear: both;" />
</div>
