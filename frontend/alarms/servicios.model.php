<?php
class servicios_model
{
    var $servicios;

    var $params;

    var $arr_clientes;

    var $zabbix;

    var $spark;

    var $ccx;

    var $nexmo;

    var $e1;

    var $correo;

    var $cliente;

    var $lista_correos;

    var $rooms;

    function servicios_model()
    {
        include('main.php');

        $sql = "SELECT CLIENTE_NOMBRE FROM cliente WHERE CLIENTE_PRINCIPAL = 1";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($fila = mysql_fetch_assoc($res))
        {
            $this->cliente = $fila['CLIENTE_NOMBRE'];
        }

        mysql_free_result($res);

        $sql = "SELECT CLIENTE_NOMBRE,CLIENTE_APIKEY,USUARIO_ID, USUARIO_CORREO,USUARIO_ROOM,USUARIO_NROOM,USUARIO_ACCESS_TOKEN FROM cliente INNER JOIN usuario ON (CLIENTE_ID = USUARIO_EMPRESA)";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        while($fila = mysql_fetch_assoc($res))
        {
            if($fila['USUARIO_CORREO'])
            {
                $this->lista_correos[$fila['CLIENTE_NOMBRE']][$fila['USUARIO_CORREO']] = 1;
            }
            $this->rooms[$fila['CLIENTE_NOMBRE']]['APIKEY'] = $fila['CLIENTE_APIKEY'];
            if($fila['USUARIO_ACCESS_TOKEN'])
            {
                $this->rooms[$fila['CLIENTE_NOMBRE']]['rooms'][$fila['USUARIO_ACCESS_TOKEN']]['id'] = $fila['USUARIO_ROOM'];
                $this->rooms[$fila['CLIENTE_NOMBRE']]['rooms'][$fila['USUARIO_ACCESS_TOKEN']]['nom'] = $fila['USUARIO_NROOM'];
            }
        }

        mysql_free_result($res);

        $sql = "SELECT SERVICIO_ID FROM servicio WHERE SERVICIO_NOMBRE = 'zabbix'";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($fila = mysql_fetch_assoc($res))
        {
            $this->zabbix = $fila['SERVICIO_ID'];
        }

        mysql_free_result($res);

        $sql = "SELECT SERVICIO_ID FROM servicio WHERE SERVICIO_NOMBRE = 'spark'";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($fila = mysql_fetch_assoc($res))
        {
            $this->spark = $fila['SERVICIO_ID'];
        }
        mysql_free_result($res);

        $sql = "SELECT SERVICIO_ID FROM servicio WHERE SERVICIO_NOMBRE = 'ccx'";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($fila = mysql_fetch_assoc($res))
        {
            $this->ccx = $fila['SERVICIO_ID'];
        }
        mysql_free_result($res);

        $sql = "SELECT SERVICIO_ID FROM servicio WHERE SERVICIO_NOMBRE = 'nexmo'";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($fila = mysql_fetch_assoc($res))
        {
            $this->nexmo = $fila['SERVICIO_ID'];
        }
        mysql_free_result($res);

        $sql = "SELECT SERVICIO_ID FROM servicio WHERE SERVICIO_NOMBRE = 'correo'";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($fila = mysql_fetch_assoc($res))
        {
            $this->correo = $fila['SERVICIO_ID'];
        }
        mysql_free_result($res);

        $sql = "SELECT SERVICIO_ID FROM servicio WHERE SERVICIO_NOMBRE = 'e1'";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($fila = mysql_fetch_assoc($res))
        {
            $this->e1 = $fila['SERVICIO_ID'];
        }
        mysql_free_result($res);

        $sql = "SELECT SERVICIO_ID,SERVICIO_NOMBRE,SERVICIO_FIJO FROM servicio";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        while($fila = mysql_fetch_assoc($res))
        {
            $this->servicios[$fila["SERVICIO_ID"]][$fila["SERVICIO_NOMBRE"]] = array();
            $this->servicios[$fila["SERVICIO_ID"]][$fila["SERVICIO_NOMBRE"]]['fijo'] = ($fila["SERVICIO_FIJO"] == 1)?true:false;
            $sql_def = "SELECT DEFINE_ID, DEFINE_TIPO, DEFINE_PARAM,DEFINE_DESCRIPCION FROM define WHERE DEFINE_SERVICIO_ID = ".$fila["SERVICIO_ID"];
            $res1 = mysql_query($sql_def,$conn);
            if($res1 === false){echo 'Error SQL {'.$sql_def.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
            while($fila1 = mysql_fetch_assoc($res1))
            {
                $this->servicios[$fila["SERVICIO_ID"]][$fila["SERVICIO_NOMBRE"]]['define'][$fila1["DEFINE_ID"]]['tipo'] = $fila1["DEFINE_TIPO"];
                $this->servicios[$fila["SERVICIO_ID"]][$fila["SERVICIO_NOMBRE"]]['define'][$fila1["DEFINE_ID"]]['param'] = $fila1["DEFINE_PARAM"];
                $this->servicios[$fila["SERVICIO_ID"]][$fila["SERVICIO_NOMBRE"]]['define'][$fila1["DEFINE_ID"]]['desc'] = utf8_encode($fila1["DEFINE_DESCRIPCION"]);

                $sql_val = "SELECT VAL_DEFINE_ID,CLIENTE_ID, CLIENTE_NOMBRE, VAL_DEFINE_VALOR,VAL_DEFINE_REPORTE,VAL_DEFINE_TEST_ANT,VAL_DEFINE_TEST_ACT
                FROM cliente INNER JOIN val_define ON (CLIENTE_ID = VAL_DEFINE_CLIENTE)
                WHERE VAL_DEFINE_PARAM = ".$fila1["DEFINE_ID"];
                $res2 = mysql_query($sql_val,$conn);
                if($res2 === false){echo 'Error SQL {'.$sql_val.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
                while($fila2 = mysql_fetch_assoc($res2))
                {
                    $this->params[$fila["SERVICIO_ID"]][$fila2["CLIENTE_NOMBRE"]][$fila1["DEFINE_PARAM"]]['id'] = $fila2["VAL_DEFINE_ID"];
                    $this->params[$fila["SERVICIO_ID"]][$fila2["CLIENTE_NOMBRE"]][$fila1["DEFINE_PARAM"]]['valor'] = $fila2["VAL_DEFINE_VALOR"];
                    $this->params[$fila["SERVICIO_ID"]][$fila2["CLIENTE_NOMBRE"]][$fila1["DEFINE_PARAM"]]['test_ant'] = $fila2["VAL_DEFINE_TEST_ANT"];
                    $this->params[$fila["SERVICIO_ID"]][$fila2["CLIENTE_NOMBRE"]][$fila1["DEFINE_PARAM"]]['test_act'] = $fila2["VAL_DEFINE_TEST_ACT"];
                    $this->params[$fila["SERVICIO_ID"]][$fila2["CLIENTE_NOMBRE"]]['reporte'] = $fila2["VAL_DEFINE_REPORTE"];
                }
            }
        }
        mysql_free_result($res1);
        mysql_free_result($res2);
        mysql_free_result($res);
        $sql = "SELECT CLIENTE_ID,CLIENTE_NOMBRE FROM cliente";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        while($fila = mysql_fetch_assoc($res))
        {
            $this->arr_clientes[$fila['CLIENTE_ID']] = $fila['CLIENTE_NOMBRE'];
        }
        mysql_free_result($res);
    }

    function traerClientes()
    {
        return $this->arr_clientes;
    }

    function traerServicios()
    {
        return $this->servicios;
    }

    function obtenerParametros()
    {
        global $servicio;
        return (isset($this->params[$servicio]))?$this->params[$servicio]:'';
    }

    function testZabbix()
    {
        global $servicio;
        $params = $this->obtenerParametros();
        $a_vect['val'] = 'TRUE';
        $a_vect['alertas'] = "";
        $sep = "";
        foreach($params as $cliente => $info)
        {
            $test_act = $info['zabbix']['test_act'];
            if($test_act != '')
            {
                $dif = round((strtotime(date("Y-m-d H:i:s")) - strtotime($test_act))/60);
                if($dif > 5)
                {
                    $a_vect['alertas'] .= $sep.$cliente;
                    $sep = '<br>';
                }
            }
            else
            {
                $a_vect['alertas'] .= $sep.$cliente;
                $sep = '<br>';
            }
        }

        $a_vect['info'] = (strlen($a_vect['alertas']) > 0)?1:0;

        echo json_encode($a_vect);
    }

    function caidazabbix()
    {
        global $servicio,$lista,$noLaboral,$destino,$jefe,$destinoCel,$jefeCel;
        $a_vect['val'] = 'TRUE';
        $this->notificaCorreo("Zabbix");
        if($noLaboral)
        {
            if(!$this->llamadaCCx("Zabbix"))
            {
                $this->llamadaNexmo("Zabbix");
            }
        }
        else
        {
            if(!$this->notificaSpark("Zabbix"))
            {
                if(!$this->llamadaCCx("Zabbix"))
                {
                    $this->llamadaNexmo("Zabbix");
                }
            }
        }
        echo json_encode($a_vect);
    }

    function testCorreo()
    {
        global $servicio;
        $params = $this->obtenerParametros();
        $a_vect['val'] = 'TRUE';
        $a_vect['alertas'] = "";
        $sep = "";
        require_once('librerias/phpmailer/class.phpmailer.php');

        foreach($params as $cliente => $info)
        {

            $mail             = new PHPMailer();
            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
            $mail->AddAddress($info['testCorreo']['valor']);
            $mail->SetFrom($info['rem_prin']['valor']);
            $mail->Subject = 'Mensaje de prueba de Sistema de Alarmas';
            $mail->MsgHTML("Mensaje de correo electrónico enviado automáticamente por el Sistema de Alarmas para comprobar estado del envío.");
            $mail->SMTPAuth   = false;                  // enable SMTP authentication
            $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
            $mail->Host       = $info['correo_prin']['valor'];      // sets as the SMTP server
            $mail->Port       = 25;                   // set the SMTP port for the server
            $mail->Username   = $info['rem_prin']['valor'];  // username
            $mail->Password   = $info['pass_prin']['valor'];            // password
            $mail->SetFrom($info['rem_prin']['valor']);
            if(!$mail->Send())
            {
                $mail             = new PHPMailer();
                $mail->IsSMTP(); // telling the class to use SMTP
                $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                $mail->AddAddress($info['testCorreo']['valor']);
                $mail->SetFrom($info['rem_alt']['valor']);
                $mail->Subject = 'Mensaje de prueba de Sistema de Alarmas';
                $mail->MsgHTML("Mensaje de correo electrónico enviado automáticamente por el Sistema de Alarmas para comprobar estado del envío.");
                $mail->SMTPAuth   = true;                  // enable SMTP authentication
                $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
                $mail->Host       = $info['correo_alt']['valor'];      // sets as the SMTP server
                $mail->Port       = 465;                   // set the SMTP port for the server
                $mail->Username   = $info['rem_alt']['valor'];  // username
                $mail->Password   = $info['pass_alt']['valor'];            // password
                $mail->SetFrom($info['rem_alt']['valor']);
                if(!$mail->Send())
                {
                    $a_vect['alertas'] .= $sep.$cliente;
                    $sep = '<br>';
                }
            }
        }

        $a_vect['info'] = (strlen($a_vect['alertas']) > 0)?1:0;

        echo json_encode($a_vect);
    }

    function caidacorreo()
    {
        global $servicio,$lista,$noLaboral,$destino,$jefe,$destinoCel,$jefeCel;
        $a_vect['val'] = 'TRUE';
        if($noLaboral)
        {
            if(!$this->llamadaCCx("Correo"))
            {
                $this->llamadaNexmo("Correo");
            }
        }
        else
        {
            if(!$this->notificaSpark("Correo"))
            {
                if(!$this->llamadaCCx("Correo"))
                {
                    $this->llamadaNexmo("Correo");
                }
            }
        }
        echo json_encode($a_vect);
    }

    function testCcx()
    {
        global $servicio;
        $params = $this->obtenerParametros();
        $a_vect['val'] = 'TRUE';
        $a_vect['alertas'] = "";
        $sep = "";
        foreach($params as $cliente => $info)
        {

            $url = $info['url_ccx']['valor']."test=1";

            $ch = curl_init();

            curl_setopt ($ch, CURLOPT_URL,$url);
            curl_setopt ($ch, CURLOPT_HEADER, 0);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $page = trim(curl_exec($ch));
            if (!strpos($page, "OK"))
            {
                $a_vect['alertas'] .= $sep.$cliente;
                $sep = '<br>';
            }
        }

        $a_vect['info'] = (strlen($a_vect['alertas']) > 0)?1:0;

        echo json_encode($a_vect);
    }

    function caidaccx()
    {
        global $servicio,$lista,$noLaboral,$destino,$jefe,$destinoCel,$jefeCel;
        $a_vect['val'] = 'TRUE';
        $this->notificaCorreo("Ccx");
        if($noLaboral)
        {
            $this->llamadaNexmo("Ccx");
        }
        else
        {
            if(!$this->notificaSpark("Ccx"))
            {
                $this->llamadaNexmo("Ccx");
            }
        }
        echo json_encode($a_vect);
    }

    function testnexmo()
    {
        global $servicio;
        $params = $this->obtenerParametros();
        $a_vect['val'] = 'TRUE';
        $a_vect['alertas'] = "";
        $sep = "";
        foreach($params as $cliente => $info)
        {

            $url = $info['url_nexmo']['valor']."cstest?test=1";

            $ch = curl_init();

            curl_setopt ($ch, CURLOPT_URL,$url);
            curl_setopt ($ch, CURLOPT_HEADER, 0);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $page = trim(curl_exec($ch));
            if (!strpos($page, "OK"))
            {
                $a_vect['alertas'] .= $sep.$cliente;
                $sep = '<br>';
            }
        }

        $a_vect['info'] = (strlen($a_vect['alertas']) > 0)?1:0;

        echo json_encode($a_vect);
    }

    function caidanexmo()
    {
        global $servicio,$lista,$noLaboral,$destino,$jefe,$destinoCel,$jefeCel;
        $a_vect['val'] = 'TRUE';
        $this->notificaCorreo("Nexmo");
        if($noLaboral)
        {
            $this->llamadaCCx("Nexmo");
        }
        else
        {
            if(!$this->notificaSpark("Nexmo"))
            {
                $this->llamadaCCx("Nexmo");
            }
        }
        echo json_encode($a_vect);
    }

    function caidae1()
    {
        global $servicio,$lista,$noLaboral,$destino,$jefe,$destinoCel,$jefeCel;
        $a_vect['val'] = 'TRUE';
        $this->notificaCorreo("E1");
        if($noLaboral)
        {
            $this->llamadaNexmo("E1");
        }
        else
        {
            if(!$this->notificaSpark("E1"))
            {
                $this->llamadaNexmo("E1");
            }
        }
        echo json_encode($a_vect);
    }

    function testSpark()
    {
        global $servicio;
        $params = $this->obtenerParametros();
        $a_vect['val'] = 'TRUE';
        $a_vect['alertas'] = "";
        $sep = "";
        foreach($params as $cliente => $info)
        {

            $url = $info['url_spark']['valor']."cstest?test=1";

            $ch = curl_init();

            curl_setopt ($ch, CURLOPT_URL,$url);
            curl_setopt ($ch, CURLOPT_HEADER, 0);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $page = trim(curl_exec($ch));
            if (!strpos($page, "OK"))
            {
                $a_vect['alertas'] .= $sep.$cliente;
                $sep = '<br>';
            }
        }

        $a_vect['info'] = (strlen($a_vect['alertas']) > 0)?1:0;

        echo json_encode($a_vect);
    }

    function caidaspark()
    {
        global $servicio,$lista,$noLaboral,$destino,$jefe,$destinoCel,$jefeCel;
        $a_vect['val'] = 'TRUE';
        $this->notificaCorreo("Spark");
        if(!$this->llamadaCCx("Spark"))
        {
            $this->llamadaNexmo("Spark");
        }
        echo json_encode($a_vect);
    }

    function llamadaCCx($nom = '')
    {
        global $servicio,$lista,$destino,$jefe,$clienteRep,$asunto;

        $audio = ($nom != '')?"$nom.wav":$clienteRep[0].".wav";
        $paramsccx = $this->params[$this->ccx][$this->cliente];
        $url = $paramsccx['url_ccx']['valor']."destino=$destino&jefe=$jefe&audio=$audio";

        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = trim(curl_exec($ch));
        $res;
        if (!strpos($page, "!Script ejecutado correctamente!"))
        {
            $res = true;
        }
        else
        {
            $res = false;
        }

        $tipo = ($res)?"1":"2";
        $ref = "Llamada Ccx";
        $mensaje = ($nom != '')?"Llamada a los destinos $destino y $jefe. Caída en Servicio $nom":"Llamada a los destinos $destino y $jefe. Zabbix reporta falla con el asunto: $asunto";
        $cliente = array();
        if($nom != '')
        {
            $cliente = explode("<br>",$lista);
        }
        else
        {
            $cliente = $clienteRep;
        }
        for($i = 0; $i < count($cliente); $i++)
        {
            $key = array_search($cliente[$i],$this->arr_clientes);
            $this->registroEvento($tipo,$ref,$mensaje,$key);
        }
        return $res;
    }

    function llamadaNexmo($nom = '')
    {
        global $servicio,$lista,$destinoCel,$jefeCel,$clienteRep,$asunto;
        if($nom != '')
        {
            $cliente = explode("<br>",$lista);
            $lista = str_replace("<br>","\n",$lista);
        }
        else
        {
            $servicio = $this->zabbix;
            $cliente = $clienteRep;
        }
        $paramsnexmo = $this->params[$this->nexmo][$this->cliente];
        $url = $paramsnexmo['url_nexmo']['valor']."altcall";
        $lista = str_replace(",","\n",$lista);
        $message = ($nombre != '')?"Se esta presentando caidas en el servicio $nom en las siguientes instancias:\n$lista":"Zabbix reporta fallas en el cliente ".$cliente[0]." con el asunto: ".$asunto;
        $data = array("pnumber" => str_replace("*03","57",$destinoCel),"anumber" => str_replace("*03","57",$jefeCel),"message"=>$message,"client" => $this->cliente);
        $data_string = json_encode($data);
        $ch=curl_init($url);

        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Authorization:'.$this->rooms[$this->cliente]['APIKEY'],'Content-Type:application/json')//APIKEY
        ));
        $result = curl_exec($ch);
        file_put_contents("debug.log",$result.PHP_EOL,FILE_APPEND);
        if(strpos($result, "Call in progress") > 0)
        {
            $res = true;
        }
        else
        {
            $res = false;
        }
        $tipo = ($res)?"1":"2";
        $ref = "Llamada Nexmo";
        $mensaje = "Llamada a los destinos ".str_replace("*03","57",$destinoCel)." y ".str_replace("*03","57",$jefeCel).". Caída en Servicio $nom";
        $mensaje = ($nom != '')?"Llamada a los destinos ".str_replace("*03","57",$destinoCel)." y ".str_replace("*03","57",$jefeCel).". Caída en Servicio $nom":"Llamada a los destinos ".str_replace("*03","57",$destinoCel)." y ".str_replace("*03","57",$jefeCel).". Zabbix reporta fallas con el asunto: ".$asunto;
        for($i = 0; $i < count($cliente); $i++)
        {
            $key = array_search($cliente[$i],$this->arr_clientes);
            $this->registroEvento($tipo,$ref,$mensaje,$key);
        }
    }

