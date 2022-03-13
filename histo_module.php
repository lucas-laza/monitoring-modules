<?php
require_once("bootstrap.php");
require("head.html");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $rep = $entityManager->getRepository('Module');
    $module = $rep->find($id);


    $sessions = $entityManager->getRepository('Session')->findBy(['module' => $module], ['startDate' => 'DESC']);

?>
    <div class="top">
        <div><a href="./" class="link-warning">
                << Accueil: monitoring</a>
        </div>
        <h2>Historique des sessions du module <?= $module->getId() ?>: <?= $module->getNom() ?></h2>
    </div>
    <div class="grille">

        <?php
        foreach ($sessions as $s) {
            $start = date_format($s->getStartDate(), 'Y-m-d H:i:s');
            $end = ' / /';
            if ($s->getEndDate() != null) {
                $end = date_format($s->getEndDate(), 'Y-m-d H:i:s');
            }

        ?>


            <div class="session setat<?= $s->getEtat() ?>" onclick="location.href='histo_session.php?id=<?= $s->getId() ?>'">
                
                <h2>Session n°<?= $s->getId(); ?></h2>
                <h4>Début:<?= $start ?></h3>
                <h4>Fin:<?= $end ?></h3>
                <?php if ($s->getEtat() == 2){
                     $duree = $s->dureeFonc() ;
                ?>
                <h4>Durée: <?=$duree->h?>h:<?=$duree->i?>m:<?=$duree->s?>s</h4>
                <?php
            } ?>
                <h5>Nb° mesures: <?= $s->countMesures($entityManager) ?></h5>

            </div>

        <?php }
        ?>
    </div>


    


<?php















} else {
?>
    <form action="" method="GET"><label for="id">Entrer un id de module</label><input type="number" name="id" id="id"></form>
<?php
}
