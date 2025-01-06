<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto flex-wrap">

                <?php
                //var_dump($sezony);
                foreach ($sezony as $item) {
                ?>
                    <li class="nav-item ">
                        <?php
                        if($tatoSezona == $item->id_season) {
                            $atr = array('class' => 'nav-link active py-0', 'style' => 'font-size: 75%');
                        } else {
                            $atr = array('class' => 'nav-link py-0', 'style' => 'font-size: 75%');
                        }
                        
                        $name= $item->start."-".$item->finish;
                        echo anchor("sezona/zobraz/".$name."/".$item->id_season, $name, $atr);
                        ?>
                    </li>

                <?php
                }

                ?>
            </ul>
        </div>
    </div>
</nav>
