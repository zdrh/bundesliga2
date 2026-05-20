<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Person as P;
use App\Models\Country;
use App\Models\City;

use App\Libraries\AlertLibrary;

class Person extends BaseBackendController
{
    private object $person;
    private object $country;
    private object $city;
    private object $alertLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->person = new P();
        $this->country = new Country();
        $this->city = new City();
        $this->alertLib = new AlertLibrary();
    }
    public function index()
    {
        $this->data['player'] = $this->person->select('person.id_person, person.first_name, person.last_name, person.born, person.death, person.retire, country.name, city_country.name as city_country, city.name_de, country.short_name')->join('country', $this->data['join']['person_country'], 'left')->join('city', $this->data['join']['person_city'], 'left')->join('country as city_country', 'city_country.id_country=city.country', 'left')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->paginate($this->data['perPage']);
        $this->data['pager'] = $this->person->pager;
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
            if ($born[$key] == "") {
                $born[$key] = NULL;
            }

            foreach ($first_name as $key => $row) {
                if ($death[$key] == "") {
                    $death[$key] = NULL;
                }
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

            $result =  $this->person->save($data);
            $alerts[] = $this->alertLib->createAlert($result, 'dbAddCount', $this->country->insertID);
        }

        $data2 =  $this->errorMessage->prepareMessage3($alerts);
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-hracu');
    }

    public function import()
    {

        echo view('backend/player/import', $this->data);
    }

    public function createImport() {}

    public function edit($id)
    {
        $this->data['country'] = $this->country->orderBy('name', 'asc')->findAll();
        $this->data['city'] = $this->city->orderBy('name_de', 'asc')->findAll();
        $this->data['player'] = $this->person->find($id);

        echo view('backend/player/edit', $this->data);
    }

    public function update()
    {
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
            'id_person' => $id_player
        );

        $result =  $this->person->save($data);
        // $alerts[] = $this->alertLib->createAlert($result, 'dbEdit', $this->country->insertID);

        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-hracu');
    }
}
