<head>


<style>
  #myIframe {
    width: 100%;
    border: none;
    height: 10000px; /* Tetapkan tinggi iframe */
    transform: scale(1.0); /* Perbesar konten di dalam iframe */
    transform-origin: 1 1;
  }
</style>
</head>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
          <!-- <iframe src="https://dpmptsp.jabarprov.go.id/itemmanis/" height="590px" width="100%"></iframe> -->
<!-- <a href="https://dpmptsp.jabarprov.go.id/schedule/"><button class="button-wrc">Full Screen</button></a> -->

<iframe id="myIframe" src="https://dpmptsp.jabarprov.go.id/schedule/"></iframe>
<script>
  var iframe = document.getElementById("myIframe");
  iframe.onload = function() {
    iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
  };
</script>
    </div>
  </div>
  <br style="clear: both;" />
</div>