<?php
class clientes_model
{
    var $clientes;

    function clientes_model()
    {
        include('main.php');
        $sql = "SELECT CLIENTE_ID,CLIENTE_NOMBRE,CLIENTE_REPORTE FROM cliente";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        while($fila = mysql_fetch_assoc($res))
        {
            $this->clientes[$fila['CLIENTE_ID']]['nombre'] = $fila['CLIENTE_NOMBRE'];
            $this->clientes[$fila['CLIENTE_ID']]['reporte'] = $fila['CLIENTE_REPORTE'];
        }
        mysql_free_result($res);
    }

    function validarCliente()
    {
        include('main.php');
        global $nombre;
        $sql = "SELECT CLIENTE_ID FROM cliente WHERE CLIENTE_NOMBRE = '$nombre'";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $a_vect['val'] = 'TRUE';
            $filas = mysql_num_rows($res);

            if($filas == 0)
                $a_vect['ok'] = 1;
            else
                $a_vect['ok'] = 0;
        }
        echo json_encode($a_vect);
    }

    function obtenerToken($params)
    {
        global $cliente;
        $a_vect['val'] = 'FALSE';
        $url = $params['url_spark']['valor']."tc?client=".strtolower($cliente);
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = trim(curl_exec($ch));
        if($page != '')
        {
            $a_vect['val'] = 'TRUE';
            $page = json_decode($page);
            $a_vect['info'] = $page->token;
        }
        echo json_encode($a_vect);
    }

    function guardarCliente()
    {
        include('main.php');
        global $cliente,$token,$informe;
        $sql = "INSERT INTO cliente(CLIENTE_NOMBRE,CLIENTE_APIKEY,CLIENTE_REPORTE) VALUES ('".strtolower($cliente)."','$token','$informe')";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $a_vect['val'] = 'TRUE';
        }
        echo json_encode($a_vect);
    }

    function upd_cliente()
    {
        include('main.php');
        global $cliente,$token,$id,$informe;
        $sql = "UPDATE cliente SET CLIENTE_NOMBRE = '".strtolower($cliente)."',CLIENTE_APIKEY = '$token',CLIENTE_FMODIFICADO = now(), CLIENTE_REPORTE = '$informe' WHERE CLIENTE_ID = $id";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $a_vect['val'] = 'TRUE';
        }
        echo json_encode($a_vect);
    }
    function validarDup()
    {
        include('main.php');
        global $cliente,$id;
        $sql = "SELECT CLIENTE_ID FROM cliente WHERE CLIENTE_NOMBRE = '$cliente' AND CLIENTE_ID != $id";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $a_vect['val'] = 'TRUE';
            $filas = mysql_num_rows($res);

            if($filas == 0)
                $a_vect['ok'] = 1;
            else
                $a_vect['ok'] = 0;
        }
        echo json_encode($a_vect);
    }
}
?>