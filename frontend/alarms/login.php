<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <title>Sistema de Alarmas</title>

    <link href="recursos/css/bootstrap.min.css" rel="stylesheet" />
    <link href="recursos/css/rubick_pres.css" rel="stylesheet"/>
    <link href="recursos/css/font-awesome.min.css" rel="stylesheet">
    <link href="recursos/css/fonts/Rubik-Fonts.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-default navbar-transparent navbar-fixed-top navbar-burger" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button id="menu-toggle" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
                </button>
                <a href="http://www.infomediaservice.com" class="navbar-brand">
                    <img src = "recursos/img/Infomedia-logo.png" style = "width:100px">
                </a>
            </div>
            <div class="collapse navbar-collapse" >
                <div id = "divcollapse" class="nav navbar-nav navbar-right navbar-uppercase" style = "margin-top: 50%; margin-left: -16px;">
                    <form id = "login" action = "validar_usuario.php" method = "post">
                        <input type = "hidden" id = "ajaxvar" name = "ajaxvar">
                        <label for="user" class="sr-only">Login</label>
                        <input type="text" id="user" name = "user" class="form-control" placeholder="Login" required autofocus>
                        <label for="pass" class="sr-only">Password</label>
                        <input type="password" id="pass" name = "pass" class="form-control" placeholder="Password" required>
                        <input type = "submit" value = "Ingresar" class="btn btn-default">
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <div class="section section-header">
            <div class="parallax pattern-image">
                <img src="recursos/img/Infomedia.jpg"/>
                <div class="container">
                    <div class="content">
                        <h1>Sistema de Alarmas</h1>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer footer-color-black">
            <div class="container">
                <div class="copyright">
                    &copy; <?php echo date('Y')?> <a href="#"> Infomedia Posventa</a>
                </div>
            </div>
        </footer>
    </div>
</body>
<script src="librerias/js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="librerias/js/bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="librerias/js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="librerias/js/modernizr.js"></script>
<script type="text/javascript" src="librerias/js/rubick_pres.js"></script>
</html>

