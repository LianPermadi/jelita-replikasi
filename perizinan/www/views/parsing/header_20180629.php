<?php
$base_url=base_url().'assets/';
?>
<header id="header">

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <a class="navbar-brand" href="http://bpmpt.jabarprov.go.id/"><img src="<?php echo $base_url."2016/images/logo_bpmpt.png";?>" style="width:150px" /></a>

        </div>
        <div class="collapse navbar-collapse">
            <?php $id = $this->uri->segment(4); ?>
            <ul id="top_menus" class="nav navbar-nav">

               <li class=""><a href="../../web/index.php/home/index" target="">BERANDA</a> </li>
            <li class=""><a href="../../web/index.php/pages/detail/205-pejabat-bpmpt-provinsi-jawa-barat/82">PROFIL<span class="fa arrow"></span></a></li>
             <li class=""><a href="../../web/index.php/pages/detail/208-bidang/83">BIDANG<span class="fa arrow"></span></a></li>

           
             <li class=""><a href="../../web/index.php/pages/detail/191-gerai-bogor-bpmpt-provinsi-jawa-barat/86">GERAI<span class="fa arrow"></span></a></li>
				<li class="active"><a href="../../web/index.php/pages/detail/176-lkpm-online/87">LAYANAN ONLINE<span class="fa arrow"></span></a></li>


			<li class=""><a href="../../web/index.php/pages/detail/217-opd-terkait/244">PD TERKAIT<span class="fa arrow"></span></a>
			<li class=""><a href="http://dpmptsp.jabarprov.go.id/web/pages/detail/247-statistik/293">STATISTIK<span class="fa arrow"></span></a>


				<li class=""><a href="../../web/index.php/arsip/index" target="">REGULASI</a> </li>

				<li class=""><a href="https://sirup.lkpp.go.id/sirup/rekapKldi/D95" target="_blank">PENGADAAN</a> </li>               
            
            </ul>

                
            </ul>
			<div class="pull-right" style="padding-top:13px">
			      <a href="#" class="mr5"><img src="http://www.bpmpt.jabarprov.go.id/web/themes/default/images/indonesia.png" /></a>
             <a href="#" class="mr5"><img src="http://www.bpmpt.jabarprov.go.id/web/themes/default/images/United-Kingdom.png" /></a>
             <a href="#" style="color:#666" id="search_bt" ><i class="fa fa-search"></i></a>
             <a href="#" style="color:#666;display:none" id="close_search_bt" ><i class="fa fa-search"></i></a>
			</div>
			<div id="search_form" style="padding-bottom:10px;float:right;display:none" >
          <?php echo form_open("../searching","id='cse-search-box' method='get'");?>
          <input type="hidden" name="cx" value="003799789951844657258:3j6m-3v1ggy">
           <input type="hidden" name="cof" value="FORID:11">
          <div style="width:250px" class="input-group">
			<input type="text" name="q" value="<?php echo $this->input->get("q");?>" id="query_string3" class="form-control" placeholder="Search">
            <div class="input-group-btn">
              <button class="btn btn-default search-bt" name="sa" type="submit" data-toggle="tooltip" data-placement="top" id="search_bt" title="" data-original-title="Search"><i class="fa fa-search"></i></button>
            </div>
          </div>
		  <?php echo form_close();?>
        </div>
        </div>
    </div>
</div>


</header><!-- /header -->
