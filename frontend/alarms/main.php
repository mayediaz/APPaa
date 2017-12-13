<?php
/*include('librerias/adodb/adodb.inc.php');
ADOLoadCode('MySql');
$conn = &ADONewConnection();
if($conn -> PConnect("localhost","root","","alarma") === false)
    echo 'no se puedo conectar';
*/
$conn = mysql_connect("localhost","root", "") or die ("No se pudo conectar");
mysql_select_db("alarma",$conn);
?>