<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
/**
 * @var object $liga
 * @var array $uploadPath
 * @var array $sezony
 * @var array $form
 * 
 */
?>
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

        $data_copy_previous_season = array(
            'name' => 'copy_previous',
            'id' => 'copy_previous',
            'type' => 'button',
            'class' => 'btn btn-primary mb-2',
            'content' => 'Zkopírovat z předchozí sezóny'
        );

        $data_logo_hidden = array(
            'type' => 'hidden',
            'id' => 'logo_string',
            'name' => 'logo_string',
            'value' => ''

        );

        $data_img_hidden = array(
            'id' => 'logo_img',
            'class' => 'edit',
            // 'src' => $uploadPath["logoLeague"],
            'visibility' => 'hidden'
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

        <?= form_input_bs('general_name', $dataGeneralName, "Obecný název ligy"); ?>
        <?= form_dropdown_bs('season', $options, $extra, "Vyber sezónu", $selected, $disabled) ?>
        <?= form_button($data_copy_previous_season); ?>
        <?= form_button($data_button_general_name); ?>
        <?= form_input_bs('name', $dataName, "Název ligy v sezóně"); ?>
        <?= img($data_img_hidden) ?>
        <?= form_input_bs('logo', $dataLogo, "Logo ligy v této sezóně", 'file', false); ?>

        <?= form_dropdown_bs('groups', $optionsGroups, $extraGroups, "Skupiny", $selected, $disabledGroups) ?>
        <?= form_hidden('id_league', $liga->id_league) ?>
        <?= form_hidden('id_association', $liga->id_association) ?>
        <?= form_input($data_logo_hidden) ?>
        <div id="groupsDiv"></div>

        <?= form_button($data_button_add) ?>
        <?= form_button($form["submitButton"]) ?>

        <?php
        echo form_close();
        ?>
    </div>
</div>
<template id="group">
    <?= form_input_bs('groupsList[]', $dataGroups, "Název skupiny", 'text', true);  ?>
    <?= form_dropdown_bs('groupsType[]', $optionsGroupsType, $extraGroupsType, "Typ skupiny", $selected, $disabledGroups);  ?>
</template>
<template id="group-revert">
    <?= form_dropdown_bs('groupsType[]', $optionsGroupsType, $extraGroupsType, "Typ skupiny", $selected, $disabledGroups);  ?>
    <?= form_input_bs('groupsList[]', $dataGroups, "Název skupiny", 'text', true);  ?>
</template>
<script>
    $("#general_name_button").click(function() {
        let text = $('#general_name').val();
        $('#name').val(text);
    });

    $("#groups").change(function() {
        let groups = $('#groups').val()
        if (groups == 2) {
            const clone = $('#group-revert').contents().clone();
            $('#groupsDiv').prepend(clone);
            $('#add_group').show();

        } else {
            $('#groupsDiv').children().empty('.remove');
            $('#add_group').hide();
        }
    });

    $('#add_group').click(function() {

        const clone = $('#group').contents().clone();
        $('#groupsDiv').append(clone);
    });

    $('#copy_previous').click(function() {
        let season = $('#league').val();
        let seasonData = <?= json_encode($sezony); ?>;
        let id = findPrevious(seasonData, season, 'id_season', 'start');
        let values = seasonData[id];
        //console.log(values['logo']);
        $('#name').val(values['league_name_in_season']);
        $('#logo_string').val(values['logo']);
        $('#groups').val(values['groups']);
        $('#logo_img').attr('visibility', 'visible');
        let path = "<?= $uploadPath["logoLeague"] ?>" + values['logo'];
        //console.log(path);
        $('#logo_img').attr('src', '<?= base_url() ?>' + path);
        $('#logo').removeAttr('required');

        //console.log(season);
    });

    function findPrevious(array, value, attr, attr2) {
        let result = 0;
        array.forEach(function(value2, index) {
            if (value == value2[attr]) {
                if (index > 0) {
                    result = index - 1;
                } else {
                    result = index;
                }
            }
        });
        return result;
    }
</script>

<?= $this->endSection(); ?>