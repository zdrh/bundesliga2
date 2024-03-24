<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1><?= $liga->name ?></h1>

<h2>Přehled sezón</h2>
<div class="row">
    <div class="col-md-12">


        <?php
        $data = array(
            'class' => $form['addClass'] . " mb-3"
        );
        echo anchor('admin/liga/' . $liga->id_league . '/sezona/pridat', $form['addBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Sezóna', 'Název ligy', 'Logo', 'Organizátor', 'Skupiny','');
        foreach ($sezony as $key =>  $row) {

            //sloupec sezona
            $sezonaCas = $row->start . "-" . $row->finish;
            //sloupec logo
            $dataImg = array(
                'src' => $uploadPath['logoLeague'] . $row->logo,
                'class' => 'table'
            );
            $logo = img($dataImg);
            //sloupec skupiny
            if ($row->groups == 2) {
                $skupiny = "ano";
            } else {
                $skupiny = "ne";
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

            $dataList = array(
                'class' => $form['listClass']. ' ms-3'
            );
            $editBtn = anchor('admin/liga/' . $liga->id_league . '/sezona/' . $row->id_season . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";

            //button na správu skupin
            if ($row->groups == 2) {
                $listBtn = anchor('admin/liga/' . $liga->id_league . '/sezona/' . $row->id_season . '/sprava-skupin', $form['listBtn']." Správa skupin", $dataList);
            } else {
               
                $listBtn = "";
            }
            //button na info o lize
            $dataTable = array(
                'class' => $form['listClass'].' ms-3'
            );
           
            $listSeasonBtn = anchor("admin/liga/".$row->id_league_season."/info",  $form['listBtn']." O sezóně", $dataTable);


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $liga->id_league, "Smazat sezonu ligy", "Chceš opravdu smazat sezonu " . $sezonaCas . " pro ligu " . $row->league_name . "?", "admin/ligaz/" . $liga->id_league . "/sezona/" . $row->id_season . "/delete");
            echo "<!-- konec modalu -->\n";
           
            $table->addRow($sezonaCas, $row->league_name_in_season, $logo, $row->association_name, $skupiny, $editBtn . $deleteBtn . $listBtn . $listSeasonBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>