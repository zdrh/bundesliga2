<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Main extends BaseConfig
{
    //vzhled tabulky
    var $template = array(
        'table_open' => '<table class="table table-bordered">',
        'thead_open' => '<thead>',
        'thead_close' => '</thead>',
        'heading_row_start' => '<tr>',
        'heading_row_end' => ' </tr>',
        'heading_cell_start' => '<th>',
        'heading_cell_end' => '</th>',
        'tbody_open' => '<tbody>',
        'tbody_close' => '</tbody>',
        'row_start' => '<tr>',
        'row_end'  => '</tr>',
        'cell_start' => '<td>',
        'cell_end' => '</td>',
        'row_alt_start' => '<tr>',
        'row_alt_end' => '</tr>',
        'cell_alt_start' => '<td>',
        'cell_alt_end' => '</td>',
        'table_close' => '</table>'
    );

    //tlačítka pro přidávání, editaci a mazání a třídy pro daná tlačítka;
    var $form = array(
        'addBtn' =>'<i class="fa-solid fa-circle-plus fa-xs"></i> Přidat',
        'editBtn' => '<i class="fa-solid fa-pen fa-2xs"></i> Upravit',
        'deleteBtn' => '<i class="fa-solid fa-trash fa-2xs"></i> Smazat',
        'addClass' => 'btn btn-primary',
        'editClass' => 'btn btn-warning',
        'deleteClass' => 'btn btn-danger'
    );
    
}
