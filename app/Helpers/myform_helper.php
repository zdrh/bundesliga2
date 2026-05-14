<?php

if (! function_exists('form_modal_delete')) {
    /**
     * Vygeneruje Bootstrap modal pro potvrzení mazání záznamu.
     * /**
     * @param string     $idModal   Unikátní ID Bootstrap modalu
     * @param int|string $idRow     ID mazaného záznamu
     * @param string     $heading   Titulek modalu
     * @param string     $message   Text potvrzení mazání
     * @param string     $route     URL pro DELETE request
     * @param string     $type      Bootstrap varianta tlačítka
     * @param string     $buttonText Text potvrzovacího tlačítka    
     */

    function form_modal_delete(string $idModal, int|string $idRow, string $heading, string $message, string $route, string $type = 'danger', string $buttonText = 'Smazat'): string
    {
        $allowedTypes = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        if (! in_array($type, $allowedTypes, true)) {
            $type = 'danger';
        }

        $result  = '<div class="modal fade" id="' . esc($idModal, 'attr') . '" tabindex="-1" aria-hidden="true">' . "\n";
        $result .= '    <div class="modal-dialog">' . "\n";
        $result .= '        <div class="modal-content">' . "\n";

        $result .= '            <div class="modal-header">' . "\n";
        $result .= '                <h4 class="modal-title">' . esc($heading) . '</h4>' . "\n";
        $result .= '                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>' . "\n";
        $result .= '            </div>' . "\n";

        $result .= '            <div class="modal-body">' . "\n";
        $result .= '                ' . esc($message) . "\n";
        $result .= '            </div>' . "\n";

        $result .= '            <div class="modal-footer">' . "\n";
        $result .= '                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>' . "\n";
        $result .=                  form_open($route) . "\n";
        $result .= '                    <input type="hidden" name="_method" value="DELETE">' . "\n";
        $result .= '                    <input type="hidden" name="id" value="' . esc((string) $idRow, 'attr') . '">' . "\n";
        $result .= '                    <button type="submit" class="btn btn-' . esc($type, 'attr') . '">' . esc($buttonText) . '</button>' . "\n";
        $result .=                  form_close() . "\n";
        $result .= '            </div>' . "\n";

        $result .= '        </div>' . "\n";
        $result .= '    </div>' . "\n";
        $result .= '</div>' . "\n";

        return $result;
    }
}

if (! function_exists('form_input_bs')) {
    /**
     * Bootstrap input s podporou floating label.
     *
     * @param string $name         Name atribut inputu
     * @param array  $attributes   Další atributy inputu
     * @param string $wrapperClass Bootstrap třídy obalového divu
     * @param string $label        Text labelu
     * @param string $type         Typ inputu
     * @param bool   $floating     Použít floating label
     */
    function form_input_bs(
        string $name,
        array $attributes = [],
        string $label = '',
        string $type = 'text',
        bool $floating = true,
        string $wrapperClass = 'mb-3'
    ): string {

        // základní atributy inputu
        $attributes['name'] = $name;
        $attributes['type'] ??= $type;

        // automatické vytvoření ID z name
        if (! isset($attributes['id'])) {
            $attributes['id'] = preg_replace('/_+/', '_', trim(str_replace(['[', ']'], '_', $name), '_'));
        }

        // přidání bootstrap třídy
        $attributes['class'] = trim(
            'form-control ' . ($attributes['class'] ?? '')
        );

        // floating label potřebuje placeholder
        if ($floating && ! isset($attributes['placeholder'])) {
            $attributes['placeholder'] = $label !== '' ? $label : ' ';
        }

        // wrapper class
        $wrapperClass = trim(
            $wrapperClass . ($floating ? ' form-floating' : '')
        );

        // otevření wrapperu
        $html = '<div';

        if ($wrapperClass !== '') {
            $html .= ' class="' . esc($wrapperClass, 'attr') . '"';
        }

        $html .= '>' . "\n";

        // klasický label před inputem - u varianty bez floatingu
        if ($label !== '' && ! $floating) {
            $html .= "\t";
            $html .= '<label for="' . esc((string) $attributes['id'], 'attr') . '" class="form-label">';
            $html .= esc($label);
            $html .= '</label>' . "\n";
        }

        // input
        $html .= "\t";
        $html .= '<input ' . stringify_attributes_bs($attributes) . '>';
        $html .= "\n";

        // floating label za inputem
        if ($label !== '' && $floating) {
            $html .= "\t";
            $html .= '<label for="' . esc((string) $attributes['id'], 'attr') . '">';
            $html .= esc($label);
            $html .= '</label>' . "\n";
        }

        // konec wrapperu
        $html .= '</div>' . "\n";

        return $html;
    }
}  

