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
        'addBtn' => '<i class="fa-solid fa-circle-plus fa-xs"></i> Přidat',
        'importBtn' => '<i class="fa-solid fa-circle-plus fa-xs"></i> Importovat',
        'editBtn' => '<i class="fa-solid fa-pen fa-2xs"></i> Upravit',
        'deleteBtn' => '<i class="fa-solid fa-trash fa-2xs"></i> Smazat',
        'listBtn' => '<i class="fa-solid fa-table"></i>',
        'addClass' => 'btn btn-primary',
        'editClass' => 'btn btn-warning',
        'deleteClass' => 'btn btn-danger',
        'listClass' => 'btn btn-info',
        'divInputClass' => "mb-3",
        
        'submitButton' => array(
            'name' => 'send',
            'id' => 'send',
            'type' => 'submit',
            'class' => 'btn btn-primary',
            'content' => 'Odeslat'
        ),

    );


    //nastavení povolených hodnot
    public $year = array(
        'assoc_foundation_min' => 1895,
        'assoc_foundation_max' => 2001,
        'league_season_min' => 1945,
        'league_season_max' => 2035,
        'team_foundation_min' => 1850,
        'team_foundation_max' => 2015,
        'team_dissolve_min' => 1950,
        'team_dissolve_max' => 2025
    );

    //cesta k uploadocaným souborů
    public $uploadPath  = array(
        'general' => 'upload',
        'logoAssoc' => 'upload/logo/association/',
        'logoLeague' => 'upload/logo/league/'
    );

    //error hlášky
    public $errorMessage = array(
        'generalError' => 'Bohužel něco se pokazilo',
        'generalSuccess' => 'Vše proběhlo v pořádku',
        'loginError' => 'Špatné uživatelské jméno nebo heslo',
        'dbAddError' => 'Záznam se nepřidal',
        'dbEditError' => 'Záznam se neaktulizoval',
        'dbDeleteError' => 'Záznam se nesmazal',
        'dbAddSuccess' => 'Záznam byl přidán do databáze',
        'dbEditSuccess' => 'Zaznam se aktualizoval',
        'dbDeleteSuccess' => 'Záznam byl smazán',
        'uploadError' => 'Nepodařilo se nahrát obrázek',
        'uploadSuccess' => 'Upload proběhl v pořádku'
    );

    //relace mezi tabulkami
    public $joinTable = array(
        'season_association_season' => 'season.id_season=association_season.id_season',
        'association_season_season' => 'season.id_season=association_season.id_season',
        'association_association_season' => 'association.id_association=association_season.id_association',
        'association_season_association' => 'association.id_association=association_season.id_association',
        'association_league' => 'league.id_association=association.id_league',
        'league_association' => 'league.id_association=association.id_league',
        'league_league_season' => 'league.id_league=league_season.id_league',
        'league_season_league' => 'league.id_league=league_season.id_league',
        'league_season_association_season' => 'league_season.id_assoc_season=association_season.id_assoc_season',
        'association_season_league_season' => 'league_season.id_assoc_season=association_season.id_assoc_season',
        'league_season_league_season_group' => 'league_season.id_league_season=league_season_group.id_league_season',
        'league_season_group_league_season' => 'league_season.id_league_season=league_season_group.id_league_season',
    );

    //stránkování
    public $perPage = 20;

}