    function notificaCorreo($nom = '')
    {
        global $servicio,$lista,$clienteRep,$asunto,$reporte;

        $reporte = ($reporte == 1)?true:false;
        $cliente = array();
        if($nom != '')
        {
            $cliente = explode("<br>",$lista);
        }
        else
        {
            $servicio = (!$reporte)?$this->zabbix:0;
            $cliente = $clienteRep;
        }

        require_once('librerias/phpmailer/class.phpmailer.php');
        $interno = array_keys($this->lista_correos[$this->cliente]);
        $paramscorreo = $this->params[$this->correo][$this->cliente];
        $ref = "Envio Correo";
        if(!$reporte)
        {
            $mail             = new PHPMailer();
            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
            foreach($interno as $key => $value)
            {
                $mail->AddAddress($value);
            }
            $mail->SetFrom($paramscorreo['rem_prin']['valor']);
            $mail->Subject = ($nom != '')?'Sistema de Alarmas '."Caidas Detectadas en ".ucfirst($nom):'Sistema de Alarmas. Zabbix reporta fallas';
            if($nom != '')
            {
                $mail->MsgHTML("Se está presentando caidas en las siguientes instancias:<br>$lista");
            }
            else
            {
                $mail->MsgHTML('Zabbix reporta fallas en el cliente '.$cliente[0]." con el asunto: ".$asunto);
            }

            $mail->SMTPAuth   = false;                  // enable SMTP authentication
            $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
            $mail->Host       = $paramscorreo['correo_prin']['valor'];      // sets as the SMTP server
            $mail->Port       = 25;                   // set the SMTP port for the server
            $mail->Username   = $paramscorreo['rem_prin']['valor'];  // username
            $mail->Password   = $paramscorreo['pass_prin']['valor'];            // password
            $envio = false;
            if(!$mail->Send())
            {
                $mail             = new PHPMailer();
                $mail->IsSMTP(); // telling the class to use SMTP
                $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                foreach($interno as $key => $value)
                {
                    $mail->AddAddress($value);
                }
                $mail->SetFrom($paramscorreo['rem_alt']['valor']);
                $mail->Subject = ($nom != '')?'Sistema de Alarmas '."Caidas Detectadas en ".ucfirst($nom):'Sistema de Alarmas. Zabbix reporta fallas';
                $evento = ($nom != '')?"Se está presentando caidas en las siguientes instancias:<br>$lista":'Zabbix reporta fallas en el cliente '.$cliente[0]." con el asunto: ".$asunto;
                $mail->MsgHTML($evento);
                $mail->SMTPAuth   = true;                  // enable SMTP authentication
                $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
                $mail->Host       = $paramscorreo['correo_alt']['valor'];      // sets as the SMTP server
                $mail->Port       = 465;                   // set the SMTP port for the server
                $mail->Username   = $paramscorreo['rem_alt']['valor'];  // username
                $mail->Password   = $paramscorreo['pass_alt']['valor'];            // password
                $mail->SetFrom($paramscorreo['rem_alt']['valor']);
                if(!$mail->Send())
                {
                    $envio = false;
                }
                else
                {
                    $envio = true;
                }
            }
            else
            {
                $envio = true;
            }

            $tipo = ($envio)?"1":"2";
            $mensaje = ($nom != '')?"Envío correo a ".implode(",",$interno).". caida en el servicio $nom":'Envío correo a '.implode(",",$interno).'. Zabbix reporta fallas con el asunto: '.$asunto;
            for($i = 0; $i < count($cliente); $i++)
            {
                $key = array_search($cliente[$i],$this->arr_clientes);
                $this->registroEvento($tipo,$ref,$mensaje,$key);
            }

            $mail->ClearAllRecipients( );
        }
        else
        {
            $envio = true;
        }

        $envioc = array();

        for($i = 0; $i < count($cliente); $i++)
        {
            if(($cliente[$i] != $this->cliente && isset($this->params[$servicio][$cliente[$i]]['reporte']) && $this->params[$servicio][$cliente[$i]]['reporte'] == 1 && !$reporte) || $reporte)
            {
                if(isset($this->lista_correos[$cliente[$i]]))
                {
                    $mail             = new PHPMailer();
                    $mail->IsSMTP(); // telling the class to use SMTP
                    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                    $aux = array_keys($this->lista_correos[$cliente[$i]]);
                    foreach($aux as $key => $value)
                    {
                        $mail->AddAddress($value);
                    }
                    if($cliente[$i] != $this->cliente)
                    {
                        foreach($interno as $ind => $bcc)
                        {
                            $mail->AddBCC($bcc);
                        }
                    }
                    $mail->SetFrom($paramscorreo['rem_prin']['valor']);
                    if(!$reporte)
                    {
                        $mail->Subject = ($nom != '')?'Sistema de Alarmas '."Caidas Detectadas en ".ucfirst($nom):'Sistema de Alarmas. Zabbix reporta fallas';
                        $evento = ($nom != '')?"El servicio ".ucfirst($nom)." en el Cliente ".ucfirst($cliente[$i])." no se encuentra en servicio":'Zabbix reporta fallas con el asunto:'.$asunto;
                        $mail->MsgHTML($evento);
                    }
                    else
                    {
                        $mail->Subject = 'Sistema de Alarmas. Reporte por Horas';
                        $evento = $this->reporte_hora($cliente[$i]);
                        $mail->MsgHTML($evento);
                    }
                    $mail->SMTPAuth   = false;                  // enable SMTP authentication
                    $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
                    $mail->Host       = $paramscorreo['correo_prin']['valor'];      // sets as the SMTP server
                    $mail->Port       = 25;                   // set the SMTP port for the server
                    $mail->Username   = $paramscorreo['rem_prin']['valor'];  // username
                    $mail->Password   = $paramscorreo['pass_prin']['valor'];            // password
                    $envioc = false;
                    if(!$mail->Send())
                    {
                        $mail             = new PHPMailer();
                        $mail->IsSMTP(); // telling the class to use SMTP
                        $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                        $aux = array_keys($this->lista_correos[$cliente[$i]]);
                        foreach($aux as $key => $value)
                        {
                            $mail->AddAddress($value);
                        }
                        if($cliente[$i] != $this->cliente)
                        {
                            foreach($interno as $ind => $bcc)
                            {
                                $mail->AddBCC($bcc);
                            }
                        }
                        $mail->SetFrom($paramscorreo['rem_alt']['valor']);
                        if(!$reporte)
                        {
                            $mail->Subject = ($nom != '')?'Sistema de Alarmas '."Caidas Detectadas en ".ucfirst($nom):'Sistema de Alarmas. Zabbix reporta fallas';
                            $evento = ($nom != '')?"El servicio ".ucfirst($nom)." en el Cliente ".ucfirst($cliente[$i])." no se encuentra en servicio":'Zabbix reporta fallas con el asunto:'.$asunto;
                            $mail->MsgHTML($evento);
                        }
                        else
                        {
                            $mail->Subject = 'Sistema de Alarmas. Reporte por Horas';
                            $evento = $this->reporte_hora($cliente[$i]);
                            $mail->MsgHTML($evento);
                        }
                        $mail->SMTPAuth   = true;                  // enable SMTP authentication
                        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
                        $mail->Host       = $paramscorreo['correo_alt']['valor'];      // sets as the SMTP server
                        $mail->Port       = 465;                   // set the SMTP port for the server
                        $mail->Username   = $paramscorreo['rem_alt']['valor'];  // username
                        $mail->Password   = $paramscorreo['pass_alt']['valor'];            // password
                        if(!$mail->Send())
                        {
                            $envioc = false;
                        }
                        else
                        {
                            $envioc = true;
                        }
                    }
                    else
                    {
                        $envioc = true;
                    }
                    $tipo = ($envioc)?"1":"2";
                    $mensaje = ($nom != '')?"Envío correo a ".implode(",",$aux).". caida en el servicio $nom":'Envío correo a '.implode(",",$aux).'. Zabbix reporta fallas con el asunto: '.$asunto;
                    $key = array_search($cliente[$i],$this->arr_clientes);
                    $this->registroEvento($tipo,$ref,$mensaje,$key);
                }
            }
        }

        return $envio;
    }

