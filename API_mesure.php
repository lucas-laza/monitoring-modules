<?php
require_once("bootstrap.php");


$repSession=$entityManager->getRepository('Session');
$session = $repSession->find(2);

$rep=$entityManager->getRepository('Mesure');
$affiche = $rep->findBy(array('session'=> $session));

foreach ($affiche as $obj){
    echo json_encode($obj->arrayfy()); 
}

// var_dump($affiche);

// foreach ($affiche as $obj){
//     var_dump($obj);
//    echo json_encode($obj);
// }
