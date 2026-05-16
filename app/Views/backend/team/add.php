<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
/**
 * @var array $year
 * @var array $tymy
 * @var array $form
 */
?>
<h1>Přidat klub</h1>
<div class="row">
    <div class="col-md-4">
        <?php

        echo form_open('admin/tym/create');
        $dataName = array(
            'name' => 'name[]',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'a'
        );

        $dataShortName = array(
            'name' => 'short_name[]',
            'id' => 'short_name',
            'placeholder' => 'a'

        );
        $dataFounded = array(
            'name' => 'founded[]',
            'required' => 'required',
            'id' => 'founded',
            'min' => $year['team_foundation_min'],
            'max' => $year['team_foundation_max'],
            'step' => 1
        );

        $dataDissolved = array(
            'name' => 'dissolved[]',
            'id' => 'dissolved',
            'min' => $year['team_dissolve_min'],
            'max' => $year['team_dissolve_max'],
            'step' => 1,
            'class' => 'dissolve form-control'
        );

        $options[''] = "Vyber tým";
        foreach ($tymy as $row) {
            $options[$row->id_team] = $row->general_name;
        }
        $extra = array(
            'id' => 'team'
        );

        $disabled = array();
        $selected[] = '';

        $dataAddNext = array(
            'name' => 'add-next',
            'id' => 'add-team',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další'
        );

        ?>

        <div id="team_form">
            <?= form_input_bs('name[]', $dataName, "Obecný název klubu"); ?>
            <?= form_input_bs('short_name[]', $dataShortName, "Zkratka klubu"); ?>
            <?= form_input_bs('founded[]', $dataFounded, "Rok založení", "number", false); ?>
            <?= form_input_bs('dissolved[]', $dataDissolved, "Rok rozpuštění", "number", false); ?>
            <?= form_dropdown_bs('follower[]', $options, $extra, 'Vyber nástupce', $selected, $disabled); ?>
        </div>
        <?= form_button($dataAddNext) ?>
        <?= form_button($form["submitButton"]) ?>


        </form>

        <template id='team'>
            <hr>
            <?= form_input_bs('name[]', $dataName, "Obecný název klubu"); ?>
            <?= form_input_bs('short_name[]', $dataShortName, "Zkratka klubu"); ?>
            <?= form_input_bs('founded[]', $dataFounded, "Rok založení", "number", false); ?>
            <?= form_input_bs('dissolved[]', $dataDissolved, "Rok rozpuštění", "number", false); ?>
            <?= form_dropdown_bs('follower[]', $options, $extra, 'Vyber nástupce', $selected, $disabled); ?>
        </template>
        <script>
            let count = 0;
            $('#add-team').click(function() {
                count++;
                const clone = $($('#team').html());
                $('#team_form').append(clone);

            });
            $('#send').click(function() {
                $('select').each(function() {

                });
            });
        </script>

        <?php

        $this->endSection();
