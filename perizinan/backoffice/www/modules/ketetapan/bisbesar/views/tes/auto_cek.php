
	<style>
	
		label{
			display: inline-block;
			width: 100px;
		}
	</style>

	<script src="jquery.js"></script>
	<script>
	$(document).ready(function(){
		$('#username').blur(function(){
			$('#pesan').html('<img style="margin-left:10px; width:10px" src="loading.gif">');
			var username = $(this).val();

			$.ajax({
				type	: 'POST',
				url 	: 'proses.php',
				//url 	: <?php echo base_url();?>'tes/c_tes/check',
				data 	: 'username='+username,
				success	: function(data){
					$('#pesan').html(data);
				}
			})

		});
	});
	</script>

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
		<div class="jwForm registrasi">
			<h1>Registrasi User Baru</h1>
			<p>
				<label for="username">Username</label> 
				<input type="text" id="username">
				<span id="pesan"></span>
			</p>
			<br style="clear: both" />
			<p>
				<label for="password">Password</label>
				<input type="password" name="password" id="password">
			</p>
			<br style="clear: both" />
			<p>
				<label for="password">Full Name</label>
				<input type="text" id="fullname">
			</p>
			<br style="clear: both" />
			<p>
				<label for="phone">Phone</label>
				<input type="phone" id="phone">
			</p>
			<br style="clear: both" />
			<p>
				<input type="submit" value="Daftarkan">
			</p>
			<br style="clear: both" />
		</div>

		
	</div>
</div>
</div>
