<?= $this->extend('layout/frontend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přehled sezón <?= $team->general_name ?></h1>
<?php


$table = new \CodeIgniter\View\Table();

$table->setHeading('Sezóna', 'Soutěž', 'Úroveň', 'Logo');
foreach($history as $row) {
    $sezona = $row->start."-".$row->finish;
    $imgData = array(
        'src' => $uploadPath['logoTeam'].$row->teamLogo,
        'class' => 'table'
    );
    $img = img($imgData);
    $nazevLigy = $row->league_name_in_season;
    if(!is_null($row->groupname)) {
        $nazevLigy .=" (".$row->groupname.")";
    }
    $imgLeagueLogoData = array(
        'src' => $uploadPath['logoLeague'].$row->leagueLogo,
        'class' => 'table'
    );
    $imgLeagueLogo = img($imgLeagueLogoData);
    $table->addRow($sezona, $imgLeagueLogo." ".$nazevLigy, $row->level, $img);

}

$table->setTemplate($tableTemplate);
echo $table->generate();
?>

<?= $this->endSection(); ?>