    function notificaSpark($nombre = '')
    {
        global $servicio,$lista,$clienteRep,$asunto;
        $cliente = array();
        if($nombre != '')
        {
            $cliente = explode("<br>",$lista);
            $lista = str_replace("<br>","\n",$lista);
        }
        else
        {
            $servicio = $this->zabbix;
            $cliente = $clienteRep;
        }
        $url = $this->params[$this->spark][$this->cliente]['url_spark']['valor']."/cs";
        $res;
        $espacio = array();
        foreach($this->rooms[$this->cliente]['rooms'] as $ind => $room)
        {
            if($room != '')
            {
                $message = ($nombre != '')?"Se esta presentando caidas en el servicio $nombre en las siguientes instancias:\n$lista":"Zabbix reporta fallas en el cliente ".$cliente[0]." con el asunto: ".$asunto;
                $espacio[] = $room['nom'];
                $data = array("tokenCS" => $ind,"room" => $room['id'],"message"=>$message,"client" => $this->cliente);
                $data_string = json_encode($data);
                $ch=curl_init($url);

                curl_setopt_array($ch, array(
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $data_string,
                    CURLOPT_HEADER => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array('Authorization:'.$this->rooms[$this->cliente]['APIKEY'],'Content-Type:application/json')//APIKEY
                ));
                $result = curl_exec($ch);

                if(strpos($result, "Message published") > 0)
                {
                    $res = true;
                }
                else
                {
                    $res = false;
                }
            }
        }

        $tipo = ($res)?"1":"2";
        $ref = "Mensaje Spark";
        $mensaje = ($nombre != '')?"Mensaje por Spark a: ".implode(",",$espacio).". Caida del servicio $nombre":"Mensaje por Spark a: ".implode(",",$espacio).". Zabbix reporta fallas con el asunto: ".$asunto;
        for($i = 0; $i < count($cliente); $i++)
        {
            $key = array_search($cliente[$i],$this->arr_clientes);
            $this->registroEvento($tipo,$ref,$mensaje,$key);
        }

        for($i = 0; $i < count($cliente); $i++)
        {
            $espacio = array();
            if($cliente[$i] != $this->cliente && $this->params[$servicio][$cliente[$i]]['reporte'] == 1)
            {
                if(isset($this->rooms[$cliente[$i]]))
                {
                    foreach($this->rooms[$cliente[$i]]['rooms'] as $ind => $room)
                    {
                        if($room != '')
                        {
                            $espacio[] = $room['nom'];
                            $message = ($nombre != '')?"El servicio ".ucfirst($nombre)." en el Cliente ".ucfirst($cliente[$i])." no se encuentra en servicio":"Zabbix reporta fallas con el asunto: ".$asunto;
                            $data = array("tokenCS" => $ind,"room" => $room['id'],"message"=>$message,"client" => $cliente[$i]);
                            $data_string = json_encode($data);
                            $ch=curl_init($url);

                            curl_setopt_array($ch, array(
                                CURLOPT_POST => true,
                                CURLOPT_POSTFIELDS => $data_string,
                                CURLOPT_HEADER => true,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_HTTPHEADER => array('Authorization:'.$this->rooms[$cliente[$i]]['APIKEY'],'Content-Type:application/json')//APIKEY
                            ));
                            $result = curl_exec($ch);
                            $resc;
                            if(strpos($result, "Message published") > 0)
                            {
                                $resc = true;
                            }
                            else
                            {
                                $resc = false;
                            }
                            $tipo = ($resc)?"1":"2";
                            $ref = "Mensaje Spark";
                            $mensaje = ($nombre != '')?"Mensaje por Spark a: ".implode(",",$espacio).". Caida del servicio $nombre":"Mensaje por Spark a: ".implode(",",$espacio).". Zabbix reporta fallas con el asunto: ".$asunto;
                            $key = array_search($cliente[$i],$this->arr_clientes);
                            $this->registroEvento($tipo,$ref,$mensaje,$key);
                            curl_close($ch);
                        }
                    }
                }
            }
        }
        return $res;
    }

