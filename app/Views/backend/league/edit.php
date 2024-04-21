<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Editovat ligu</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/liga/update');
        $dataName = array(
            'name' => 'name',
            'id' => 'name',
            'required' => 'required',
            'value' => $liga->name
        );

        $selectedAssociation[] = $liga->id_association;
        $selectedLevel[] = $liga->level;
        $selectedActive = $liga->active;

        $optionsLevel = array(
            1 => 1,
            2 => 2,
            3 => 3);

        $optionsActive = array(
            0 => "neaktivní",
            1 => 'aktivní'
        );

       
        foreach($svazy as $svaz) {
            $optionsAssociation[$svaz->id_association] = $svaz->general_name;
            
        }

        $disabled = array();
        $extraLevel = array(
            'class' => 'form-select',
            'id' => 'level',
            'required' => 'required',
        );

        $extraActive = array(
            'class' => 'form-select',
            'id' => 'active',
            'required' => 'required',
        );

        $extraAssociation = array(
            'class' => 'form-select',
            'id' => 'association',
            'required' => 'required',
        );
        
       
        ?>

        <div id="season_form">
            
            <?= form_input_bs($dataName, $form["divInputClass"], "Obecný název ligy"); ?>
            <?= form_dropdown_bs('level', $optionsLevel, $extraLevel, 'mb-3' ,"Vyber úroveň", $disabled, $selectedLevel) ?>
            <?= form_dropdown_bs('active', $optionsActive, $extraActive, 'mb-3' ,"Aktivní soutěž", $disabled, $selectedActive) ?>
            <?= form_dropdown_bs('association', $optionsAssociation, $extraAssociation, 'mb-3' ,"Organizuje svaz", $disabled, $selectedAssociation) ?>
            <?= form_hidden('league', $liga->id_league) ?>
            <?= form_hidden('_method', 'PUT') ?>
            <?= form_button($form["submitButton"]) ?>

        </div>
        <?php



       
        
        echo form_close();
        ?>
    </div>
</div>

<?= $this->endSection(); ?>