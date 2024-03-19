<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Association as AsocModel;
use CodeIgniter\HTTP\RequestInterface;

use Psr\Log\LoggerInterface;

class Association extends BaseBackendController
{
    var $asocModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->asocModel = new AsocModel();
    }
    public function index()
    {
        $this->data["svazy"] = $this->asocModel->orderBy('general_name', 'asc')->findAll();
        echo view('backend/association/index', $this->data);
    }

    public function add()
    {
        echo view('backend/association/add', $this->data);
    }

    public function create()
    {
        $general_name = $this->request->getPost('general_name');
        $short_name = $this->request->getPost('short_name');
        $founded = $this->request->getPost('founded');

        $data = array(
            'general_name' => $general_name,
            'short_name' => $short_name,
            'founded' => $founded
        );

        $result =  $this->asocModel->save($data);

        $pole[] = [$result, 'dbAdd'];
        $this->errorMessage->makeErrorMessage($pole);

        return redirect()->route('admin/seznam-svazu');
    }

    public function edit($id)
    {

        $this->data['svaz'] = $this->asocModel->find($id);
        echo view('backend/association/edit', $this->data);
    }

    public function update()
    {
        $general_name = $this->request->getPost('general_name');
        $short_name = $this->request->getPost('short_name');
        $founded = $this->request->getPost('founded');
        $id_association = $this->request->getPost('id_association');
        $data = array(
            'general_name' => $general_name,
            'short_name' => $short_name,
            'founded' => $founded,
            'id_association' => $id_association
        );
        $result = $this->asocModel->save($data);

        $pole[] = [$result, 'dbEdit'];
        $this->errorMessage->makeErrorMessage($pole);

        return redirect()->route('admin/seznam-svazu');
    }

    public function delete($id)
    {
        $result = $this->asocModel->delete($id);

        $pole[] = [$result, 'dbDelete'];
        $this->errorMessage->makeErrorMessage($pole);

        return redirect()->route('admin/seznam-svazu');
    }
}
