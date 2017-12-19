<?php
	class Consola
    {
        public function display()
        {
            global $param,$servicios,$noLaboral;
            $this->encabezados();
            ?>
                        .navbar-brand{
                            line-height: 40px;
                        }
                        .navbar-brand:hover{
                            color:#FFFFFF;
                        }
                    </style>
                </head>
                <body <?php echo (!$param)?'onload="monitorear()"':"";?>>
                    <div class="wrapper">
                        <div class="section section-header">
                            <div class="parallax pattern-image">
                                <img src="../../recursos/img/Infomedia.jpg"/>
                                <div class="container">
                                    <div class="content">
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <?php
                                                if($param)
                                                {
                                                    ?>
                                                    <a href="#" class="navbar-brand" onclick = "iniciarMonitoreo()">
                                                        Monitorear Servicios
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                                <h2><?php echo ($param)?utf8_encode('Configuración de los servicios'):"Estado de Servicios"?></h2>
                                            </div>
                                        </div>
                                        <?php
                                        $ind = 0;
                                        $cierre = false;
                                        foreach($servicios as $key => $value)
                                        {
                                            foreach($value as $nom => $info)
                                            {
                                                $evento = ($param)?'onclick = "formulario('.$key.',\''.strtoupper($nom).'\')"':'onclick = "caidas(\''.$nom.'\')"';
                                                if($ind % 3 == 0)
                                                {
                                                    if($cierre)
                                                    {
                                                        ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="row">
                                                    <?php
                                                    $cierre = true;
                                                }
                                                $imagen = getimagesize("recursos/img/".$nom.".png");
                                                $alto = $imagen[1]/50-0.32;
                                                ?>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header card-chart" data-background-color="green">
                                                            <div data-toggle="modal" data-target="#myModal" <?php echo $evento?>  style = "cursor:pointer;">
                                                                <img src = "../../recursos/img/<?php echo $nom?>.png" style = "width: 30%;margin-top:<?php echo $alto?>px">
                                                            </div>
                                                        </div>
                                                        <div class="card-content">
                                                            <h2 class="title" id = "<?php echo $nom?>"><?php echo strtoupper($nom)?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type = "hidden" name = "lista_<?php echo $nom?>" id = "lista_<?php echo $nom?>">
                                                <?php
                                                $ind++;
                                            }
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <audio id="myAudio">
                        <source src="../../recursos/sonidos/alarma.mp3" type="audio/mpeg">
                    </audio>

                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 style="color:#999999;"><span id = "title_modal"></span></h4>
                                </div>
                                <div class="modal-body" id = "modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"></span> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                $this->cierre();
                $variables = "var entprincipal = 0;";
                $llamada = "";
                $notificar = "if(";
                $funcionprin = "function monitorear()
                {";
                $funcion = array();
                $testear = "";
                foreach($servicios as $key => $value)
                {
                    foreach($value as $nom => $info)
                    {
                        $variables .= " var test".$nom.";
                            var alarm".$nom.";
                            var mon".$nom.";
                            var ent".$nom." = 0;
                            var cont".$nom." = 0;";

                        $llamada .= " if(ent".$nom." == 0)
                            {
                                ".$nom."();
                            }";

                        $funcion[] = "function ".$nom."()
                        {
                            $.ajax({
                                url:'',
                                type: 'POST',
                                cache: false,
                                dataType: 'json',
                                data: ({actionID: 'test".$nom."',servicio: ".$key.",web:1 }),
                                error:function(objeto, quepaso, otroobj){clearInterval(test".$nom.");alert('Error');},
                                success: function(data){
                                    clearInterval(test".$nom.");
                                    if(data.val=='FALSE'){
                                        alert('Error al hacer test de ".$nom."');
                                        return false;
                                    }
                                    if(data.info == 1)
                                    {
                                        document.getElementById('lista_".$nom."').value = data.alertas;
                                        cont".$nom."++;
                                        if(cont".$nom." == 3)
                                        {
                                            $.ajax({
                                                url:'',
                                                type: 'POST',
                                                cache: false,
                                                dataType: 'json',
                                                data: ({actionID: 'caida".$nom."',servicio: ".$key.", lista: data.alertas }),
                                                error:function(objeto, quepaso, otroobj){alert('Error');},
                                                success: function(data){
                                                    if(data.val=='FALSE'){
                                                        alert('Error al notificar caida ".$nom."');
                                                        return false;
                                                    }
                                                }
                                            });
                                        }
                                        if(ent".$nom." == 0)
                                        {
                                            document.getElementById('myAudio').play();
                                            alarm".$nom." = setInterval(function(){parpadear('".$nom."');}, 500);
                                            mon".$nom." = window.setInterval (".$nom.", 60000);
                                            ent".$nom." = 1;
                                        }
                                    }
                                    else
                                    {
                                        if(cont".$nom." > 3)
                                        {
                                            $.ajax({
                                                url:'',
                                                type: 'POST',
                                                cache: false,
                                                dataType: 'json',
                                                data: ({actionID: 'subida".$nom."',servicio: ".$key." }),
                                                error:function(objeto, quepaso, otroobj){alert('Error');},
                                                success: function(data){
                                                    if(data.val=='FALSE'){
                                                        alert('Error al notificar subida ".$nom."');
                                                        return false;
                                                    }
                                                }
                                            });
                                        }
                                        cont".$nom." = 0;
                                        document.getElementById('lista_".$nom."').value = '';
                                        ent".$nom." = 0;
                                        clearInterval(alarm".$nom.");
                                        clearInterval(mon".$nom.");
                                        document.getElementById ('".$nom."').style.color = '#000000';
                                    }
                                }
                            });
                        }";

                        $testear .= " case $key:
                        {
                            clearInterval(alarm".$nom.");
                            test".$nom." = setInterval(function(){parpadearTest('".$nom."');}, 500);
                            ".$nom."();
                        }
                        break;";
                    }
                }

                $funcionprin .= "$llamada
                if(entprincipal == 0)
                {
                    window.setInterval (monitorear, 300000);
                    entprincipal = 1;
                }}";
                $actualizar = "function actualizar(campos,servicio,cliente)
                {
                    if($('#reporte_'+cliente).val() == '-1')
                    {
                        alert('Debe completar todos los campos');
                        return;
                    }

                    valores = campos.split(',');
                    var conca = '';
                    var sep = '';

                    for (var i=0; i < valores.length; i++)
                    {
                        if($('#'+valores[i]).val() != '')
                        {
                            conca += sep + valores[i] + '!' + $('#'+valores[i]).val();
                            sep = '*';
                        }
                        else
                        {
                            alert('Debe completar todos los campos');
                            return;
                        }
                    }

                    $.ajax({
                        url:'',
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        data: ({actionID:'actualizar',conca:conca,reporte:$('#reporte_'+cliente).val()}),
                        error:function(objeto, quepaso, otroobj){alert('Error');},
                        success: function(data){
                            if(data.val=='FALSE'){
                                alert('Error al actualizar datos');
                                return false;
                            }
                            alert('Datos actualizados correctamente');
                            $('#myModal').modal('hide');
                            switch(servicio) {
                                $testear
                            }
                        }
                    });
                }";

                $guardarParam = "function guardarParam(campos,servicio,cliente)
                {
                    if($('#reporte_'+cliente).val() == '-1')
                    {
                        alert('Debe completar todos los campos');
                        return;
                    }
                    valores = campos.split(',');
                    var conca = '';
                    var sep = '';

                    for (var i=0; i < valores.length; i++)
                    {
                        if($('#'+valores[i]).val() != '')
                        {
                            conca += sep + valores[i] + '!' + $('#'+valores[i]).val();
                            sep = '*';
                        }
                        else
                        {
                            alert('Debe completar todos los campos');
                            return;
                        }
                    }

                    $.ajax({
                        url:'',
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        data: ({actionID:'guardarParam',conca:conca,cliente:cliente,reporte:$('#reporte_'+cliente).val()}),
                        error:function(objeto, quepaso, otroobj){alert('Error');},
                        success: function(data){
                            if(data.val=='FALSE'){
                                alert('Error al guardar datos');
                                return false;
                            }
                            alert('Datos guardados correctamente');
                            $('#myModal').modal('hide');
                            switch(servicio) {
                                $testear
                            }
                        }
                    });
                }";

                $concafunc = $variables." ".$funcionprin." ";
                $sep = "";
                for($i = 0;$i < count($funcion);$i++)
                {
                    $concafunc .= $sep.$funcion[$i];
                    $sep = " ";
                }
                $parpadear = "function parpadear(servicio)
                {
                    color = (document.getElementById (servicio).style.color == 'red')? '#000000' : 'red';
                    document.getElementById (servicio).style.color = color;
                }
                function parpadearTest(servicio)
                {
                    color = (document.getElementById (servicio).style.color == 'gray')? '#000000' : 'gray';
                    document.getElementById (servicio).style.color = color;
                }
                function caidas(nom)
                {
                    document.getElementById('title_modal').innerHTML = 'Caidas Detectadas';
                    document.getElementById('modal-body').innerHTML = document.getElementById('lista_'+nom).value;
                }
                ";
                $concafunc .= " $actualizar $parpadear $guardarParam";
                echo '<script>'.$concafunc.'</script>';
                ?>
            </html>
		<?php
		}

        function encabezados()
        {
            ?>
            <!doctype html>
            <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
                    <meta name="viewport" content="width=device-width" />

                    <title>Infomedia Posventa - Consola</title>
                    <link href="../../recursos/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
                    <link href="../../recursos/css/bootstrap.min.css" rel="stylesheet" />
                    <link href="../../recursos/css/rubick_pres.css" rel="stylesheet"/>
                    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
                    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
                    <style>
                    .form-group{
                            margin: 15px 0 0 0;
                            padding-bottom: 0px;
                        }
                        .form-control:focus {
                          background-color: #FFFFFF;
                          border: 0px;
                          -webkit-box-shadow: none;
                          box-shadow: none;
                          outline: 0 !important;
                          background-image: linear-gradient(green, green), linear-gradient(green, green) !important;
                        }
                        .form-group label.control-label{
                            color:#999999;
                            font-size: medium;
                        }
                        .modal-content .modal-body{
                            padding-top:0px;
                        }
                        .modal-body{
                            padding-top:0px;
                        }
                        h2 {
                            margin: 0.4em 194px;
                        }
            <?php
        }

        function cierre()
        {
            ?>
            </body>
                <script src="../../librerias/js/jquery-1.11.2.min.js" type="text/javascript"></script>
                <script src="../../librerias/js/bootstrap.min.js" type="text/javascript"></script>
                <script type="text/javascript" src="../../librerias/js/jquery.waypoints.min.js"></script>
                <script type="text/javascript" src="../../librerias/js/modernizr.js"></script>
                <script type="text/javascript" src="../../librerias/js/rubick_pres.js"></script>
                <script type="text/javascript" src="../../librerias/js/funciones_consola1.js"></script>
                <script src="../../librerias/js/xhr.js" type="text/javascript"></script>
                <script src="../../librerias/js/ajax.js" type="text/javascript"></script>
            <?php
        }

        function formulario()
        {
            global $valores,$form,$servicio,$clientes;
            $client = array();
            ?>
            <div class="form-group">
                <select id = "cliente_conf" name = "cliente_conf" onchange = "cargaConf()">
                    <option value = "">Seleccione un cliente...</option>
                    <?php
                    foreach($clientes as $keys => $val)
                    {
                        $client[] = $val;
                        ?>
                        <option value = "<?php echo $val?>"><?php echo $val?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type = "hidden" id = "l_clientes" name = "l_clientes" value = "<?php echo implode(",",$client)?>">
            <?php
            foreach($clientes as $keys => $val)//$valores as $cliente => $params
            {
                ?>
                <div id = "cfg_<?php echo $val?>" style = "display:none">
                    <?php
                    $campos = "";
                    $sep = "";
                    foreach($form as $idserv => $defines)
                    {
                        if(count($defines) > 0)
                        {
                            $function = (!isset($valores[$val]))?"guardarParam":"actualizar";
                            if(isset($defines['define']))
                            {
                                $reporte = "-1";
                                foreach($defines['define'] as $llave => $cfg)
                                {
                                    $id = (!isset($valores[$val]))?"n_".$llave:$valores[$val][$cfg['param']]['id'];
                                    $valor = (!isset($valores[$val]))?"":$valores[$val][$cfg['param']]['valor'];
                                    $reporte = (!isset($valores[$val]))?"-1":$valores[$val]['reporte'];
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label label-floating"><?php echo $cfg['desc']?></label>
                                        <input type="<?php echo $cfg['tipo']?>" class="form-control" id="<?php echo $id?>" name="<?php echo $id?>" value="<?php echo $valor?>">
                                    </div>
                                    <?php
                                    $campos .= $sep.$id;
                                    $sep = ",";
                                }
                                ?>
                                <div class="form-group">
                                    <label class="control-label label-floating">Reporte</label>
                                    <select id = "reporte_<?php echo $keys?>" name = "reporte_<?php echo $keys?>">
                                        <option value = "-1" <?php echo ($reporte == '-1')?'selected':"";?>>Seleccione una opcion....</option>
                                        <option value = "0" <?php echo ($reporte == 0)?'selected':"";?>>Internamente</option>
                                        <option value = "1" <?php echo ($reporte == 1)?'selected':"";?>>Todos</option>
                                    </select>
                                </div>
                                <button class="btn btn-default" onclick = "<?php echo $function?>('<?php echo $campos?>',<?php echo $servicio?>,<?php echo $keys?>)">Guardar</button>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <?php
            }
        }
	}
?>