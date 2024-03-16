<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přidat sezónu</h1>
<div class="row">
    <div class="col-md-4">
        <?php
        echo form_open('admin/sezona/create');
        $dataStart = array(
            'name' => 'start[]',
            'id' => 'start-',
            'min' => $year['league_season_min'],
            'max' => $year['league_season_max'],
            'step' => 1,
            'required' => 'required',
            'oninput' => 'startFinishSeason()',

        );
        $js = array(
            'oninput' => 'startFinishSeason()'
        );
        $dataFinish = array(
            'name' => 'finish[]',
            'id' => 'finish-',
            'min' => $year['league_season_min'],
            'max' => $year['league_season_max'],
            'step' => 1,
            'required' => 'required',


        );

        $attr = array(
            'id' => 'season_form'
        );
        ?>

        <div id="season_form">
            <?= form_input_bs($dataStart, $form["divInputClass"], "Začátek", "number", false); ?>


            <?= form_input_bs($dataFinish, $form["divInputClass"], "Konec", "number", false); ?>

        </div>
        <?php



        $data_button_add = array(
            'name' => 'add_season',
            'id' => 'add_season',
            'type' => 'button',
            'class' => 'btn btn-primary me-3',
            'content' => 'Přidat další sezónu'
        );
        echo form_button($data_button_add);
        echo form_button($form["submitButton"]);
        echo form_close();
        ?>
    </div>
</div>
<script>
    $('input#start-').attr("id", "start-0");
    $('input#finish-').attr("id", "finish-0");
    //document.getElementById('start-').setAttribute('id', 'start-0');
    //document.getElementById('finish-').setAttribute('id', 'finish-0');
    key = 1;
    $("#add_season").click(function() {
        value = "<hr><?php echo form_input_bs($dataStart, $form["divInputClass"], 'Začátek', 'number', false, false) . form_input_bs($dataFinish, $form["divInputClass"], 'Konec', 'number', false, false) ?>";
        newDiv = $("<div></div>").html(value).attr("id", "newDiv");
        $("#season_form").append(newDiv);
        $("#start-").attr("id", "start-" + key);
        $("#finish-").attr("id", "finish-" + key);
        key++;
    });
   // document.getElementById('add_season').addEventListener('click', function() {


        //newdiv = document.createElement('div');
        //newdiv.innerHTML = value;
        //$("#season_form").append(newDiv);
        //document.getElementById('season_form').appendChild(newdiv);
        //newdiv.setAttribute('id', 'newdiv');
        //document.getElementById('start-').setAttribute('id', 'start-'+key);
        //document.getElementById('finish-').setAttribute('id', 'finish-0'+key);
        //key++;
    //});

    function startFinishSeason() {
    let id = $(document.activeElement).prop('id');
    
    let elValue = parseInt($(document.activeElement).val())+1;
    let key = id.split("-");
    if(key[0] == "start") {
        let classInput = "finish-" + key[1];
        $('input#'+classInput).val(elValue);
    }
    //const key = id.split("-")[1];
   // startValue = Number(startElement.value);
   // let finishValue = startValue + 1;
   // console.log(key);

}

</script>

<?= $this->endSection(); ?>