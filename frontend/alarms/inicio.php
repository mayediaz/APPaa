<?php
include('sesion.php');
$actionID = (isset($_REQUEST['actionID']))?$_REQUEST['actionID']:"";
$code = (isset($_REQUEST['code']))?$_REQUEST['code']:"";
$onload = (isset($_REQUEST['code']))?true:false;
switch($actionID)
{
    default:{
        MainGeneral();
        $C_inicio->requeridos();
        $perfil = $_SESSION['perfil'];
        $menu = $M_inicio->menu();
        $C_inicio->display();
    }break;
}
function MainGeneral()
{
    global $C_inicio,$M_inicio;
    include('inicio.class.php');
    include('inicio.model.php');
    $C_inicio	= new Inicio();
    $M_inicio = new Inicio_model();
}
?>