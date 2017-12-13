<?php
	class Usuarios
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
                                    <h4 class="title">Usuarios</h4>
                                    <p class="category">Seleccione la opci&oacute;n deseada</p>
                                </div>
                                <div class="card-content">
                                    <div class="list-group">
                                        <a href="#" onclick = "abrirOpcion('usuarios.php?actionID=nuevo')" class="list-group-item">Adicionar nuevo Usuario</a>
                                        <a href="#" onclick = "abrirOpcion('usuarios.php?actionID=edicion')" class="list-group-item">Modificar Usuario</a>
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

                    <title>Infomedia Posventa - Usuarios</title>
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

        function nuevoUsuario()
        {
            global $clientes,$perfiles,$edit,$usuarios;
            ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="green" style = "height:83.3px">
                                    <a href="#">
                                        <img class="img" src="recursos/img/home.png" style = "width: 4%;float: right;"  onclick = "abrirOpcion('usuarios.php')"/>
                                    </a>
                                    <h4 class="title"><?php echo ($edit)?"Edici&oacute;n de Usuario":"Nuevo Usuario";?></h4>
                                    <p class="category">Complete los &iacute;tems solicitados</p>
                                </div>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre</label>
                                                <?php
                                                if($edit)
                                                {
                                                    ?>
                                                    <select id = "n_nombre" name = "n_nombre" class="form-control" onchange = "cargarUsuario()">
                                                        <option value = "">Seleccione una opci&oacute;n....</option>
                                                        <?php
                                                        foreach($usuarios as $key => $value)
                                                        {
                                                            if($key != $_SESSION['userid'] && $value['perfil'] >= $_SESSION['perfil'] )
                                                            {
                                                                ?>
                                                                <option value = "<?php echo $key?>"><?php echo $value['nombre']?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <input type="text" id = "n_nombre" name = "n_nombre" class="form-control">
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Login</label>
                                                <input type="text" id = "n_login" name = "n_login" class="form-control" <?php echo ($edit)?"disabled":"";?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contrase&ntilde;a</label>
                                                <input type="password" id = "n_contrasena" name = "n_contrasena" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Correo Electr&oacute;nico</label>
                                                <input type="text" id = "n_correo" name = "n_correo" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Perfil</label>
                                                <select id = "n_perfil" name = "n_perfil" class="form-control">
                                                    <option value = "">Seleccione una opci&oacute;n....</option>
                                                    <?php
                                                    foreach($perfiles as $key => $value)
                                                    {
                                                        ?>
                                                        <option value = "<?php echo $key?>"><?php echo $value?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Cliente</label>
                                                <select id = "n_cliente" name = "n_cliente" class="form-control">
                                                    <option value = "">Seleccione una opci&oacute;n....</option>
                                                    <?php
                                                    foreach($clientes as $key => $value)
                                                    {
                                                        ?>
                                                        <option value = "<?php echo $key?>"><?php echo $value['nombre']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-default" <?php echo ($edit)?'onclick = "actualizarUsuario()"':'onclick = "validarUsuario()"';?>>Guardar</button>
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