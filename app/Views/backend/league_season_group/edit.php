<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
    /**
     * @var object $liga
     * @var object $league_season_group
     * @var array $form
     */
?>
<h1>Editovat skupinu ligy <?= $liga->league_name_in_season ?> ročník <?= $liga->start ?>/<?= $liga->finish  ?></h1>
<div class="row">
    <div class="col-md-4">
        <?php

        echo form_open('admin/liga/sezona/skupina/update');

        $dataName = array(
            'name' => 'groupname',
            'id' => 'groupname',
            'required' => 'required',
            'value' => $league_season_group->groupname
        );


       
        $selectedGroups[] = $league_season_group->regular;
      

        //skupiny
        $optionsGroups = array(
            0 => 'Vyber hodnotu',
            1 =>  'Základní skupina',
            2 => 'Finálová skupina'
        );
        $disabledGroups = array(0 => 0);

        $extraGroups = array(
            'class' => 'form-select',
            'id' => 'groups'
        );

        ?>

        <?= form_input_bs('groupname', $dataName, "Název skupiny");?>
        
        <?= form_dropdown_bs('regular', $optionsGroups, $extraGroups, "Skupiny", $selectedGroups, $disabledGroups) ?>
        <?= form_hidden('id_league_season_group', $league_season_group->id_league_season_group) ?>
        <?= form_hidden('_method', 'put') ?>
        <?= form_button($form["submitButton"]) ?>

        <?php
        echo form_close();
        ?>
    </div>
</div>


<?= $this->endSection(); ?>