    function obtenerForm()
    {
        global $servicio;
        return $this->servicios[$servicio];
    }

    function guardarParam()
    {
        include('main.php');
        global $conca,$cliente,$reporte;
        $datos = explode("*",$conca);
        for($i = 0;$i < count($datos);$i++)
        {
            $val = explode("!",$datos[$i]);
            $sql = "INSERT INTO val_define (VAL_DEFINE_VALOR,VAL_DEFINE_CLIENTE,VAL_DEFINE_PARAM,VAL_DEFINE_REPORTE ) VALUES ('".$val[1]."','$cliente','".str_replace("n_","",$val[0])."','$reporte')";
            $res = mysql_query($sql,$conn);
            if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
            if(!$res)
            {
                $a_vect['val'] = 'FALSE';
                echo json_encode($a_vect);
            }
            mysql_free_result($res);
        }
        $a_vect['val'] = 'TRUE';
        echo json_encode($a_vect);
    }

    function actualizar()
    {
        include('main.php');
        global $conca,$reporte;
        $datos = explode("*",$conca);
        for($i = 0;$i < count($datos);$i++)
        {
            $val = explode("!",$datos[$i]);
            $sql = "UPDATE val_define SET VAL_DEFINE_VALOR = '".$val[1]."', VAL_DEFINE_FMODIFICADO = now(),VAL_DEFINE_REPORTE = '$reporte' WHERE VAL_DEFINE_ID = ".$val[0];
            $res = mysql_query($sql,$conn);
            if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
            if(!$res)
            {
                $a_vect['val'] = 'FALSE';
                echo json_encode($a_vect);
            }
        }
        $a_vect['val'] = 'TRUE';
        echo json_encode($a_vect);
    }

