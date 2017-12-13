<?php
class Inicio_model
{
    function menu()
    {
        include('main.php');
        global $perfil;
        $menu = array();
        $sql_menu = "SELECT MENU_ID,MENU_NOMBRE,MENU_RUTA,MENU_ICONO FROM menu INNER JOIN PERMISO ON (MENU_ID = PERMISO_MENU_ID) WHERE MENU_ACTIVO = 1 AND PERMISO_PERFIL_ID = $perfil";
        $res_menu = mysql_query($sql_menu,$conn);
        if($res_menu === false){echo 'Error SQL {'.$sql_menu.'}&nbsp;&nbsp;&nbsp;'.mysql_error($conn);exit;}
        while($fila = mysql_fetch_assoc($res_menu))
        {
            $menu[$fila["MENU_ID"]][$fila["MENU_NOMBRE"]] = $fila["MENU_RUTA"]."/".$fila["MENU_ICONO"];
        }
        mysql_free_result($res_menu);
        return $menu;
    }
}
?>