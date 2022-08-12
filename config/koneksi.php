<?php
//KONVERSI PHP KE PHP 7
require_once "parser-php-version.php";

$server = "remotemysql.com:3306";
$username = "p23rQbGkpf";
$password = "Rr0QG92Cgn";
$database = "p23rQbGkpf ";

mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Maaf, Database tidak bisa dibuka");
?>