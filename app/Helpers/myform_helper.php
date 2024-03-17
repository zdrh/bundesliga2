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
        $result .= "<input type=\"hidden\" name=\"id\" value=\"" . $idRow . "\">";
        $result .= "<button type=\"submit\" class=\"btn btn-" . $type . "\" data-bs-dismiss=\"modal\">" . $buttonText . "</button>\n";
        $result .= "</form>\n";
        $result .= "</div>\n</div>\n</div>\n</div>\n";

        return $result;
    }
}


if (!function_exists('form_input_bs')) {
    /**
     * Text Input Field. If 'type' is passed in the $type field, it will be
     * used as the input type, for making 'email', 'phone', etc input fields.
     *
     * @param array $data - pole atributu do inputu, předpokládá se prvek id
     * @param string $bs - třídy pro div, ve kterém celý input bude
     * @param string $label - text v labelu inputu
     * @param string $type - type inputu - text, number, password apod.
     * @param boolean $floating - jestli to má být floating label nebo ne
     * @param boolean $notation - jestli se mají před uvozovky přidávat \ (pokud to cchi použít v javascriptu, dát false)
     */
    function form_input_bs($data = '', string $bs = '', string $label = '',  string $type = 'text', $floating = true,  $notation = true): string
    {
        if ($notation) {
            $quot = "\"";
            $endL = "\n";
            $tab = "\t";
        } else {
            $quot = "";
            $endL = "";
            $tab = "";
        }
        $defaults = [
            'type'  => $type,
            'name'  => is_array($data) ? '' : $data,

        ];
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
                $return = "<div class=\"" . $bs .  " form-floating\">" . $endL;
               
            }
        }

        $input = $tab . '<input class=' . $quot . 'form-control' . $quot . ' ' . my_parse_form_attributes($data, $defaults, $quot) . " />" . $endL;

        if ($label != '') {
            $for = $data["id"];
            if ($floating) {
                $return .= $input. $tab . '<label for=' . $quot . $for . $quot . '>' . $label . "</label>" . $endL;
            } else {
                $return .= $tab . '<label for=' . $quot . $for . $quot . ' class=' . $quot . 'form-label' . $quot . '>' . $label . "</label>" . $endL.$input;
            }
        }
        $return .= "</div>" . $endL;

        
        return $return;
    }
}


if (! function_exists('form_dropdown_bs')) {
    /**
     * Drop-down Menu, není multiselect
     *
     * @param string $name - name selectu
     * @param mixed $options - asociativní pole možností dropdownu, klíčem je value v option, hodnotou zobrazovaná hodnota
     * @param string $bs - třídy v rámci divu, který obalí celý dropdown
     * @param string $label - hodnota v rámci značky label
     * @param mixed $selected - pole nebo hodnota, která je vybraná
     * @param mixed $disabled - pole klíčů hodnot, které budou mít atribut disabled
     * @param mixed $extra - dodatečné atributy ve značce select, asociativní pole
     * @param boolean $notation - pokud do javascriptu, pak false, jinak true
     * 
     */
    function form_dropdown_bs($name = '', $options = [], $extra = '', string $bs = '', string $label = '', $disabled = [],$selected = [] , $notation = true): string
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
        
        $defaults = ['name' => $name];

        if (! is_array($selected)) {
            $selected = [$selected];
        }
        if (! is_array($disabled)) {
            $disabled = [$disabled];
        }
        if (! is_array($options)) {
            $options = [$options];
        }
      
        

        // Standardize selected as strings, like the option keys will be
        foreach ($selected as $key => $item) {
            $selected[$key] = (string) $item;
        }

        // Standardize selected as strings, like the option keys will be
        foreach ($disabled as $key => $item) {
            $disabled[$key] = (string) $item;
        }

        $extra2    = stringify_attributes($extra, false, $notation);
        

        //počáteční div
        if($bs == '') {
            $form = "<div>".$endL;
        } else {
            $form = '<div class='.$quot.$bs.$quot.'>'.$endL;
        }

        //label
        if($label != '') {
            
            $form.= '<label for='.$quot.$extra['id'].$quot.' class='.$quot.'form-label'.$quot.'>'.$label."</label>".$endL;
        }

        //počíteční select
        $form     .= '<select name='.$quot.$name.$quot.' class='.$quot.'form-select'.$quot . $extra2  . '>'.$endL;
        //options
        foreach ($options as $key => $val) {
            // Keys should always be strings for strict comparison
            $key = (string) $key;
           
            if (is_array($val)) {
                if (empty($val)) {
                    continue;
                }

                
                
                
                foreach ($val as $optgroupKey => $optgroupVal) {
                    // Keys should always be strings for strict comparison
                    $optgroupKey = (string) $optgroupKey;

                    $sel = in_array($optgroupKey, $selected, true) ? ' selected='.$quot.'selected'.$quot : '';
                    $dis = in_array($optgroupKey, $disabled, true) ? ' disabled='.$quot.'disabled'.$quot : '';
                   
                    $form .= '<option value='.$quot . htmlspecialchars($optgroupKey) . $quot . $sel .$dis. '>' . $optgroupVal . '</option>'.$endL;
                    
                    
                }

               
            } else {
                $form .= '<option value='.$quot . htmlspecialchars($key).$quot
                    . (in_array($key, $selected, true) ? ' selected='.$quot.'selected'.$quot : '') 
                    . (in_array($key, $disabled, true) ? ' disabled='.$quot.'disabled'.$quot : '') . 
                    '>'
                    . $val . '</option>'.$endL;
            }
        }

        $form .= '</select>'.$endL;
        $form .= '</div>'.$endL;

        return $form;
    }
}


if (!function_exists('my_parse_form_attributes')) {
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
            if (!empty($attributes)) {
                $default = array_merge($default, $attributes);
            }
        }

        $att = '';

        foreach ($default as $key => $val) {
            if (!is_bool($val)) {
                if ($key === 'value') {
                    $val = esc($val);
                } elseif ($key === 'name' && !strlen($default['name'])) {
                    continue;
                }
                $att .= $key . '=' . $notation . $val . $notation . ($key === array_key_last($default) ? '' : ' ');
            } else {
                $att .= $key . ' ';
            }
        }

        return $att;
    }
}
