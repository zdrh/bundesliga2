<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat město</h1>
<?php
/**
 * @var array $country
 * @var array $form
 */
?>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/mesto/create');
        $dataNameDe = array(
            'name' => 'name_de[]',
            'id' => 'name_de',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $dataNameCz = array(
            'name' => 'name_cz[]',
            'id' => 'name_cz',
            'required' => 'required',
            'placeholder' => 'a'
        );

        $optionsCountry = $country;
        $optionsCountry[''] = "Vyber stát";

        $disabled = array(0 => '');
        $selected[0] = '';

        $extraCountry = array(
            'class' => 'form-select',
            'id' => 'country'
        );

        $optionsLeague = array(
            '' => 'Vyber důvod vložení',
            1 => 'Liga',
            0 => 'Narození hráče'
        );

        $extraLeague = array(
            'class' => 'form-select',
            'id' => 'league'
        );

        ?>

        <div id="city_form">

            <?= form_input_bs('name_de[]', $dataNameDe, "Název německy"); ?>
            <?= form_input_bs('name_cz[]', $dataNameCz, "Název česky"); ?>
            <?= form_dropdown_bs('country[]', $optionsCountry, $extraCountry, "Vyber stát", $selected, $disabled) ?>
            <?= form_dropdown_bs('league[]', $optionsLeague, $extraLeague, "Vyber důvod vložení", $selected, $disabled) ?>


        </div>

        <template id="city">
            <hr>
            <?= form_input_bs('name_de[]', $dataNameDe, "Název německy"); ?>
            <?= form_input_bs('name_cz[]', $dataNameCz, "Název česky"); ?>
            <?= form_dropdown_bs('country[]', $optionsCountry, $extraCountry, "Vyber stát", $selected, $disabled) ?>
            <?= form_dropdown_bs('league[]', $optionsLeague, $extraLeague, "Vyber důvod vložení", $selected, $disabled) ?>
        </template>
        <?php

        $data_button_add = array(
            'name' => 'add_city',
            'id' => 'add_city',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další město'
        );
        echo form_button($data_button_add);


        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<script>
    $("button#add_city").click(function() {
        const clone = $($('#city').html());
        $('#city_form').append(clone);

    });
</script>

<?= $this->endSection(); ?>