<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

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

        $options[0] = "Vyber tým";
        foreach ($tymy as $row) {
            $options[$row->id_team] = $row->general_name;
        }
        $extra = array(
            'id' => 'team'
        );

        $disabled[] = 0;
        $selected[] = 0;

        $dataAddNext = array(
            'name' => 'add-next',
            'id' => 'add-team',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další'
        );

        ?>


        <?= form_input_bs($dataName, $form["divInputClass"], "Obecný název klubu"); ?>
        <?= form_input_bs($dataShortName, $form["divInputClass"], "Zkratka klubu"); ?>
        <?= form_input_bs($dataFounded, $form["divInputClass"], "Rok založení", "number", false); ?>
        <?= form_input_bs($dataDissolved, $form["divInputClass"], "Rok rozpuštění", "number", false); ?>
        <?= form_dropdown_bs('follower[]', $options, $extra, 'mb-3', 'Vyber nástupce', $disabled, $selected); ?>
        <div id="add-new"></div>
        <?= form_button($dataAddNext) ?>
        <?= form_button($form["submitButton"]) ?>


        </form>

        <script>
            $('#add-team').click(function() {
                value = "<hr><?php echo form_input_bs($dataName, $form["divInputClass"], "Obecný název klubu", 'text', 'true', false) . form_input_bs($dataShortName, $form["divInputClass"], "Zkratka klubu", 'text', 'true', false) . form_input_bs($dataFounded, $form["divInputClass"], "Rok založení", "number", false, false) . form_input_bs($dataDissolved, $form["divInputClass"], "Rok rozpuštění", "number", false, false) . form_dropdown_bs('follower[]', $options, $extra, 'mb-3', 'Vyber nástupce', $disabled, $selected, false) ?>";
                $('div#add-new').append(value);
            });
        </script>

        <?php

        $this->endSection();
