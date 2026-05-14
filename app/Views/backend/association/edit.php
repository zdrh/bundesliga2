<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Editovat asociaci</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        /** 
        * @var object $svaz
        * @var array $year
        * @var array $form
        */
        echo form_open('admin/svaz/update');
        $dataName = array(
            'name' => 'general_name',
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

        <?= form_input_bs('general_name', $dataName, "Obecný název"); ?>
        <?= form_input_bs('short_name', $dataShortName, "Zkratka asociace"); ?>
        <?= form_input_bs('founded', $dataFounded, "Rok založení", "number", false); ?>
        <?= form_hidden('id_association', $svaz->id_association); ?>
        <?= form_hidden('_method', 'PUT'); ?>
        
        <?php

        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>
<script>
</script>

<?= $this->endSection(); ?>