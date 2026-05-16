<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
    /**
     * @var object $stadion
     * @var array $city 
     * @var array $form
     */
?>
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
            'class' => 'form-select select2-basic-single',
            'id' => 'city'
        );

        $disabled = array(0 => '');
        $selected[] = $stadion->id_city;
        ?>

        <div id="stadium_form">
            <?= form_input_bs('general_name', $generalName, "Název stadionu"); ?>
            <?= form_input_bs('latitude', $latitude, "Zeměpisná šířka"); ?>
            <?= form_input_bs('longtitude', $longtitude, "Zeměpisná délka"); ?>
            <?= form_dropdown_bs('id_city', $optionsCity, $extra, "Vyber město", $selected, $disabled) ?>
        </div>
        <?php

        echo form_hidden('id_stadium', $stadion->id_stadium);
        echo form_hidden('_method', 'PUT');
        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<?= $this->endSection(); ?>