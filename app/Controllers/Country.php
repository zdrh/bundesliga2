<?php

namespace App\Controllers;

use App\Controllers\BaseBackEndController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Country as C;
use stdClass;

class Country extends BaseBackendController
{
    var $country;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->country = new C();
    }

    public function index()
    {
        $this->data["country"] = $this->country->orderBy('name', 'asc')->paginate($this->data['perPage']);
        $this->data["pager"] = $this->country->pager;

        echo view('backend/country/index', $this->data);
    }

    public function add() {

        echo view('backend/country/add', $this->data);
    }

    public function create() {
        $name = $this->request->getPost('name');
        $shortName = $this->request->getPost('short_name');
        
       
        foreach($name as $key => $row) {
            $data = array(
                'name' => $row,
                'short_name' => $shortName[$key]
            );
           
           $result =  $this->country->save($data);
           $alertMess = new stdClass();
           $alertMess->status = $result;
           $alertMess->type = 'dbAddCount';
           $alertMess->id = $this->country->insertID;
           $alerts[] = $alertMess;
           
        }

        $data2 =  $this->errorMessage->prepareMessage3($alerts);
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-zemi');
    }

    public function edit($id_country) {
        $this->data['country'] = $this->country->find($id_country);
        echo view ('backend/country/edit', $this->data);
    }

    public function update() {
        $name = $this->request->getPost('name');
        $shortName = $this->request->getPost('short_name');
        $idCountry = $this->request->getPost('id_country');

        $data = array(
            'name' => $name,
            'short_name' => $shortName,
            'id_country' => $idCountry
        );

        $result = $this->country->save($data);
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-zemi');
    }

    public function delete($id_country) {
        $result = $this->country->delete($id_country);

       
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        return redirect()->route('admin/seznam-zemi');
    }


}
