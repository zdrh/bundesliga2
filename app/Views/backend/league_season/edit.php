<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Editovat sezónu ligy <?= $league->name ?></h1>
<div class="row">
    <div class="col-md-4">
        <?php

        echo form_open_multipart('admin/liga/sezona/update');

        $dataGeneralName = array(
            'name' => 'general_name',
            'id' => 'general_name',
            'required' => 'required',
            'disabled' => 'disabled',
            'value' => $league->name
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
            'value' =>  $league_season->league_name_in_season
        );

        $dataLogo = array(
            'name' => 'logo',
            'id' => 'logo',
            'accept' => '.jpg, .png'
        );


        $options = array(
            0 => "Vyber hodnotu"
        );
        $disabled = array(0 => 0);

        $selected[] = $league_season->id_league_season;
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

        $selectedGroups[] = $league_season->groups;
        $disabledGroups = array(0 => 0);

        $extraGroups = array(
            'class' => 'form-select',
            'id' => 'groups'
        );
        //dropdown pro skupiny
        $optionsGroupsType = array(
            0 => 'Vyber hodnotu',
            1 =>  'Základní skupina',
            2 => 'Finálová část'
        );
 //data pro input se skupinama
 $dataGroups = array(
    'name' => 'groupsList[]',
    'id' => 'groupsList',
    'required' => 'required',
    
    'class' => 'remove'
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
       
        foreach ($sezony as $sezona) {
            $casSezony = $sezona->start . "-" . $sezona->finish;
            $options[$sezona->id_season] = $casSezony;
            if (!is_null($sezona->id_league_season) and $sezona->id_league_season != $league_season->id_league_season) {
                
                $disabled[] = $sezona->id_season;
            } 
        }


        ?>

        <?= form_input_bs($dataGeneralName, $form["divInputClass"], "Obecný název ligy"); ?>
        <?= form_button($data_button_general_name); ?>
        <?= form_input_bs($dataName, $form["divInputClass"], "Název ligy v sezóně"); ?>
        <div>

            <?php

            $data = array(
                'src' => $uploadPath["logoLeague"] . $league_season->logo,
                'class' => 'edit'
            );
            echo img($data);

            ?>
        </div>
        <?= form_input_bs($dataLogo, $form["divInputClass"], "Logo ligy v této sezóně", 'file', false); ?>
        <?= form_dropdown_bs('season', $options, $extra, 'mb-3', "Vyber sezónu", $disabled, $selected) ?>
        <?= form_dropdown_bs('groups', $optionsGroups, $extraGroups, 'mb-3', "Skupiny", $disabledGroups, $selectedGroups) ?>
        <?= form_hidden('id_league_season', $league_season->id_league_season) ?>
        <?= form_hidden('id_league', $league->id_league) ?>
        <?= form_hidden('id_assoc_season', $league_season->id_assoc_season) ?>
        <?= form_hidden('_method', 'PUT') ?>
       
           

       
        <?= form_button($form["submitButton"]) ?>

        <?php
        echo form_close();
        ?>
    </div>
</div>
<script>
  

    $("#general_name_button").click(function() {
        let text = $('#general_name').val();
        $('#name').val(text);
    });

   
</script>

<?= $this->endSection(); ?>