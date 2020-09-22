<?php 
  header('Access-Control-Allow-Origin: *'); 
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  require_once "../../../bootstrap.php";
  
  $json = file_get_contents('php://input');
 
  $params = json_decode($json);
  
  $stdTicket = get_object_vars($params);  
  
  $ticketUpdate = $entityManager->createQueryBuilder();
$query = $ticketUpdate->update('Tickets', 't') 
        ->set('t.estadoticket', '?2')
        ->where('t.consecutivoticket = ?1')
        ->setParameter(1,$stdTicket['codigoTicket'] )
        ->setParameter(2,'Usado' )
        ->getQuery();
        $execute = $query->execute();

var_dump($query);
