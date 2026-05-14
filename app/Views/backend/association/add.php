<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat asociaci</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        /**
         * @var array $year
         * @var array $form
         */
        echo form_open('admin/svaz/create');
        $dataName = array(
            'name' => 'name',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $dataShortName = array(
            'name' => 'short_name',
            'id' => 'short_name',
            'required' => 'required',
            'placeholder' => 'a'
        );

        $dataFounded = array(
            'name' => 'founded',
            'required' => 'required',
            'id' => 'founded',
            'min' => $year['assoc_foundation_min'],
            'max' => $year['assoc_foundation_max'],
            'step' => 1
        );
        ?>

        <div id="association_form">
           
            <?= form_input_bs('name', $dataName, "Obecný název" ); ?>

            <?= form_input_bs('short_name', $dataShortName, "Zkratka svazu"); ?>

            <?= form_input_bs('founded', $dataFounded, "Rok založení", "number", false); ?>

        </div>
        <?php



       
        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<?= $this->endSection(); ?>