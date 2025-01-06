<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

use App\Models\Stadium as S;
use App\Models\City;

class Stadium extends BaseBackendController
{
    var $stadium;
    var $city;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->stadium = new S();
        $this->city = new City();
    }

    public function index()
    {
        $this->data['stadion'] = $this->stadium->join('city', $this->data['join']['city_stadium'], 'inner')->orderBy('general_name', 'asc')->paginate($this->data['perPage']);
        $this->data['pager'] = $this->stadium->pager;

        echo view('backend/stadium/index', $this->data);
    }

    public function add()
    {
        $this->data["city"] = $this->city->orderBy('name_de', 'asc')->findAll();

        echo view('backend/stadium/add', $this->data);
    }

    public function create()
    {
        $generalName = $this->request->getPost('general_name');
        $latitude = $this->request->getPost('latitude');
        $longtitude = $this->request->getPost('longtitude');
        $city = $this->request->getPost('city');


        foreach ($generalName as $key => $row) {
            $data = array(
                'general_name' => $row,
                'latitude' => $latitude[$key],
                'longtitude' => $longtitude[$key],
                'id_city' => $city[$key],
            );
            //var_dump($data);
            $result =  $this->stadium->save($data);
        }

        //generování hlášek
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbAdd');
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-stadionu');
    }

    public function edit($id_stadion) {
        $this->data["stadion"] = $this->stadium->find($id_stadion);
        $this->data["city"] = $this->city->orderBy('name_de', 'asc')->findAll();

        echo view('backend/stadium/edit', $this->data);
    }

    public function update() {
        $general_name = $this->request->getPost('general_name');
        $latitude = $this->request->getPost('latitude');
        $longtitude = $this->request->getPost('longtitude');
        $id_city = $this->request->getPost('id_city');
        $id_stadium = $this->request->getPost('id_stadium');
        $data = array(
            'general_name' => $general_name,
            'latitude' => $latitude,
            'longtitude' => $longtitude,
            'id_city' => $id_city,
            'id_stadium' => $id_stadium
        );
        $result = $this->stadium->save($data);

        
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data2);



        return redirect()->route('admin/seznam-stadionu');
    }

    public function delete($id_stadion) {
        $result = $this->stadium->delete($id_stadion);

       
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        return redirect()->route('admin/seznam-stadionu');
    }
}
