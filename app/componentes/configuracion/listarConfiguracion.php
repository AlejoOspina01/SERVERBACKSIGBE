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

$email = new \SendGrid\Mail\Mail();
$email->setFrom("alejandro.ospina@correounivalle.edu.co", "Example User");
$email->setSubject("Sending with Twilio SendGrid is Fun");
$email->addTo("alejandro.ospina@correounivalle.edu.co", "Example User");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$sendgrid = new \SendGrid(getenv('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'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
echo json_encode($variables);
