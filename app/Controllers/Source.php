<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Source as S;
use App\Models\SourceType;
use Config\Main;
use App\Libraries\ArrayLibrary;

class Source extends BaseBackendController
{

    private object $source;
    private object $sourceType;
    private object $config;
    private object $arrayLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->source = new S();
        $this->sourceType = new SourceType();
        $this->config = new Main();
        $this->arrayLib = new ArrayLibrary();

        return parent::initController($request, $response, $logger);
    }
    public function index()
    {
        $this->data['seznamZdroju'] = $this->source->select('source.name as NazevZdroje, source_type.name as NazevTypu, source.id_source')->join('source_type', $this->data['join']['source_source_type'])->orderBy('source.name', 'asc')->paginate($this->config->perPage);

        echo view('backend/source/index', $this->data);
    }

    public function add()
    {
        $seznamZdroju = $this->sourceType->orderBy('name', 'asc')->findAll();
        $this->data['seznamTypu'] = $this->arrayLib->arrayToDropdown($seznamZdroju, 'id_source_type', 'name');

        echo view('backend/source/add', $this->data);
    }

    public function create()
    {
        $name = $this->request->getPost('name');
        $sourceType = $this->request->getPost('source_type');

        foreach ($name as $key => $row) {
            $data = array(
                'name' => $row,
                'id_source_type' => $sourceType[$key]
            );
            var_dump($data);
            $result =  $this->source->save($data);

            $alertMess = new \stdClass();
            $alertMess->status = $result;
            $alertMess->type = 'dbAddCount';
            $alertMess->id = $this->sourceType->insertID;
            $alerts[] = $alertMess;
        }

        $data2 =  $this->errorMessage->prepareMessage3($alerts);
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-zdroju');
    }

    public function edit(int $id)
    {
        $this->data['zdroj'] = $this->source->find($id);

        $seznamZdroju = $this->sourceType->orderBy('name', 'asc')->findAll();
        $this->data['seznamTypu'] = $this->arrayLib->arrayToDropdown($seznamZdroju, 'id_source_type', 'name');
        echo view('backend/source/edit', $this->data);
    }

    public function update()
    {
        $name = $this->request->getPost('name');
        $sourceType = $this->request->getPost('source_type');
        $id = $this->request->getPost('id');

        $data = array(
            'name' => $name,
            'id_source_type' => $sourceType,
            'id_source' => $id

        );
        $result = $this->source->save($data);


        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data2);

        return redirect()->route('admin/seznam-zdroju');
    }

    public function delete(int $id) {
         $result = $this->source->delete($id);

       
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        return redirect()->route('admin/seznam-zdroju');
    }
}
