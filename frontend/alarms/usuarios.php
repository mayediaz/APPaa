<?php
include('sesion.php');
$actionID = (isset($_REQUEST['actionID']))?$_REQUEST['actionID']:"";
$edit = ($actionID == 'edicion')?true:false;
switch($actionID)
{
    case 'act_token':
    {
        header('Content-type: application/json');
        MainGeneral();
        $id = $_REQUEST['id'];
        $token = $_REQUEST['token'];
        $M_usuarios->act_token();
    }
    break;
    case 'updUsuario':
    {
        header('Content-type: application/json');
        MainGeneral();
        $contrasena = $_REQUEST['contrasena'];
        $usuario = $_REQUEST['usuario'];
        $correo = $_REQUEST['correo'];
        $perfil = $_REQUEST['perfil'];
        $cliente = $_REQUEST['cliente'];
        $M_usuarios->updUsuario();
    }
    break;
    case 'traeUsuario':
    {
        header('Content-type: application/json');
        MainGeneral();
        $usuario=$_REQUEST['usuario'];
        $M_usuarios->traeUsuario();
    }
    break;
    case 'guardarUsuario':
    {
        header('Content-type: application/json');
        MainGeneral();
        $login = $_REQUEST['login'];
        $contrasena =$_REQUEST['contrasena'];
        $nombre=$_REQUEST['nombre'];
        $correo=$_REQUEST['correo'];
        $perfil=$_REQUEST['perfil'];
        $cliente=$_REQUEST['cliente'];
        $M_usuarios->guardarUsuario();
    }
    break;
    case 'validarLogin':
    {
        header('Content-type: application/json');
        MainGeneral();
        $nombre = $_REQUEST['nombre'];
        $M_usuarios->validarLogin();
    }
    break;
    case 'edicion':
    case 'nuevo':
    {
        MainGeneral();
        $usuarios = $M_usuarios->usuarios;
        $clientes = $M_clientes->clientes;
        $perfiles = $M_perfiles->perfiles;
        $C_usuarios->nuevoUsuario();
    }
    break;
    default:
    {
        MainGeneral();
        $C_usuarios->display();
    }
    break;
}

function MainGeneral()
{
    global $C_usuarios,$M_usuarios,$M_usuarios,$M_clientes,$M_perfiles;
    include('usuarios.class.php');
    include('usuarios.model.php');
    include('cliente.model.php');
    include('perfil.model.php');
    $C_usuarios	= new usuarios();
    $M_usuarios = new usuarios_model();
    $M_clientes = new clientes_model();
    $M_perfiles = new perfiles_model();
}
?>