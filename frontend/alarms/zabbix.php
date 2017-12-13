<?php
$data = json_decode(file_get_contents('php://input'), true);
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
?>