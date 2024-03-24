<?php

namespace App\Libraries;


class StringLibrary {

    public function __construct() {

    }
    public function findPosition($string, $find) {
        $result = strpos($string, $find);

        return $result;
    }
    /**
     * odebere z celé url adresy base_url, abych měl jen samotnou routu
     */

    public function getRoute($url) {
        $route = $this->removeString($url, base_url());

        return $route;
    }
    /**
     * zjistí, jestli se jedná o routu do adminsitrace (na začátku má slovo admin)
     */
    public function getAdmin($route) {
        $result = $this->findPosition($route, 'admin');
        if($result === 0) {
            return true;
        } else {
            return false;
        }
    }

    public function removeString($string, $remove) {
        $position = $this->findPosition($string, $remove);
        if($position !== false) {
            $delka = strlen($remove);
            
            $return = substr($string, $position, $delka);
        } else {
            $return = false;
        }

        return $return;
    }


}