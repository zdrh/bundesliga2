<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Upravit stát</h1>
<?php
    /**
     * @var object $country
     * @var array $form
     */
?>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/zeme/update');
        $dataName = array(
            'name' => 'name',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b',
            'value' => $country->name
        );

        $dataShortName = array(
            'name' => 'short_name',
            'id' => 'short_name',
            'required' => 'required',
            'placeholder' => 'a',
            'value' => $country->short_name
        );


        ?>

        <div id="country_form">

            <?= form_input_bs('name', $dataName, "Název státu"); ?>
            <?= form_input_bs('short_name', $dataShortName, "Zkratka státu"); ?>
            <?= form_hidden('_method', 'PUT');?>
            <?= form_hidden('id_country', $country->id_country); ?>

        </div>
        <?php


        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>


    <?= $this->endSection(); ?>