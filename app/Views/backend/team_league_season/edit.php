<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
/**
 * @var object $skupina
 * @var object $tym
 * @var array $stadion
 * @var array $uploadPath
 * @var array $form
 * @var string $stadiumName
 * @var object $lastSeasonData
 */
if (!is_null($skupina->groupname)) {
    $groupName = " (skupina " . $skupina->groupname . ")";
} else {
    $groupName = "";
}

?>
<h1>Editovat tým <?= $tym->general_name ?> v lize <?= $skupina->league_name_in_season ?><?= $groupName ?> ročník <?= $skupina->start ?>/<?= $skupina->finish  ?></h1>
<?php
if (!is_null($lastSeasonData)) {
    anchor('liga/' . $lastSeasonData->id_league_season . '/info', 'Předchozí sezóna', ['class' => 'btn btn-primary mb-3 me-3']);
}
?>

<div class="row">
    <div class="col-md-4">
        <h2>Minulá sezóna</h2>
        <?php
        if (is_null($lastSeasonData)) {
        ?>
            <h5>Nejsou data za minulou sezónu</h5>
        <?php
        } else {

        ?>

            <h5>Název klubu:</h5>
            <?= $lastSeasonData->team_name_in_season ?>
            <h5>Logo klubu</h5>
            <?php
            $dataLogoLast = array(
                'class' => 'img-fluid edit',
                'src' => $uploadPath['logoTeam'] . $lastSeasonData->logo
            );
            echo img($dataLogoLast);
            ?>
            <h5>Stadion</h5>
            <?= $lastSeasonData->general_name . " - " . $lastSeasonData->name_de ?>
            <h5>Nazev stadion v sezóně:</h5>
            <?= $lastSeasonData->stadium_name_in_season ?>
            <?php
            $data_button_use_last_season = array(
                'name' => 'last_season_button',
                'id' => 'last_season_button',
                'type' => 'button',
                'class' => 'btn btn-primary mt-3',
                'content' => 'Použít data z minulé sezóny'
            );
            ?>
            <p><?= form_button($data_button_use_last_season); ?></p>
        <?php
        }
        ?>
    </div>
    <div class="col-md-4">
        <h2>Tato sezóna</h2>
        <?php

        echo form_open_multipart('admin/liga/tym/update');

        $dataName = array(
            'name' => 'general_name',
            'id' => 'general_name',
            'value' => $tym->general_name,
            'disabled' => 'disabled'
        );
        if ($tym->team_name_in_season == "") {
            $dataSeasonName = array(
                'name' => 'name_in_season',
                'id' => 'name_in_season',
                'required' => 'required',
                'placeholder' => $tym->team_name_in_season
            );
        } else {
            $dataSeasonName = array(
                'name' => 'name_in_season',
                'id' => 'name_in_season',
                'required' => 'required',
                'value' => $tym->team_name_in_season
            );
        }

        $data_button_general_name = array(
            'name' => 'general_name_button',
            'id' => 'general_name_button',
            'type' => 'button',
            'class' => 'btn btn-primary mb-3',
            'content' => 'Pro tuto sezónu použít obecný název týmu'
        );

        $dataLogo = array(
            'name' => 'logo',
            'id' => 'logo',
            'accept' => '*.jpg, *.png, *.gif'
        );

        $optionsStadium = array(
            '' => 'Vyber stadion'
        );

        foreach ($stadion as $row) {
            $optionsStadium[$row->id_stadium] = $row->general_name . " - " . $row->name_de;
        }
        $extra = array(
            'class' => 'form-select',
            'id' => 'stadium'
        );

        $disabled = array(0 => '');
        $selected[] = $tym->id_stadium;


        if ($tym->stadium_name_in_season == "") {
            $dataStadiumName = array(
                'name' => 'stadium_name_in_season',
                'id' => 'stadium_name_in_season',
                'required' => 'required',
                'placeholder' => $tym->stadium_name_in_season
            );
        } else {
            $dataStadiumName = array(
                'name' => 'stadium_name_in_season',
                'id' => 'stadium_name_in_season',
                'required' => 'required',
                'value' => $tym->stadium_name_in_season
            );
        }

        $data_button_general_stadium_name = array(
            'name' => 'general_stadium_name_button',
            'id' => 'general_stadium_name_button',
            'type' => 'button',
            'class' => 'btn btn-primary mb-3',
            'content' => 'Pro tuto sezónu použít obecný název stadionu'
        );

        ?>
        <?= form_input_bs('general_name', $dataName, "Obecný název"); ?>

        <?= form_input_bs('name_in_season', $dataSeasonName, "Název týmu v této sezoně"); ?>
        <?= form_button($data_button_general_name); ?>
        <?php
        $data = [];
        if ($tym->logo != "") {
            $data = array(
                'src' => $uploadPath["logoTeam"] . $tym->logo,
                'class' => 'edit'
            );
            echo "<p id='club-logo'>" . img($data);
        } else {
            echo "<p id='club-logo'>Zatím žádné logo nevloženo.</p>";
        }

        ?>

        <?= form_input_bs('logo', $dataLogo, "Vložit nové logo týmu v této sezóně", 'file', false); ?>
        <?= form_dropdown_bs('stadium', $optionsStadium, $extra, "Vyber stadion", $selected, $disabled) ?>
        <?= form_input_bs('stadium_name_in_season', $dataStadiumName, "Název stadionu v této sezoně"); ?>
        <?= form_button($data_button_general_stadium_name); ?>
        <?= form_hidden('id_team_in_season', $tym->id_team_league_season); ?>
        <?= form_hidden('_method', 'PUT') ?>
        <p>
            <?= form_button($form["submitButton"]) ?>

            <?php
            echo form_close();
            ?>

    </div>
</div>
<script>
    $("#general_name_button").click(function() {
        let text = $('#general_name').val();
        $('#name_in_season').val(text);
    });

    $("#general_stadium_name_button").click(function() {
        let id = $('#stadium').val();
        let stadium = <?= $stadiumName;  ?>

        $('#stadium_name_in_season').val(stadium[id]);
    });
</script>

<?php

if (!is_null($lastSeasonData)) {
?>
    <script>
        $("#last_season_button").click(function() {
            let name = "<?= $lastSeasonData->team_name_in_season ?>";
            $('#name_in_season').val(name);
            let stadium = <?= $lastSeasonData->id_stadium ?>;
            $('#stadium').val(stadium);
            let stadiumName = '<?= $lastSeasonData->stadium_name_in_season ?>';
            $('#stadium_name_in_season').val(stadiumName);
            let obrazek = '<?= img($dataLogoLast) ?>';
            $('p#club-logo').html(obrazek);
            let logoPath = '<input type="hidden" name="logoPath" value="<?= $lastSeasonData->logo ?>">';
            $('p#club-logo').append(logoPath);
        });
    </script>
<?php
}

?>


<?= $this->endSection(); ?>