<?php
require_once("bootstrap.php");

$v = json_decode(file_get_contents("php://input"),true);

var_dump($v["session_id"]);

date_default_timezone_set('Europe/Paris');
$date = date("Y-m-d H:i:s");
$date = new \DateTime($date);
var_dump($date);
// $date = DateTime::format($date);

$repSession=$entityManager->getRepository('Session');
$session = $repSession->find($v["session_id"]);

// var_dump($session->getId());


$mesure = new Mesure();
$mesure->setValeur($v["valeur"]);
$mesure->setDate($date);
$mesure->setSession($session);


$entityManager->persist($mesure);
$entityManager->flush();