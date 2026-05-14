<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Player as P;
use App\Models\Country;
use App\Models\City;

use App\Libraries\AlertLibrary;

class Player extends BaseBackendController
{
    var $player;
    var $country;
    var $city;
    var $alertLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->player = new P();
        $this->country = new Country();
        $this->city = new City();
        $this->alertLib = new AlertLibrary();
    }
    public function index()
    {
        $this->data['player'] = $this->player->select('player.id_player, player.first_name, player.last_name, player.born, player.death, player.retire, country.name, city_country.name as city_country, city.name_de, country.short_name')->join('country', $this->data['join']['player_country'], 'left')->join('city', $this->data['join']['player_city'], 'left')->join('country as city_country', 'city_country.id_country=city.country', 'left')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->paginate($this->data['perPage']);
        $this->data['pager'] = $this->player->pager;
        echo view('backend/player/index', $this->data);
    }

    public function add()
    {
        $this->data['country'] = $this->country->orderBy('name', 'asc')->findAll();
        $this->data['city'] = $this->city->orderBy('name_de', 'asc')->findAll();
        echo view('backend/player/add', $this->data);
    }

    public function create()
    {
        $alerts = array();
        $first_name = $this->request->getPost('first_name');
        $last_name = $this->request->getPost('last_name');
        $country = $this->request->getPost('country');
        $born = $this->request->getPost('born');
        $death = $this->request->getPost('death');
        $bornCity = $this->request->getPost('bornCity');
        $retire = $this->request->getPost('retire');
       
        foreach ($first_name as $key => $row) {
            if ($death[$key] == "") {
                $death[$key] = NULL;
            }
            $data = array(
                'first_name' => $row,
                'last_name' => $last_name[$key],
                'country' => $country[$key],
                'born' => $born[$key],
                'death' => $death[$key],
                'born_city' => $bornCity[$key],
                'retire' => $retire[$key]
            );
           
            $result =  $this->player->save($data);
            $alerts[] = $this->alertLib->createAlert($result, 'dbAddCount', $this->country->insertID);
            
        }

        $data2 =  $this->errorMessage->prepareMessage3($alerts);
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-hracu');
    }

    public function import() {

        echo view('backend/player/import', $this->data);
    }

    public function createImport() {
        
    }

    public function edit($id) {
        $this->data['country'] = $this->country->orderBy('name', 'asc')->findAll();
        $this->data['city'] = $this->city->orderBy('name_de', 'asc')->findAll();
        $this->data['player'] = $this->player->find($id);

        echo view('backend/player/edit', $this->data);
    }

    public function update() {
        $first_name = $this->request->getPost('first_name');
        $last_name = $this->request->getPost('last_name');
        $country = $this->request->getPost('country');
        $born = $this->request->getPost('born');
        $death = $this->request->getPost('death');
        $bornCity = $this->request->getPost('bornCity');
        $retire = $this->request->getPost('retire');
        $id_player = $this->request->getPost('id_player');

        if ($death == "") {
            $death = NULL;
        }

        $data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'country' => $country,
            'born' => $born,
            'death' => $death,
            'born_city' => $bornCity,
            'retire' => $retire,
            'id_player' => $id_player
        );
       
        $result =  $this->player->save($data);
       // $alerts[] = $this->alertLib->createAlert($result, 'dbEdit', $this->country->insertID);

        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-hracu');


    }
}
