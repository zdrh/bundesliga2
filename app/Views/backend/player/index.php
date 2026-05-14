<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Seznam hráčů</h1>
<div class="row">
    <div class="col-md-10">


        <?php
        $data = array(
            'class' => $form['addClass']." mb-3 me-3"
        );
        echo anchor('admin/hrac/pridat', $form['addBtn'], $data);
        echo anchor('admin/hrac/import', $form['importBtn'], $data);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Jméno','Příjmení', 'Narození','Místo narození', 'Úmrtí', 'Konec kariéry', 'Země', '');
        foreach ($player as $key =>  $row) {
            $dataEdit = array(
                'class' => $form['editClass'],
                'content' => $form['editBtn'],
                'type' => 'button'
            );
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/hrac/' . $row->id_player . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal("modal" . $key, $row->id_player, "Smazat hráče", "Chceš opravdu smazat stát " . $row->first_name . " " . $row->last_name . "?", "admin/hrac/" . $row->id_player . "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'].' ms-3'
            );
            $narozen = $row->name_de." - ".$row->city_country;
            $datumNarozeni = date('j.n.Y', strtotime($row->born));
            if(is_null($row->death)) {
                $datumUmrti = "";
            } else {
                $datumUmrti = date('j.n.Y', strtotime($row->death));
            }
            if($row->retire) {
                $konec = "Ano";
            } else {
                $konec = "Ne";
            }
            $zeme = "<span class=\"fi fi-".$row->short_name."\"></span> ".$row->name;
            $table->addRow($row->first_name, $row->last_name, $datumNarozeni, $narozen, $datumUmrti, $konec, $zeme, $editBtn . $deleteBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();

        echo $pager->links();

        ?>

    </div>
</div>
<?= $this->endSection(); ?>