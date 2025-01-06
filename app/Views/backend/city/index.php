<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Seznam měst</h1>
<div class="row">
    <div class="col-md-10">


        <?php
        $data = array(
            'class' => $form['addClass']." mb-3"
        );
        echo anchor('admin/mesto/pridat', $form['addBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Název německy','Název česky');
        foreach ($city as $key =>  $row) {
            $dataEdit = array(
                'class' => $form['editClass'],
                'content' => $form['editBtn'],
                'type' => 'button'
            );
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/mesto/' . $row->id_city . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $row->id_city, "Smazat město", "Chceš opravdu smazat město " . $row->name_de ."?", "admin/mesto/" . $row->id_city . "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'].' ms-3'
            );
           
            $table->addRow($row->name_de, $row->name_cz, $editBtn . $deleteBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        echo $pager->links();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>