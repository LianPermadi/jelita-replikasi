<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/themes/smoothness/jquery-ui-1.8.17.custom.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/rido.css" type="text/css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>template/css/jquery-1.7.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>template/css/ui/jquery.ui.core.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>template/css/ui/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>template/css/ui/jquery.ui.progressbar.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>template/css/ridojs.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>template/css/ui/jquery.ui.mouse.js" ></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>template/css/ui/jquery.ui.draggable.js" ></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>template/css/ui/jquery.ui.position.js" ></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>template/css/ui/jquery.ui.resizable.js" ></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>template/css/ui/jquery.ui.dialog.js" ></script>
    </head>
    <script>
        function ambilUrl()
        {
            var data="<?php echo base_url(); ?>";
            return data;
        }
    </script>
    <body>
        <div id="tagbody">
            <dir id="header">
                <h2>Instalasi Aplikasi</h2>
                Wizard ini akan menuntun anda untuk melakukan proses Instalasi Aplikasi
            </dir>
            <div id="dialogloading">Proses Data<br /><img src="<?php echo base_url(); ?>template/loading1.gif" border="0" /></div>
            <div id="isikontent">
                <?php echo $isikontent; ?>
            </div>
            <div id="footer">
                Aplikasi Layanan Publik &copy;2011
            </div>
        </div>
    </body>
</html>

