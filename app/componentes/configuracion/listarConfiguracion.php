<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


require_once('../../../vendor/autoload.php');

$textoArchivo = file("config.txt");
$variables= array();
// Mostrar el contenido del archivo:
for ($i=0; $i < sizeof($textoArchivo); $i++) { 
    array_push($variables, explode("|",$textoArchivo[$i]));
}

for ($i=0; $i < sizeof($variables); $i++) { 
    $variables[$i][1] = trim($variables[$i][1]);
}


$request_body = json_decode('{
  "personalizations": [
    {
      "to": [
        {
          "email": "alejandro@correounivalle.edu.co"
        }
      ],
      "subject": "Hello, World!"
    }
  ],
  "from": {
    "email": "alejandro@correounivalle.edu.co"
  },
  "content": [
    {
      "type": "text/plain",
      "value": "Hello, World!"
    }
  ]
}');
$response = $sg->client->mail()->send()->post($request_body);
echo $response->statusCode();
echo $response->body();
echo $response->headers();


echo json_encode($variables);
