<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Editovat asociaci</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/svaz/update');
        $dataName = array(
            'name' => 'name',
            'id' => 'name',
            'required' => 'required',
            'value' => $svaz->general_name
        );

        $dataShortName = array(
            'name' => 'short_name',
            'id' => 'short_name',
            'required' => 'required',
            'value' => $svaz->short_name
        );

        $dataFounded = array(
            'name' => 'founded',
            'required' => 'required',
            'id' => 'founded',
            'min' => $year['assoc_foundation_min'],
            'max' => $year['assoc_foundation_max'],
            'step' => 1,
            'value' => $svaz->founded
        );
        ?>

        <?= form_input_bs($dataName, $form["divInputClass"], "Obecný název", "text"); ?>
        <?= form_input_bs($dataShortName, $form["divInputClass"], "Zkratka asociace", "text"); ?>
        <?= form_input_bs($dataFounded, $form["divInputClass"], "Rok založení", "number", false); ?>
        <?= form_hidden('id_association', $svaz->id_association); ?>
        
        <?php

        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>
<script>
</script>

<?= $this->endSection(); ?>