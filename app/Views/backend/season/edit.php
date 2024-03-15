<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Editovat sezónu</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/sezona/update');
        $dataStart = array(
            'name' => 'start',
            'id' => 'start',
            'min' => $year['league_season_min'],
            'max' => $year['league_season_max'],
            'step' => 1,
            'required' => 'required',
            'oninput' => 'startFinishSeason()',
            'value' => $sezona->start

        );
        $js = array(
            'oninput' => 'startFinishSeason()'
        );
        $dataFinish = array(
            'name' => 'finish',
            'id' => 'finish',
            'min' => $year['league_season_min'],
            'max' => $year['league_season_max'],
            'step' => 1,
            'required' => 'required',
            'value' => $sezona->finish
        );
        ?>

        <?= form_input_bs($dataStart, $form["divInputClass"], "Začátek", "number"); ?>
        <?= form_input_bs($dataFinish, $form["divInputClass"], "Konec", "number"); ?>
        <?= form_hidden('id_season', $sezona->id_season); ?>
        
        <?php

        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>
<script>
</script>

<?= $this->endSection(); ?>