    function validarServicio()
    {
        include('main.php');
        global $nombre;
        $sql = "SELECT SERVICIO_ID FROM servicio WHERE SERVICIO_NOMBRE = '$nombre'";
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
        mysql_free_result($res);
        echo json_encode($a_vect);
    }

    function guardarServicio()
    {
        include('main.php');
        global $nombre;
        $sql = "INSERT INTO servicio(SERVICIO_NOMBRE) VALUES ('$nombre')";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $a_vect['val'] = 'FALSE';
        if($res)
        {
            $id = mysql_insert_id();
            if($id)
            {
                $a_vect['val'] = 'TRUE';
                $a_vect['id'] = $id;
            }
        }
        echo json_encode($a_vect);
    }
    function guardarParametro()
    {
        include('main.php');
        global $desc,$nombre,$tipo,$servicio;
        $a_vect['val'] = 'FALSE';
        $sql = "INSERT INTO define(DEFINE_SERVICIO_ID, DEFINE_TIPO, DEFINE_PARAM, DEFINE_DESCRIPCION) VALUES ($servicio,'$tipo', '$nombre','$desc')";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($res)
        {
            $a_vect['val'] = 'TRUE';
        }
        echo json_encode($a_vect);
    }

    function actualizarParametro()
    {
        include('main.php');
        global $desc,$nombre,$tipo,$id;
        $a_vect['val'] = 'FALSE';
        $sql = "UPDATE define SET DEFINE_TIPO='$tipo',DEFINE_PARAM='$nombre',DEFINE_DESCRIPCION='$desc',DEFINE_FMODIFICADO=NOW() WHERE DEFINE_ID = ".$id;
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        if($res)
        {
            $a_vect['val'] = 'TRUE';
        }

        echo json_encode($a_vect);
    }

