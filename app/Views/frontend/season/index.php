<?= $this->extend('layout/frontend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Vyber sezónu, kterou chceš zobrazit</h1>

<?php
    echo form_open('sezona/view');
    $options = array();
    $options[''] = "Vyber sezónu";
    $selected[] = '';
    $disabled[] = '';
    $extra['class'] = 'form-control';
    foreach($sezony as $key => $row) {
        $options[$key] = $row;
    }

    echo form_dropdown_bs('season', $options,$extra, 'mb-3', '',$disabled, $selected);
    echo form_button($form['submitButton']);
    echo form_close();
?>



    <?= $this->endSection(); ?>