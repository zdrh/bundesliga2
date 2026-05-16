<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
/**
 * @var object $league
 * @var mixed $id
 * @var object $game
 * @var array $team
 * @var object $game_team
 * @var array $allStadiums
 * @var object $stadium
 * @var array $form
 */
if ($league->groupname != NULL) {
    $textSkupina = " (skupina " . $league->groupname . ")";
} else {
    $textSkupina = "";
}


?>

<h1>Upravit zápas ligy <?= $league->league_name_in_season ?><?= $textSkupina ?></h1>
<div class="row">
    <div class="col-md-4">

        <?php

        $dataIdGame = array(
            'name' => 'game_id',
            'id' => 'game_id',
            'value' => $id,
            'disabled' => 'disabled'
        );
        $dataDate = array(
            'name' => 'date',
            'id' => 'date',
            'value' => $game->date
        );

        $dataTime = array(
            'name' => 'time',
            'id' => 'time',
            'value' => $game->time
        );

        $dataAttendance = array(
            'name' => 'attendance',
            'id' => 'attendance',
            'value' => $game->attendance
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
        $selected = array($game->round);

        $optionsHome = array(
            '' => "Vyber domácí tým"
        );

        $optionsAway = array(
            '' => "Vyber hostující tým"
        );


        foreach ($team as $row) {
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

        $selectedHome = array($game_team->me_id_team);
        $selectedAway = array($game_team->oppo_id_team);


        $goalHome = array(
            'name' => 'goal_home',
            'id' => 'goal_home',
            'value' => $game_team->result_team
        );

        $goalAway = array(
            'name' => 'goal_away',
            'id' => 'goal_away',
            'value' => $game_team->result_opponent
        );

        $halfHome = array(
            'name' => 'half_home',
            'id' => 'half_home',
            'value' => $game_team->halftime_team
        );

        $halfAway = array(
            'name' => 'half_away',
            'id' => 'half_away',
            'value' => $game_team->halftime_opponent
        );

        $optionsStadium = array(
            '' => 'Vyber stadion'
        );

        foreach ($allStadiums as $row) {
            $optionsStadium[$row->id_stadium] = $row->general_name . " - " . $row->name_de;
        }

        $disabled = array('');
        if (is_null($game->id_stadium)) {
            $selectedStadium = array($stadium->id_stadium);
        } else {
            $selectedStadium = array($game->id_stadium);
        }


        $extraStadium = array(
            'class' => 'form-select',
            'id' => 'stadium'
        );

        ?>
        <?= form_open('admin/zapas/update'); ?>
        <?= form_input_bs('game_id', $dataIdGame, "Id zápasu", 'text', false); ?>
        <div class="d-flex">
            <?= form_input_bs('date', $dataDate, "Datum zápasu", 'date', false); ?>
            <?= form_input_bs('time', $dataTime, "Čas zápasu", 'time', false, 'mb-3 ms-3'); ?>
        </div>
        <?= form_dropdown_bs('kolo', $options, $extra, "Vyber kolo", $selected, $disabled) ?>
        <?= form_dropdown_bs('home', $optionsHome, $extraHome, "Domácí tým", $selectedHome, $disabled) ?>
        <?= form_dropdown_bs('away', $optionsAway, $extraAway, "Hostující tým", $selectedAway, $disabled) ?>
        <?= form_dropdown_bs('stadium', $optionsStadium, $extraStadium, "Stadion", $selectedStadium, $disabled) ?>
        <?= form_input_bs('attendance', $dataAttendance, "Návštěva", 'text', false); ?>
        <div class="d-flex">
            <?= form_input_bs('goal_home', $goalHome, "Góly domácí", 'number', false); ?>
            <?= form_input_bs('goal_away', $goalAway, "Góly hosté", 'number', false); ?>
        </div>
        <div class="d-flex">
            <?= form_input_bs('half_home', $halfHome, "Poločas domácí", 'text', false); ?>
            <?= form_input_bs('half_away', $halfAway, "Poločas hosté", 'text', false); ?>
        </div>
        <?php
        ?>
        <?= form_hidden('game_id', "$id") ?>
        <?= form_hidden('_method', 'PUT'); ?>
        <?= form_close(); ?>
    </div>
</div>
<script>
    $('#home').on("change", function() {
        let val = $('#home').val();
        $('#away option[value=' + val + ']').attr('disabled', 'disabled').siblings().removeAttr('disabled');
    });
</script>
<?= $this->endSection(); ?>