if (! function_exists('form_dropdown_bs')) {
    /**
     * Bootstrap select bez multiselectu.
     *
     * @param string $name            Name atribut selectu
     * @param array  $options         Pole možností: value => label, případně optgroup
     * @param array  $attributes      Další atributy selectu
     * @param string $label           Text labelu
     * @param mixed  $selected        Vybraná hodnota nebo pole hodnot
     * @param mixed  $disabledOptions Disabled option hodnoty
     * @param mixed  $hiddenOptions   Hidden option hodnoty
     * @param string $wrapperClass    Bootstrap třídy obalového divu
     */
    function form_dropdown_bs(
        string $name,
        array $options = [],
        array $attributes = [],
        string $label = '',
        mixed $selected = [],
        mixed $disabledOptions = [],
        mixed $hiddenOptions = [],
        string $wrapperClass = 'mb-3'
    ): string {
        $selected = is_array($selected) ? $selected : [$selected];
        $disabledOptions = is_array($disabledOptions) ? $disabledOptions : [$disabledOptions];
        $hiddenOptions = is_array($hiddenOptions) ? $hiddenOptions : [$hiddenOptions];

        $selected = array_map('strval', $selected);
        $disabledOptions = array_map('strval', $disabledOptions);
        $hiddenOptions = array_map('strval', $hiddenOptions);

        $attributes['name'] = $name;

        if (! isset($attributes['id'])) {
            $attributes['id'] = preg_replace(
                '/_+/',
                '_',
                trim(str_replace(['[', ']'], '_', $name), '_')
            );
        }

        $attributes['class'] = trim('form-select ' . ($attributes['class'] ?? ''));

        $html = '<div';

        if ($wrapperClass !== '') {
            $html .= ' class="' . esc($wrapperClass, 'attr') . '"';
        }

        $html .= '>' . "\n";

        if ($label !== '') {
            $html .= "\t";
            $html .= '<label for="' . esc((string) $attributes['id'], 'attr') . '" class="form-label">';
            $html .= esc($label);
            $html .= '</label>' . "\n";
        }

        $html .= "\t" . '<select ' . stringify_attributes_bs($attributes) . '>' . "\n";

        foreach ($options as $key => $value) {
            if (is_array($value)) {
                $html .= "\t\t" . '<optgroup label="' . esc((string) $key, 'attr') . '">' . "\n";

                foreach ($value as $optionValue => $optionLabel) {
                    $html .= form_dropdown_option_bs(
                        (string) $optionValue,
                        (string) $optionLabel,
                        $selected,
                        $disabledOptions,
                        $hiddenOptions
                    );
                }

                $html .= "\t\t" . '</optgroup>' . "\n";
            } else {
                $html .= form_dropdown_option_bs(
                    (string) $key,
                    (string) $value,
                    $selected,
                    $disabledOptions,
                    $hiddenOptions
                );
            }
        }

        $html .= "\t" . '</select>' . "\n";
        $html .= '</div>' . "\n";

        return $html;
    }
}

