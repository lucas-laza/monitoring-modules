<?php
require_once("bootstrap.php");
require("head.html");

if (isset($_GET["id"])) {
  $id = $_GET["id"];

  $rep = $entityManager->getRepository('Session');
  $session = $rep->find($id);

  if ($session == null){
    ?>
    
    <script>
        history.go(-1);
    </script>

    <?php
  }

?>
  <div class="top"><a href="histo_module.php?id=<?= $session->getModule()->getId(); ?>" class="link-warning">
      << Historique de module</a>
        <?php

        $mesures = $entityManager->getRepository('Mesure')->findBy(['session' => $session], ['date' => 'ASC']);

        // ## suppression de la premiere mesure dont la valeur est systématiquement nulle ##
        $firstMesure = $mesures[0];
        $i=0;
        foreach ($mesures as $m){
          $i++;
          // on supprime la valeur, seulement s'il y a au minimum 2 valeurs pour éviter les bugs
          if ($i>=2){
            if (($firstMesure->getValeur() == null)) {
              $entityManager->remove($firstMesure);
              $entityManager->flush();
              header("Refresh:0");
            }    
            break;
          }
        }
        
        $startS = date_format($session->getStartDate(), 'Y-m-d H:i:s');
        $endS = '---';
        if ($session->getEndDate() != null) {
          $endS = date_format($session->getEndDate(), 'Y-m-d H:i:s');
        }

        ?> <h3>Historique des mesures de la session <?= $session->getId() ?> du <?= $startS ?> au <?= $endS ?></h3>
  </div>
  <!-- Button trigger modal -->
<button type="button supprS" class="btn btn-danger my-2 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Supprimer session
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Voulez-vous supprimer la session <?= $id ?> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <a href="del_handler.php?entite=Session&id=<?=$id?>"><button type="button" class="btn btn-danger">  Supprimer</button></a>
      </div>
    </div>
  </div>
</div>

  <div class="ct-chart ct-perfect-fourth legraph"></div>
  <table class="table table-striped table-hover">
    <thead>
      <td>N° id</td>
      <td>Date</td>
      <td>Valeur</td>
      <td>Unité</td>
    </thead>
    <?php
    foreach ($mesures as $m) {
      $date = date_format($m->getdate(), 'Y-m-d H:i:s');

    ?>

      <tr class="mesure">
        <td><?= $m->getId(); ?></td>
        <td><?= $date ?></td>
        <td class="val h5"><?= $m->getValeur() ?></td>
        <td><?= $session->getModule()->getUnite(); ?></td>

      </tr>

    <?php }
    ?>
  </table> <?php




            ?>
  <script src="bower_components/chartist/dist/chartist.min.js"></script>
  <script src="bower_components/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.min.js"></script>
  <script src="node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
  <script>
    let data = {
      // Axe X du graphique
      labels: [<?php foreach ($mesures as $m) {
                  echo "'";
                  echo date_format($m->getdate(), 'H:i');
                  echo "'";
                  echo ',';
                } ?>],
      // Données
      series: [
        [<?php foreach ($mesures as $m) {
            echo "'";
            if ($m->getValeur() == null) {
              ?> null <?php
            } else {
              echo $m->getValeur();
            }
            echo "'";
            echo ',';
          } ?>]
      ]
    };

    let options = {
      scaleMinSpace: 100

    };

    let plugins = {
      plugins: [
        Chartist.plugins.ctPointLabels({
          textAnchor: 'middle',
          labelInterpolationFnc: Chartist.noop
        })
      ]
    }



    new Chartist.Line('.ct-chart', data, plugins, options);
  </script>
<?php







} else {
?>
  <form action="" method="GET"><label for="id">Entrer un id de module</label><input type="number" name="id" id="id"></form>
<?php
}
