<?= $this->extend('layout/frontend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Soutěže v sezóně <?= $sezona->start ?>-<?= $sezona->finish ?></h1>

<?php

$table = new \CodeIgniter\View\Table();
    $table->setHeading('Název soutěže','Logo', 'Úroveň', 'Pořadatel');
  foreach($souteze as $row) {
    $data = array(
        'src' => $uploadPath['logoLeague'].$row->logo,
        'class' => 'img-fluid table'
    );
    $img = img($data);
    $leagueName = anchor('sezona/'.$sezona->start.'-'.$sezona->finish.'/zobraz/liga/'.$row->id_league_season, $row->league_name_in_season);
    $table->addRow($leagueName, $img, $row->level, $row->name);
  }

  $table->setTemplate($tableTemplate);
  echo $table->generate();
?>



    <?= $this->endSection(); ?>