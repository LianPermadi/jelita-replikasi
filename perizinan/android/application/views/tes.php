<!DOCTYPE html>
<html>
<head>
	<title>Hi there</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
// @param data content html tokopedia(index.php)
var Tokopedia = function(data) {
 $scope = {};
 $scope.data = data;

 // Mengambil kategori-kategori tokopedia
 this.getCategories = function() {
 return $scope.getCategories();
 }

 // Private method untuk mengambil kategori tokopedia
 $scope.getCategories = function() {
 // Mengubah data XML menjadi object jQuery 
 var _jquery = $($scope.data);

 // Mengambil semua tag <span class="title"> yang mempunyai parent <li> lalu <ul class ="allcat">
 var _ul = _jquery.find('ul.allcat li span.title');

 // Membuat variable _cat untuk menampung semua kategori
 var _cat = [];

 _ul.each(function(i, li) {
 _cat.push($(li).text());
 });

 return _cat;
 }
}

$(document).ready(function(){
 var _url = 'getpage.php';
 $.get(_url, {url: 'https://www.tokopedia.com'}, function(data) {
   var tp = new Tokopedia(data);
   var categories = tp.getCategories();

   console.log(categories);
 });
});
</script>
</head>
<body>
</body>
</html>