<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Editovat stadion</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/stadion/update');
        $generalName = array(
            'name' => 'general_name',
            'id' => 'general_name',
            'required' => 'required',
            'placeholder' => 'b',
            'value' => $stadion->general_name
        );

        $latitude = array(
            'name' => 'latitude',
            'id' => 'latitude',
            'required' => 'required',
            'placeholder' => 'a',
            'value' => $stadion->latitude
        );

        $longtitude = array(
            'name' => 'longtitude',
            'id' => 'longtitude',
            'required' => 'required',
            'placeholder' => 'a',
            'value' => $stadion->longtitude
        );

        $optionsCity = array(
            '' => "Vyber město"
        );



        foreach ($city as $row) {
            $optionsCity[$row->id_city] = $row->name_de;
        }

        $extra = array(
            'class' => 'form-select',
            'id' => 'city'
        );

        $disabled = array(0 => '');
        $selected[] = $stadion->id_city;
        ?>

        <div id="stadium_form">

            <?= form_input_bs($generalName, $form["divInputClass"], "Název stadionu"); ?>

            <?= form_input_bs($latitude, $form["divInputClass"], "Zeměpisná šířka"); ?>
            <?= form_input_bs($longtitude, $form["divInputClass"], "Zeměpisná délka"); ?>
            <?= form_dropdown_bs('id_city', $optionsCity, $extra, 'mb-3', "Vyber město", $disabled, $selected) ?>


        </div>
        <?php

        echo form_hidden('id_stadium', $stadion->id_stadium);
        echo form_hidden('_method', 'PUT');
        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<script>
    $("button#add_stadium").click(function() {

        value = "<hr><?php echo form_input_bs($generalName, $form["divInputClass"], 'Název stadionu', 'text', true, false) . form_input_bs($latitude, $form["divInputClass"], 'Zeměpisná šířka', 'text', true, false) . form_input_bs($longtitude, $form["divInputClass"], 'Zeměpisná délka', 'text', true, false) . form_dropdown_bs('city', $optionsCity, $extra, 'mb-3', "Vyber město", $disabled, $selected, [], false); ?>";
        newDiv = $("<div></div>").html(value).attr("id", "newDiv");
        $("#stadium_form").append(newDiv);

    });
</script>

<?= $this->endSection(); ?>