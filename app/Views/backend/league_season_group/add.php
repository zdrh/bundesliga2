<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
/**
 * @var object $liga
 * @var array $form
 * @var int $idLeagueSeason 
 */
?>
<h1>Přidat skupinu ligy <?= $liga->league_name_in_season ?> ročník <?= $liga->start ?>/<?= $liga->finish  ?></h1>
<div class="row">
    <div class="col-md-4">
        <?php

        echo form_open('admin/liga/sezona/skupina/create');

        $dataName = array(
            'name' => 'groupname',
            'id' => 'groupname',
            'required' => 'required',
            'placeholder' => 'b'
        );


       
        $selectedGroups[] = 0;
      

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
        <?= form_input_bs('groupname', $dataName, "Název skupiny"); ?>
        
        <?= form_dropdown_bs('regular', $optionsGroups, $extraGroups, "Skupiny", $selectedGroups, $disabledGroups) ?>
        <?= form_hidden('id_league_season', $idLeagueSeason) ?>
        
        <?= form_button($form["submitButton"]) ?>

        <?php
        echo form_close();
        ?>
    </div>
</div>


<?= $this->endSection(); ?>