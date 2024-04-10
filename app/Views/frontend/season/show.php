<?= $this->extend('layout/frontend/layout'); ?>

<?= $this->section('content'); ?>

<?php
 echo form_open('sezona/view');
 $options = array();
 $options[''] = "Vyber sezónu";
 $selected[] = $sezona->id_season;
 $disabled[] = '';
 $extra['class'] = 'form-control';
 foreach($sezony as $key => $row) {
     $options[$key] = $row;
 }

 $divBtn = array(
    'class' => 'mb-3 mt-3 ms-3'
 );
echo "<div class ='d-flex'>";
 echo form_dropdown_bs('season', $options,$extra, 'mb-3 mt-3 col-md-4', '',$disabled, $selected);
 echo div($divBtn);
 echo form_button($form['submitButton']);
 echo "</div>";
 echo form_close();
 
 echo "</div>";

?>


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