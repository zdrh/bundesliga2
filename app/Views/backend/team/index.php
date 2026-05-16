<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
    /**
     * @var array $form
     * @var array $tymy
     * @var array $tableTemplate
     * @var object $pager
     */
?>
<h1>Seznam týmů</h1>
<div class="row">
    <div class="col-md-10">


        <?php
        $data = array(
            'class' => $form['addClass']." mb-3 me-3"
        );
        echo anchor('admin/tym/pridat', $form['addBtn'], $data);
        echo anchor('admin/tym/import', $form['importBtn'], $data);
        echo filter_input_bs($form['divInputClass']);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Název','Zkratka', 'Založení', 'Zánik', 'Nástupce', '');
        foreach ($tymy as $key =>  $row) {
        
            $data = array(
                'class' => $form['editClass']
            );
            $editBtn = anchor('admin/tym/' . $row->id_team . '/edit', $form['editBtn'], $data);
            $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";


            echo "<!-- začátek modalu -->\n";
            echo form_modal_delete("modal" . $key, $row->id_team, "Smazat tým", "Chceš opravdu smazat tým " . $row->general_name ."?", "admin/tym/" . $row->id_team. "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'].' ms-3'
            );
            $listSeasonBtn = anchor("admin/tym/".$row->id_team."/seznam-sezon",  $form['listBtn']." Sezony", $data);

            $table->addRow($row->general_name, $row->short_name, $row->founded, $row->dissolve, $row->follower, $editBtn . $deleteBtn. $listSeasonBtn);
        }



        $table->setTemplate($tableTemplate);

        echo $table->generate();
        echo $pager->links();
        ?>

    </div>
</div>
<script>
    $(document).ready(function(){
  $("#filter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<?= $this->endSection(); ?>