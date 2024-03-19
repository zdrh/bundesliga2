<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat ligu</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/liga/create');
        $dataName = array(
            'name' => 'name',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $optionsLevel = array('' => "Vyber hodnotu", 1, 2, 3);

        $optionsActive = array(
            '' => 'Vyber',
            0 => "neaktivní",
            1 => 'aktivní'
        );

        $optionsAssociation = array(
            '' => 'Vyber'
        );
        foreach($svazy as $svaz) {
            $optionsAssociation[$svaz->id_association] = $svaz->general_name;
        }

        $disabled[0] = "";
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
         $selected[0] = "";
       
        ?>

        <div id="season_form">
            
            <?= form_input_bs($dataName, $form["divInputClass"], "Obecný název ligy"); ?>
            <?= form_dropdown_bs('level', $optionsLevel, $extraLevel, 'mb-3' ,"Vyber úroveň", $disabled, $selected) ?>
            <?= form_dropdown_bs('active', $optionsActive, $extraActive, 'mb-3' ,"Aktivní soutěž", $disabled, $selected) ?>
            <?= form_dropdown_bs('association', $optionsAssociation, $extraAssociation, 'mb-3' ,"Organizuje svaz", $disabled, $selected) ?>
            <?= form_button($form["submitButton"]) ?>

        </div>
        <?php



       
        
        echo form_close();
        ?>
    </div>
</div>

<?= $this->endSection(); ?>