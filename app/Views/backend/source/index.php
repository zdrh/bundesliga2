<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
/**
 * @var array $form
 * @var array $seznamZdroju
 * @var array $tableTemplate
 * @var object $pager
 */
?>
<h1>Seznam zdrojů</h1>
<div class="row">
    <div class="col-md-10">
 <div>
            <?php
            $data = array(
                'class' => $form['manageClass'] . " mb-3"
            );

            echo anchor('admin/seznam-typu-zdroju', $form['manageBtn'] . " typů zdrojů", $data);
            ?>
        </div>

        <div>
            <?php
            $data = array(
                'class' => $form['addClass'] . " mb-3"
            );

            echo anchor('admin/zdroj/pridat', $form['addBtn'] . " zdroj", $data);
            ?>
        </div>
        <?php

        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Název zdroje', 'Druh zdroje', 'Správa');
        foreach ($seznamZdroju as $key => $row) {
            $dataEdit = array(
                'class' => $form['editClass'],
                'content' => $form['editBtn'],
                'type' => 'button'
            );
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/zdroj/' . $row->id_source . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal_delete("modal" . $key, $row->id_source, "Smazat zdroj", "Chceš opravdu smazat zdroj " . $row->NazevZdroje . "?", "admin/zdroj/" . $row->id_source . "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'] . ' ms-3'
            );

            $table->addRow($row->NazevZdroje, $row->NazevTypu, $editBtn . $deleteBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();


        ?>

    </div>
</div>

<?= $this->endSection(); ?>