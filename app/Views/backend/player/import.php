<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Import hráčů</h1>
<p>Přidává data do tabulky hráčů. CSV musí mít celkem 5 sloupců v pořadí - křestní jméno, příjmení, datum narození (yyyy-mm-dd), id města narození,ukončil kariéru (0|1), datum úmrtí (yyyy-mm-dd, pokud žije, nechat prázdné), id země. </p>
<div class="row">
    <div class="col-md-4">


        <?php


        echo form_open_multipart('admin/hrac/createImport');

        $data = array(
            'name' => 'import',
            'id' => 'import',
            'required' => 'required',
            'accept' => '*.csv, *.txt'
        );
        ?>

        <?= form_input_bs($data, $form["divInputClass"], 'Importovat hráče', 'file'); ?>
        <?= form_button($form['submitButton']); ?>
        </form>

    </div>
</div>
<?= $this->endSection(); ?>