<?= $this->extend('layout/frontend/layout-league'); ?>

<?= $this->section('content'); ?>



<h1> <?= $sezona->league_name_in_season ?> - sezóna <?= $sezona->start ?>-<?= $sezona->finish ?></h1>


<div class="card-group">
    <div class="row">

<?php
//var_dump($sezona);
foreach($tymy as $row) {
   // var_dump($row);
   echo div(['class' => 'col-sm-12 col-lg-6 col-xl-4']);

    $data = array(
        'src' => base_url($uploadPath['logoTeam'].$row->logo),
        'class' => 'img-fluid card-logo'  
    );
    $headerContent = "<h4>".img($data)." ".$row->team_name_in_season."</h4>";
    $linkMatches = "tym/".$row->id_team."/sezona/".$sezona->start."-".$sezona->finish."/".$sezona->id_league_season."/zapasy";
    $linkRoster = "tym/".$row->id_team."/sezona/".$sezona->start."-".$sezona->finish."/".$sezona->id_league_season."/soupiska";
    $linkStadium = "tym/".$row->id_team."/sezona/".$sezona->start."-".$sezona->finish."/".$sezona->id_league_season."/stadion";
    $linkHistory = "tym/".$row->id_team."/historie";
    $bodyContent = "<div class=\"row\"><div class=\"col-6\"><p>".anchor($linkMatches, "Zápasy")."</p>\n";
    $bodyContent .= "<p>".anchor($linkRoster, "Soupiska")."</p>\n</div>";
    $bodyContent .= "<div class=\"col-6\"><p>".anchor($linkStadium, "Stadion")."</p>\n";
    $bodyContent .= "<p>".anchor($linkHistory, "Historie klubu")."</p>\n</div>\n</div>\n";


    $class = "mb-3";
    echo card($headerContent, $bodyContent, $class);
    echo "</div>\n";
    
}
        ?>
    </div>
</div>


<?= $this->endSection(); ?>