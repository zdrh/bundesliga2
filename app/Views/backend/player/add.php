<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat hráče</h1>
<?php
/**
 * @var array $country
 * @var array $city
 * @var array $form
 */
?>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/hrac/create');
        $dataFirstName = array(
            'name' => 'first_name[]',
            'id' => 'first_name',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $dataLastName = array(
            'name' => 'last_name[]',
            'id' => 'last_name',
            'required' => 'required',
            'placeholder' => 'a'
        );

        $dataBorn = array(
            'name' => 'born[]',
            'id' => 'born',
            'required' => 'required',
            'placeholder' => 'a'
        );

        $dataDeath = array(
            'name' => 'death[]',
            'id' => 'death',
            'placeholder' => 'a'
        );
        $optionsCountry = array(
            '' => "Vyber stát"
        );
        foreach ($country as $row) {
            $optionsCountry[$row->id_country] = $row->name;
           
        }

        $extraCountry = array(
            'class' => 'form-select',
            'id' => 'country'
        );

        $disabled = array(0 => '');
        $selected[0] = '';

        $optionsCity = array(
            '' => "Vyber město narození"
        );
        foreach ($city as $row) {
            $optionsCity[$row->id_city] = $row->name_de;
           
        }

        $extraCity = array(
            'class' => 'form-select select2-basic-single',
            'id' => 'city'
        );

        $optionsRetire = array(
            '' => "Vyber zda ukončil kariéru",
            1 => "Ukončil kariéru",
            0 => "Stále aktivní"
        );

        $extraRetire = array(
            'class' => 'form-select',
            'id' => 'retire'
        );

        ?>

        <div id="player_form">

            <?= form_input_bs('first_name[]', $dataFirstName, "Jméno hráče"); ?>
            <?= form_input_bs('last_name[]', $dataLastName, "Příjmení hráče"); ?>
            <?= form_dropdown_bs('country[]', $optionsCountry, $extraCountry, "Vyber národnost", $selected, $disabled) ?>
            <?= form_input_bs('born[]', $dataBorn, "Datum narození", "date", false); ?>
            <?= form_dropdown_bs('bornCity[]', $optionsCity, $extraCity, "Vyber město narození", $selected) ?>
            <?= form_dropdown_bs('retire[]', $optionsRetire, $extraRetire ,"Ukončil kariéru?", $selected, $disabled) ?>
            <?= form_input_bs('death[]', $dataDeath, "Datum úmrtí", "date", false); ?>


        </div>
        <?php

        $data_button_add = array(
            'name' => 'add_player',
            'id' => 'add_player',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat dalšího hráče'
        );
        echo form_button($data_button_add);


        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>
<template id="player">
    <hr>
    <?= form_input_bs('first_name[]', $dataFirstName, "Jméno hráče"); ?>
            <?= form_input_bs('last_name[]', $dataLastName, "Příjmení hráče"); ?>
            <?= form_dropdown_bs('country[]', $optionsCountry, $extraCountry, "Vyber národnost", $selected, $disabled) ?>
            <?= form_input_bs('born[]', $dataBorn, "Datum narození", "date", false); ?>
            <?= form_dropdown_bs('bornCity[]', $optionsCity, $extraCity, "Vyber město narození", $selected) ?>
            <?= form_dropdown_bs('retire[]', $optionsRetire, $extraRetire ,"Ukončil kariéru?", $selected, $disabled) ?>
            <?= form_input_bs('death[]', $dataDeath, "Datum úmrtí", "date", false); ?>
</template>

<script>
       
    $("button#add_player").click(function() {
        const clone = $('#player').contents().clone();
        $('#player_form').append(clone);
       
        $('.select2-basic-single').select2({
        theme: 'bootstrap-5'
    });
    });

    $(document).ready(function() {
    $('#city').select2({
        theme: 'bootstrap-5'
    });
});

</script>

    <?= $this->endSection(); ?>