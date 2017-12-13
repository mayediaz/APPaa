<?php
class miPerfil_model
{
    function guardarTokens()
    {
        global $access_token,$refresh_token;
        include('main.php');
        $sql = "UPDATE usuario SET USUARIO_ACCESS_TOKEN = '".$access_token."', USUARIO_REFRESH_TOKEN = '".$refresh_token."' WHERE USUARIO_ID = ".$_SESSION['userid'];
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $_SESSION['token'] = $access_token;
    }

    function obtenerRooms()
    {
        global $url;

        $ch = curl_init();

        curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = json_decode(trim(curl_exec($ch)));
        $rooms = array();
        $arreglo = get_object_vars($page);
        foreach($arreglo['items'] as $ind => $value)
        {
            $info = get_object_vars($value);
            $rooms[$info['id']] = $info['title'];
        }

        return $rooms;
    }
}
?>