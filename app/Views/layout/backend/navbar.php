<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <ul class="navbar-nav">

        <?php
    /**
     * @var array $menu
     * @var string $profile
     */
        foreach ($menu as $item) {
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
   
        <?= $this->include($profile); ?>
   
</nav>