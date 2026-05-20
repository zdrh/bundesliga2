<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
/**
 * @var object $liga
 * @var array $rozhodci
 * @var array $vybraniRozhodci
 * @var array $form
 */
?>
<h1>Přidat rozhodčí do soutěže <?= $liga->league_name_in_season ?> ročník <?= $liga->start ?>/<?= $liga->finish ?></h1>
<div class="row">
    <div class="col-md-5">
        <?php
        $extra = [
            'multiple' => 'multiple',
            'class' => 'rozhodci',
            'id' => 'rozhodci',
            'data-placeholder' => 'Vyber rozhodčí'
        ];
        echo form_open('admin/liga/'.$liga->id_league_season.'/rozhodci/create');
        echo form_dropdown_bs('referee[]', $rozhodci, $extra, 'Vyber rozhodčí daného ročníku', [], $vybraniRozhodci, []);
        ?>
        <?= form_hidden('id_league_season', $liga->id_league_season); ?>
        <?= form_button($form["submitButton"]) ?>
        <?= form_close(); ?>
    </div>
</div>
<script>
    $('#rozhodci').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: true,
    });
</script>
<?= $this->endSection(); ?>