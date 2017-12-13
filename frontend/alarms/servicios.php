<?php
include('sesion.php');
$actionID = (isset($_REQUEST['actionID']))?$_REQUEST['actionID']:"";
switch($actionID)
{
    case 'actualizarParametro':
    {
        header('Content-type: application/json');
        MainGeneral();
        $id  = $_REQUEST['id_param'];
        $desc  = $_REQUEST['desc'];
        $nombre = $_REQUEST['nombre'];
        $tipo = $_REQUEST['tipo'];
        $M_servicios->actualizarParametro();
    }
    break;
    case 'traeParametros':
    {
        header('Content-type: application/json');
        MainGeneral();
        $servicio = $_REQUEST['servicio'];
        $params = $M_servicios->obtenerForm();
        $a_vect['val'] = 'true';
        foreach($params as $key => $val)
        {
            if(isset($val['define']))
            {
                $a_vect['define'] = $val['define'];
            }
        }
        echo json_encode($a_vect);
    }
    break;
    case 'edicion':
    {
        MainGeneral();
        $servicios = $M_servicios->traerServicios();
        $C_servicios->nuevoServicio();
    }
    break;
    case 'guardarParametro':
    {
        header('Content-type: application/json');
        MainGeneral();
        $desc  = $_REQUEST['desc'];
        $nombre = $_REQUEST['nombre'];
        $tipo = $_REQUEST['tipo'];
        $servicio = $_REQUEST['servicio'];
        $M_servicios->guardarParametro();
    }
    break;
    case 'guardarServicio':
    {
        header('Content-type: application/json');
        MainGeneral();
        $nombre = $_REQUEST['nombre'];
        $M_servicios->guardarServicio();
    }
    break;
    case 'validarServicio':
    {
        header('Content-type: application/json');
        MainGeneral();
        $nombre = $_REQUEST['nombre'];
        $M_servicios->validarServicio();
    }
    break;
    case 'nuevo':
    {
        MainGeneral();
        $C_servicios->nuevoServicio();
    }
    break;
    default:
    {
        MainGeneral();
        $C_servicios->display();
    }
    break;
}

function MainGeneral()
{
    global $C_servicios,$M_servicios;
    include('servicios.class.php');
    include('servicios.model.php');
    $C_servicios	= new Servicios();
    $M_servicios = new servicios_model();
}
?>