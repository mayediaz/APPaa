<?php
	class Servicios
    {
        public function display()
        {
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" data-background-color="green" style = "height:83.3px">
                                <h4 class="title">Servicios</h4>
                                <p class="category">Seleccione la opci&oacute;n deseada</p>
                            </div>
                            <div class="card-content">
                                <div class="list-group">
                                    <a href="#" onclick = "abrirOpcion('servicios.php?actionID=nuevo')" class="list-group-item">Adicionar nuevo Servicio</a>
                                    <a href="#" onclick = "abrirOpcion('servicios.php?actionID=edicion')" class="list-group-item">Modificar Servicio</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        function nuevoServicio()
        {
            global $servicios;

            $title = (count($servicios) > 0)?utf8_encode("Edición de Servicios"):"Nuevo Servicio";

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
                                            <img class="img" src="recursos/img/home.png" style = "width: 4%;float: right;"  onclick = "abrirOpcion('servicios.php')"/>
                                        </a>
                                        <h4 class="title"><?php echo $title?></h4>
                                        <p class="category">Complete los &iacute;tems solicitados</p>
                                    </div>
                                    <div class="card-content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Nombre del Servicio</label>
                                                        <?php
                                                        if(count($servicios) == 0)
                                                        {
                                                        ?>
                                                            <input type="text" id = "n_servicio" name = "n_servicio" class="form-control" onchange = "validarServicio()">
                                                            <a href="#" id = "crearServicio" name = "crearServicio" class="navbar-brand" onclick = "guardarServicio()" style = "display:none;margin-top: -34px;height: auto;">Crear Servicio</a>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <select id = "n_servicio" name = "n_servicio" class="form-control" onchange = "traeParametros()">
                                                                <option value = "">Seleccione un servicio....</option>
                                                                <?php
                                                                foreach($servicios as $key => $value)
                                                                {
                                                                    foreach($value as $nom => $info)
                                                                    {
                                                                        if(!$info['fijo'])
                                                                        {
                                                                            ?>
                                                                            <option value = "<?php echo $key?>"><?php echo $nom?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                        <input type="hidden" id = "id_servicio" name = "id_servicio">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id = "defines" class="row" style = "display:none">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Tipo</th>
                                                                <th>Par&aacute;metro</th>
                                                                <th>Descripci&oacute;n</th>
                                                                <th>Guardar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id = "params">
                                                            <?php
                                                            if(count($servicios) == 0)
                                                            {
                                                                ?>
                                                                <tr id = "1">
                                                                    <td>
                                                                        <select id = "tipo_1" name = "tipo_1">
                                                                        <option value = "">Seleccione una opci&oacute;n</option>
                                                                        <option value = "text">Text</option>
                                                                        <option value = "password">Password</option>
                                                                    </td>
                                                                    <td><input type = "text" name = "nombre_1" id = "nombre_1"></td>
                                                                    <td><input type = "text" name = "desc_1" id = "desc_1"></td>
                                                                    <td id = "guardado_1"><input type="checkbox" id="guardar_1" value="1" onchange = "guardarParametro(1)"></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                      </table>
                                                </div>
                                            </div>
                                            <?php
                                            $item = (count($servicios) == 0)?1:0;
                                            ?>
                                            <div  id = "nuevo" class="row" style = "display:none">
                                                <div class="col-md-12">
                                                    <a href="#" onclick = "nuevoItem()">Nuevo &Iacute;tem</a>
                                                    <input type = "hidden" name = "item" id = "item" value = "<?php echo $item?>">
                                                </div>
                                            </div>
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