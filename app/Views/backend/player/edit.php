<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
    /**
     * @var object $player
     * @var array $country
     * @var array $city
     * @var array $form
     */
?>
<h1>Upravit hráče</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/hrac/update');
        $dataFirstName = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'required' => 'required',
            'placeholder' => 'b',
            'value' => $player->first_name
        );

        $dataLastName = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'required' => 'required',
            'placeholder' => 'a',
            'value' => $player->last_name
        );

        $dataBorn = array(
            'name' => 'born',
            'id' => 'born',
            'required' => 'required',
            'placeholder' => 'a',
            'value' => $player->born
        );

        $dataDeath = array(
            'name' => 'death',
            'id' => 'death',
            'placeholder' => 'a',
            'value' => $player->death
        );
        $optionsCountry = array(
            '' => "Vyber národnost"
        );
        foreach ($country as $row) {
            $optionsCountry[$row->id_country] = $row->name;
           
        }

        $extraCountry = array(
            'class' => 'form-select',
            'id' => 'country'
        );

        $disabled = array(0 => '');
        $selectedCountry[] = $player->country;

        $optionsCity = array(
            '' => "Vyber město narození"
        );
        foreach ($city as $row) {
            $optionsCity[$row->id_city] = $row->name_de;
           
        }

        $selectedCity[] = $player->born_city;

        $extraCity = array(
            'class' => 'form-select select2-basic-single',
            'id' => 'city'
        );

        $optionsRetire = array(
            '' => "Vyber zda ukončil kariéru",
            1 => "Ukončil kariéru",
            0 => "Stále aktivní"
        );

        $selectedRetire[] = $player->retire;
        $extraRetire = array(
            'class' => 'form-select',
            'id' => 'retire'
        );

        ?>

        <div id="player_form">

            <?= form_input_bs('first_name', $dataFirstName, "Jméno hráče"); ?>
            <?= form_input_bs('last_name', $dataLastName, "Příjmení hráče"); ?>
            <?= form_dropdown_bs('country[]', $optionsCountry, $extraCountry, "Vyber národnost", $selectedCountry, $disabled) ?>
            <?= form_input_bs('born', $dataBorn, "Datum narození", "date", false); ?>
            <?= form_dropdown_bs('bornCity[]', $optionsCity, $extraCity, "Vyber město narození", $selectedCity) ?>
            <?= form_dropdown_bs('retire[]', $optionsRetire, $extraRetire, "Ukončil kariéru?", $selectedRetire, $disabled) ?>
            <?= form_input_bs('death', $dataDeath, "Datum úmrtí", "date", false); ?>
            <?= form_hidden('_method', 'PUT'); ?>
            <?= form_hidden('id_player', $player->id_player); ?>

        </div>
        <?php
        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>
<script>
      $(document).ready(function() {
    $('#city').select2({
        theme: 'bootstrap-5'
    });
});
</script>



    <?= $this->endSection(); ?>