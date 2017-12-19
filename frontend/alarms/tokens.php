<?php
include('usuarios.model.php');
$M_usuarios = new usuarios_model();
foreach($M_usuarios->usuarios as $key => $info)
{
    if($info['refresh'])
    {
        $url = "https://api.ciscospark.com/v1/access_token";
        $data = array("grant_type"=>"refresh_token","client_id"=>"C14b8fdc411b38ea02bd0c19bd760f5517456953f2f8275bbb8afcec97e48cbda","client_secret"=>"9b4e59ad50f74a6bb88d83c42ff61e8e8d340212b6bf9ad184152b552ad14e72","refresh_token"=>$info['refresh']);
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