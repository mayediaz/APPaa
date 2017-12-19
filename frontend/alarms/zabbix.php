<?php
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents("debug.log", print_r($data,1).PHP_EOL,FILE_APPEND);
include('servicios.model.php');
$M_servicios = new servicios_model();
if($_REQUEST['test'] == 1)
{

    $param = $M_servicios->params[$M_servicios->zabbix];
    if(isset($param[$data['Cliente']]))
    {
        $id = $param[$data['Cliente']]['zabbix']['id'];
        $M_servicios->salvarTestZabbix($id,date('Y-m-d H:i:s'));
    }
}
else
{

    include('funciones.php');
    $clienteRep[] = $data['Cliente'];
    $key = array_search($data['Cliente'],$M_servicios->arr_clientes);
    $asunto = $data['Asunto'];
    $M_servicios->registroEvento(2,"Evento Zabbix",$asunto,$key);
    $M_servicios->alertar();
}
if((isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"] == '127.0.0.1'))
{
    echo "Script Ejecutado";
}
?>