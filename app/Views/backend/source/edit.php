<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Upravit zdroj</h1>
<?php
/**
 * 
 * @var array $form
 * @var array $seznamTypu
 * @var object $zdroj
 */
?>
<div class="row">
    <div class="col-md-4">
        <?php

        $dataName = array(
            'name' => 'name',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b',
            'value' => $zdroj->name
        );

        $optionsTyp =  $seznamTypu;


        $selected[] = $zdroj->id_source_type;

        $extraTyp = array(
            'class' => 'form-select',
            'id' => 'source_type'
        );


        echo form_open('admin/zdroj/update');


        ?>
        <div id="source_form">

            <?= form_input_bs('name', $dataName, "Název zdroje"); ?>
            <?= form_dropdown_bs('source_type', $optionsTyp, $extraTyp, 'Vyber typ zdroje', $selected) ?>


        </div>


        <?php


        echo form_hidden('id', $zdroj->id_source);
        echo form_hidden('_method', 'PUT');
        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>



<?= $this->endSection(); ?>