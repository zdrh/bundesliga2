<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat asociaci</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/svaz/create');
        $dataName = array(
            'name' => 'name',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $dataShortName = array(
            'name' => 'short_name',
            'id' => 'short_name',
            'required' => 'required',
            'placeholder' => 'a'
        );

        $dataFounded = array(
            'name' => 'founded',
            'required' => 'required',
            'id' => 'founded',
            'min' => $year['assoc_foundation_min'],
            'max' => $year['assoc_foundation_max'],
            'step' => 1
        );
        ?>

        <div id="association_form">
            
            <?= form_input_bs($dataName, $form["divInputClass"], "Obecný název"); ?>

            
            <?= form_input_bs($dataShortName, $form["divInputClass"], "Zkratka svazu"); ?>

            <?= form_input_bs($dataFounded, $form["divInputClass"], "Rok založení", "number", false); ?>

        </div>
        <?php



       
        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<?= $this->endSection(); ?>