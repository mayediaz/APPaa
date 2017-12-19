<?php
	class Inicio
    {
        public function display()
        {
            global $menu,$code,$onload;
		?>
			<body <?php echo ($onload)?'onload="miPerfil(\''.$code.'\')"':"";?>>
                <div class="wrapper">

                    <div class="sidebar" data-color="green" data-image="recursos/img/sidebar-1.jpg">
                        <div class="logo" style = "width:260px;height:70px">
                                <img src = "recursos/img/Infomedia-logo.png" style = "width:60%;margin-left: 40px;margin-top: -9px;">
                        </div>

                        <div class="sidebar-wrapper">
                            <ul class="nav" id = "navegacion">
                                <?php
                                foreach($menu as $key => $info)
                                {
                                    foreach($info as $key2 => $val)
                                    {
                                        $dato = explode("/",$val);
                                        ?>
                                            <li id = "<?php echo $key?>">
                                                <a href="#" onclick = "abrirPagina('<?php echo $dato[0]?>','<?php echo $key?>','<?php echo $key2?>')">
                                                    <i class="material-icons"><?php echo $dato[1]?></i>
                                                    <p><?php echo $key2?></p>
                                                </a>
                                            </li>
                                        <?php
                                    }
                                }
                                ?>
                                <li id = "Logout">
                                    <a href="logout.php">
                                        <i class="material-icons">directions_walk</i>
                                        <p>Logout</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="main-panel">
                        <nav class="navbar navbar-transparent navbar-absolute">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="#" id = "title"></a>
                                </div>
                            </div>
                        </nav>
                        <div id = "contenido" class="content" style = "height: auto;">
                        </div>
                        <footer class="footer" style = "padding: 0px 0;">
                            <div class="container-fluid">
                                <p class="copyright pull-right">
                                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.infomediaservice.com">Sistema de Alarmas</a>
                                </p>
                            </div>
                        </footer>
                    </div>
                </div>
            </body>
            <script src="librerias/js/xhr.js" type="text/javascript"></script>
            <script src="librerias/js/ajax.js" type="text/javascript"></script>
            <script src="librerias/js/jquery-3.1.0.min.js" type="text/javascript"></script>
            <script src="librerias/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="librerias/js/material.min.js" type="text/javascript"></script>
            <script src="librerias/js/funciones_consola1.js" type="text/javascript"></script>
            <script src="librerias/js/material-dashboard.js"></script>
            <script>
            function abrirPagina(pagina,id,titulo)
            {
                document.getElementById('title').innerHTML = titulo;
                obtenerXHR(pagina,'contenido','contenido');
                lista = document.getElementById('navegacion').children;
                for(var j=0;j<lista.length;j++)
                {
                    if(lista[j].id != id)
                        lista[j].className = '';
                    else
                        lista[j].className = 'active';
                }
            }
            function miPerfil(code)
            {
                $.ajax({
                    url:'https://api.ciscospark.com/v1/access_token',
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: ({grant_type:"authorization_code",client_id:'client_id',code:code,redirect_uri:'redirect_uri'}),
                    error:function(objeto, quepaso, otroobj){alert('Error');},
                    success: function(info){
                        abrirPagina('miperfil.html.php?access_token='+info.access_token+'&refresh_token='+info.refresh_token,8,"Mi Perfil")
                    }
                });
            }
            </script>
        </html>
		<?php
		}
        public function requeridos()
        {
            ?>
            <!doctype html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
                    <meta name="viewport" content="width=device-width" />

                    <title>Infomedia Posventa</title>

                    <!-- Bootstrap core CSS     -->
                    <link href="recursos/css/bootstrap.min.css" rel="stylesheet" />

                    <!--  Material Dashboard CSS    -->
                    <link href="recursos/css/material-dashboard.css" rel="stylesheet"/>

                    <link href="recursos/css/bootstrap-multiselect.css" rel="stylesheet"/>

                    <!--     Fonts and icons     -->
                    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
                    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
                    <style>
                        #contenedor div{ float:right; }
                        a{
                            color: #AAAAAA;
                        }
                        a:hover
                        {
                            color:#000000;
                        }
                    </style>
                </head>

            <?php
        }
	}
?>
