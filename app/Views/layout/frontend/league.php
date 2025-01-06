<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto flex-wrap">

                <?php
                $name= $sezona->start."-".$sezona->finish;
               
                ?>
                <a class="navbar-brand" >Souteže <?= $name.": " ?></a>
                <?php
                foreach ($soutezeTatoSezona as $item) {
                ?>

                    <li class="nav-item ">
                        <?php
                        if($id_league_season == $item->id_league_season) {
                            $atr = array('class' => 'nav-link active align-middle');
                        } else {
                            $atr = array('class' => 'nav-link align-middle');
                        }
                        
                     
                        echo anchor("sezona/".$name."/zobraz/liga/".$item->id_league_season, $item->league_name_in_season, $atr);
                        ?>
                    </li>

                <?php
                }

                ?>
            </ul>
        </div>
    </div>
</nav>
