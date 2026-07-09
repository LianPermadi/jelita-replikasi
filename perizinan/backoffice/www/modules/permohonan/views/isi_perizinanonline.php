<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script>
	$(function(){
		$('.sektor').on('change', function(e){
			var sektor = $(".sektor").val();
			$.ajax({
				url : "getperizinan",
				type: "post",
				data:{"data":sektor},
				success : function(data){
					$(".perizinan").html('');
					var myarray = JSON.parse(data);
					var myarray = myarray.split(",");
					//console.log(data);
					for (i=0;i<myarray.length;i++){
						if(myarray[i] != myarray[i+1]){
							var myarray2 = myarray[i].split("|");
							var optn2 = document.createElement("OPTION");
							
							optn2.text = myarray2[1];
							optn2.value = myarray2[0];
							$(".perizinan").append(optn2);
						}
					}
				}
			});
		});
	});
</script>

<h2>Perizinan Online</h2>

<!-- <div class="alert alert-info" style="color:#fff;">
Untuk pemohon yang sudah memiliki akun silahkan <?php //echo anchor('main/login', 'Login Disini') ?>
</div> -->


     
<div class="kiri">
<?php 
$error = $this->session->flashdata("error");
if(!empty($error)){
?>
<div id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $error; ?></center></div>
<?php } ?>

<h4>Silahkan Pilih Perizinan Yang Akan Diajukan</h4>
<hr />
				
<form method="post" class="form-horizontal" action="<?php echo base_url() . 'main/pendaftaranbaru/pilihizin'; ?>">
<input type="hidden" value="<?php echo $sms; ?>" id="sms" name="sms">
<input type="hidden" value="<?php echo $mail; ?>" id="mail" name="mail">
<div class="form-group">
	<label class="col-sm-3 control-label">Sektor :</label>
	<div class="col-sm-6">
		<select name="sektor" class="sektor form-control" required>
			<option value="">------------------------ Pilih Sektor ------------------------</option>
			<?php foreach($sektor as $skt){ ?>
				<option value="<?php echo $skt->id; ?>"><?php echo $skt->n_sektor; ?></option>
			<?php } ?>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">Perizinan :</label>
	<div class="col-sm-6">
		<select name="perizinan" class="perizinan form-control" style="white-space: normal;" required>
		<option value="">------------------------ Pilih Perizinan ------------------------</option>
		</select>
	</div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
      <input type="submit" value="Pilih" class='btn btn-primary' style="float: left; margin-right: 5px; margin-left: 0px;"/>
    </div>
</div>
</form>

<script>
	$(function(){
		$('.numberonly').keyup(function () { 
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});
	});
</script>
</div>

<img src="https://dpmptsp.jabarprov.go.id/jelita/assets/alur(new).png" class="img-responsive hidden-xs hidden-sm" style="border:3px solid black">

<div class="kanan">
    <?php //echo "$menu" ?>
    <?php echo "$menu1" ?>
</div>
       