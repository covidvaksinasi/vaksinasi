 <title>Login</title>
<?php
session_start();
include "config/koneksi.php";

$user=$_POST['username'];
$pass=md5($_POST['password']);

$login=mysql_query("select * from admin where username='$user' and password='$pass'");

$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);
if ($ketemu>0) {
	$_SESSION['username'] = $r['username'];
	$_SESSION['password'] = $r['password'];
	$_SESSION['nama_lengkap'] = $r['nama_lengkap'];
	header("location: index.php");
}
else{
	header("location: formlogin");
}
?>