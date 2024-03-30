<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Import týmů</h1>
<p>Přidává data do tabulky týmů. CSV musí mít celkem 5 sloupců v pořadí - rok založení, název týmu, zkratka týmu, rok rozpuštění klubu a id nástupoce klubu. Pokud klub stále existuje, tak poslední dva sloupce zůstávají prázdné.</p>
<div class="row">
    <div class="col-md-4">


        <?php


        echo form_open_multipart('admin/tym/createImport');

        $data = array(
            'name' => 'import',
            'id' => 'import',
            'required' => 'required',
            'accept' => '*.csv, *.txt'
        );
        ?>

        <?= form_input_bs($data, $form["divInputClass"], 'Importovat týmy', 'file'); ?>
        <?= form_button($form['submitButton']); ?>
        </form>

    </div>
</div>
<?= $this->endSection(); ?>