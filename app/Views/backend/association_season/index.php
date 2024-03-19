<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1><?= $svaz->general_name ?></h1>
<h2>Přehled soutěží</h2>

<h2>Přehled sezón</h2>
<div class="row">
    <div class="col-md-10">


        <?php
        $data = array(
            'class' => $form['addClass'] . " mb-3"
        );
        echo anchor('admin/svaz/' . $svaz->id_association . '/sezona/pridat', $form['addBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Sezóna', 'Název', 'Logo', 'Pořádané soutěže (obecný název)', '');

        foreach ($sezony as $key =>  $row) {
            $row2 = $row[0];
            //sloupec sezona
            $sezonaCas = $row2->start . "-" . $row2->finish;
            //sloupec logo
            $dataImg = array(
                'src' => $uploadPath['logoAssoc'] . $row2->logo,
                'class' => 'table'
            );
            $logo = img($dataImg);
            //sloupec soutěže
            $soutez = "";

            foreach ($row as $key3 => $row3) {
                if (!is_null($row3->league_name)) {
                    if ($key3 > 0) {
                        $soutez .= " ";
                    }
                    $soutez .= $row3->league_name_in_season . " (" . $row3->league_name . ")";
                }
            }

            //buttony
            $dataEdit = array(
                'class' => $form['editClass'],
                'content' => $form['editBtn'],
                'type' => 'button'
            );
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/svaz/' . $svaz->id_association . '/sezona/' . $row2->id_season . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $svaz->id_association, "Smazat sezonu", "Chceš opravdu smazat sezonu " . $sezonaCas . " pro svaz " . $row2->assoc_name . "?", "admin/svaz/" . $svaz->id_association . "/sezona/" . $row2->id_season . "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'] . ' ms-3'
            );
            $listSeasonAsocBtn = anchor("admin/svaz/" . $svaz->id_association . "/seznam-sezon",  $form['listBtn'] . " Sezony", $data);
            $table->addRow($sezonaCas, $row2->assoc_name, $logo, $soutez, $editBtn . $deleteBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>