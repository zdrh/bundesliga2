<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">

                <?php

                foreach ($subMenu as $item) {
                ?>
                    <li class="nav-item">
                        <?php
                        $atr = array('class' => 'nav-link');
                        echo anchor($item->link, $item->name, $atr);
                        ?>
                    </li>

                <?php
                }

                ?>
            </ul>
        </div>
    </div>
</nav>