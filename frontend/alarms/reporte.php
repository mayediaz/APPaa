<?php
include("cliente.model.php");
include("servicios.model.php");
$M_clientes = new clientes_model();
$M_servicios = new servicios_model();
foreach($M_clientes->clientes as $key => $info)
{
    if($info['reporte'] == 1)
    {
        $M_servicios->registroEvento("1","Reporte","Generación Reporte por hora",$key);
        $clienteRep[] = $info['nombre'];
        $reporte = 1;
        $M_servicios->notificaCorreo();
    }
}
if((isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"] == '127.0.0.1'))
{
    echo "Script Ejecutado";
}
?>