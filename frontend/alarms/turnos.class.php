<?php
	class Turnos
    {
		public function display()
        {
            global $turnos;
            $this->encabezados();
            ?>
            <body style = "background-color: #EEEEEE;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="green" style = "height:83.3px">
                                    <h4 class="title">Configuraci&oacute;n Disponibilidad</h4>
                                    <p class="category">Complete los &iacute;tems solicitados</p>
                                </div>
                                <div class="card-content">
                                    <?php
                                    $campos = "";
                                    $sep = "";
                                    foreach($turnos as $key => $val)
                                    {
                                        foreach($val as $nom => $info)
                                        {
                                            $campos .= $sep.$key;
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label"><?php echo $info['desc']?></label>
                                                        <input type="text" id = "campo_<?php echo $key?>" name = "campo_<?php echo $key?>" class="form-control" value = "<?php echo $info['val'] ?>" onkeypress="return validaNum(event,true);" onchange="ValidaRangos(this.id);">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $sep = ",";
                                        }
                                    }
                                    ?>
                                    <button class="btn btn-default" onclick = "udpTurnos('<?php echo $campos?>')">Guardar</button>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            <?php
            $this->cierre();
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

                    <title>Infomedia Posventa - Turnos</title>
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
	}
?>