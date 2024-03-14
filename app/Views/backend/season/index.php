<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Seznam sezón</h1>
<div class="row">
    <div class="col-md-6">


        <?php
        $data = array(
            'class' => $form['addClass']." mb-3"
        );
        echo anchor('admin/sezona/pridat', $form['addBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Sezóna', '');
        foreach ($sezony as $key =>  $row) {
            $nazevSezony = $row->start . "-" . $row->finish;
            $dataEdit = array(
                'class' => $form['editClass'],
                'content' => $form['editBtn'],
                'type' => 'button'
            );
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/sezona/' . $row->id_season . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $row->id_season, "Smazat sezonu", "Chceš opravdu smazat sezónu " . $row->start . "-" . $row->finish . "?", "admin/sezona/" . $row->id_season . "/delete");
            echo "<!-- konec modalu -->\n";


            $table->addRow($nazevSezony, $editBtn . $deleteBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>