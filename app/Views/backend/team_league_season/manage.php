<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
    /**
     * @var object $team
     */
?>
<h1>Správa týmu <?= $team->team_name_in_season ?></h1>
<h2>Přiřadit hráče do týmu</h2>

<h2>Přiřadit trenéra do týmu</h2>
<?= $this->endSection(); ?>