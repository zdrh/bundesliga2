<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat stát</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/zeme/create');
        $dataName = array(
            'name' => 'name[]',
            'id' => 'name',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $dataShortName = array(
            'name' => 'short_name[]',
            'id' => 'short_name',
            'required' => 'required',
            'placeholder' => 'a'
        );


        ?>

        <div id="country_form">

            <?= form_input_bs($dataName, $form["divInputClass"], "Název státu"); ?>


            <?= form_input_bs($dataShortName, $form["divInputClass"], "Zkratka státu"); ?>



        </div>
        <?php

        $data_button_add = array(
            'name' => 'add_country',
            'id' => 'add_country',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další stát'
        );
        echo form_button($data_button_add);


        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<script>
    //document.getElementById('start-').setAttribute('id', 'start-0');
    //document.getElementById('finish-').setAttribute('id', 'finish-0');
       
    $("button#add_country").click(function() {
        
        value = "<hr><?php echo form_input_bs($dataName, $form["divInputClass"], 'Název státu', 'text', true, false) . form_input_bs($dataShortName, $form["divInputClass"], 'Zkratka státu', 'text', true, false);?>";
        newDiv = $("<div></div>").html(value).attr("id", "newDiv");
        $("#country_form").append(newDiv);

    });
</script>

    <?= $this->endSection(); ?>