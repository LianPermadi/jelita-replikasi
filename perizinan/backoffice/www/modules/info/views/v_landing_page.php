<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
      <!-- Lib Date View Title Here -->
    </div>
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
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('error')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
    <?php } ?>
    <?php
    if ($this->session->flashdata('success')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php
    }
    ?>

<div class="entry">
            <div id="tabs">
                <ul>
                <li><a href="#tabs-1">Landing Page ID</a></li>
                <li><a href="#tabs-2">Landing Page EN</a></li>
                <li><a href="#tabs-3">Landing Content</a></li>
                
                </ul>
                <div id="tabs-1">
        <?php
// Fallback kalau $homepage_id gak dikirim atau kosong/null
if (!isset($homepage_id) || !is_object($homepage_id)) {
    $homepage_id = new stdClass();
}

$homepage_id->Id              = isset($homepage_id->Id) ? $homepage_id->Id : '';
$homepage_id->title           = isset($homepage_id->title) ? $homepage_id->title : '';
$homepage_id->bannerText      = isset($homepage_id->bannerText) ? $homepage_id->bannerText : '';
$homepage_id->slug            = isset($homepage_id->slug) ? $homepage_id->slug : '';
$homepage_id->isBahasa        = isset($homepage_id->isBahasa) ? $homepage_id->isBahasa : '0';
$homepage_id->bannerImage     = isset($homepage_id->bannerImage) ? $homepage_id->bannerImage : '';
$homepage_id->whyInvestImage  = isset($homepage_id->whyInvestImage) ? $homepage_id->whyInvestImage : '';
$homepage_id->sectorImage     = isset($homepage_id->sectorImage) ? $homepage_id->sectorImage : '';
$homepage_id->findInvestImage = isset($homepage_id->findInvestImage) ? $homepage_id->findInvestImage : '';
$homepage_id->users_id        = isset($homepage_id->users_id) ? $homepage_id->users_id : '';
$homepage_id->created_at      = isset($homepage_id->created_at) ? $homepage_id->created_at : '';
$homepage_id->updated_at      = isset($homepage_id->updated_at) ? $homepage_id->updated_at : '';
?>

<form method="post" action="<?php echo site_url('homepage/update'); ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlentities($homepage_id->Id); ?>">

    <table class="display">
        <tbody>
            <tr>
                <td><b>Judul</b></td>
                <td><input type="text" name="title" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->title); ?>"></td>
            </tr>

            <tr>
                <td><b>Banner Text</b></td>
                <td><input type="text" name="bannerText" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->bannerText); ?>"></td>
            </tr>

            <tr>
                <td><b>Slug</b></td>
                <td><input type="text" name="slug" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->slug); ?>"></td>
            </tr>

            <tr>
                <td><b>Banner Image</b></td>
                <td><input type="text" name="bannerImage" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->bannerImage); ?>"></td>
            </tr>

            <tr>
                <td><b>Why Invest Image</b></td>
                <td><input type="text" name="whyInvestImage" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->whyInvestImage); ?>"></td>
            </tr>

            <tr>
                <td><b>Sector Image</b></td>
                <td><input type="text" name="sectorImage" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->sectorImage); ?>"></td>
            </tr>

            <tr>
                <td><b>Find Invest Image</b></td>
                <td><input type="text" name="findInvestImage" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->findInvestImage); ?>"></td>
            </tr>

            <tr>
                <td><b>User ID</b></td>
                <td><input type="text" name="users_id" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->users_id); ?>" readonly></td>
            </tr>

            <tr>
                <td><b>Created At</b></td>
                <td><input type="text" name="created_at" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->created_at); ?>" readonly></td>
            </tr>

            <tr>
                <td><b>Updated At</b></td>
                <td><input type="text" name="updated_at" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_id->updated_at); ?>" readonly></td>
            </tr>
        </tbody>
    </table>

    <div style="text-align:right; margin-top: 20px;">
        <button type="submit" class="button-wrc">Simpan Perubahan</button>
        <a href="<?php echo site_url('homepage'); ?>" class="button-wrc">Batal</a>
    </div>
