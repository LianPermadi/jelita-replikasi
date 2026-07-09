$(".tombol-simpan").click(function(){
	var data = $('.form-user').serialize();
	$.ajax({
		type: 'POST',
		url: "simpan.php",
		data: data
	});
});

$(document).ready(function() {
    selesai();
});
 
function selesai() {
	setTimeout(function() {
		update();
		selesai();
	}, 200);
}
 
function update() {
	$.getJSON("data.php", function(data) {
		$("table").empty();
		var no = 1;
		$.each(data.result, function() {
			$("table").append("<tr><td>"+(no++)+"</td><td>"+this['nama']+"</td><td>"+this['status']+"</td></tr>");
		});
	});
}