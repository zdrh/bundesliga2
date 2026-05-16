<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
    /**
     * @var object $tym
     * @var array $year
     * @var array $tymy
     * @var array $form
     */
?>
<h1>Editovat klub <?= $tym->general_name ?></h1>
<div class="row">
    <div class="col-md-4">
        <?php

        echo form_open('admin/tym/update');
        $dataName = array(
            'name' => 'name[]',
            'id' => 'name',
            'required' => 'required',
            'value' => $tym->general_name
        );

        $dataShortName = array(
            'name' => 'short_name[]',
            'id' => 'short_name',
            'value' => $tym->short_name

        );
        $dataFounded = array(
            'name' => 'founded[]',
            'required' => 'required',
            'id' => 'founded',
            'min' => $year['team_foundation_min'],
            'max' => $year['team_foundation_max'],
            'step' => 1,
            'value' => $tym->founded
        );

        $dataDissolved = array(
            'name' => 'dissolved[]',
            'id' => 'dissolved',
            'min' => $year['team_dissolve_min'],
            'max' => $year['team_dissolve_max'],
            'step' => 1,
            'class' => 'dissolve form-control',
            'value' => $tym->dissolve
        );

        $options[''] = "Vyber tým";
        foreach ($tymy as $row) {
            $options[$row->id_team] = $row->general_name;
        }
        $extra = array(
            'id' => 'team'
        );

        $disabled[] = '';
        if(!is_null($tym->follower)) {
            $selected[] = $tym->follower;
        } else {
            $selected[] = '';
        }
        

        ?>


        <?= form_input_bs('name[]', $dataName, "Obecný název klubu"); ?>
        <?= form_input_bs('short_name[]', $dataShortName, "Zkratka klubu"); ?>
        <?= form_input_bs('founded[]', $dataFounded, "Rok založení", "number", false); ?>
        <?= form_input_bs('dissolved[]', $dataDissolved, "Rok rozpuštění", "number", false); ?>
        <?= form_dropdown_bs('follower[]', $options, $extra, 'Vyber nástupce', $selected, $disabled); ?>
        <?= form_hidden('_method', 'PUT') ?>
        <?= form_hidden('id_team', $tym->id_team) ?>

        <?= form_button($form["submitButton"]) ?>


        </form>

        <?php

        $this->endSection();
