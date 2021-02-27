<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// show_roles.php <id>
require_once "../../../bootstrap.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

$codigoticket = $_GET['codigoesc'];

$ticketencontrado = $entityManager->createQuery('SELECT tk FROM Tickets tk WHERE tk.consecutivoticket = ?1')
	->setParameter(1, $codigoticket)
	->getSingleResult();

$periodoencontrado = $entityManager->createQuery('SELECT pa FROM Periodosacademicos pa WHERE pa.fecha_fin = (SELECT MAX(p.fecha_fin) from Periodosacademicos p)')
->getSingleResult();

$convocatoriasEncontradas=null;

if($ticketencontrado->getTipoTicket() == 'Ticket Refrigerio'){
	$convocatoriasEncontradas = $entityManager->createQuery('SELECT c FROM Convocatorias c WHERE c.periodosacademicos = ?1 AND c.becas = 1')//
	->setParameter(1, $periodoencontrado->getConsecutivo_periodo())
	->getSingleResult();
}else{
	$convocatoriasEncontradas = $entityManager->createQuery('SELECT c FROM Convocatorias c WHERE c.periodosacademicos = ?1 AND c.becas = 2')
	->setParameter(1, $periodoencontrado->getConsecutivo_periodo())
	->getSingleResult();
}

$postulacionesEncontradas = $entityManager->createQuery('SELECT p FROM Postulacion p WHERE p.convocatoria = ?1 AND p.usuario = ?2 AND p.estado_postulacion = ?3')
->setParameter(1, $convocatoriasEncontradas->getConsecutivoConvocatoria())
->setParameter(2, $ticketencontrado->getUsuario()->getIdentifacion())
->setParameter(3, 'Aprobado')
->getSingleResult();

$postulacionfound =  array(
	'consecutivo_postulacion'     => $postulacionesEncontradas->getConsecutivo_postulacion(),
	'fecha'         => $postulacionesEncontradas->getFechapostulacion(),
	'estrato'    => $postulacionesEncontradas->getEstrato(),
	'nombreest' =>  $ticketencontrado->getUsuario()->getNombre(),
	'codigoest' => $ticketencontrado->getUsuario()->getCodigoEst(),
	
);
echo json_encode($postulacionfound);
