<?php
$hostname='localhost';
$database='cardenastec';
$username='root';
$password='';

$conexion=mysqli_connect($hostname, $username, $password, $database);
if($conexion->connect_errno){
	echo "Problemas de conexion";
	
}
?>