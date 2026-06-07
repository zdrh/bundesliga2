<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Upravit typ zdroje</h1>
<?php
/**
 * 
 * @var array $form
 * @var object $typ_zdroje
 */
?>
<div class="row">
    <div class="col-md-4">
        <?php

        $dataName = array(
            'name' => 'name[]',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b',
            'value' => $typ_zdroje->name
        );
        echo form_open('admin/typ-zdroje/update');
       

        ?>
        <div id="type_source_form">

            <?= form_input_bs('name[]', $dataName, "Název typu zdroje"); ?>
        
        </div>
     
        <?php

        echo form_hidden('id', $typ_zdroje->id_source_type);
        echo form_hidden('_method', 'PUT');
        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<?= $this->endSection(); ?>