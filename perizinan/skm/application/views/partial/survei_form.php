
<?php
$CI =& get_instance();
if (!isset($csrf_name)) { $csrf_name = $CI->security->get_csrf_token_name(); }
if (!isset($csrf_hash)) { $csrf_hash = $CI->security->get_csrf_hash(); }
?>
<div class="col-lg-6 content-right" id="start">
  <div id="wizard_container">
    <div id="top-wizard"><div id="progressbar"></div></div>

    <?php if ($this->session->flashdata('err')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('err'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('ok')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('ok'); ?></div>
    <?php endif; ?>

    <form id="" name="form1" method="POST" enctype="multipart/form-data" action="<?= site_url('survey/insert'); ?>">
      <!-- CSRF -->
      <input type="hidden" name="<?= $csrf_name; ?>" value="<?= $csrf_hash; ?>">

      <h3 class="main_question"><strong>1/11</strong>Data Masyarakat (Responden)</h3>

      <div class="form-group">
        <input type="text" id="resi" name="resi" class="form-control" placeholder="Nomor Resi atau NIK">
      </div>

      <!-- Container update hasil AJAX -->
      <div id="update"></div>

      <!-- reCAPTCHA -->
      <!-- <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($recaptcha_sitekey, ENT_QUOTES, 'UTF-8'); ?>" data-callback="enableBtn" data-expired-callback="disableBtn"></div> -->
      <div class="g-recaptcha" data-sitekey="6LdJzMgZAAAAAOKKMaJ1L4GOb0f0qKsA1ZZhbfhu" data-callback="enableBtn" data-expired-callback="disableBtn"></div>
      <input type="hidden" name="qry" value="ins">
      <input type="submit" name="submit" class="submit" value="Next Step">
    </form>
  </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
(function(){
  var input = document.getElementById('resi');
  if (!input) return;

  input.addEventListener('change', function(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= site_url('survei/get_info'); ?>', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    var csrfName = document.getElementById('csrf-name').value;
    var csrfHash = document.getElementById('csrf-hash').value;

    var payload = 'resi=' + encodeURIComponent(input.value)
                + '&' + encodeURIComponent(csrfName) + '=' + encodeURIComponent(csrfHash);

    xhr.onreadystatechange = function(){
      if (xhr.readyState === 4) {
        document.getElementById('update').innerHTML = xhr.responseText || '';
        // update token baru biar submit form nggak ditolak
        var newHash = xhr.getResponseHeader('X-CSRF-Hash');
        if (newHash) {
          document.getElementById('csrf-hash').value = newHash;
        }
      }
    };
    xhr.send(payload);
  });
})();
</script>
