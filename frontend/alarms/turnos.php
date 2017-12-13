<?php
include('sesion.php');
$actionID = (isset($_REQUEST['actionID']))?$_REQUEST['actionID']:"";

switch($actionID)
{
    case 'udpTurnos':
    {
        header('Content-type: application/json');
        MainGeneral();
        $conca = $_REQUEST['conca'];
        $M_turnos->udpTurnos();
    }
    break;
    default:
    {
        MainGeneral();
        $turnos = $M_turnos->traerTurnos();
        $C_turnos->display();
    }
    break;
}

function MainGeneral()
{
    global $C_turnos,$M_turnos;
    include('turnos.class.php');
    include('turnos.model.php');
    $C_turnos	= new turnos();
    $M_turnos = new turnos_model();
}
?>