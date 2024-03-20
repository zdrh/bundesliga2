<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Seznam Lig</h1>
<div class="row">
    <div class="col-md-10">


        <?php
        $data = array(
            'class' => $form['addClass']." mb-3"
        );
        echo anchor('admin/liga/pridat', $form['addBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Liga','Úroveň', 'Aktivní', 'Organizátor', '');
        foreach ($ligy as $key =>  $row) {
            /*$dataEdit = array(
                'class' => $form['editClass'],
                'content' => $form['editBtn'],
                'type' => 'button'
            );*/
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/liga/' . $row->id_league . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $row->id_association, "Smazat ligu", "Chceš opravdu smazat ligu " . $row->name ."?", "admin/liga/" . $row->id_league . "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'].' ms-3'
            );
           
           
            $listSeasonBtn = anchor("admin/liga/".$row->id_league."/seznam-sezon",  $form['listBtn']." Sezony", $data);

            $table->addRow($row->name, $row->level, $row->active, $row->general_name, $editBtn . $deleteBtn. $listSeasonBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>