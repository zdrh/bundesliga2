<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>
<?php
    /**
     *  @var array $city
     *  @var array $form
     *  @var array $tableTemplate
     *  @var object $pager
     */
?>
<h1>Seznam měst</h1>
<div class="row">
    <div class="col-md-10">


        <?php
        $data = array(
            'class' => $form['addClass']." mb-3"
        );
        echo anchor('admin/mesto/pridat', $form['addBtn'], $data);
        echo filter_input_bs($form['divInputClass']);
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Název německy','Název česky', 'Stát', 'Ligové');
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
            echo form_modal_delete("modal" . $key, $row->id_city, "Smazat město", "Chceš opravdu smazat město " . $row->name_de ."?", "admin/mesto/" . $row->id_city . "/delete");
            echo "<!-- konec modalu -->\n";
            $data = array(
                'class' => $form['listClass'].' ms-3'
            );
            if($row->league) {
                $league = "Ano";
            } else {
                $league = "Ne";
            }
            $country = flagIcon($row->short_name) . $row->name;
            $table->addRow($row->name_de, $row->name_cz, $country, $league, $editBtn . $deleteBtn);
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