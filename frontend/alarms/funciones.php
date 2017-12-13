<?php
include('festivos.php');
include('turnos.model.php');
$M_turnos = new turnos_model();
$M_horarios = new festivos();
$noLaboral = $M_horarios->esNoLaboral(date('d'),date('m'));
$destino;
$tecnico1;
$tecnico2;
$jefe;
$destinoCel;
$tecnico1Cel;
$tecnico2Cel;
$jefeCel;
foreach($M_turnos->valores as $key => $value)
{
    switch($key)
    {
        case 'turno1ext':
        {
            $destino = $value;
        }
        break;
        case 'turno1cel':
        {
            $destinoCel = $value;
        }
        break;
        case 'turno2ext':
        {
            $tecnico1 = $value;
        }
        break;
        case 'turno2cel':
        {
            $tecnico1Cel = $value;
        }
        break;
        case 'turno3ext':
        {
            $tecnico2 = $value;
        }
        break;
        case 'turno3cel':
        {
            $tecnico2Cel = $value;
        }
        break;
        case 'jefeext':
        {
            $jefe = $value;
        }
        break;
        case 'jefecel':
        {
            $jefeCel = $value;
        }
        break;
    }
}
$hora = date("H");

if($hora >= 15 && $hora < 23)
{
    $destino = $tecnico1;
    $destinoCel = $tecnico1Cel;
}
else if($hora >= 23 && $hora < 7)
{
    $destino = $tecnico2;
    $destinoCel = $tecnico2Cel;
}
?>