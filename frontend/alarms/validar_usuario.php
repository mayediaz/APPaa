<?php
session_start();
//datos para establecer la conexion con la base de mysql.
include('main.php');
if(isset($_REQUEST["user"]) && trim($_REQUEST["user"]) != "" && isset($_REQUEST["pass"]) && trim($_REQUEST["pass"]) != "")
{
  $SQL = 'SELECT USUARIO_ID,USUARIO_NOMBRE, USUARIO_PASSWORD, USUARIO_PERFIL,USUARIO_CORREO, USUARIO_ROOM,USUARIO_NROOM, USUARIO_ACCESS_TOKEN FROM usuario WHERE USUARIO_LOGIN ="'.$_REQUEST['user'].'"';
  $result = mysql_query($SQL,$conn);
  if($result === false){echo 'Error SQL {'.$SQL.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
  if($result)
  {
    $fila = mysql_fetch_assoc($result);
  	if($fila["USUARIO_PASSWORD"] == base64_encode($_REQUEST['pass']))
    {
  		$_SESSION["k_username"] = $_REQUEST['user'];
		$_SESSION['userid'] = $fila["USUARIO_ID"];
        $_SESSION['usernom'] = $fila["USUARIO_NOMBRE"];
        $_SESSION['login'] = $_REQUEST['user'];
        $_SESSION['pass'] = $_REQUEST['pass'];
        $_SESSION['perfil'] = $fila["USUARIO_PERFIL"];
        $_SESSION['correo'] = $fila["USUARIO_CORREO"];
        $_SESSION['room'] = $fila["USUARIO_ROOM"];
        $_SESSION['nroom'] = $fila["USUARIO_NROOM"];
        $_SESSION['token'] = $fila["USUARIO_ACCESS_TOKEN"];
        mysql_free_result($result);
        ?>
  		<script LANGUAGE="javascript">
            location.href = "index.php";
  		</script>
        <?php
  	}else
    {
  		echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=index.php'>";
  	}
  }else
  {
  	echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=index.php'>";
  }

}
if(isset($_REQUEST["nombre"]) && trim($_REQUEST["nombre"]) != "" && isset($_REQUEST["pass"]) && trim($_REQUEST["pass"]) != "" && trim($_REQUEST["correo"]) != "")
{
    $campos = "";
    if(isset($_REQUEST['room']))
    {
        $room = explode("-",$_REQUEST['room']);
        $campos = ",USUARIO_ROOM = '".$room[0]."',USUARIO_NROOM = '".$room[1]."'";
        $_SESSION['room'] = $room[0];
        $_SESSION['nroom'] = $room[1];
    }
    $sql = "UPDATE usuario SET USUARIO_NOMBRE = '".$_REQUEST['nombre']."', USUARIO_PASSWORD = '".base64_encode($_REQUEST['pass'])."', USUARIO_CORREO = '".$_REQUEST["correo"]."' $campos WHERE USUARIO_LOGIN = '".$_SESSION['login']."'";
    $result = mysql_query($sql,$conn);
    if($result === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
    $_SESSION['usernom'] = $_REQUEST['nombre'];
    $_SESSION['pass'] = $_REQUEST['pass'];
    $_SESSION['correo'] = $_REQUEST['correo'];
    ?>
    <script LANGUAGE="javascript">
        alert("Perfil Actualizado");
        location.href = "index.php";
    </script>
    <?php
}
else
{
	echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=index.php'>";
}
?>

