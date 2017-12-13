<?php
class perfiles_model
{
    var $perfiles;

    function perfiles_model()
    {
        include('main.php');

        $sql = "SELECT PERFIL_ID, PERFIL_NOMBRE FROM perfil";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        while($fila = mysql_fetch_assoc($res))
        {
            $this->perfiles[$fila['PERFIL_ID']] = $fila['PERFIL_NOMBRE'];
        }
    }
}
?>