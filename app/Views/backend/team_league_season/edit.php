<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
if (!is_null($skupina->groupname)) {
    $groupName = " (skupina " . $skupina->groupname . ")";
} else {
    $groupName = "";
}

?>
<h1>Editovat tým <?= $tym->general_name ?> v lize <?= $skupina->league_name_in_season ?><?= $groupName ?> ročník <?= $skupina->start ?>/<?= $skupina->finish  ?></h1>
<div class="row">
    <div class="col-md-4">


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




        ?>
        <?= form_input_bs($dataName, $form["divInputClass"], "Obecný název"); ?>

        <?= form_input_bs($dataSeasonName, $form["divInputClass"], "Název tým v této sezoně"); ?>
        <?= form_button($data_button_general_name); ?>
        <?php
        if($tym->logo != "") {
            $data = array(
                'src' => $uploadPath["logoTeam"].$tym->logo,
                'class' => 'edit'
            );
            echo img($data);
        } else {
            echo "<p>Zatím žádné logo nevloženo.</p>";
        }
      
        ?>

        <?= form_input_bs($dataLogo, $form["divInputClass"], "Logo týmu v této sezóně", 'file', false); ?>
        <?= form_hidden('id_team_in_season', $tym->id_team_league_season); ?>
        <?= form_hidden('_method', 'PUT') ?>
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
</script>

<?= $this->endSection(); ?>