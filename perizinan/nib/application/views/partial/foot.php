


</div>
                        <!-- <div class="col-lg-4 col-md-6 box-de">
                           <div class="inn-cover">
                               <div class="ditk-inf">
                                   <div class="small-logo">
                                <i class="fab fa-asymmetrik"></i> Style Login
                            </div>
                                    <h2 class="w-100">Din't Have an Account </h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra ut dui in dictum. Simply Create your account by clicking the Signup Button</p>
                                    <a href="#">
                                    <button type="button" class="btn btn-outline-light">SIGN UP</button>
                                    </a>
                                </div>
                                 <div class="foter-credit">
                                  <a href="https://dpmptsp.jabarprov.go.id/" target="_blank">&copy Dinas PMPTSP JABAR</a>  
                               </div>
                           </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/script.js') ?>"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ui.touch-punch.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.signature.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<script>
$(function() {
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#disable').click(function() {
        var disable = $(this).text() === 'Disable';
        $(this).text(disable ? 'Enable' : 'Disable');
        sig.signature(disable ? 'disable' : 'enable');
    });
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
    $('#json').click(function() {
        alert(sig.signature('toJSON'));
    });
    $('#svg').click(function() {
        alert(sig.signature('toSVG'));
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#lok').hide();

        $('#inputGroupSelect01').change(function() {
        var selected = $(this).val();
        if(selected == 'Lainnya'){
          $('#lok').show();
          $('#kablain').focus();
        }
        else{
          $('#lok').hide();
        }
        });

        $('#kablain').keyup(function(){
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>

</html>
