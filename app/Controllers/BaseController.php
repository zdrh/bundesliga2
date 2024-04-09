<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use \IonAuth\Libraries\IonAuth;
use App\Libraries\ErrorMessage;
use Config\Main as MainConfig;
use stdClass;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
   /**
    * Instance of the main Request object.
    *
    * @var CLIRequest|IncomingRequest
    */
   protected $request;

   /**
    * An array of helpers to be loaded automatically upon
    * class instantiation. These helpers will be available
    * to all other controllers that extend BaseController.
    *
    * @var array
    */
   protected $helpers = ['html', 'form', 'myform', 'myhtml'];
   protected $ionAuth;
   protected $data;
   protected $mainConfig;
   protected $errorMessage;
   protected $delRows;
  
   
   
   /**
    * Be sure to declare properties for any property fetch you initialized.
    * The creation of dynamic property is deprecated in PHP 8.2.
    */
   // protected $session;
   protected $session;

   /**
    * @return void
    */
   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
   {
      // Do Not Edit This Line
      parent::initController($request, $response, $logger);

      // Preload any models, libraries, etc, here.

      $this->session = \Config\Services::session();
      $this->ionAuth = new IonAuth();

      if ($this->ionAuth->loggedIn()) {
         $this->data['profile'] = 'layout/profile';
      } else {
         $this->data['profile'] = 'layout/notLogged';
      }

      $this->errorMessage = new ErrorMessage();
      if (!isset($this->session->error)) {
         $chyba[] = $this->errorMessage->prepareMessage('', '', '', false);

         $this->session->setFlashdata('error', $chyba);
         
        
      }
      $this->data["error"] = $this->session->error;
      $this->mainConfig = new MainConfig();
      $this->data['uploadPath'] = $this->mainConfig->uploadPath;
      $this->data['join'] = $this->mainConfig->joinTable;
      $this->session->set('lastPage', current_url());
      $this->delRows = $this->mainConfig->deletedRows;
      $this->data["form"] = $this->mainConfig->form;
      $this->data["tableTemplate"] = $this->mainConfig->template;
   }
}
