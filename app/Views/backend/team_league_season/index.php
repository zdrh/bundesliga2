<?= $this->extend('layout/backend/layout'); ?>

<?= $this->section('content'); ?>

<h1>Soutěž <?= $liga->league_name_in_season ?> ročník <?= $liga->start  ?>/<?= $liga->finish ?></h1>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#groups">Skupiny</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#teams">Týmy</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#matches">Zápasy</a>
    </li>
    <li class="nav_item">
        <a class="nav-link" data-bs-toggle="tab" href="#rules">Pravidla</a>
    </li>
</ul>

<div class="tab-content">

    <!--první panel - skupiny -->
    <div class="tab-pane container active" id="groups">
        <h2>Části soutěže</h2>
        <?php
        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Název skupiny', 'Typ', '');
        foreach ($skupiny as $key => $row) {
            if ($row->regular == 1) {
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
                'class' => $form['listClass'] . ' ms-3'
            );


            $dataTable = array(
                'class' => $form['listClass'] . ' ms-3'
            );

            $listSeasonBtn = anchor("admin/liga/" . $row->id_league_season_group . "/seznam-tymu",  $form['listBtn'] . " Týmy", $dataTable);
            if ($row->real == 1) {
                $editBtn = anchor('admin/liga/' . $liga->id_league . '/sezona/' . $liga->id_season . '/skupina/' . $row->id_league_season_group . '/edit', $form['editBtn'], $data);
                $deleteBtn = "<button type=\"button\" class=\"" . $form['deleteClass'] . " text-black ms-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal" . $key . "\">" . $form['deleteBtn'] . "</button>";

                echo "<!-- začátek modalu -->\n";
                echo form_modal("modal" . $key, $row->id_league_season_group, "Smazat skupinu ligy", "Chceš opravdu smazat skupinu " . $row->groupname . " pro ligu " . $liga->league_name_in_season . "?", "admin/liga/" . $liga->id_league . "/sezona/" . $liga->id_season . "/skupina/" . $row->id_league_season_group . "/delete");
                echo "<!-- konec modalu -->\n";


                $buttony = $editBtn . $deleteBtn . $listSeasonBtn;
            } else {
                $buttony = $listSeasonBtn;
            }
            $table->addRow($row->groupname, $type, $buttony);
        }
        $table->setTemplate($tableTemplate);

        echo $table->generate();
        ?>
    </div>

    <!-- druhý panel - týmy v soutěži -->
    <div class="tab-pane container" id="teams">
        <h2>Týmy v soutěži</h2>
        <?php

        $data = array(
            'class' => $form['addClass'] . " mb-3"
        );

        $data2 = array(
            'class' => $form['listClass'] . " mb-3 ms-3"
        );
        $table = new \CodeIgniter\View\Table();
        $h1 = array(
            'data' => 'Název skupiny',
            'class' => 'col-md-1'
        );
        $h2 = array(
            'data' => 'Seznam týmů',
            'class' => 'col-md-8'
        );
        $h3 = array(
            'data' => '',
            'class' => 'col-md-3'
        );
        $table->setHeading($h1, $h2, $h3);
        $table->setHeading('Název skupiny', 'Seznam týmů', '');

        foreach ($skupiny as $row) {
            $seznamTymu = '';
            if (array_key_exists($row->id_league_season_group, $tymy)) {
                foreach ($tymy[$row->id_league_season_group] as $key => $row2) {
                    $seznamTymu .= $row2;
                    if ($key + 1 != Count($tymy[$row->id_league_season_group])) {
                        $seznamTymu .= ", ";
                    }
                }
            } else {
                $seznamTymu = "";
            }


            $addBtn = anchor('admin/liga/' . $row->id_league_season_group . '/tym/pridat', $form['addBtn'], $data);
            $listBtn = anchor('admin/liga/' . $row->id_league_season_group . '/seznam-tymu', $form['listBtn'] . 'Správa týmů', $data2);
            $h1 = array(
                'data' => $row->groupname,
                'class' => 'col-md-1'
            );
            $h2 = array(
                'data' => $seznamTymu,
                'class' => 'col-md-8'
            );
            $h3 = array(
                'data' => $addBtn  . $listBtn,
                'class' => 'col-md-3'
            );
            $table->addRow($h1, $h2, $h3);
        }

        $table->setTemplate($tableTemplate);

        echo $table->generate();


        ?>
    </div>

    <!-- třetí panel s jednotlivými zápasy  -->
    <div class="tab-pane container fade" id="matches">
        <div class="mt-3">
            <ul class="nav nav-tabs">
                <?php
                foreach ($skupiny as $key => $row) {
                    $key == 0 ? $active = true : $active = false;
                    echo form_tabs("liga-" . $row->id_league_season_group, $row->groupname, $active);
                }
                ?>
            </ul>
        </div>

        <div class="tab-content">
            <?php
            foreach ($skupiny as $key2 => $row2) {
                $key2 == 0 ? $text = "active" : $text = "fade";
                $data = array(
                    "class" => "tab-pane container " . $text,
                    "id" => "liga-" . $row2->id_league_season_group

                );
                echo div($data);
                /* obsah každého panelu*/
                $data = array(
                    'class' => $form['addClass'] . " mb-3 mt-3"
                );
                echo anchor('admin/liga/skupina/' . $row2->id_league_season_group . '/zapasy/pridat', $form['addBtn'] . " zápasy", $data);


                //generování karet
            ?>
                <div class="row row-cols-md-2 g-1">
                  
                    <?php
                    if (array_key_exists($row2->id_league_season_group, $zapasy)) {
                        //var_dump($zapasy[$row2->id_league_season_group]);
                        //procházíme kola
                        foreach ($zapasy[$row2->id_league_season_group] as $key3 =>  $row3) {
                            $table = new \CodeIgniter\View\Table();
                            $table->setHeading('Datum','Čas', 'Domácí', 'Hosté', 'Výsledek', '');
                            foreach($row3 as $row4) {
                                $result = $row4->result_team . ":". $row4->result_opponent;
                                $dataEdit = array(
                                    'class' => $form['editClass']
                                );
                                $editBtn = anchor('admin/liga/skupina/' . $row2->id_league_season_group . '/zapasy/'.$row4->id_game.'/edit', $form['editBtnSmall'], $dataEdit);
                                $table->addRow(date('j.n.Y', strtotime($row4->date)), date('H:i', strtotime($row4->time)), $row4->team, $row4->oppo, $result, $editBtn);
                            }
                            $table->setTemplate($tableTemplateFixture);
                            $textTable = $table->generate();
                            $textRound = $key3.". kolo";
                            echo "<div class=\"col\">";
                            echo card($textRound, $textTable, 'no-padding');
                            echo "</div>\n";
                          
                            
                        }
                    }
                   
                    echo "</div>\n";
                    echo "</div>\n";
                }
                    ?>


                    

                </div>

        </div>
        <!--  čtvrtý tab -->
        <div class="tab-pane container fade" id="rules">

        </div>
    </div>

    <?= $this->endSection(); ?>