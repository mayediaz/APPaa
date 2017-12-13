<?php
include('sesion.php');
$actionID = (isset($_REQUEST['actionID']))?$_REQUEST['actionID']:"";

switch($actionID)
{
    case 'upd_cliente':
    {
        header('Content-type: application/json');
        MainGeneral();
        $cliente = $_REQUEST['nombre'];
        $token = $_REQUEST['token'];
        $id = $_REQUEST['id'];
        $informe = $_REQUEST['informe'];
        $M_clientes->upd_cliente();
    }
    break;
    case 'validarDup':
    {
        header('Content-type: application/json');
        MainGeneral();
        $cliente = $_REQUEST['nombre'];
        $id = $_REQUEST['id'];
        $M_clientes->validarDup();
    }
    break;
    case 'listar':
    {
        MainGeneral();
        $clientes = $M_clientes->clientes;
        $C_clientes->listar();
    }
    break;
    case 'guardarCliente':
    {
        header('Content-type: application/json');
        MainGeneral();
        $cliente = $_REQUEST['nombre'];
        $token = $_REQUEST['token'];
        $informe = $_REQUEST['informe'];
        $M_clientes->guardarCliente();
    }
    break;
    case 'obtenerToken':
    {
        header('Content-type: application/json');
        MainGeneral();
        $cliente = $_REQUEST['nombre'];
        $servicio = $M_servicios->spark;
        $clientepri = $M_servicios->cliente;
        $params = $M_servicios->obtenerParametros();
        $M_clientes->obtenerToken($params[$clientepri]);
    }
    break;
    case 'validarCliente':
    {
        header('Content-type: application/json');
        MainGeneral();
        $nombre = $_REQUEST['nombre'];
        $M_clientes->validarCliente();
    }
    break;
    case 'nuevo':
    {
        MainGeneral();
        $C_clientes->nuevoCliente();
    }
    break;
    default:
    {
        MainGeneral();
        $C_clientes->display();
    }
    break;
}

function MainGeneral()
{
    global $C_clientes,$M_clientes,$M_servicios;
    include('cliente.class.php');
    include('cliente.model.php');
    include('servicios.model.php');
    $C_clientes	= new clientes();
    $M_clientes = new clientes_model();
    $M_servicios = new servicios_model();
}
?>