    function salvarTestZabbix($id,$fecha)
    {
        include('main.php');
        $sql = "UPDATE val_define SET VAL_DEFINE_TEST_ANT=VAL_DEFINE_TEST_ACT,VAL_DEFINE_TEST_ACT='$fecha' WHERE VAL_DEFINE_ID = ".$id;
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
    }

    function registroEvento($tipo,$ref,$mens,$cliente)
    {
        include('main.php');
        $sql = "INSERT INTO evento(EVENTO_TIPO,EVENTO_FECHA,EVENTO_REFERENCIA,EVENTO_MENSAJE,EVENTO_CLIENTE) VALUES ('$tipo','".date('Y-m-d H:i:s')."', '$ref','$mens','$cliente')";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
    }

    function alertar()
    {
        global $clienteRep,$asunto,$destino,$jefe,$destinoCel,$jefeCel,$noLaboral;
        $this->notificaCorreo();
        if($noLaboral)
        {
            if(!$this->llamadaCCx())
            {
                $this->llamadaNexmo();
            }
        }
        else
        {
            if(!$this->notificaSpark())
            {
                if(!$this->llamadaCCx())
                {
                    $this->llamadaNexmo();
                }
            }
        }
    }

    function reporte_hora($cliente)
    {
        include('main.php');
        $key = array_search($cliente,$this->arr_clientes);
        $fechaPost = date('Y-m-d H:i:s');
        $fechaAnt = strtotime('-1 hour',strtotime($fechaPost));
        $fechaAnt = date('Y-m-d H:i:s',$fechaAnt);
        $sql_val = "SELECT EVENTO_FECHA, EVENTO_MENSAJE FROM evento WHERE EVENTO_REFERENCIA = 'Evento Zabbix' and EVENTO_CLIENTE = $key and EVENTO_FECHA BETWEEN '$fechaAnt' and '$fechaPost'";
        $res = mysql_query($sql_val,$conn);
        if($res === false){echo 'Error SQL {'.$sql_val.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        $html = "";
        if($res)
        {
            $filas = mysql_num_rows($res);
            $html = (date("a",strtotime($fechaPost)) == "am")?'Buenos días, <br><br>':'Buenas Tardes, <br><br>';
            $html .= "En el periodo comprendido entre las ".date("g:i a",strtotime($fechaAnt))." y ".date("g:i a",strtotime($fechaPost));
            if($filas == 0)
            {
                $html .= " no se presentan novedades.";
            }
            else
            {
                $html .= " se presentan las siguientes novedades:".'<br><br>';
                $nov = array();
                while($fila = mysql_fetch_assoc($res))
                {
                    if(strpos($fila['EVENTO_MENSAJE'], "PROBLEM") === 0)
                    {
                        $ind = (isset($nov['p']))?count($nov['p']):0;
                        $nov['p'][$ind]['fecha'] = $fila['EVENTO_FECHA'];
                        $nov['p'][$ind]['asunto'] = substr($fila['EVENTO_MENSAJE'],strpos($fila['EVENTO_MENSAJE'], "PROBLEM") + 9,strlen($fila['EVENTO_MENSAJE'])-9);
                    }
                    elseif(strpos($fila['EVENTO_MENSAJE'], "OK") === 0)
                    {
                        $ind = (isset($nov['o']))?count($nov['o']):0;
                        $nov['o'][$ind]['fecha'] = $fila['EVENTO_FECHA'];
                        $nov['o'][$ind]['asunto'] = substr($fila['EVENTO_MENSAJE'],strpos($fila['EVENTO_MENSAJE'], "OK") + 4,strlen($fila['EVENTO_MENSAJE'])-4);
                    }
                }
            }
            if(isset($nov['p']) && count($nov['p']) > 0)
            {
                $html .= 'Problemas:<br>';
                $sep = "";
                foreach($nov['p'] as $key => $info)
                {
                    $html .= $sep.$info['fecha'].": ".$info['asunto'];
                    $sep = '<br>';
                }
            }
            $html .= '<br><br>';
            if(isset($nov['o']) && count($nov['o']) > 0)
            {
                $html .= 'OK:<br>';
                $sep = "";
                foreach($nov['o'] as $key => $info)
                {
                    $html .= $sep.$info['fecha'].": ".$info['asunto'];
                    $sep = '<br>';
                }
            }
        }
        mysql_free_result($res);
        return $html;
    }
}
?>