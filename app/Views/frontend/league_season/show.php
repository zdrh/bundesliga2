<?= $this->extend('layout/frontend/layout'); ?>

<?= $this->section('content'); ?>

<?php
echo form_open('sezona/view');
$options = array();
$options[''] = "Vyber sezónu";
$selected[] = $sezona->id_season;
$disabled[] = '';
$extra['class'] = 'form-control';
foreach ($sezony as $key => $row) {
    $options[$key] = $row;
}

$divBtn = array(
    'class' => 'mb-3 mt-3 ms-3'
);
echo "<div class ='d-flex'>";
echo form_dropdown_bs('season', $options, $extra, 'mb-3 mt-3 col-md-4', '', $disabled, $selected);
echo div($divBtn);
echo form_button($form['submitButton']);
echo "</div>";
echo form_close();

echo "</div>";

?>


<h1> <?= $sezona->league_name_in_season ?> - sezóna <?= $sezona->start ?>-<?= $sezona->finish ?></h1>

<?php



$table = new \CodeIgniter\View\Table();
$table->setHeading('Název týmu', 'Logo', 'Vznik');

foreach($tymy as $row) {

    $data = array(
        'src' => base_url($uploadPath['logoTeam'].$row->logo),
        'class' => 'img-fluid table'
    );
    $table->addRow($row->team_name_in_season, img($data), $row->founded);
}

$table->setTemplate($tableTemplate);
echo $table->generate();
?>



<?= $this->endSection(); ?>