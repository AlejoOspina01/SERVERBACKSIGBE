<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// show_roles.php <id>
require_once "../../../bootstrap.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);


$idUser = $_GET["idUser"];
$tipoticketal = $_GET["tipoticket"];
$fechahoy = new \DateTime('now');
$fechafinal= $fechahoy->format('Y-m-d');
$fechainicialhoy = '2021-03-05 00:00:00';
$fechafinalhoy = '2021-03-05 23:59:59';

// $ticketencontrado = $entityManager->createQuery('SELECT u FROM Tickets u WHERE u.fechacompra BETWEEN ?2 AND ?3 AND u.tipoTicket = ?4 AND u.usuario = ?1')
$ticketencontrado = $entityManager->createQuery('SELECT u FROM Tickets u WHERE u.fechacompra BETWEEN ?2 AND ?3')
->setParameter(2,$fechainicialhoy)
->setParameter(3,$fechafinalhoy)
->getSingleResult();

if ($ticketencontrado === null) {
	echo "No asignacion founbsdsdbdS.\n";
	exit(1);
}

 $ticketfound =  array(
	'concecutivo'     => $ticketencontrado->getConsecutivoTicket(),
	'fecha'         => $ticketencontrado->getFechaCompra(),
	'tipoTicket'    => $ticketencontrado->getTipoTicket()
);

echo json_encode($ticketfound);
