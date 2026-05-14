<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

use App\Models\City as C;
use App\Models\Country;
use App\Libraries\ArrayLibrary;
use App\Libraries\AlertLibrary;

class City extends BaseBackendController
{
    var $city;
    var $country;
    var $arrayLib;
    var $alertLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->city = new C();
        $this->country = new Country();
        $this->arrayLib = new ArrayLibrary();
        $this->alertLib = new AlertLibrary();
    }
    public function index()
    {
        $this->data['city'] = $this->city->join('country', $this->data['join']['country_city'], 'inner')->orderBy('name_de', 'asc')->paginate($this->data['perPage']);
        $this->data['pager'] = $this->city->pager;

        echo view('backend/city/index', $this->data);
    }

    public function add() {
        $country = $this->country->orderBy('name', 'asc')->findAll();
        $this->data['country'] = $this->arrayLib->arrayToDropdown($country, 'id_country', 'name');
        echo view('backend/city/add', $this->data);
    }

    public function create() {
        $nameDe = $this->request->getPost('name_de');
        $nameCz = $this->request->getPost('name_cz');
        $country = $this->request->getPost('country');
        $league = $this->request->getPost('league');
        
       
        foreach($nameDe as $key => $row) {
            $data = array(
                'name_de' => $row,
                'name_cz' => $nameCz[$key],
                'country' => $country[$key],
                'league' => $league[$key]
            );
           
           $result =  $this->city->save($data);
           $alerts[] = $this->alertLib->createAlert($result, 'dbAddCount', $this->country->inserID);
        }

        //generování hlášek
        $data2 =  $this->errorMessage->prepareMessage3($alerts);
        $this->session->setFlashdata('error', $data2);

        
       
        return redirect()->route('admin/seznam-mest');
    }

    public function edit($id_city) {
        $country = $this->country->orderBy('name', 'asc')->findAll();
        $this->data['country'] = $this->arrayLib->arrayToDropdown($country, 'id_country', 'name');
        $this->data['city'] = $this->city->find($id_city);
        echo view('backend/city/edit', $this->data);
    }

    public function update() {
        $nameDe = $this->request->getPost('name_de');
        $nameCz = $this->request->getPost('name_cz');
        $idCity = $this->request->getPost('id_city');

        $data = array(
            'name_de' => $nameDe,
            'name_cz' => $nameCz,
            'id_city' => $idCity
        );

        $result = $this->city->save($data);
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-mest');
        
    }

    public function delete($id_city) {
        $result = $this->city->delete($id_city);

       
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        return redirect()->route('admin/seznam-mest');
    }
}
