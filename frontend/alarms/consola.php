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
        $M_servicios->testZabbix();
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
        $M_servicios->testCorreo();
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
        $M_servicios->testnexmo();
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
        $M_servicios->testCcx();
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
        $M_servicios->testSpark();
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
        $C_servicios->display();
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