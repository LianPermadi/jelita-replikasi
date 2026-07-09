
  <!-- <script src="assets/js/jquery-2.1.1.min.js"></script> -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.js"></script>
  <script>
    $('table option').each(function()
      {
          var myStr = $(this).text();
          if(myStr.length > 5){$(this).text(myStr.substring(5));}
      });
  </script>

<body>
  <?php include 'v_header.php';?>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <!--<h4 class="header center">Persyaratan <br /> Perizinan</h4>-->
      </div>
    </div>
    <div class="parallax"><img src="<?php echo base_url(); ?>assets/img/4.png" alt="Unsplashed background img 1"></div>
  </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->

      <div class="row">
        <div class="col s12">
          <div class="card-panel">
             <form acton="#" method="POST">
                <div class="form-group">
                  <label>Bidang Perizinan</label>
                  <select class="browser-default bidang" name="bidang">
                    <option value="" disabled selected>Pilih Bidang Perizinan</option>
                    <?php 
					foreach($bidang as $b) { 
                        if($b->n_sektor != '*LAIN-LAIN'){
					?>
					
                    <option value="<?php echo $b->id; ?>"><?php echo $b->n_sektor; ?></option>
                    <?php }} ?>
                  </select>
                </div>

                <script>
				          $(function(){
                    $('.bidang').on('change', function(e){
                      var bidang = $(".bidang").val();
                      $.ajax({
                        url : "ceksyarat/getizin",
                        type: "post",
                        data:{"data":bidang},
                        success : function(data){
                          $(".izin").html('');
                          var myarray = JSON.parse(data);
                          var myarray = myarray.split(",");

                          for (i=0;i<myarray.length;i++)
                          {
                            if(myarray[i] != myarray[i+1])
                            {
                              var myarray2 = myarray[i].split("|");
                              var optn2 = document.createElement("OPTION");
                              
                              optn2.text = myarray2[1];
                              optn2.value = myarray2[0];
                              $(".izin").append(optn2);
                            }
                          }
                        }
                      });
                    });
                  });
                </script>
                
                <div class="form-group">
                  <label>Perizinan</label>
                  <select class="browser-default izin" name="izin">
                    <option value="">Pilih Perizinan</option>
                  </select>
                </div>

                <script>
                  $(function(){
                    $('.izin').on('change', function(e){
                      var izin = $(".izin").val();
                      $.ajax({
                        url : "ceksyarat/getsyarat",
                        type: "post",
                        data:{"data":izin},
                        success : function(data){
                          $(".syarat").html('');
                          var myarray = JSON.parse(data);
                          $(".syarat").html(myarray);
                          //var myarray = myarray.split(",");
                          /*
                          for (i=0;i<myarray.length;i++)
                          {
                            if(myarray[i] != myarray[i+1])
                            {
                              var myarray2 = myarray[i].split("|");
                              var optn2 = document.createElement("OPTION");
                              
                              optn2.text = myarray2[1];
                              optn2.value = myarray2[0];
                              $(".syarat").append(optn2);
                            }
                          }
                          */
                        }
                      });
                    });
                  });
                </script>

                <!-- <div class="form-group">
                  <label>Persyaratan</label>
                  <select class="browser-default syarat" name="syarat">
                    <option value="">Pilih Persyaratan</option>
                  </select>
                </div> -->
              </form>
          </div>
          <div class="card-panel">
            <!-- <ul class="syarat" name="syarat">
            </ul> -->

            <h6>Persyaratan</h6>
            <ol class="syarat">
            </ol>
          </div>
        </div>
      </div>

      <!-- <div class="row">
        <div class="col s12">
          <div class="card-panel blue-grey darken-1">
              
          </div>
        </div>
      </div> -->

    </div>
  </div>

  <footer class="page-footer teal">
    <div class="footer-copyright">
      <div class="container">
        <center>2018 © DPMPTSP Kabupaten Tasikmalaya v.1</center>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/init.js"></script>

  </body>
</html>
