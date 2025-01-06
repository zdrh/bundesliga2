<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Editovat město</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/mesto/update');
        $dataNameDe = array(
            'name' => 'name_de',
            'id' => 'name_de',
            'required' => 'required',
            'placeholder' => 'b',
            'value' => $city->name_de
        );

        $dataNameCz = array(
            'name' => 'name_cz',
            'id' => 'name_cz',
            'required' => 'required',
            'placeholder' => 'a',
            'value' => $city->name_cz
        );


        ?>

        <div id="city_form">

            <?= form_input_bs($dataNameDe, $form["divInputClass"], "Název německy"); ?>

            <?= form_input_bs($dataNameCz, $form["divInputClass"], "Název česky"); ?>
            <?= form_hidden('id_city', $city->id_city);?>
            <?= form_hidden('_method', 'PUT');?>


        </div>
        <?php

        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>


    <?= $this->endSection(); ?>