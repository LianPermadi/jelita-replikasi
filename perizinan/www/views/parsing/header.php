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


            <a class="navbar-brand" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/"><img src="<?php echo $base_url."2016/images/logo_bpmpt.png";?>" style="width:40px" /></a>

        </div>
        <div class="collapse navbar-collapse">
            <?php $id = $this->uri->segment(4); ?>
            <ul id="top_menus" class="nav navbar-nav">
               <li class=""><a href="<?php echo site_url();?>" target="">BERANDA</a> </li>
               <li class="267"><a id="link267" href="<?php echo site_url();?>main/login"><span>LOGIN PEMOHON<span></span></span></a></li>             
            </ul>

                
            </ul>
			<div class="pull-right" style="padding-top:13px">
			      <a href="#" class="mr5"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/web/themes/default/images/indonesia.png" /></a>
             <a href="#" class="mr5"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/web/themes/default/images/United-Kingdom.png" /></a>
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
