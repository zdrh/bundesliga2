<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat sezónu svazu <?= $svaz->general_name ?></h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open_multipart('admin/svaz/sezona/create');

        $dataGeneralName = array(
            'name' => 'general_name',
            'id' => 'general_name',
            'required' => 'required',
            'disabled' => 'disabled',
            'value' => $svaz->general_name
        );

        
        $data_button_general_name = array(
            'name' => 'general_name_button',
            'id' => 'general_name_button',
            'type' => 'button',
            'class' => 'btn btn-primary mb-3',
            'content' => 'Pro tuto sezónu použít obecný název svazu'
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
        $disabled = array(0 => '');
        $selected[0] = '';
        $extra = array(
            'class' => 'form-select',
            'id' => 'season'
        );
        foreach($sezony as $sezona) {
            $casSezony = $sezona->start."-".$sezona->finish;
            $options[$sezona->id_season] = $casSezony;
            if(!is_null($sezona->id_association)) {
                $disabled[] = $sezona->id_season;
            }
           
        }
        
       
        ?>
        <?= form_input_bs($dataGeneralName, $form["divInputClass"], "Obecný název svazu"); ?>
        <?= form_button($data_button_general_name); ?>
        <?= form_input_bs($dataName, $form["divInputClass"], "Název svazu v sezóně"); ?>
        <?= form_input_bs($dataLogo, $form["divInputClass"], "Logo svazu v této sezóně", 'file', false); ?>
        <?= form_dropdown_bs('season', $options, $extra, 'mb-3' ,"Vyber sezónu", $disabled, $selected) ?>
        <?= form_hidden('id_association', $svaz->id_association) ?>
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