<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat hráče</h1>
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

            <?= form_input_bs($dataFirstName, $form["divInputClass"], "Jméno hráče"); ?>
            <?= form_input_bs($dataLastName, $form["divInputClass"], "Příjmení hráče"); ?>
            <?= form_dropdown_bs('country[]', $optionsCountry, $extraCountry, 'mb-3' ,"Vyber národnost", $disabled, $selected) ?>
            <?= form_input_bs($dataBorn, $form["divInputClass"], "Datum narození", "date", false); ?>
            <?= form_dropdown_bs('bornCity[]', $optionsCity, $extraCity, 'mb-3' ,"Vyber město narození", [], $selected) ?>
            <?= form_dropdown_bs('retire[]', $optionsRetire, $extraRetire, 'mb-3' ,"Ukončil kariéru?", $disabled, $selected) ?>
            <?= form_input_bs($dataDeath, $form["divInputClass"], "Datum úmrtí", "date", false); ?>


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

<script>
    //document.getElementById('start-').setAttribute('id', 'start-0');
    //document.getElementById('finish-').setAttribute('id', 'finish-0');
       
    $("button#add_player").click(function() {
        
        value = "<hr><?php echo form_input_bs($dataFirstName, $form["divInputClass"], 'Jméno hráče', 'text', true, false) . form_input_bs($dataLastName, $form["divInputClass"], 'Příjmení hráče', 'text', true, false). form_dropdown_bs('country[]', $optionsCountry, $extraCountry, 'mb-3' ,"Vyber národnost", $disabled, $selected, [], false) . form_input_bs($dataBorn, $form["divInputClass"], "Datum narození", "date", false, false) . form_dropdown_bs('bornCity[]', $optionsCity, $extraCity, 'mb-3' ,"Vyber město narození", [], $selected, [], false) . form_dropdown_bs('retire[]', $optionsRetire, $extraRetire, 'mb-3' ,"Ukončil kariéru?", $disabled, $selected, [], false) . form_input_bs($dataDeath, $form["divInputClass"], "Datum úmrtí", "date", false, false);?>";
        newDiv = $("<div></div>").html(value).attr("id", "newDiv");
        $("#player_form").append(newDiv);
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