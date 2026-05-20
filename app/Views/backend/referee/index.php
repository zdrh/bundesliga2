<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
    /**
     * @var object $liga
     */
?>
<h1>Seznam rozhodčích v soutěži <?= $liga->league_name_in_season ?> v sezoně <?=  $liga->start ?>/<?= $liga->finish ?></h1>
<?php
    var_dump($liga);
?>

<?= $this->endSection(); ?>