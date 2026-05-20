<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\LeagueSeason;
use App\Models\Person;
use App\Models\RefereeSeason;

use App\Libraries\ArrayLibrary;
use App\Libraries\AlertLibrary;

class Referee extends BaseBackendController
{
    private object $leagueSeason;
    private object $person;
    private object $refereeSeason;
    private object $arrayLib;
    private object $alertLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->leagueSeason = new LeagueSeason();
        $this->person = new Person();
        $this->refereeSeason = new RefereeSeason();
        $this->arrayLib = new ArrayLibrary();
        $this->alertLib = new AlertLibrary();

        return parent::initController($request, $response, $logger);
    }

    public function index(int $idLeagueSeason){
        
    }

    public function add(int $idLeagueSeason)
    {
        $this->data['liga'] = $this->leagueSeason->join('league', $this->data['join']['league_season_league'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->find($idLeagueSeason);

        $rozhodci = $this->person->select('person.*, referee_season.id_league_season')->join('referee_season', $this->data['join']['person_referee_season'], 'left')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->findAll();
        $rozhodci = $this->arrayLib->combineAttributes($rozhodci, ['first_name', 'last_name'], 'full_name');
        $this->data['rozhodci'] = $this->arrayLib->arrayToDropdown($rozhodci, 'id_person', 'full_name');
        $vybraniRozhodci = $this->refereeSeason->where('id_league_season', $idLeagueSeason)->findAll();
        $this->data['vybraniRozhodci'] = $this->arrayLib->transformArray($vybraniRozhodci, 'id_person');

        echo view('backend/referee/add', $this->data);
    }

    public function create(int $idLeagueSeason)
    {
        $alerts = array();
        $person = $this->request->getPost('referee');
        foreach ($person as $key) {
            $data = array(
                'id_league_season' => $idLeagueSeason,
                'id_person' => $key
            );
            $result =  $this->refereeSeason->save($data);
            $alerts[] = $this->alertLib->createAlert($result, 'dbAddCount', $this->refereeSeason->insertID);
        }
        $data2 =  $this->errorMessage->prepareMessage3($alerts);
        $this->session->setFlashdata('error', $data2);

        return redirect()->to('admin/liga/' . $idLeagueSeason . '/info');
    }
}
