<div id="content" style="width: 800px;">
    <div class="post">
        <div class="title">
            <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="tampil_pdf">
                <thead>
                    <tr>
                        <div style="text-align:center">
                            <?php
				            $url = base_url()."../assets/userassets/pemohon/".$dir1."/pengajuan/".$dir2."/".$file.".pdf";
				            echo $url;
                            echo '<iframe
                                      src="http://docs.google.com/viewer?url='.$url.'&embedded=true"
                                      width="600"
                                      height="792"
									  style="border: none;">
                                  </iftame>';
                            ?>
                        </div>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>