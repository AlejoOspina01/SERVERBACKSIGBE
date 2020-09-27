<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


require_once('../../../../vendor/autoload.php');

$textoArchivo = file("config.txt");
$variables= array();
// Mostrar el contenido del archivo:
for ($i=0; $i < sizeof($textoArchivo); $i++) { 
    array_push($variables, explode("|",$textoArchivo[$i]));
}

for ($i=0; $i < sizeof($variables); $i++) { 
    $variables[$i][1] = trim($variables[$i][1]);
}


$from = new SendGrid\Email(null, "haloalejo@gmail.com");
$subject = "Hello World from the SendGrid PHP Library!";
$to = new SendGrid\Email(null, "haloalejo@gmail.com");
$content = new SendGrid\Content("text/plain", "Hello, Email!");
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv('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');
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
echo $response->headers();
echo $response->body();

echo json_encode($variables);
