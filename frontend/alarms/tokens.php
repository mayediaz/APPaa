<?php
include('usuarios.model.php');
$M_usuarios = new usuarios_model();
$actionID = (isset($_REQUEST['actionID']))?$_REQUEST['actionID']:"";
if($actionID == 'act_token')
{
    $id = $_REQUEST['id'];
    $token = $_REQUEST['token'];
    $M_usuarios->act_token();
}
else
{
    ?>
    <script>
    function act_token(id, token)
    {
        var http = new XMLHttpRequest();
        var url = "?actionID=act_token&id="+id+"&token="+token;
        http.open("POST", url, false);
        http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
               //aqui obtienes la respuesta de tu peticion
            }
        }
        http.send();
    }
    </script>
    <?php
    foreach($M_usuarios->usuarios as $key => $info)
    {
        if($info['refresh'])
        {
            ?>
            <script>
            var http = new XMLHttpRequest();
            var url = "https://api.ciscospark.com/v1/access_token";
            http.open("POST", url, false);
            var grant_type = "refresh_token";
            var client_id = "C14b8fdc411b38ea02bd0c19bd760f5517456953f2f8275bbb8afcec97e48cbda";
            var client_secret = "9b4e59ad50f74a6bb88d83c42ff61e8e8d340212b6bf9ad184152b552ad14e72";
            var refresh_token = "<?php echo $info['refresh']?>";
            http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

            http.onreadystatechange = function() {
                if(http.readyState == 4 && http.status == 200) {
                   //aqui obtienes la respuesta de tu peticion
                   data = JSON.parse(http.responseText);
                   act_token(<?php echo $key?>,data.access_token);
                }
            }
            http.send(JSON.stringify({grant_type:grant_type, client_id: client_id,client_secret:client_secret,refresh_token:refresh_token}));
            </script>
            <?php
        }
    }
}
?>