<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

use App\Models\City as C;

class City extends BaseBackendController
{
    var $city;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->city = new C();
    }
    public function index()
    {
        $this->data['city'] = $this->city->orderBy('name_de', 'asc')->paginate($this->data['perPage']);
        $this->data['pager'] = $this->city->pager;

        echo view('backend/city/index', $this->data);
    }

    public function add() {
        echo view('backend/city/add', $this->data);
    }

    public function create() {
        $nameDe = $this->request->getPost('name_de');
        $nameCz = $this->request->getPost('name_cz');
        
       
        foreach($nameDe as $key => $row) {
            $data = array(
                'name_de' => $row,
                'name_cz' => $nameCz[$key]
            );
            var_dump($data);
           $result =  $this->city->save($data);
        }

        //generování hlášek
        
        
    $data2[] =  $this->errorMessage->prepareMessage($result, 'dbAdd');
        $this->session->setFlashdata('error', $data2);

        
       
        return redirect()->route('admin/seznam-mest');
    }

    public function edit($id_city) {
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

        $this->city->save($data);

        return redirect()->route('admin/seznam-mest');
        
    }

    public function delete($id_city) {
        $result = $this->city->delete($id_city);

       
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        return redirect()->route('admin/seznam-mest');
    }
}
