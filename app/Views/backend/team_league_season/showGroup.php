<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<?php
if ($liga->groupname != NULL) {
    $skupina = " (" . $liga->groupname . ") ";
} else {
    $skupina = "";
}

?>
<h1>Soutěž <?= $liga->league_name_in_season ?><?= $skupina ?> ročník <?= $liga->start  ?>/<?= $liga->finish ?></h1>
<h2>Přehled týmů</h2>
<?php
 $data = array(
    'class' => $form['editClass']
);
    $table = new \CodeIgniter\View\Table();
    $editBtnAll = anchor('admin/liga/' . $liga->id_league_season_group . '/tym/edit', $form['editBtn']." vše", $data);
    $table->setHeading('Obecný název týmu', 'Název v sezóně', 'Logo', 'Tehdejší název stadionu', $editBtnAll);
    foreach($tymy as $key => $row) {
        if($row->logo != '') {
            $cesta = base_url($uploadPath['logoTeam'].$row->logo);
            $imgProperties = array(
                'src' => $cesta,
                'height' => '50',
            );
            $logo = img($imgProperties);
        } else {
            $logo = "";
        }


       
        
        $editBtn = anchor('admin/liga/' . $liga->id_league_season_group . '/tym/' . $row->id_team_league_season . '/edit', $form['editBtn'], $data);
        $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";
        $table->addRow($row->general_name, $row->team_name_in_season, $logo, $row->stadium_name_in_season. " - ".$row->name_de, $editBtn.$deleteBtn);

        echo "<!-- začátek modalu -->\n";
        echo form_modal("modal" . $key, $row->id_team_league_season, "Smazat tým z ligy", "Chceš opravdu smazat tým " . $row->general_name . " z ligy " . $liga->league_name_in_season . $skupina . " ročník ". $liga->start . "/" . $liga->finish . "?", "admin/liga/" . $liga->id_league_season_group . '/tym/' . $row->id_team_league_season . '/delete');
        echo "<!-- konec modalu -->\n";
    }

    $table->setTemplate($tableTemplate);
    echo $table->generate();

?>


<?= $this->endSection(); ?>