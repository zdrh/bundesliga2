<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\SourceType as St;

class SourceType extends BaseBackendController
{
    private object $sourceType;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->sourceType = new St();
        return parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $this->data['seznamTypu'] = $this->sourceType->orderBy('name', 'asc')->findAll();

        echo view('backend/source_type/index', $this->data);
    }

    public function add()
    {

        echo view('backend/source_type/add', $this->data);
    }

    public function create()
    {
        $name = $this->request->getPost('name');
        
       
        foreach($name as $row) {
            $data = array(
                'name' => $row
            );
           
           $result =  $this->sourceType->save($data);
           $alertMess = new \stdClass();
           $alertMess->status = $result;
           $alertMess->type = 'dbAddCount';
           $alertMess->id = $this->sourceType->insertID;
           $alerts[] = $alertMess;
           
        }

        $data2 =  $this->errorMessage->prepareMessage3($alerts);
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-typu-zdroju');
    }

    public function edit(int $id){
    
        $this->data['typ_zdroje'] = $this->sourceType->find($id);
        echo view('backend/source_type/edit', $this->data);
    }

    public function update() {
        $name = $this->request->getPost('name');
        $id = $this->request->getPost('id');
        
        $data = array(
            'name' => $name,
            'id_source_type' => $id
            
        );
        $result = $this->sourceType->save($data);

        
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data2);



        return redirect()->route('admin/seznam-typu-zdroju');
    }

     public function delete(int $id) {
        $result = $this->sourceType->delete($id);

       
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        return redirect()->route('admin/seznam-typu-zdroju');
    }
}
