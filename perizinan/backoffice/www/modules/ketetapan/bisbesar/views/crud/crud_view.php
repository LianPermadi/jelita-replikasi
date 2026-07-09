


<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/autocomplete/bootstrap/css/bootstrap.min.css">!-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/autocomplete/sweetalert/sweetalert.css">

<script type="text/javascript" src="<?php echo base_url();?>assets/autocomplete/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/autocomplete/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/autocomplete/sweetalert/sweetalert.min.js"></script>

<style type="text/css">

td {
	cursor: pointer;
}

.editor{
	display: none;
}

</style>


<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">

<br style="clear: both" />
<button class="btn btn-info" id="tambah-data"><i class="glyphicon glyphicon-plus-sign"></i> Tambah </button>

<br>
<br>
<br>
<!---<table id="table-data" class="table table-striped">-->

<table cellpadding="0" cellspacing="0" border="0" class="display" id="izintrayek" >
<thead>
<tr>
<th>Nama</th>
<th>Email</th>
<th>Phone</th>
<th>Hapus</th>
</tr>
</thead>

<tbody id="table-body">
<?php 

foreach ($people as $member) {
	echo "<tr data-id='$member[id]'>
			<td><span class='span-nama caption' data-id='$member[id]'>$member[nama]</span> <input type='text' class='field-nama form-control editor' value='$member[nama]' data-id='$member[id]' /></td>
			<td><span class='span-email caption' data-id='$member[id]'>$member[email]</span> <input type='text' class='field-email form-control editor' value='$member[email]' data-id='$member[id]' /></td>
			<td><span class='span-phone caption' data-id='$member[id]'>$member[phone]</span> <input type='text' class='field-phone form-control editor' value='$member[phone]' data-id='$member[id]' /></td>
			<td><button class='btn btn-xs btn-danger hapus-member' data-id='$member[id]'><i class='glyphicon glyphicon-remove'></i> Hapus</button></td>
			</tr>";
}


 ?>
</tbody>

</table>

</div>
</div>

</div>







<script type="text/javascript">

$(function(){

$.ajaxSetup({
	type:"post",
	cache:false,
	dataType: "json"
})


$(document).on("click","td",function(){
$(this).find("span[class~='caption']").hide();
$(this).find("input[class~='editor']").fadeIn().focus();
});


$("#tambah-data").click(function(){

$.ajax({
url:"<?php echo base_url();?>bisbesar/c_crud/create",
success: function(a){
var ele="";
ele+="<tr data-id='"+a.id+"'>";
ele+="<td><span class='span-nama caption' data-id='"+a.id+"'></span> <input type='text' class='field-nama form-control editor'  data-id='"+a.id+"' /></td>";
ele+="<td><span class='span-email caption' data-id='"+a.id+"'></span> <input type='text' class='field-email form-control editor' data-id='"+a.id+"' /></td>";
ele+="<td><span class='span-phone caption' data-id='"+a.id+"'></span> <input type='text' class='field-phone form-control editor'  data-id='"+a.id+"' /></td>";
ele+="<td><button class='btn btn-xs btn-danger hapus-member' data-id='"+a.id+"'><i class='glyphicon glyphicon-remove'></i> Hapus</button></td>";
ele+="</tr>";

var element=$(ele);
element.hide();
element.prependTo("#table-body").fadeIn(1500);

}
});
});

var cc =jQuery.noConflict();
cc(document).on("keydown",".editor",function(e){
if(e.keyCode==13){
var target=$(e.target);
var value=target.val();
var id=target.attr("data-id");
var data={id:id,value:value};
if(target.is(".field-nama")){
data.modul="nama";
}else if(target.is(".field-email")){
data.modul="email";
}else if(target.is(".field-phone")){
data.modul="phone";
}

var c =jQuery.noConflict();
c.ajax({
	data:data,
//	url:"<?php echo base_url();?>bisbesar/c_crud/update",
	url:"<?php echo base_url();?>bisbesar/c_crud/user_exists",	

	success: function(a){
		//alert("Data Berhasil diubah");
	 target.hide();
	 target.siblings("span[class~='caption']").html(value).fadeIn();
	}
	
})

}

});

var f =jQuery.noConflict();
f(document).on("click",".hapus-member",function(){
	var id=f(this).attr("data-id");
	swal({
		title:"Hapus Member",
		text:"Yakin akan menghapus member ini? ",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Hapus",
		closeOnConfirm: true,
	},
		function(){
		
		 f.ajax({
			url:"<?php echo base_url();?>bisbesar/c_crud/delete",
			data:{id:id},
			success: function(){
				f("tr[data-id='"+id+"']").fadeOut("fast",function(){
					f(this).remove();
				});
			}
		 });
	});
});

});

</script>

<br style="clear: both" />
       </div>
       </div>
       </div>