if (! function_exists('form_textarea_bs')) {
    /**
     * Bootstrap textarea bez floating labelu.
     *
     * @param string $name         Name atribut textarea
     * @param string $label        Text labelu
     * @param string $value        Obsah textarea
     * @param int    $rows         Počet řádků
     * @param array  $attributes   Další atributy textarea
     * @param string $labelClass   CSS třídy labelu
     * @param string $wrapperClass CSS třídy obalového divu
     */
    function form_textarea_bs(
        string $name,
        string $label = '',
        string $value = '',
        int $rows = 5,
        array $attributes = [],
        string $labelClass = 'form-label',
        string $wrapperClass = 'mb-3'
    ): string {
        $attributes['name'] = $name;
        $attributes['rows'] ??= $rows;

        if (! isset($attributes['id'])) {
            $attributes['id'] = preg_replace(
                '/_+/',
                '_',
                trim(str_replace(['[', ']'], '_', $name), '_')
            );
        }

        $attributes['class'] = trim('form-control ' . ($attributes['class'] ?? ''));

        $html = '<div';

        if ($wrapperClass !== '') {
            $html .= ' class="' . esc($wrapperClass, 'attr') . '"';
        }

        $html .= '>' . "\n";

        if ($label !== '') {
            $html .= "\t";
            $html .= '<label for="' . esc((string) $attributes['id'], 'attr') . '"';

            if ($labelClass !== '') {
                $html .= ' class="' . esc($labelClass, 'attr') . '"';
            }

            $html .= '>';
            $html .= esc($label);
            $html .= '</label>' . "\n";
        }

        $html .= "\t";
        $html .= '<textarea ' . stringify_attributes_bs($attributes) . '>';
        $html .= esc($value);
        $html .= '</textarea>' . "\n";

        $html .= '</div>' . "\n";

        return $html;
    }
}

if (! function_exists('form_dropdown_option_bs')) {
    /**
     * jen de facto privátní metoda, kterou voláme zevnitř dropdown helperu
     */
    function form_dropdown_option_bs(
        string $value,
        string $label,
        array $selected = [],
        array $disabledOptions = [],
        array $hiddenOptions = []
    ): string {
        $attributes = [
            'value' => $value,
        ];

        if (in_array($value, $selected, true)) {
            $attributes['selected'] = true;
        }

        if (in_array($value, $disabledOptions, true)) {
            $attributes['disabled'] = true;
        }

        if (in_array($value, $hiddenOptions, true)) {
            $attributes['hidden'] = true;
        }

        return "\t\t" . '<option ' . stringify_attributes_bs($attributes) . '>' . esc($label) . '</option>' . "\n";
    }
}

if (! function_exists('stringify_attributes_bs')) {
    /**
     * Převede atributy pole na HTML atributy.
     * De facto privátní metoda, kterou voláme zevnitř helperu
     */
    function stringify_attributes_bs(array $attributes): string
    {
        $result = [];

        foreach ($attributes as $key => $value) {

            if ($value === null || $value === false) {
                continue;
            }

            $key = esc((string) $key, 'attr');

            // boolean atributy
            if ($value === true) {
                $result[] = $key;
                continue;
            }

            $result[] = $key . '="' . esc((string) $value, 'attr') . '"';
        }

        return implode(' ', $result);
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


if (!function_exists('form_pill')) {
    /**
     * vygeneruje prvek pill
     *
     * @param $url - url adresa daného pillu,  
     * @param $type - true, jestli to má být klasická url adresa nebo false, jestli to má být pouze odkaz na id
     * 
     */
    function form_pill($url, $type, $text, $active = false): string
    {
        $result = "";
        $result .= "<li class=\"nav-item\">\n";
        if ($active) {
            $activeString = " active";
        } else {
            $activeString = "";
        }
        $result .= "<a class=\"nav-link" . $activeString . "\" href=\"" . base_url($url) . "\">" . $text . "</a>\n";
        $result .=  "</li>\n";


        return $result;
    }
}


if (!function_exists('form_tabs')) {
    /**
     * vygeneruje prvek pill
     *
     * @param $id - id daného tabu  
     * @param $text - txt, na který se kliká
     * @param $active - jestli se jedná o aktivní tab
     * 
    
     */


    function form_tabs($id, $text, $active = false): string
    {
        $result = "";
        $result .= "<li class=\"nav-item\">\n";
        if ($active) {
            $activeString = " active";
        } else {
            $activeString = "";
        }
        $result .= "<a class=\"nav-link" . $activeString . "\" data-bs-toggle=\"tab\" href=\"#" . $id . "\">" . $text . "</a>\n";
        $result .=  "</li>\n";


        return $result;
    }
}

if (!function_exists('filter_input_bs')) {

    function filter_input_bs($input)
    {


        $dataFilter = array(
            'id' => 'filter',
            'placeholder' => 'a'
        );

       // $form = 

        $result = div(['class' => 'col-4']) . form_input_bs('filter', $dataFilter, 'Filtrovat', 'text', 'false', $input) . "</div>";

        return $result;
    }
}