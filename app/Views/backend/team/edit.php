<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

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


        <?= form_input_bs($dataName, $form["divInputClass"], "Obecný název klubu"); ?>
        <?= form_input_bs($dataShortName, $form["divInputClass"], "Zkratka klubu"); ?>
        <?= form_input_bs($dataFounded, $form["divInputClass"], "Rok založení", "number", false); ?>
        <?= form_input_bs($dataDissolved, $form["divInputClass"], "Rok rozpuštění", "number", false); ?>
        <?= form_dropdown_bs('follower[]', $options, $extra, 'mb-3', 'Vyber nástupce', $disabled, $selected); ?>
        <?= form_hidden('_method', 'PUT') ?>
        <?= form_hidden('id_team', $tym->id_team) ?>

        <?= form_button($form["submitButton"]) ?>


        </form>

        <?php

        $this->endSection();
