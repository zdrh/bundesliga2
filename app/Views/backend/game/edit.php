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

<h1>Přidat zápasy do ligy <?= $skupina->league_name_in_season ?><?= $textSkupina ?> <?= $rocnik ?></h1>
<div class="row">
    <div class="col-md-4">

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
        for($i = 1; $i<39; $i++) {
            $options[$i] = $i.". kolo";
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

       
        foreach($tymy as $row) {
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
        ?>

        <?= form_input_bs($dataDate, $form["divInputClass"], "Datum zápasu", 'date', false); ?>
        <?= form_input_bs($dataTime, $form["divInputClass"], "Čas zápasu", 'time', false); ?>
        <?= form_dropdown_bs('kolo', $options, $extra, 'mb-3' ,"Vyber kolo", $disabled, $selected) ?>
        <?= form_dropdown_bs('home', $optionsHome, $extraHome, 'mb-3' ,"Domácí tým", $disabled, $selected) ?>
        <?= form_dropdown_bs('away', $optionsAway, $extraAway, 'mb-3' ,"Hostující tým", $disabled, $selected) ?>

    </div>
</div>
<script>
    $('#home').on("change", function() {
        let val = $('#home').val();
        $('#away option[value='+ val + ']').attr('disabled', 'disabled').siblings().removeAttr('disabled');
    });
</script>
<?= $this->endSection(); ?>