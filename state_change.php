
<?php

require_once("bootstrap.php");

$id = $_GET["id"];
$change = $_GET["change"];

$rep=$entityManager->getRepository('Module');
$module = $rep->find($id);

if ($change == 0){
    // Le module passe de arrêt à marche
    $module->setEtat(2);



    // ### création d'une nouvelle session pour éviter les messages d'erreur ###
        //date et heure actuelle
    date_default_timezone_set('Europe/Paris');
    $date = date("Y-m-d H:i:s");
    $date = new \DateTime($date);

    $session = new Session();
    $session->setStartDate($date);
        //session en état de fonctionnement
    $session->setEtat(2);
    $session->setModule($module);
    $entityManager->persist($session);


        // mesure nulle associée à la session
    $mesure = new Mesure();
    $mesure->setDate($date);
    $mesure->setSession($session);
    $entityManager->persist($mesure);

    header('location: index.php');


} else if ($change == 1){

    // On récupere en get la "direction" du changement. 
    $dir = $_GET["dir"];

    // ######### Si le module était en état 1 (erreur)
    if ($dir == "from"){
        $rand = rand(1,100);
        // echo $rand;

        // 70% de chance que l'erreur se résolve et que le module s'éteigne
        if ($rand < 70){
            ?>
    
        <form action="" method="GET" class="formError">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="change" value="2">
        </form>
    
        <script>document.querySelector(".formError").submit();</script>
    
    <?php
        } else {
            header('location: index.php');
        }

    // ######## Si le module va être en état 1 (erreur)
    } else if ($dir == "to"){
        $module->setEtat(1);

    // ### Arrêt de la session associée ###
        //date et heure actuelle
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s");
        $date = new \DateTime($date);
    
        $session=$entityManager->getRepository('Session')->findBy(array('module' => $module),array('startDate'=>'DESC'),1,0);
        $session = $session[0];
        $session->setEndDate($date);
            //session en état d'arret
        $session->setEtat(0);
        header('location: index.php');
    }

    

    

    

} else if ($change == 2){
    $module->setEtat(0);

    // --- suppréssion de la variable de valeur associée à la session dans le localstorage. ---
    $lastS=$entityManager->getRepository('Session')->findBy(['module' => $module],['startDate' => 'DESC'],1,0);
    $lastS = $lastS[0]; 
    ?> <script>localStorage.removeItem(`session<?=$lastS->getId()?>Value`); console.log(`session<?=$lastS->getId()?>Value`); </script>
    <!-- --------- -->
    <?php


    // ### Arrêt de la session associée ###
        //date et heure actuelle
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s");
        $date = new \DateTime($date);
    
        $session=$entityManager->getRepository('Session')->findBy(array('module' => $module),array('startDate'=>'DESC'),1,0);
        $session = $session[0];
        $session->setEndDate($date);
            //session en état d'arret
        $session->setEtat(0);

        $rand = rand(1,100);

    if ($rand < 20){
        ?>

    <form action="" method="GET" class="formError">
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="change" value="1">
        <input type="hidden" name="dir" value="to">
    </form>

    <script>document.querySelector(".formError").submit();</script>

    <?php
    } else {
        // retour en  JS pour laisser le temps au script js de se charger
        ?> 
        <script>window.location.href = './';</script>
        <?php
    }
}
// actualisation des données
$entityManager->flush();



?>