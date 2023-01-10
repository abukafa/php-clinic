<?php 
session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('aku', '', time()-3600, '/sik');
setcookie('kamu', '', time()-3600, '/sik');

header("location:../index.php");
exit;
?>