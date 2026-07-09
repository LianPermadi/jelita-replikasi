
<script type="text/javascript" src="<?php echo base_url();?>assets/dt/media/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/dt/media/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/dt/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/dt/media/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/dt/css/dataTables.bootstrap.css">
   <script type="text/javascript">
  var message="Function right click is Disabled!";
  function clickIE4(){
    if(event.button==2){
      alert(message);
      return false;
    }
  }
  function clickNS4(e){
    if(document.layers||document.getElementById&&!document.all){
      if(e.which==2||e.which==3){
        alert(message);
        return false;
      }
    }
  }
  if(document.layers){
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown=clickNS4;
  }else if(document.all&&!document.getElementById){
    document.onmousedown=clickIE4;
  }
  //document.oncontextmenu=new Function("alert(message);return false");
 document.oncontextmenu=new Function("return false")
</script><!--IE=internet explorer 4+ dan NS=netscape 4+0-->
  <div class="container">
  <br>
  <br>
<table class="table table-striped data" style="font-size:12px;">
                <thead>
                    <tr>
                      <th width="" >NO</th>
                       <th width="">DAFTAR PERIZINAN</th>
                       <th width="">DURASI</th>
                        <th width=""></th>
                        <th width=""></th>
                      
                    </tr>
                </thead>
                <?php
        if($izintrayek_table !== "")
        {

            echo $izintrayek_table;

        }
        else
        {
        ?>

            <tr>
            <td colspan="6"><center>Tidak ada data</center></td>
            </tr>
            <?php } ?>
        </tbody>
                </table>
              </div>
<!--</div>
<div id="" style="width:30%; float:left; margin-left: 5%;border : 0px solid gray;">
-->

  <!-- </div>
   </div>-->
<br style="clear: both" />
<script type="text/javascript">
  $(document).ready(function(){
    $('.data').DataTable();
  });
</script>
      