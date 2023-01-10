<?php 
include 'config.php';
$user=$_POST['user'];
$lama=$_POST['lama'];
$baru=$_POST['baru'];
$ulang=$_POST['ulang'];

$cek=$conn->query("select * from admin where uname='$user' and pass='$lama'");
if($cek->num_rows==1 && $lama<>""){
	if($baru==$ulang){
		$b =($baru);
		$conn->query("update admin set pass='$b' where uname='$user'");
		header("location:pass.php?pesan=oke");
	}else{
		header("location:pass.php?pesan=tdksama");
	}
}else{
	header("location:pass.php?pesan=gagal");
}

 ?>