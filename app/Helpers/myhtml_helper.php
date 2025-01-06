<?php

if (!function_exists('div')) {
    /**
     * vytvoří počáteční značku divu, v poli budou jednotlivé atributy
     *
    
     */
    function div($attributes)
    {
        $result = "";
        $result .= "<div";
        foreach($attributes as $key => $row) {
            $result .= " ".$key."=\"".$row."\"";
        }
        $result .= ">";

        return $result;
    }
    //vygeneruje kod pro vytvořen jedné karty
    /**
     * @param headerContent - obsah karty v hlavičce karty
     * @param bodyContent - obsah karty v body karty
     * @param class - dodatečné třídy v divu card
     */
    function card($headerContent, $bodyContent, $class) {
        $result ="";
        $result .= "<div class=\"card ".$class."\">\n";
        
        $result .= "<div class=\"card-header\">\n";
        $result .= $headerContent;
        $result .= "</div>\n";


        $result .= "<div class=\"card-body\">\n";
        $result .= $bodyContent;
        $result .= "</div>\n";

        $result .= "</div>\n";
        return $result;
    }

}