<?php
/*include('librerias/adodb/adodb.inc.php');
ADOLoadCode('MySql');
$conn = &ADONewConnection();
if($conn -> PConnect("mariadb","infomedia","Inf0m3d14alarms","alarmas") === false)
    echo 'no se puedo conectar';
*/
$conn = mysql_connect("host","user", "clave") or die ("No se pudo conectar");
mysql_select_db("bd",$conn);
?>
