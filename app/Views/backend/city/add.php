<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat město</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/mesto/create');
        $dataNameDe = array(
            'name' => 'name_de[]',
            'id' => 'name_de',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $dataNameCz = array(
            'name' => 'name_cz[]',
            'id' => 'name_cz',
            'required' => 'required',
            'placeholder' => 'a'
        );


        ?>

        <div id="city_form">

            <?= form_input_bs($dataNameDe, $form["divInputClass"], "Název německy"); ?>


            <?= form_input_bs($dataNameCz, $form["divInputClass"], "Název česky"); ?>



        </div>
        <?php

        $data_button_add = array(
            'name' => 'add_city',
            'id' => 'add_city',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další město'
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
       
    $("button#add_city").click(function() {
        
        value = "<hr><?php echo form_input_bs($dataNameDe, $form["divInputClass"], 'Název německy', 'text', true, false) . form_input_bs($dataNameCz, $form["divInputClass"], 'Název česky', 'text', true, false);?>";
        newDiv = $("<div></div>").html(value).attr("id", "newDiv");
        $("#city_form").append(newDiv);

    });
</script>

    <?= $this->endSection(); ?>