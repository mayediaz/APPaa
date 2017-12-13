<?php
include('sesion.php');
$actionID = (isset($_REQUEST['actionID']))?$_REQUEST['actionID']:"";
$access_token = (isset($_REQUEST['access_token']))?$_REQUEST['access_token']:"";
$refresh_token = (isset($_REQUEST['refresh_token']))?$_REQUEST['refresh_token']:"";
$access_token = ($access_token == '')?$_SESSION['token']:$access_token;
switch($actionID)
{
    default:
    {
        MainGeneral();
        $rooms = array();
        if($access_token != '' && $refresh_token != '')
        {
            $M_perfil->guardarTokens();
        }
        if($access_token != '')
        {
            $url = $M_servicios->params[$M_servicios->spark][$M_servicios->cliente]['url_spark']['valor']."csrooms?token=$access_token";
            $rooms = $M_perfil->obtenerRooms();
        }
        $C_perfil->display();
    }
    break;
}
function MainGeneral()
{
    global $C_perfil,$M_perfil,$M_servicios;
    include('miperfil.class.php');
    include('miperfil.model.php');
    include('servicios.model.php');
    $C_perfil	= new miPerfil();
    $M_perfil = new miPerfil_model();
    $M_servicios = new servicios_model();
}
?>