<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat zdroj</h1>
<?php
/**
 * 
 * @var array $form
 * @var array $seznamTypu
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

        $optionsTyp = ['' => 'Vyber typ'] + $seznamTypu;
        
        $disabled = array(0 => '');
        $selected[0] = '';

        $extraTyp = array(
            'class' => 'form-select',
            'id' => 'source_type'
        );


        echo form_open('admin/zdroj/create');


        ?>
        <div id="source_form">

            <?= form_input_bs('name[]', $dataName, "Název zdroje"); ?>
            <?= form_dropdown_bs('source_type[]', $optionsTyp, $extraTyp, 'Vyber typ zdroje', $selected, $disabled) ?>


        </div>

        <template id="source">
            <hr>
            <?= form_input_bs('name[]', $dataName, "Název zdroje"); ?>
            <?= form_dropdown_bs('source_type[]', $optionsTyp, $extraTyp, 'Vyber typ zdroje', $selected, $disabled) ?>
        </template>
        <?php

        $data_button_add = array(
            'name' => 'add_source',
            'id' => 'add_source',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další zdroj'
        );
        echo form_button($data_button_add);


        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<script>
    $("button#add_source").click(function() {
        const clone = $($('#source').html());
        $('#source_form').append(clone);

    });
</script>

<?= $this->endSection(); ?>