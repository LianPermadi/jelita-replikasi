<script type="text/javascript" src="<?php echo base_url() . 'assets/js/' ?>uploadify/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/' ?>uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/' ?>uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<style type="text/css">
    .uploadifyButton {
        background-color: #505050;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        color: #FFF;
        font: 12px Arial, Helvetica, sans-serif;
        padding: 8px 0;
        text-align: center;
        width: 100%;
    }
    .uploadify:hover .uploadifyButton {
        background-color: #808080;
    }
    .uploadifyQueueItem {
        background-color: #F5F5F5;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        font: 11px Verdana, Geneva, sans-serif;
        margin-top: 5px;
        max-width: 350px;
        padding: 10px;
    }
    .uploadifyError {
        background-color: #FDE5DD !important;
    }
    .uploadifyQueueItem .cancel {
        float: right;
    }
    .uploadifyQueue .completed {
        background-color: #E5E5E5;
    }
    .uploadifyProgress {
        background-color: #E5E5E5;
        margin-top: 10px;
        width: 100%;
    }
    .uploadifyProgressBar {
        background-color: #0099FF;
        height: 3px;
        width: 1px;
    }
</style>
<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        $('#file_upload').uploadify({
            'uploader'  : site+'assets/js/uploadify/uploadify.swf',
            'script'    : site+'main/save_upload',
            'cancelImg' : site+'assets/js/uploadify/cancel.png',
            'folder'    : 'uploads',
            'auto'      : false,
            'removeCompleted' : false,
            'onComplete' : function(event,fileObj,data,response)
            {
                alert(response);
                $.ajax({
                    url: "<?php echo 'main/ok'?>",
                    type:"POST",
                    data:"file_path="+response,
                    success: function(html)
                    {
                        alert(html);
                    },
                    error: function(html)
                    {
                        alert(html);
                    }
                });//ajax over
            }
            
        });
        
    });
   

    // ]]>
</script>
<input id="file_upload" type="file" name="file_upload" />
<a href="javascript:$('#file_upload').uploadifyUpload().test_upload();">Upload Files</a>
<div id="after_upload"></div>

<form method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'main/save_upload' ?>">
    <input type="file" name="Filedata">
    <input type="submit" value="upload">
</form>