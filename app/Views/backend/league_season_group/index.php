<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Přehled skupin <?= $liga->league_name_in_season ?> ročník <?= $liga->start  ?>/<?= $liga->finish ?></h1>


<div class="row">
    <div class="col-md-12">


        <?php
        $data = array(
            'class' => $form['addClass'] . " mb-3"
        );
        echo anchor('admin/liga/' . $liga->id_league . '/sezona/'.$liga->id_season.'/skupina/pridat', $form['addBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Název skupiny', 'Typ','');
       
        foreach ($skupiny as $key => $row) {
            if($row->regular == 1) {
                $type = 'Základní skupina';
            } else {
                $type = 'Finálová skupina';
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
            $editBtn = anchor('admin/liga/' . $liga->id_league . '/sezona/' . $liga->id_season . '/skupina/'.$row->id_league_season_group.'/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";

           


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $row->id_league_season_group, "Smazat skupinu ligy", "Chceš opravdu smazat skupinu " . $row->groupname . " pro ligu " . $liga->league_name_in_season . "?", "admin/liga/" . $liga->id_league . "/sezona/" . $liga->id_season . "/skupina/".$row->id_league_season_group."/delete");
            echo "<!-- konec modalu -->\n";
           
            $table->addRow($row->groupname, $type , $editBtn . $deleteBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>