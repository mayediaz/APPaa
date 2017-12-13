<?php
	class miPerfil
    {
		public function display()
        {
            global $access_token,$rooms;
		?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" data-background-color="green" style = "height:83.3px">
                                <h4 class="title">Editar Perfil</h4>
                                <p class="category">Complete su perfil</p>
                            </div>
                            <div class="card-content">
                                <form action = "validar_usuario.php" method = "post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombres</label>
                                                <input type="text" id = "nombre" name = "nombre" class="form-control" value = "<?php echo $_SESSION['usernom']?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" id = "pass" name = "pass" class="form-control" value = "<?php echo $_SESSION['pass']?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Correo</label>
                                                <input type="email" id = "correo" name = "correo" class="form-control" value = "<?php echo $_SESSION['correo']?>">
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if(count($rooms) > 0)
                                    {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Room</label>
                                                    <select id = "room" name = "room" class="form-control">
                                                        <option value = "">Seleccione una opci&oacute;n....</option>
                                                        <?php
                                                        foreach($rooms as $key => $value)
                                                        {
                                                            $llave = $key."-".$value;
                                                            $lg = $_SESSION['room']."-".$_SESSION['nroom'];
                                                            ?>
                                                            <option value = "<?php echo $llave?>" <?php echo ($lg == $llave)?"selected":"";?>><?php echo $value?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <button type="submit" class="btn btn-primary pull-right">Actualizar Perfil</button>
                                    <div class="clearfix"></div>
                                </form>
                                <?php
                                if($access_token == '')
                                {
                                    ?>
                                    <button class="btn btn-primary pull-right" onClick = "integrarSpark()">Integrar Spark</button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            </script>
		<?php
		}
	}
?>