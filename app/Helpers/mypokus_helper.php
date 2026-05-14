<?php
if (!function_exists('form_input_bs')) {
    /**
     * Text Input Field. If 'type' is passed in the $type field, it will be
     * used as the input type, for making 'email', 'phone', etc input fields.
     *
     * @param array $data - pole atributů do inputu, předpokládá se prvek id
     * @param string $bs - třídy pro div, ve kterém celý input bude
     * @param string $label - text v labelu inputu
     * @param string $type - type inputu - text, number, password apod.
     * @param boolean $floating - jestli to má být floating label nebo ne
     * @param boolean $notation - jestli se mají před uvozovky přidávat \ (pokud to cchi použít v javascriptu, dát false)
     */
    function form_input_bs($data = '', string $label = '', string $bs = 'mb-3',  string $type = 'text', $floating = true): string
    {
       
            $quot = "\"";
            $endL = "\n";
            $tab = "\t";

        $defaults = [
            'type'  => $type,
            'name'  => is_array($data) ? '' : $data,

        ];
        $attributes = "";
        foreach ($data as $key => $row) {
            $attributes .= "\"".$key."\"=\"".$row."\" ";
        }
      

        if ($bs == '') {
            if (!$floating) {
                $return = "<div>" . $endL;
            } else {
                $return = "<div class=" . $quot . "form-floating" . $quot . ">" . $endL;
            }
        } else {
            if (!$floating) {
                $return = '<div class=' . $quot . $bs . $quot . '>' . $endL;
            } else {
                $return = "<div class=" . $quot . $bs .  " form-floating" . $quot . ">" . $endL;
            }
        }

        $input = $tab . '<input class=' . $quot . 'form-control' . $quot . ' ' . my_parse_form_attributes($data, $defaults, $quot) . " />" . $endL;

        if ($label != '') {
            $for = $data["id"];
            if ($floating) {
                $return .= $input . $tab . '<label for=' . $quot . $for . $quot . '>' . $label . "</label>" . $endL;
            } else {
                $return .= $tab . '<label for=' . $quot . $for . $quot . ' class=' . $quot . 'form-label' . $quot . '>' . $label . "</label>" . $endL . $input;
            }
        }
        $return .= "</div>" . $endL;


        return $return;
    }
}