</form>
</div>


<div id="tabs-2">
<?php
// Fallback kalau $homepage_en gak dikirim atau kosong/null
if (!isset($homepage_en) || !is_object($homepage_en)) {
    $homepage_en = new stdClass();
}

$homepage_en->Id              = isset($homepage_en->Id) ? $homepage_en->Id : '';
$homepage_en->title           = isset($homepage_en->title) ? $homepage_en->title : '';
$homepage_en->bannerText      = isset($homepage_en->bannerText) ? $homepage_en->bannerText : '';
$homepage_en->slug            = isset($homepage_en->slug) ? $homepage_en->slug : '';
$homepage_en->isBahasa        = isset($homepage_en->isBahasa) ? $homepage_en->isBahasa : '0';
$homepage_en->bannerImage     = isset($homepage_en->bannerImage) ? $homepage_en->bannerImage : '';
$homepage_en->whyInvestImage  = isset($homepage_en->whyInvestImage) ? $homepage_en->whyInvestImage : '';
$homepage_en->sectorImage     = isset($homepage_en->sectorImage) ? $homepage_en->sectorImage : '';
$homepage_en->findInvestImage = isset($homepage_en->findInvestImage) ? $homepage_en->findInvestImage : '';
$homepage_en->users_id        = isset($homepage_en->users_id) ? $homepage_en->users_id : '';
$homepage_en->created_at      = isset($homepage_en->created_at) ? $homepage_en->created_at : '';
$homepage_en->updated_at      = isset($homepage_en->updated_at) ? $homepage_en->updated_at : '';
?>
<form method="post" action="<?php echo site_url('homepage/update'); ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlentities($homepage_en->Id); ?>">

    <table class="display">
        <tbody>
            <tr>
                <td><b>Judul</b></td>
                <td><input type="text" name="title" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->title); ?>"></td>
            </tr>

            <tr>
                <td><b>Banner Text</b></td>
                <td><input type="text" name="bannerText" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->bannerText); ?>"></td>
            </tr>

            <tr>
                <td><b>Slug</b></td>
                <td><input type="text" name="slug" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->slug); ?>"></td>
            </tr>

            <tr>
                <td><b>Banner Image</b></td>
                <td><input type="text" name="bannerImage" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->bannerImage); ?>"></td>
            </tr>

            <tr>
                <td><b>Why Invest Image</b></td>
                <td><input type="text" name="whyInvestImage" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->whyInvestImage); ?>"></td>
            </tr>

            <tr>
                <td><b>Sector Image</b></td>
                <td><input type="text" name="sectorImage" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->sectorImage); ?>"></td>
            </tr>

            <tr>
                <td><b>Find Invest Image</b></td>
                <td><input type="text" name="findInvestImage" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->findInvestImage); ?>"></td>
            </tr>

            <tr>
                <td><b>User ID</b></td>
                <td><input type="text" name="users_id" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->users_id); ?>" readonly></td>
            </tr>

            <tr>
                <td><b>Created At</b></td>
                <td><input type="text" name="created_at" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->created_at); ?>" readonly></td>
            </tr>

            <tr>
                <td><b>Updated At</b></td>
                <td><input type="text" name="updated_at" class="input-wrc" style="width:100%;" value="<?php echo htmlentities($homepage_en->updated_at); ?>" readonly></td>
            </tr>
        </tbody>
    </table>

    <div style="text-align:right; margin-top: 20px;">
        <button type="submit" class="button-wrc">Simpan Perubahan</button>
        <a href="<?php echo site_url('homepage'); ?>" class="button-wrc">Batal</a>
    </div>
</form>
</div>

<div id="tabs-3">
<?php
// Fallback kalau $homepage_en gak dikirim atau kosong/null
if (!isset($homepage_en) || !is_object($homepage_en)) {
    $homepage_en = new stdClass();
}

