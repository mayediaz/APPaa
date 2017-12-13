<?php
class usuarios_model
{
    var $usuarios;

    function usuarios_model()
    {
        include('main.php');
        $sql = "SELECT USUARIO_ID,USUARIO_NOMBRE,USUARIO_LOGIN,USUARIO_PASSWORD,USUARIO_CORREO,USUARIO_PERFIL,USUARIO_EMPRESA,USUARIO_REFRESH_TOKEN FROM usuario";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        while($fila = mysql_fetch_assoc($res))
        {
            $this->usuarios[$fila['USUARIO_ID']]['nombre'] = $fila['USUARIO_NOMBRE'];
            $this->usuarios[$fila['USUARIO_ID']]['login'] = $fila['USUARIO_LOGIN'];
            $this->usuarios[$fila['USUARIO_ID']]['contrasena'] = base64_decode($fila['USUARIO_PASSWORD']);
            $this->usuarios[$fila['USUARIO_ID']]['correo'] = $fila['USUARIO_CORREO'];
            $this->usuarios[$fila['USUARIO_ID']]['perfil'] = $fila['USUARIO_PERFIL'];
            $this->usuarios[$fila['USUARIO_ID']]['empresa'] = $fila['USUARIO_EMPRESA'];
            $this->usuarios[$fila['USUARIO_ID']]['refresh'] = $fila['USUARIO_REFRESH_TOKEN'];
        }
    }

    function traeUsuario()
    {
        global $usuario;
        $a_vect['val'] = 'TRUE';
        $a_vect['info'] = $this->usuarios[$usuario];
        echo json_encode($a_vect);
    }

    function validarLogin()
    {
        include('main.php');
        global $nombre;
        $sql = "SELECT USUARIO_ID FROM usuario WHERE USUARIO_LOGIN = '$nombre'";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $a_vect['val'] = 'TRUE';
            $filas = mysql_num_rows($res);

            if($filas == 0)
            {
               $a_vect['ok'] = 1;
            }
            else
            {
                $a_vect['ok'] = 0;
            }
        }
        echo json_encode($a_vect);
    }

    function guardarUsuario()
    {
        include('main.php');
        global $login,$contrasena,$nombre,$correo,$perfil,$cliente;
        $sql = "INSERT INTO usuario(USUARIO_LOGIN,USUARIO_PASSWORD,USUARIO_NOMBRE, USUARIO_CORREO,USUARIO_PERFIL,USUARIO_EMPRESA) VALUES ('$login', '".base64_encode($contrasena)."', '$nombre' , '$correo', $perfil, $cliente)";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $a_vect['val'] = 'TRUE';
        }
        echo json_encode($a_vect);
    }
    function updUsuario()
    {
        include('main.php');
        global $contrasena,$usuario,$correo,$perfil,$cliente;
        $sql = "UPDATE usuario SET USUARIO_PASSWORD = '".base64_encode($contrasena)."',USUARIO_CORREO = '$correo',USUARIO_PERFIL = $perfil,USUARIO_EMPRESA = $cliente WHERE USUARIO_ID = $usuario";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $a_vect['val'] = 'TRUE';
        }
        echo json_encode($a_vect);
    }
    function act_token()
    {
        include('main.php');
        global $id,$token;
        $sql = "UPDATE usuario SET USUARIO_ACCESS_TOKEN = '$token' WHERE USUARIO_ID = $id";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        header('Content-type: application/json');
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $a_vect['val'] = 'TRUE';
        }
        echo json_encode($a_vect);
    }
}
?>