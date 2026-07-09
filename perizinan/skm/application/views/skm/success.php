<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Terima kasih</title>
    <link href="<?= base_url('theme_skm/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('theme_skm/css/style.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('theme_skm/css/vendors.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('theme_skm/css/custom.css'); ?>" rel="stylesheet">
    <style>
      body{background:#fff}
      #success{max-width:520px;margin:10vh auto;text-align:center}
      .icon{margin-bottom:24px}
      small{color:#666}
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', function(){
        setTimeout(function(){ window.location.href = '<?= $redirect_url; ?>'; }, <?= (int)$delay_ms; ?>);
      });
    </script>
</head>
<body>
<div id="success">
  <div class="icon icon--order-success svg">
    <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
      <g fill="none" stroke="#8EC343" stroke-width="2">
        <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
        <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
      </g>
    </svg>
  </div>
  <h4><span>Request successfully sent!</span> Thank you for your time</h4>
  <small>You will be redirected in 5 seconds.</small>
</div>
</body>
</html>