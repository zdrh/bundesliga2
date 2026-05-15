<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat stát</h1>
<?php
/**
 *  @var array $form
 * 
 */
?>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/zeme/create');
        $dataName = array(
            'name' => 'name[]',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $dataShortName = array(
            'name' => 'short_name[]',
            'id' => 'short_name',
            'required' => 'required',
            'placeholder' => 'a'
        );


        ?>

        <div id="country_form">

            <?= form_input_bs('name[]', $dataName, "Název státu"); ?>
            <?= form_input_bs('short_name[]', $dataShortName, "Zkratka státu"); ?>
        </div>

        <template id="country">
            <hr>
            <?= form_input_bs('name[]', $dataName, "Název státu"); ?>
            <?= form_input_bs('short_name[]', $dataShortName, "Zkratka státu"); ?>
        </template>
        <?php

        $data_button_add = array(
            'name' => 'add_country',
            'id' => 'add_country',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další stát'
        );
        echo form_button($data_button_add);


        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<script>
    $("button#add_country").click(function() {

        const clone = $($('#country').html());
        $('#country_form').append(clone);

    });
</script>

<?= $this->endSection(); ?>