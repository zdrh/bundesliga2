<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
if ($skupina->groupname != NULL) {
    $textSkupina = " (skupina " . $skupina->groupname . ")";
} else {
    $textSkupina = "";
}

$rocnik = $skupina->start . "-" . $skupina->finish;
?>

<h1>Přidat kolo do ligy <?= $skupina->league_name_in_season ?><?= $textSkupina ?> <?= $rocnik ?></h1>
<div class="row">
    <div class="col-md-8">

        <?php

        $dataDate = array(
            'name' => 'date',
            'id' => 'date',
        );

        $dataTime = array(
            'name' => 'time',
            'id' => 'time',
        );

        $options = array(
            '' => "Vyber pořadí kola",
        );
        for ($i = 1; $i < 39; $i++) {
            $options[$i] = $i . ". kolo";
        }
        $extra = array(
            'class' => 'form-select',
            'id' => 'round'
        );

        $disabled = array('');
        $selected = array('');

        $optionsHome = array(
            '' => "Vyber domácí tým"
        );

        $optionsAway = array(
            '' => "Vyber hostující tým"
        );


        foreach ($tymy as $row) {
            $optionsHome[$row->id_team_league_season] = $row->team_name_in_season;
            $optionsAway[$row->id_team_league_season] = $row->team_name_in_season;
        }

        $extraHome = array(
            'class' => 'form-select',
            'id' => 'home'
        );

        $extraAway = array(
            'class' => 'form-select',
            'id' => 'away'
        );

        $dataGoalsHome = array(
            'name' => 'goalsHome[]',
            'id' => 'goalsHome',
        );

        $dataGoalsAway = array(
            'name' => 'goalsAway[]',
            'id' => 'goalsAway',
        );

       
        ?>
        <div id='round_form'>
            <?= form_open('admin/liga/skupina/zapasy/create'); ?>
            <?= form_input_bs($dataDate, $form["divInputClass"], "Datum zápasů", 'date', false); ?>
            <?= form_input_bs($dataTime, $form["divInputClass"], "Čas zápasů", 'time', false); ?>
            <?= form_dropdown_bs('round', $options, $extra, 'mb-3', "Vyber kolo", $disabled, $selected) ?>
            <?php
            for ($i = 0; $i < $pocetZapasu; $i++) {
            ?>
                <div class="d-flex">
                    <?= form_dropdown_bs('home[]', $optionsHome, $extraHome, 'mb-3 me-1 col-md-4', "Domácí tým", $disabled, $selected) ?>
                    <?= form_dropdown_bs('away[]', $optionsAway, $extraAway, 'mb-3 me-1 col-md-4', "Hostující tým", $disabled, $selected) ?>
                    <?= form_input_bs($dataGoalsHome, $form["divInputClass"], "Góly domácí", 'number', false); ?>
                    <?= form_input_bs($dataGoalsAway, $form["divInputClass"], "Góly hosté", 'number', false); ?>
                </div>
            <?php

            }
            ?>
        </div>
        <?= form_hidden('id_group', $skupina->id_league_season_group) ?>
        <?= form_button($form["submitButton"]) ?>

    </div>
</div>
<script>
    selects = $('div#round_form').find('select');
    selects.on('change', function() {
        let selected = [];

        selects.each(function(index, select) {
            if (select.value !== "") {
                selected.push(select.value);
            }

        });

        for (var index in selected) {
            $('div#round_form').find('option[value="' + selected[index] + '"]:not(:selected)')
                .prop("disabled", true);
        }
    });


   // $('select option[value=' + val + ']').attr('disabled', 'disabled').parent().siblings().removeAttr('disabled');
</script>
<?= $this->endSection(); ?>