<!-- traitement des informations d'ajout de module -->
<?php
// nécessaire au fonctionnement de Doctrine.
require_once("bootstrap.php");

//récuperation des informations du formulaire
$nom = $_POST["nom"];
$periode = $_POST["periode"];

$nbSerie = null;
if (isset($_POST["nbSerie"])){ 
    $nbSerie = $_POST["nbSerie"];
};

$description = $_POST["description"];

// Etat de la machine en "off" à son ajout
$etat = 0;

$unite = $_POST["unite"];



// création d'un nouvel objet module
$module = new Module();
$module->setNom($nom);
$module->setEtat($etat);
$module->setPeriode($periode);
$module->setNbSerie($nbSerie);
$module->setDescription($description);
$module->setUnite($unite);

// ### création d'une nouvelle session pour éviter les messages d'erreur ###
        //date et heure actuelle
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s");
        $date = new \DateTime($date);
    
        $session = new Session();
        $session->setStartDate($date);
            //session en état de fonctionnement
        $session->setEtat(0);
        $session->setModule($module);
        $entityManager->persist($session);
    
    
            // mesure nulle associée à la session
        $mesure = new Mesure();
        $mesure->setDate($date);
        $mesure->setSession($session);
        $entityManager->persist($mesure);
    


// Ajout du nouveau module à la base de données
$entityManager->persist($module);
$entityManager->flush();

//retour en arriere
header('location: add_module.php?done=true');
