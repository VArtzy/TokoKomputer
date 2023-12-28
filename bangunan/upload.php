<?php
$namafolder="gambar/"; //tempat menyimpan file
	echo "Gambar Upload ";
	
	
	$gambar = $namafolder . basename($_FILES["nama_file"]["name"]);	
	move_uploaded_file($_FILES["nama_file"]["tmp_name"], $gambar);
	
	echo $_FILES["nama_file"]["tmp_name"];
	echo "Gambar berhasil dikirim ";

?>