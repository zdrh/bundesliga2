<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat sezónu ligy <?= $liga->name ?></h1>
<div class="row">
    <div class="col-md-4">
        <?php

        echo form_open_multipart('admin/liga/sezona/create');

        $dataGeneralName = array(
            'name' => 'general_name',
            'id' => 'general_name',
            'required' => 'required',
            'disabled' => 'disabled',
            'value' => $liga->name
        );


        $data_button_general_name = array(
            'name' => 'general_name_button',
            'id' => 'general_name_button',
            'type' => 'button',
            'class' => 'btn btn-primary mb-3',
            'content' => 'Pro tuto sezónu použít obecný název ligy'
        );

        $dataName = array(
            'name' => 'name',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b'
        );


        $dataLogo = array(
            'name' => 'logo',
            'id' => 'logo',
            'required' => 'required',
            'accept' => '.jpg, .png'
        );


        $options = array(
         '' => "Vyber hodnotu"
        );
        $disabled[] = '';
        $selected[] = '';
        $extra = array(
            'class' => 'form-select',
            'id' => 'league'
        );

        //skupiny
        $optionsGroups = array(
            0 => 'Vyber hodnotu',
            1 =>  'Nemá skupiny',
            2 => 'Má skupiny'
        );
        $disabledGroups = array(0 => 0);

        $extraGroups = array(
            'class' => 'form-select',
            'id' => 'groups'
        );
        //data pro input se skupinama
        $dataGroups = array(
            'name' => 'groupsList[]',
            'id' => 'groupsList',
            'required' => 'required',
            'placeholder' => 'b',
            'class' => 'remove'
        );
        //dropdown pro skupiny
        $optionsGroupsType = array(
            0 => 'Vyber hodnotu',
            1 =>  'Základní skupina',
            2 => 'Finálová část'
        );

        $extraGroupsType = array(
            'class' => 'form-select remove',
            'id' => 'groupsType'
        );
        //přiat další skupinu
        $data_button_add = array(
            'name' => 'add_group[]',
            'id' => 'add_group',
            'type' => 'button',
            'class' => 'btn btn-primary',
            'content' => 'Přidat další skupinu'
        );
       // var_dump($sezony);
        foreach ($sezony as $sezona) {
            $casSezony = $sezona->start . "-" . $sezona->finish;
            $options[$sezona->id_season] = $casSezony;
            if (!is_null($sezona->id_league_season)) {
                $disabled[] = $sezona->id_season;
            }
        }
       // var_dump($options);

        ?>

        <?= form_input_bs($dataGeneralName, $form["divInputClass"], "Obecný název ligy"); ?>
        <?= form_button($data_button_general_name); ?>
        <?= form_input_bs($dataName, $form["divInputClass"], "Název ligy v sezóně"); ?>
        <?= form_input_bs($dataLogo, $form["divInputClass"], "Logo ligy v této sezóně", 'file', false); ?>
        <?= form_dropdown_bs('season', $options, $extra, 'mb-3', "Vyber sezónu", $disabled, $selected) ?>
        <?= form_dropdown_bs('groups', $optionsGroups, $extraGroups, 'mb-3', "Skupiny", $disabledGroups, $selected) ?>
        <?= form_hidden('id_league', $liga->id_league) ?>
        <?= form_hidden('id_association', $liga->id_association) ?>
        <div id="groupsDiv"></div>

        <?= form_button($data_button_add) ?>
        <?= form_button($form["submitButton"]) ?>

        <?php
        echo form_close();
        ?>
    </div>
</div>
<script>
   /* $(document).ready(function(){
        $('#add_group').hide();
    });*/

    $("#general_name_button").click(function() {
        let text = $('#general_name').val();
        $('#name').val(text);
    });

    $("#groups").change(function() {
        let groups = $('#groups').val()
        if (groups == 2) {
            let input = '<?= form_input_bs($dataGroups, $form["divInputClass"], "Název skupiny", 'text', true, false);  ?>';
            let dropDown = '<?= form_dropdown_bs('groupsType[]', $optionsGroupsType, $extraGroupsType, "mb-3", "Typ skupiny", $disabledGroups, $selected,[] , false);  ?>';


            $('#groupsDiv').prepend(dropDown);
            $('#groupsDiv').prepend(input);
            $('#add_group').show();

        } else {
            $('#groupsDiv').children().empty('.remove');
            $('#add_group').hide();
        }
    });

    $('#add_group').click(function() {
        let input = '<?= form_input_bs($dataGroups, $form["divInputClass"], "Název skupiny", 'text', true, false);  ?>';
        let dropDown = $('<?= form_dropdown_bs('groupsType[]', $optionsGroupsType, $extraGroupsType, "mb-3", "Typ skupiny", $disabledGroups, $selected, [], false);  ?>');

        $('#groupsDiv').append(input);
        $('#groupsDiv').append(dropDown);
        
    });
</script>

<?= $this->endSection(); ?>