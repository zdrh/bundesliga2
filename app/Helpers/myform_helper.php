<?php


if (!function_exists('form_modal')) {
    /**
     * Parse the form attributes
     *
     * Helper function used by some of the form helpers
     *
     * @param array|string $attributes List of attributes
     * @param array        $default    Default values
     */
    function form_modal($idModal, $idRow, $heading, $message, $route, $type = "danger", $buttonText = "Smazat")
    {
        $result = "";
        $result .= "<div class=\"modal fade\" id=\"" . $idModal . "\">\n";
        $result .= "<div class=\"modal-dialog\">\n";
        $result .= " <div class=\"modal-content\">\n";
        $result .= "<div class=\"modal-header\">\n";
        $result .= "<h4 class=\"modal-title\">" . $heading . "</h4>\n";
        $result .= "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>\n";
        $result .= "</div>\n";
        $result .= "<div class=\"modal-body\">\n";
        $result .= $message . "\n";
        $result .= "</div>\n";
        $result .= "<div class=\"modal-footer\">\n";
        $result .= form_open($route);
        $result .= "<input type=\"hidden\" name=\"_method\" value=\"DELETE\">";
        $result .= "<input type=\"hidden\" name=\"id\" value=\"".$idRow."\">";
        $result .= "<button type=\"submit\" class=\"btn btn-" . $type . "\" data-bs-dismiss=\"modal\">" . $buttonText . "</button>\n";
        $result .= "</form>\n";
        $result .= "</div>\n</div>\n</div>\n</div>\n";

        return $result;
    }
}


if (! function_exists('form_input_bs')) {
    /**
     * Text Input Field. If 'type' is passed in the $type field, it will be
     * used as the input type, for making 'email', 'phone', etc input fields.
     *
     * @param array $data - pole atributu do inputu, předpokládá se prvek id
     * @param string $bs - třídy pro div, ve kterém celý input bude
     * @param string $label - text v labelu inputu
     * @param string $type - type inputu - text, number, password apod.
     * @param boolean $notation - jestli se mají před uvozovky přidávat \ (pokud to cchi použít v javascriptu, dát false)
     */
    function form_input_bs($data = '', string $bs = '', string $label = '',  string $type = 'text', $notation = true): string
    {
        if($notation) {
            $quot = "\"";
            $endL = "\n";
            $tab = "\t";
        } else {
            $quot = "\\\"";
            $endL = "";
            $tab = "";
        }
        $defaults = [
            'type'  => $type,
            'name'  => is_array($data) ? '' : $data,
           
        ];
        if($bs == '') {
            $return = "<div>".$endL;
        } else {
            $return = '<div class='.$quot.$bs.$quot.'>'.$endL;
        }

        if($label != '') {
            $for = $data["id"];
            $return .= $tab.'<label for='.$quot.$for.$quot.' class='.$quot.'form-label'.$quot.'>'.$label."</label>".$endL;
        }

        $return .= $tab.'<input class='.$quot.'form-control'.$quot.' ' . my_parse_form_attributes($data, $defaults, $quot) . " />".$endL."</div>".$endL;
        return $return;
    }
}


if (! function_exists('my_parse_form_attributes')) {
    /**
     * Parse the form attributes
     *
     * Helper function used by some of the form helpers
     *
     * @param array|string $attributes List of attributes
     * @param array        $default    Default values
     */
    function my_parse_form_attributes($attributes, array $default, $notation = '"'): string
    {
        if (is_array($attributes)) {
            foreach (array_keys($default) as $key) {
                if (isset($attributes[$key])) {
                    $default[$key] = $attributes[$key];
                    unset($attributes[$key]);
                }
            }
            if (! empty($attributes)) {
                $default = array_merge($default, $attributes);
            }
        }

        $att = '';

        foreach ($default as $key => $val) {
            if (! is_bool($val)) {
                if ($key === 'value') {
                    $val = esc($val);
                } elseif ($key === 'name' && ! strlen($default['name'])) {
                    continue;
                }
                $att .= $key . '='.$notation . $val . $notation . ($key === array_key_last($default) ? '' : ' ');
            } else {
                $att .= $key . ' ';
            }
        }

        return $att;
    
    }
}
