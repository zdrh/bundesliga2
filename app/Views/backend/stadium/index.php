<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Seznam stadionů</h1>
<div class="row">
    <div class="col-md-10">


        <?php
        $data = array(
            'class' => $form['addClass']." mb-3"
        );
        echo anchor('admin/stadion/pridat', $form['addBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Název stadionu','Město', 'Zem. šířka', 'Zem. délka');
        foreach ($stadion as $key =>  $row) {
            $dataEdit = array(
                'class' => $form['editClass'],
                'content' => $form['editBtn'],
                'type' => 'button'
            );
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/stadion/' . $row->id_stadium . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $row->id_stadium, "Smazat stadion", "Chceš opravdu smazat stadion " . $row->general_name ."?", "admin/stadion/" . $row->id_stadium . "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'].' ms-3'
            );
           
            $table->addRow($row->general_name, $row->name_de,$row->latitude, $row->longtitude, $editBtn . $deleteBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        echo $pager->links();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>