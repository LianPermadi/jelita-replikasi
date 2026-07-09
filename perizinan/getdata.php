<html lang="en">
<head>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="jsonp.js"></script>
  <script>
   $(document).ready(function(){
		$.jsonp({
			url: 'http://sicantik.alp.layanan.go.id/application.php',
			callbackParameter: 'callback',
			success: function(data, status) {
			
				$.each(data, function(i,item){
					var list="";
					var nama = item.nilainamaLengkap;
					
					
					list += '<h1>'+ nama + '</h1>';
					list += '<br>';
					$('#text').append(list);
				});
			},
			error: function(){
				$('#text').append('<li>There was an error loading the feed</li>');
			}
		});
	}); 
  
  </script>
  
</head>
<body>
  <div id="text">
  </div>
</body>
</html>
