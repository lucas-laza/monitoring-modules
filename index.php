<!-- Page de visualisation des modules -->
<?php
require_once("bootstrap.php");
require("head.html");


$rep = $entityManager->getRepository('Module');
$affiche = $rep->findAll('Module');

?>
<div class="titre">
    <h1>Monitoring des modules</h1><a href="add_module.php">Ajout de module >></a>
</div>
<h6 class="mx-3">En restant sur cette page, les données sont générées</h6>
<div class="grille">

    <?php

    // affichage de tous les modules 
    foreach ($affiche as $obj) {
        $session=$entityManager->getRepository('Session')->findBy(array('module' => $obj),array('startDate'=>'DESC'),1,0);
        if (isset($session)){
            

            // récupération de la derniere session du module
        $session = $session[0];

            // récupération de la derniere mesure de la derniere session associée au module (si elle existe)
        $lastMesure=$entityManager->getRepository('Mesure')->findBy(['session' => $session],array('date'=>'DESC'),1,0);
        if (isset($lastMesure)){
            $lastMesure=$lastMesure[0];
        }
        
        }
        
        
        
        
        
            
          
    ?>

        <!-- affichage des modules -->
     <div class="module m<?=$obj->getId();?> etat<?= $obj->getEtat(); ?>" onclick="location.href='histo_module.php?id=<?=$obj->getId()?>'">
            <h2><?= $obj->getNom(); ?></h2>
            <h3><?= afficheEtat($obj) ?></h3>
            
            
            <?php if ($session != null){
           ?><h5>Dernière mesure: <span class="valeur"><?=$lastMesure->getValeur();?></span><?=$obj->getUnite();?></h5>
        <?php } ?>
        <h6>Nb de mesures (session): <span class="nbM"><?= $session->countMesures($entityManager); ?></span></h5>
            
            <?= boutonEtat($obj) ?>

        </div>
    <?php
    
    }
    ?>

</div>

<script src="simule_modules.js"></script>
<!-- //  ##########################################
// voir simule_module.js pour les fonctions liées à la simulation du fonctionnement d'un module. -->
<script>
<?php

// Création d'intervals de création de mesures pour chaques modules en fonction de leur période.

$rep=$entityManager->getRepository('Module');
$affiche = $rep->findAll('Module');

foreach ($affiche as $obj){
    // Derniere session associée au module
    $session=$entityManager->getRepository('Session')->findBy(array('module' => $obj),array('startDate'=>'DESC'),1,0);
    $session = $session[0];
    ?>
    if (<?=$obj->getEtat()?> == 2){
        console.log(<?=$obj->getPeriode()*1000?>);
        randomMesure(<?=$session->getId()?>,<?=$obj->getId()?>);
        let interval<?=$obj->getId();?>= setInterval(randomMesure,<?=$obj->getPeriode()*1000?>,<?=$session->getId()?>,<?=$obj->getId()?>);
    }
    
    <?php
}

?>

// ############################################
</script>

<?php
// fonction d'affichage textuel de l'état d'un module   
function afficheEtat(Module $mod)
{
    $etat = $mod->getEtat();
    if ($etat == 0) {
        return "À l'arrêt";
    } else if ($etat == 1) {
        return "Erreur";
    } else if ($etat == 2) {
        return "En marche";
    }
}

// affichage du bouton en fonction de l'état
function boutonEtat(Module $mod)
{
    $etat = $mod->getEtat();
    $id = $mod->getId();
    if ($etat == 0) {
        return "<form action='state_change.php'><input type='submit' value='Démarrer'><input type='hidden' name='id' value='$id'><input type='hidden' name='change' value='0'></form>";
    } else if ($etat == 1) {
        return "<form action='state_change.php'><input type='submit' value='Résoudre'><input type='hidden' name='id' value='$id'><input type='hidden' name='change' value='1'><input type='hidden' name='dir' value='from'></form>";
    } else if ($etat == 2) {
        return "<form action='state_change.php'><input type='submit' value='Arrêter'><input type='hidden' name='id' value='$id'><input type='hidden' name='change' value='2'></form>";;
    }
}
