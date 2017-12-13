<?php
	class Clientes
    {
		public function display()
        {
            ?>
            <body style = "background-color: #EEEEEE;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="green" style = "height:83.3px">
                                    <h4 class="title">Clientes</h4>
                                    <p class="category">Seleccione la opci&oacute;n deseada</p>
                                </div>
                                <div class="card-content">
                                    <div class="list-group">
                                        <a href="#" onclick = "abrirOpcion('cliente.html.php?actionID=nuevo')" class="list-group-item">Adicionar nuevo Cliente</a>
                                        <a href="#" onclick = "abrirOpcion('cliente.html.php?actionID=listar')" class="list-group-item">Listar Clientes</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
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

                    <title>Infomedia Posventa - Clientes</title>
                    <link href="../../recursos/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
                    <link href="../../recursos/css/bootstrap.min.css" rel="stylesheet" />
                    <link href="../../recursos/css/rubick_pres.css" rel="stylesheet"/>
                    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
                    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
                    <style>
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
                    </style>
                </head>
            <?php
        }

        function cierre()
        {
            ?>
            <script src="../librerias/js/jquery-1.11.2.min.js" type="text/javascript"></script>
            <script src="../librerias/js/bootstrap.min.js" type="text/javascript"></script>
            <script type="text/javascript" src="../librerias/js/jquery.waypoints.min.js"></script>
            <script type="text/javascript" src="../librerias/js/modernizr.js"></script>
            <script type="text/javascript" src="../librerias/js/rubick_pres.js"></script>
            <script type="text/javascript" src="../librerias/js/funciones_consola1.js"></script>
            <script src="../librerias/js/xhr.js" type="text/javascript"></script>
            <script src="../librerias/js/ajax.js" type="text/javascript"></script>
            <?php
        }

        function nuevoCliente()
        {
            ?>
                <style>
                .navbar-brand{
                    float: right;
                    padding: 0px;
                    line-height:0px;
                }
                </style>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header" data-background-color="green" style = "height:83.3px">
                                        <a href="#">
                                            <img class="img" src="recursos/img/home.png" style = "width: 4%;float: right;"  onclick = "abrirOpcion('cliente.html.php')"/>
                                        </a>
                                        <h4 class="title">Nuevo Cliente</h4>
                                        <p class="category">Complete los &iacute;tems solicitados</p>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Nombre del Cliente</label>
                                                    <input type="text" id = "n_cliente" name = "n_cliente" class="form-control" onchange = "validarCliente()">
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label><input type="checkbox"  id = "n_informe" name = "n_informe"> Generar Informe cada hora</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button id = "crearCliente" name = "crearCliente" class="btn btn-default" onclick = "guardarCliente()" disabled>Guardar</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
        }

        function listar()
        {
            global $clientes;
            ?>
            <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header" data-background-color="green" style = "height:83.3px">
                                        <a href="#">
                                            <img class="img" src="recursos/img/home.png" style = "width: 4%;float: right;"  onclick = "abrirOpcion('cliente.html.php')"/>
                                        </a>
                                        <h4 class="title">Listado de Clientes</h4>
                                    </div>
                                    <div class="card-content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th><Strong>Acci&oacute;n</Strong></th>
                                                    <th><Strong>Nombre</Strong></th>
                                                    <th><Strong>Informe cada Hora</Strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($clientes as $llave => $info)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <a href="#" id = "edit_<?php echo $llave?>" onclick = "hab_edicion(<?php echo $llave?>)">Editar</a>
                                                            <a href="#" id = "upd_<?php echo $llave?>" style = "display:none" onclick = "upd_cliente(<?php echo $llave?>)">Actualizar</a>
                                                        </td>
                                                        <td>
                                                            <span id = "vis_<?php echo $llave?>"><?php echo $info['nombre']?></span>
                                                            <input type = "text" name = "nom_<?php echo $llave?>"  id = "nom_<?php echo $llave?>" onChange = "validarDup(<?php echo $llave?>)" value = "<?php echo $info['nombre']?>" style = "display:none">
                                                        </td>
                                                        <td>
                                                            <input type="checkbox"  id = "inf_<?php echo $llave?>" name = "inf_<?php echo $llave?>" <?php echo ($info['reporte'] == 1)?"checked":"";?> onchange = "document.getElementById('edit_<?php echo $llave?>').style.display='none';document.getElementById('upd_<?php echo $llave?>').style.display='block';">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
        }
	}
?>