$homepage_en->Id              = isset($homepage_en->Id) ? $homepage_en->Id : '';
$homepage_en->title           = isset($homepage_en->title) ? $homepage_en->title : '';
$homepage_en->bannerText      = isset($homepage_en->bannerText) ? $homepage_en->bannerText : '';
$homepage_en->slug            = isset($homepage_en->slug) ? $homepage_en->slug : '';
$homepage_en->isBahasa        = isset($homepage_en->isBahasa) ? $homepage_en->isBahasa : '0';
$homepage_en->bannerImage     = isset($homepage_en->bannerImage) ? $homepage_en->bannerImage : '';
$homepage_en->whyInvestImage  = isset($homepage_en->whyInvestImage) ? $homepage_en->whyInvestImage : '';
$homepage_en->sectorImage     = isset($homepage_en->sectorImage) ? $homepage_en->sectorImage : '';
$homepage_en->findInvestImage = isset($homepage_en->findInvestImage) ? $homepage_en->findInvestImage : '';
$homepage_en->users_id        = isset($homepage_en->users_id) ? $homepage_en->users_id : '';
$homepage_en->created_at      = isset($homepage_en->created_at) ? $homepage_en->created_at : '';
$homepage_en->updated_at      = isset($homepage_en->updated_at) ? $homepage_en->updated_at : '';
?>
<form method="post" action="<?php echo site_url('homepage/update'); ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlentities($homepage_en->Id); ?>">

    <table class="display">
    <tbody>
    <?php 
        $h_no_v2 = 1;
        foreach ($homepage_v2 as $h_v2) { 
            $isImageField = strpos($h_v2->nama, 'img') !== false;
            $id_id = "preview_id_" . $h_no_v2;
            $id_en = "preview_en_" . $h_no_v2;
        ?>
        <tr>
            <td><b><?= $h_v2->nama ?></b></td>

            <td>
                <?php if ($isImageField): ?>
                    <input type="file" name="title_id_<?= $h_no_v2 ?>" class="input-wrc" style="width:100%;" onchange="previewImage(this, '<?= $id_id ?>')">
                    <?php if (!empty($h_v2->value_id)): ?>
                        <br><small>File sekarang:</small><br>
                        <img src="<?= base_url('src/assets/img/home-page/' . $h_v2->value_id); ?>" alt="ID Image" style="max-height: 80px; border-radius: 6px; margin-top: 6px;">
                    <?php endif; ?>
                    <br><img id="<?= $id_id ?>" style="max-height: 80px; margin-top: 6px; display: none;" />
                <?php else: ?>
                    <input type="text" name="title_id_<?= $h_no_v2 ?>" class="input-wrc" style="width:100%;" value="<?= htmlentities($h_v2->value_id); ?>">
                <?php endif; ?>
            </td>

            <td>
                <?php if ($isImageField): ?>
                    <input type="file" name="title_en_<?= $h_no_v2 ?>" class="input-wrc" style="width:100%;" onchange="previewImage(this, '<?= $id_en ?>')">
                    <?php if (!empty($h_v2->value_en)): ?>
                        <br><small>File sekarang:</small><br>
                        <img src="<?= base_url('src/assets/img/home-page/' . $h_v2->value_en); ?>" alt="EN Image" style="max-height: 80px; border-radius: 6px; margin-top: 6px;">
                    <?php endif; ?>
                    <br><img id="<?= $id_en ?>" style="max-height: 80px; margin-top: 6px; display: none;" />
                <?php else: ?>
                    <input type="text" name="title_en_<?= $h_no_v2 ?>" class="input-wrc" style="width:100%;" value="<?= htmlentities($h_v2->value_en); ?>">
                <?php endif; ?>
            </td>
        </tr>
        <?php 
            $h_no_v2++;
        } 
        ?>
        <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
        </script>
    </tbody>
</table>

    <div style="text-align:right; margin-top: 20px;">
        <button type="submit" class="button-wrc">Simpan Perubahan</button>
        <a href="<?php echo site_url('homepage'); ?>" class="button-wrc">Batal</a>
    </div>
</form>
</div>

</div>
</div>



</div>
  <br style="clear: both;" />
</div>
