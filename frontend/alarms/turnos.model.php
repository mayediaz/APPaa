<?php
class turnos_model
{
    var $turnos;
    var $valores;

    function turnos_model()
    {
        include('main.php');
        $sql = "SELECT TURNO_ID,TURNO_NOMBRE,TURNO_DESCRIPCION, TURNO_VALOR FROM turno";
        $res = mysql_query($sql,$conn);
        if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        while($fila = mysql_fetch_assoc($res))
        {
            $this->turnos[$fila["TURNO_ID"]][$fila["TURNO_NOMBRE"]]['desc'] = $fila["TURNO_DESCRIPCION"];
            $this->turnos[$fila["TURNO_ID"]][$fila["TURNO_NOMBRE"]]['val'] = $fila["TURNO_VALOR"];
            $this->valores[$fila["TURNO_NOMBRE"]] = $fila["TURNO_VALOR"];
        }
    }

    function traerTurnos()
    {
        return $this->turnos;
    }

    function udpTurnos()
    {
        include('main.php');
        global $conca;
        $datos = explode("/",$conca);
        for($i = 0;$i < count($datos);$i++)
        {
            $val = explode("!",$datos[$i]);
            $sql = "UPDATE turno SET TURNO_VALOR = '".$val[1]."', TURNO_FMODIFICADO = now() WHERE TURNO_ID = ".$val[0];
            $res = mysql_query($sql,$conn);
            if($res === false){echo 'Error SQL {'.$sql.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
            if(!$res)
            {
                $a_vect['val'] = 'FALSE';
                echo json_encode($a_vect);
            }
        }
        $a_vect['val'] = 'TRUE';
        echo json_encode($a_vect);
    }
}
?>