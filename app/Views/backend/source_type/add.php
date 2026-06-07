<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat typ zdroje</h1>
<?php
/**
 * 
 * @var array $form
 */
?>
<div class="row">
    <div class="col-md-4">
        <?php

        $dataName = array(
            'name' => 'name[]',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b'
        );
        echo form_open('admin/typ-zdroje/create');
       

        ?>
        <div id="type_source_form">

            <?= form_input_bs('name[]', $dataName, "Název typu zdroje"); ?>
        


        </div>

        <template id="type_source">
            <hr>
            <?= form_input_bs('name[]', $dataName, "Název zdroje"); ?>
        </template>
        <?php

        $data_button_add = array(
            'name' => 'add_type_source',
            'id' => 'add_type_source',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další typ zdroje'
        );
        echo form_button($data_button_add);


        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<script>
    $("button#add_type_source").click(function() {
        const clone = $($('#type_source').html());
        $('#type_source_form').append(clone);

    });
</script>

<?= $this->endSection(); ?>