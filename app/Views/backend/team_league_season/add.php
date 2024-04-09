<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
if (!is_null($skupina->groupname)) {
    $groupName = " (skupina " . $skupina->groupname . ")";
} else {
    $groupName = "";
}

?>
<h1>Přidat týmy do ligy <?= $skupina->league_name_in_season ?><?= $groupName ?> ročník <?= $skupina->start ?>/<?= $skupina->finish  ?></h1>

<?php

echo form_open('admin/liga/tym/create');




$selectedGroups = array();
$disabledGroups = array();
$extraGroups = array(
    'class' => 'form-select',
    'id' => 'team',
    'multiple' => 'multiple'
);
?>

<?= form_dropdown_bs('team[]', $tymy, $extraGroups, 'mb-3', "Týmy", $disabledGroups, $selectedGroups) ?>
<?= form_hidden('id_group', $skupina->id_league_season_group); ?>
<?= form_button($form["submitButton"]) ?>

<?php
echo form_close();
?>
<script>
    let demo2 = $('#team').bootstrapDualListbox({
  nonSelectedListLabel: 'K dispozici',
  selectedListLabel: 'V soutěži',
  preserveSelectionOnMove: 'moved',
  moveOnSelect: false,
  infoText: "Zobrazeno týmů: {0}",
  infoTextEmpty: "Žádné týmy",
  selectorMinimalHeight: 200
});
</script>


<?= $this->endSection(); ?>