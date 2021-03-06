<?php
 header('Access-Control-Allow-Origin: *'); 
 header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// show_roles.php <id>
require_once "../../../bootstrap.php";
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$stdSaldo = get_object_vars($request);
$propiedadesSaldo = get_object_vars($stdSaldo['data']);

/*$newSaldo = $_GET["saldo"];
$newId = $_GET["id"];*/

$usuarioUpdate = $entityManager->createQueryBuilder();
$query = $usuarioUpdate->update('Usuarios', 'u') 
        ->set('u.saldo', '?1')
        ->set('u.correo', '?3')
        ->set('u.codigoestudiante', '?4')
        ->set('u.nombre', '?5')
        ->set('u.apellido', '?6')
        ->where('u.identificacion = ?2')
        ->setParameter(1, $propiedadesSaldo['saldo'])
        ->setParameter(2, $propiedadesSaldo['identificacion'])
        ->setParameter(3, $propiedadesSaldo['correo'])
        ->setParameter(4, $propiedadesSaldo['codigoestudiante'])
        ->setParameter(5, $propiedadesSaldo['nombre'])
        ->setParameter(6, $propiedadesSaldo['apellido'])
        ->getQuery();
$execute = $query->execute();

if ($usuarioUpdate === null) {
    echo "No usuario found.\n";
    echo "Fallo";    
    exit(1);
}