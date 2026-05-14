<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat stadion</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/stadion/create');
        $generalName = array(
            'name' => 'general_name[]',
            'id' => 'general_name',
            'required' => 'required',
            'placeholder' => 'b'
        );

        $latitude = array(
            'name' => 'latitude[]',
            'id' => 'latitude',
            'required' => 'required',
            'placeholder' => 'a'
        );

        $longtitude = array(
            'name' => 'longtitude[]',
            'id' => 'longtitude',
            'required' => 'required',
            'placeholder' => 'a'
        );

        $optionsCity = array(
            '' => "Vyber město"
        );



        foreach ($city as $row) {
            $optionsCity[$row->id_city] = $row->name_de;
           
        }

        $extra = array(
            'class' => 'form-select select2-basic-single',
            'id' => 'city',
            'data-placeholder' => 'Vyber město'
        );

        $disabled = array(0 => '');
        $selected[0] = '';
        ?>

        <div id="stadium_form">

            <?= form_input_bs($generalName, $form["divInputClass"], "Název stadionu"); ?>

            <?= form_input_bs($latitude, $form["divInputClass"], "Zeměpisná šířka"); ?>
            <?= form_input_bs($longtitude, $form["divInputClass"], "Zeměpisná délka"); ?>
            <?= form_dropdown_bs('city[]', $optionsCity, $extra, 'mb-3' ,"Vyber město", $disabled, $selected) ?>


        </div>
        <?php

        $data_button_add = array(
            'name' => 'add_stadium',
            'id' => 'add_stadium',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další stadion'
        );
        echo form_button($data_button_add);


        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>

<script>
     $(document).ready(function() {
    $('.select2-basic-single').select2();
});
     
    $("button#add_stadium").click(function() {
        
        value = "<hr><?php echo form_input_bs($generalName, $form["divInputClass"], 'Název stadionu', 'text', true, false) . form_input_bs($latitude, $form["divInputClass"], 'Zeměpisná šířka', 'text', true, false). form_input_bs($longtitude, $form["divInputClass"], 'Zeměpisná délka', 'text', true, false).form_dropdown_bs('city[]', $optionsCity, $extra, 'mb-3' ,"Vyber město", $disabled, $selected,[], false);?>";
        newDiv = $("<div></div>").html(value).attr("id", "newDiv");
        $("#stadium_form").append(newDiv);
        $('.select2-basic-single').select2();


    });

    $( '#city' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );
</script>

    <?= $this->endSection(); ?>