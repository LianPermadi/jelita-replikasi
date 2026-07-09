<head>
  <style>
    #myIframe 
    {
        width: 100%;
               border: none;
               height: 780px; /* Tetapkan tinggi iframe */
               transform: scale(1.0); /* Perbesar konten di dalam iframe */
               transform-origin: 1 0;
    }
  </style>
</head>

<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="perizinaninfo">
        <tbody>
          <th>
            <iframe id="myIframe" src="https://mppdigital.jabarprov.go.id/gis/wjis2024/"></iframe>
          </th>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>