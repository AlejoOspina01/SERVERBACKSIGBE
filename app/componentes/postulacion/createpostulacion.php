<?php
 header('Access-Control-Allow-Origin: *'); 
 header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// rol.php <name>
require_once "../../../bootstrap.php";

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);


$stdPropPostu = get_object_vars($request);
$propiedadesPostu = get_object_vars($stdPropPostu['data']);


$encontrarUser = $entityManager->find('Usuarios', $propiedadesPostu['usuario']);
$encontrarConvo = $entityManager->find('Convocatorias', $propiedadesPostu['convocatoria']);


$postulacion = new Postulacion();
$postulacion->setPromedio($propiedadesPostu['promedio']);
$postulacion->setFechapostulacion( new \DateTime('now'));
$postulacion->setSemestre($propiedadesPostu['semestre']);
$postulacion->setEstrato($propiedadesPostu['estrato']);
$postulacion->setEstado_postulacion('En espera');
$postulacion->setComentPsicologa('');
// Booleanos
$postulacion->setD10(false);
$postulacion->setFactservicio(false);
$postulacion->setCartapeticion(false);
$postulacion->setCarnetestudiante(false);
$postulacion->setCedulaPadre(false);
$postulacion->setCedulamadre(false);
$postulacion->setPromedioacumulado(false);
$postulacion->setTabulado(false);

$postulacion->setUsuario($encontrarUser);
$postulacion->setConvocatoria($encontrarConvo);
$postulacion->setCantmodificaciones(0);


$entityManager->persist($postulacion);
$entityManager->flush();