<?php
header('Access-Control-Allow-Origin: *');
cors();
$method = $_SERVER['REQUEST_METHOD'];
$resource = route($_SERVER['REQUEST_URI']);

function route($route)
{
    if (strpos($route, '?')) {
        $route = substr($route, 0, strpos($route, "?"));
        return $route;
    };
}

if(middlewareSecurity()==true)
{
    if(preg_match("/servicios/", $resource, $matches))
    {
        include("consola.php");
        exit();
    }
    if(preg_match("/zabbix/", $resource, $matches))
    {
        include("zabbix.php");
        exit();
    }
    if(preg_match("/usuarios/", $resource, $matches))
    {
        include("tokens.php");
        exit();
    }
    if(preg_match("/reporte/", $resource, $matches))
    {
        include("reporte.php");
        exit();
    }
}

function middlewareSecurity()
{
    //definir seguridad de acceso, por ahora true
    return true;
}

function cors() {

    if (isset($_SERVER['HTTP_ORIGIN']))
    {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
    {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }
}
?>