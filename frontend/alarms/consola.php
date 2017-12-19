<?php
$actionID = (isset($_REQUEST['actionID']))?$_REQUEST['actionID']:"";
$param = (isset($_REQUEST['param']))?true:false;
switch($actionID)
{
    case 'guardarParam':
    {
        header('Content-type: application/json');
        MainGeneral();
        $conca = $_REQUEST['conca'];
        $cliente = $_REQUEST['cliente'];
        $reporte = $_REQUEST['reporte'];
        $M_servicios->guardarParam();
    }
    break;
    case 'actualizar':
    {
        header('Content-type: application/json');
        MainGeneral();
        $conca = $_REQUEST['conca'];
        $reporte = $_REQUEST['reporte'];
        $M_servicios->actualizar();
    }
    break;
    case 'formulario':
    {
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        $form = $M_servicios->obtenerForm();
        $valores = $M_servicios->obtenerParametros();
        $clientes = $M_servicios->traerClientes();
        $C_servicios->formulario();
    }
    break;
    case 'testzabbix':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        if(isset($_REQUEST['web']) && $_REQUEST['web'] == 1 && $noLaboral)
        {
            $a_vect['val'] = 'TRUE';
            $a_vect['alertas'] = "";
            $a_vect['info'] = 0;
            echo json_encode($a_vect);
        }
        else
        {
            $M_servicios->testZabbix();
        }
    }
    break;
    case 'caidazabbix':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        $lista = $_REQUEST['lista'];
        $M_servicios->caidazabbix();
    }
    break;
    case 'testcorreo':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        if(isset($_REQUEST['web']) && $_REQUEST['web'] == 1 && $noLaboral)
        {
            $a_vect['val'] = 'TRUE';
            $a_vect['alertas'] = "";
            $a_vect['info'] = 0;
            echo json_encode($a_vect);
        }
        else
        {
            $M_servicios->testCorreo();
        }
    }
    break;
    case 'caidacorreo':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        $lista = $_REQUEST['lista'];
        $M_servicios->caidacorreo();
    }
    break;
    case 'testnexmo':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        if(isset($_REQUEST['web']) && $_REQUEST['web'] == 1 && $noLaboral)
        {
            $a_vect['val'] = 'TRUE';
            $a_vect['alertas'] = "";
            $a_vect['info'] = 0;
            echo json_encode($a_vect);
        }
        else
        {
            $M_servicios->testnexmo();
        }
    }
    break;
    case 'caidanexmo':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        $lista = $_REQUEST['lista'];
        $M_servicios->caidanexmo();
    }
    break;
    case 'testccx':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        if(isset($_REQUEST['web']) && $_REQUEST['web'] == 1 && $noLaboral)
        {
            $a_vect['val'] = 'TRUE';
            $a_vect['alertas'] = "";
            $a_vect['info'] = 0;
            echo json_encode($a_vect);
        }
        else
        {
            $M_servicios->testCcx();
        }
    }
    break;
    case 'caidaccx':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        $lista = $_REQUEST['lista'];
        $M_servicios->caidaccx();
    }
    break;
    case 'teste1':
    {
        header('Content-type: application/json');
        $a_vect['info'] = 0;
        $a_vect['val'] = 'true';
        $servicio = $_REQUEST['servicio'];
        echo json_encode($a_vect);
    }
    break;
    case 'caidae1':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        $lista = $_REQUEST['lista'];
        $M_servicios->caidae1();
    }
    break;
    case 'testspark':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        if(isset($_REQUEST['web']) && $_REQUEST['web'] == 1 && $noLaboral)
        {
            $a_vect['val'] = 'TRUE';
            $a_vect['alertas'] = "";
            $a_vect['info'] = 0;
            echo json_encode($a_vect);
        }
        else
        {
            $M_servicios->testSpark();
        }
    }
    break;
    case 'caidaspark':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        $lista = $_REQUEST['lista'];

        $M_servicios->caidaspark();
    }
    break;
    default:
    {

        MainGeneral();
        $servicios = $M_servicios->traerServicios();
        if((isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"] == '127.0.0.1'))
        {
            if($noLaboral)
            {
                $servicio = $M_servicios->zabbix;
                $res = $M_servicios->testZabbix();
                if($res['llamarOk'])
                {
                    $lista = $res['alertas'];
                    $M_servicios->caidazabbix();
                }
                $servicio = $M_servicios->correo;
                $res = $M_servicios->testCorreo();
                if($res['llamarOk'])
                {
                    $lista = $res['alertas'];
                    $M_servicios->caidacorreo();
                }
                $servicio = $M_servicios->ccx;
                $res = $M_servicios->testCcx();
                if($res['llamarOk'])
                {
                    $lista = $res['alertas'];
                    $M_servicios->caidaccx();
                }
                $servicio = $M_servicios->nexmo;
                $res = $M_servicios->testNexmo();
                if($res['llamarOk'])
                {
                    $lista = $res['alertas'];
                    $M_servicios->caidanexmo();
                }
                $servicio = $M_servicios->spark;
                $res = $M_servicios->testSpark();
                if($res['llamarOk'])
                {
                    $lista = $res['alertas'];
                    $M_servicios->caidaspark();
                }
                echo "Script Ejecutado";
            }
        }
        else
        {
            $C_servicios->display();
        }
    }
    break;
}

function MainGeneral()
{
    global $C_servicios,$M_servicios,$destino,$jefe,$destinoCel,$jefeCel,$noLaboral;
    include('consola.class.php');
    include('servicios.model.php');
    include('funciones.php');
    $C_servicios	= new consola();
    $M_servicios = new servicios_model();
}
?>