<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Seznam asociací</h1>
<div class="row">
    <div class="col-md-10">


        <?php
        $data = array(
            'class' => $form['addClass']." mb-3"
        );
        echo anchor('admin/svaz/pridat', $form['addBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Svaz','Zkratka', 'Rok založení', '');
        foreach ($svazy as $key =>  $row) {
            $dataEdit = array(
                'class' => $form['editClass'],
                'content' => $form['editBtn'],
                'type' => 'button'
            );
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/svaz/' . $row->id_association . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $row->id_association, "Smazat svaz", "Chceš opravdu smazat svaz " . $row->general_name ."?", "admin/svaz/" . $row->id_association . "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'].' ms-3'
            );
            $listSeasonAsocBtn = anchor("admin/svaz/".$row->id_association."/seznam-sezon",  $form['listBtn']." Sezony", $data);
            $table->addRow($row->general_name, $row->short_name, $row->founded, $editBtn . $deleteBtn. $listSeasonAsocBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>