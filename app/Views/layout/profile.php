<ul class="navbar-nav ms-auto clearfix">
            <li class="nav-item">
                <?php
                $data = array(
                    'class' => 'nav-link m-2 menu-item'
                );
                echo anchor('logout', 'Odhlásit', $data);
                ?>
                
            </li>
        </ul>