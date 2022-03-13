<?php

require_once("bootstrap.php");

$entite = $_GET["entite"];
$id = $_GET["id"];

$e = $entityManager->getRepository("$entite")->find("$id");

if ($entite == 'Session'){
    $mesures = $entityManager->getRepository("Mesure")->findBy(['session' => $e]);
    // echo $e;
    foreach ($mesures as $m){
        $entityManager->remove($m);
    }
}




$entityManager->remove($e);

$entityManager->flush();

if ($entite == 'Session'){
    header("location: histo_session.php?id=$id");
}

?>



