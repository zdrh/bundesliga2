<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
/**
 * @var array $form
 * @var array $seznamTypu
 * @var array $tableTemplate
 */
?>
<h1>Seznam typů</h1>
<div class="row">
    <div class="col-md-4">

        <div>
            <?php
            $data = array(
                'class' => $form['addClass'] . " mb-3"
            );

            echo anchor('admin/typ-zdroje/pridat', $form['addBtn'] . " typ zdroje", $data);
            ?>
        </div>
        <?php
       
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Typ zdroje', 'Správa');
        foreach ($seznamTypu as $key => $row) {
        $dataEdit = array(
        'class' => $form['editClass'],
        'content' => $form['editBtn'],
        'type' => 'button'
        );
        $data = array(
        'class' => $form['editClass']
        );
        $editBtn = anchor('admin/type-zdroje/' . $row->id_source_type . '/edit', $form['editBtn'], $data);
        $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


        echo "<!-- začátek modalu -->\n";
        echo form_modal_delete("modal" . $key, $row->id_source_type, "Smazat typ zdroje", "Chceš opravdu smazat type zdroje " . $row->name ."?", "admin/typ-zdroje/" . $row->id_source_type . "/delete");
        echo "<!-- konec modalu -->\n";
        $data = array(
        'class' => $form['listClass'].' ms-3'
        );

        $table->addRow($row->name, $editBtn . $deleteBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();


        ?>

    </div>
</div>

<?= $this->endSection(); ?>