<?php
include('usuarios.model.php');
$M_usuarios = new usuarios_model();
foreach($M_usuarios->usuarios as $key => $info)
{
    if($info['refresh'])
    {
        $url = "https://api.ciscospark.com/v1/access_token";
        $data = array("grant_type"=>"refresh_token","client_id"=>"Client_id","client_secret"=>"client_secret","refresh_token"=>$info['refresh']);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context));
        $info = get_object_vars($result);
        $id = $key;
        $token = $info['access_token'];
        $M_usuarios->act_token();
    }
}
if((isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"] == '127.0.0.1'))
{
    echo "Script Ejecutado";
}
?>
