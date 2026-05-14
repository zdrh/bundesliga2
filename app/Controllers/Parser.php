<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use \voku\helper\HtmlDomParser;

use App\Models\Kola;
use App\Models\Zapasy;
use App\Models\Goly;
use App\Models\Soupiska;
use App\Models\Udalost;

use App\Libraries\ParserLibrary;

class Parser extends BaseController
{

    var $kola;
    var $zapasy;
    var $strelci;
    var $parser;
    var $soupiska;
    var $udalost;
    var $baseUrl;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->kola = new Kola();
        $this->zapasy = new Zapasy();
        $this->strelci = new Goly();
        $this->soupiska = new Soupiska();
        $this->udalost = new Udalost();
        $this->parser = new ParserLibrary();
        $this->baseUrl = "https://www.fussballdaten.de";
    }

    public function getRounds()
    {
        for ($i = 1964; $i <= 1974; $i++) {
            $pageKolo = $this->baseUrl . "/bundesliga/" . $i . "/";
            $stranka = HtmlDomParser::file_get_html($pageKolo);
            $seznamKol = $stranka->find('div#slider');
            foreach ($seznamKol->find('a') as $el) {
                $data = array(
                    'season' => $i,
                    'link' => $this->baseUrl . $el->href
                );
                $result =  $this->kola->save($data);
            }
        }
    }

    public function getMatches()
    {
        $data = $this->kola->where('season>', 1964)->findAll();
        foreach ($data as $row) {
            $url = $row->link;
            $season = $row->season;
            echo "<hr>";
            var_dump($url);
            echo "<hr>";
            $stranka = HtmlDomParser::file_get_html($url);
            $zapasy = $stranka->find('div.content-spiele', 0);
            foreach ($zapasy->find('div.spiele-row') as $el) {
                $link = $el->find('a.ergebnis', 0)->href;
                var_dump($link);

                $data = array(
                    'link' => $this->baseUrl . $link
                );

                $result = $this->zapasy->save($data);
                var_dump($result);
                echo "<br>";
            }
        }
    }

    public function getMatchInfo()
    {
       // $data = $this->zapasy->where('strelciZpracovano', 0)->where('soupiskaZpracovano', 0)->findAll(1);
       $data = $this->zapasy->where('strelciZpracovano', 0)->where('soupiskaZpracovano', 0)->findAll(40);
        foreach ($data as $row) {
            $link = $row->link;
            $id = $row->id;

            $zapas = HtmlDomParser::file_get_html($link);
            //info o zápasu
            $info = $this->parser->getMatchInfo($zapas->find('#ergebnis-wrapper', 0)->find('.ergebnis-info', 0));
            $data = array(
                'id' => $id,
                'datum' => $info['date'],
                'cas' => $info['time']
            );

            $teamD = $this->parser->getTeam($zapas->find('.box-spiel-verein', 0));
            $teamH = $this->parser->getTeam($zapas->find('.box-spiel-verein', 1));

            $vysledek = $this->parser->getGoals($zapas->find('.box-spiel-ergebnis', 0), 1);
            $polocas = $this->parser->getGoals($zapas->find('.ergebnis-info', 1), 0);

            $rozhodci = $this->parser->getReferee($zapas->find('div#myPjax ', 0)->find('div.row-flex', 1)->find('.col-md-4', 0)->find('.box-spielinfos', 0));
           // $string = $zapas->find('div#myPjax ', 0)->find('div.row-flex', 1)->find('.col-md-4', 0)->find('.box-spielinfos', 0);
           // $string = $string->find('div', 0);
           // var_dump($string);
            $misto = $this->parser->getPlace($zapas->find('div#myPjax ', 0)->find('div.row-flex', 1)->find('.col-md-4', 0)->find('.box-spielinfos', 0));
            $string = $zapas->find('div#myPjax ', 0)->find('div.row-flex', 1)->find('.col-md-8', 0)->find('.box-spielinfos', 0);
            echo "extra";
            //var_dump($string->plaintext);
            echo "extra";
            if($string->plaintext != ""){

                $data = array(
                    'event' => 1,
                    'id' => $id
                );
                $this->zapasy->save($data);
            }
            
            var_dump($misto);

             if ($vysledek['home'] != 0 or $vysledek['away'] != 0) {
                $goly = $this->parser->getScorers($zapas->find('ul#tore-timeline', 0));
            } else {
                $goly = NULL;
            }

            $golySave = false;
            $file = $link . "aufstellung/";
            $file = HtmlDomParser::file_get_html($file);
            if ($vysledek['home'] != 0 or $vysledek['away'] != 0 or $row->strelciZpracovano == 0) {
                $goly = $this->parser->getScorers($file->find('.teaser-torschuetzen', 0));
                $golySave = true;
            }
            $soupiskaSave = false;
            $fileRoster = $file->find('.aufstellung-body', 0);
            if ($row->soupiskaZpracovano == 0) {
                $domaci = $this->parser->getSoupiska($fileRoster, 1);
                $hoste = $this->parser->getSoupiska($fileRoster, 2);
                $soupiskaSave = true;
            }



            $data = array(
                'id' => $id,
                'datum' => $info['date'],
                'cas' => $info['time'],
                'domaci' => $teamD,
                'hoste' => $teamH,
                'golyD' => $vysledek['home'],
                'golyH' => $vysledek['away'],
                'polocasD' => $polocas['home'],
                'polocasH' => $polocas['away'],
                'rozhodci' => $rozhodci,
                'mistoZapasu' => $misto['town'],
                'stadion' => $misto['stadium'],
                'divaci' => $misto['attendance']
            );
            $result = $this->zapasy->save($data);



            if ($golySave) {
                foreach ($goly as $row) {
                    $dataStrelci = array(
                        'link' => $this->baseUrl . $row->player,
                        'minuta' => $row->time,
                        'skore' => $row->score,
                        'zapas' => $id,
                        'team' => $row->team,
                        'asistence' => $row->asistence,
                        'poznamka' => $row->poznamka
                    );
                    //var_dump($dataStrelci);
                    $result = $this->strelci->save($dataStrelci);
                }
                $data = array(
                    'strelciZpracovano' => true,
                    'id' => $id
                );
                $result = $this->zapasy->save($data);
            }
           
            if($soupiskaSave) {
                echo "<hr>";
                var_dump($domaci);
                echo "<hr>";
                var_dump($hoste);
                $data = array(
                    'rozestaveniD' => $domaci->rozestaveni,
                    'rozestaveniH' => $hoste->rozestaveni,
                    'trenerD' => $domaci->trener,
                    'trenerH' => $hoste->trener,
                    'id' => $id
                );
                $result = $this->zapasy->save($data);

                foreach($domaci->hraci as $row){
                    
                    $data = array(
                        'hrac' => $row->link,
                        'tym' => 'home',
                        'pozice' => $row->position,
                        'zapas' => $id,
                        'stridani' => $row->substitution,
                        'zaklad' => $row->type
                    );
                    
                    $result = $this->soupiska->save($data);
                }

                foreach($hoste->hraci as $row){
                    $data = array(
                        'hrac' => $row->link,
                        'tym' => 'away',
                        'pozice' => $row->position,
                        'zapas' => $id,
                        'stridani' => $row->substitution,
                        'zaklad' => $row->type
                    );
                    $result = $this->soupiska->save($data);
                }

                $data = array(
                    'id' => $id,
                    'soupiskaZpracovano' => true
                );

                $result = $this->zapasy->save($data);

            }
        }
    }
}
