<?php
namespace Control;

use AmigoSecreto\AmigoQuery;
use AmigoSecreto\Map\AmigoTableMap;

use Propel\Runtime\ActiveQuery\Criteria;

use System\MappingActions;
use System\ConfigAction;
use System\BaseAction;
use System\App;

use Zend\Session\Container as SessionContainer;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Validator\HttpUserAgent;


class Controller {

  private static $instance;
  private $mappingActions = null;
  private $route          = '';
  private $params         = null;
  private $actionToGo     = null;
  private $friendlyURL    = null;
  private $objectAction   = null;

  public function __construct() {}

  public static function getInstance() {

    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    }

    return self::$instance;
  }

  public function initializeSession() {

    $sessionConfig = new SessionConfig();
    $sessionConfig->setOptions(App::getSessionConfig());
    $sessionManager = new SessionManager($sessionConfig);
    $sessionManager->start();
    SessionContainer::setDefaultManager($sessionManager);
  }

  public function initializePreConditions() {

    if(App::getEnabledLogin()) {
      $this->initializeSession();
    }

    $this->mappingActions = MappingActions::getInstance();

    $baseActions     = $this->mappingActions->transformActionsJSONToArray();
    $businessActions = $this->mappingActions->transformActionsJSONToArray(App::getCacheActionsName());
    $actions         = array_merge($baseActions, $businessActions);
    $actionsList     = array();

    foreach ($actions as $key => $action) {
      $actionsList[$key] = new ConfigAction($action);
    }
        
    $this->mappingActions->setListOfActions($actionsList);
  }

  public function execute() {

    $this->initializePreConditions();
    
    $objectActionError = new BaseAction();
    $objectActionError->setPageError(App::getPageErrorDefault());
    $objectActionError->setErrorTemplate(App::getTemplateErrorDefault());
    $objectActionError->setMenu(App::getMenuDefault());

    try {

      if(preg_match('/([views.*]*)(html\/.*)/', $_SERVER['REQUEST_URI'], $path)) {

        $location = $path[0];
        if(empty($path[1])) {

          $location = '';
          if(!empty(App::getPath()))
            $location = DS . App::getPath() . DS;

          $location .= "views" .DS. "pages" .DS. $path[0];
        }

        return require_once $location;
      }

      $this->setRoute();

      if (empty($this->route)) {
        throw new \Exception('Verifique a url digitada, não foi possível verificar a rota!');
      }
      
      if (empty(str_replace("/", "", $this->route))) {
        $this->route = 'home';
      }

      $this->setParams();

      $listActions = $this->mappingActions->getListOfActions();

      if (!array_key_exists($this->route, $listActions)) {
        throw new \Exception('Verifique a url digitada, ação não encontrada!');
      }

      $this->executeAction($listActions[$this->route]);

    } catch (\Exception $oErr) {

      if(!empty($this->objectAction)) {

        $this->objectAction->setErrorMessage($oErr->getMessage());
        return $this->objectAction->error();
      }
      
      $objectActionError->setErrorMessage($oErr->getMessage());
      $objectActionError->error();
    }
  }

  public function setRoute() {

    $this->route = 'home';

    if (isset($_GET['r']) && $_GET['r'] != "" || isset($_GET['r'])) {

      $this->friendlyURL = FALSE;
      $this->route = $_GET['r'];

    } else if (isset($_SERVER['PATH_INFO'])) {

      $this->friendlyURL = TRUE;
      $this->route = $_SERVER['PATH_INFO'];

      if(isset($_GET)){

        $path = '';
        foreach ($_GET as $key => $value) {
          $this->params[$key] = $value;
          $path.= '/'.$key.'='.$value;
        }
        $location = $_SERVER['PHP_SELF'].$path;
        unset($_GET);
      }
    }
  }

  public function setParams($paramToSet = array()) {

    if(!empty($paramToSet)) {
      return $this->params = array_merge($this->params, $paramToSet);
    }

    if ($this->friendlyURL) {

      if (strpos($this->route, "/") === 0) {

        $this->route = substr($this->route, 1);
      }

      $path        = explode("/", $this->route, 2);
      $this->route = $path[0];

      if (count($path) == 2){
                
        $params = explode("/", $path[1]);

        foreach ($params as $param) {

          $p = explode('=', $param);

          if(is_array($p) && count($p) >= 2) {
            $this->params[$p[0]] = $p[1];
          }
        }
      }

      if(empty($this->params)) {
        $this->params = array();
      }

      $this->params = array_merge($this->params, $_POST);

    } else {

      if(isset($_GET['r'])) 
        unset($_GET['r']);

      $this->params = array_merge($_GET, $_POST);
    }
    
    $this->params = array_merge($this->params, $_FILES);
  }

  public function verifyLogin($actionToGo) {

    if(App::getEnabledLogin()) {

      $sessionContainer = new SessionContainer(App::getName());
            
      if($sessionContainer->loggedUser){
            
        // Papel do administrador (1), pode todas as ações
        if((int)$sessionContainer->loggedUser->IdRole !== 1){

          if(!is_array($this->objectAction->getPermissao()) && $this->objectAction->getPermissao() != 'ALL' ) {
            throw new \Exception("A configuração de permissão da ação solicitada, contém erros.\nContate o suporte");
          }

          if(is_array($this->objectAction->getPermissao())) {

            if(!in_array($sessionContainer->loggedUser->IdRole, $this->objectAction->getPermissao())) {
              throw new \Exception('Você não possui permissão para executar esta ação!');
            }
          }
        }

      } else {

        if($this->objectAction->getNeedLogin()){

          unset($this->objectAction);
          throw new \Exception('Você precisa estar logado para executar esta ação!');
        }
      }

    } else {

      $this->objectAction->setNeedLogin(false);
      $this->objectAction->setDisabledLogin(true);
    }
  }

  public function executeAction(ConfigAction $actionToGo, $successMessage = null, $errorMessage = null) {

    $listActions = $this->mappingActions->getListOfActions();

    $class        = new \ReflectionClass('Actions\\'. $actionToGo->getNeededClass());
    $this->objectAction = $class->newInstance();
    $this->objectAction->setTemplate($actionToGo->getBaseTemplate());
    $this->objectAction->setNeedSSL($actionToGo->getNeedSSL());
    $this->objectAction->setNeedLogin($actionToGo->getNeedLogin());
    $this->objectAction->setIsAJAX($actionToGo->getIsAJAX());
    $this->objectAction->setPage($actionToGo->getIncludePage());
    $this->objectAction->setMenu($actionToGo->getMenu());
    $this->objectAction->setErrorTemplate($actionToGo->getErrorTemplate());
    $this->objectAction->setPageError($actionToGo->getError());
    $this->objectAction->setPermissao($actionToGo->getPermissao());
    $this->objectAction->setParams($this->params);
    $this->objectAction->setSuccessRedirect($actionToGo->getSuccessRedirect());

    $acoesSemRedirecionamentoDeAcesso = array('logout', 'logon', 'alteracaoSenha', 'alterarSenha');
    if( !in_array(($this->route), $acoesSemRedirecionamentoDeAcesso)) {

      if(App::getEnabledLogin()) {

        $sessionContainer = new SessionContainer(App::getName());

        if($sessionContainer->loggedUser){
     
          $amigo = AmigoQuery::create()
                              ->add(AmigoTableMap::COL_ID, $sessionContainer->loggedUser->Id, Criteria::EQUAL)
                              ->findOne();

          if($amigo->getNumeroAcesso() == 1) {

            $this->route = 'alteracaoSenha';
            $this->objectAction->setSuccessMessage('Você deve alterar sua senha');
            
            return $this->executeAction(
              $listActions['alteracaoSenha'], 
              $this->objectAction->getSuccessMessage(), 
              $this->objectAction->getErrorMessage()
            );
          }
        }
      }
    }

    if(!empty($successMessage)) {
      $this->objectAction->setSuccessMessage($successMessage);
    }

    if(!empty($errorMessage)) {
      $this->objectAction->setErrorMessage($errorMessage);
    }

    if(App::getSSL()) {
        
      if($this->objectAction->getNeedSSL()) {

        if(empty($_SERVER['HTTPS']) || $_SERVER['REQUEST_SCHEME'] == 'http') {
          header( 'Location: https://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
        }
      }
    }
    
    if($actionToGo->getNeededClass() != 'Logout') {
      $this->verifyLogin($actionToGo);
    }
    
    if(!empty($this->objectAction) && $this->objectAction->getIsAJAX() == true) {

      if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == false || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {

        unset($this->objectAction);
        throw new \Exception('Apenas AJAX nesta URL!');
      }
    }
    
    if ( !$this->objectAction->execute() ) {
        
      $this->objectAction->setPage('');
      $this->objectAction->error($actionToGo->getError());
      return false;
    }

    if( !$this->objectAction->getSuccessRedirect() ) {

      $this->objectAction->setPageError('');
      $this->objectAction->includePage();
      return true;
    }
    
    $this->executeAction(
      $listActions[$this->objectAction->getSuccessRedirect()], 
      $this->objectAction->getSuccessMessage(), 
      $this->objectAction->getErrorMessage()
    );
  }

  public function log($msg) {
    
    if(App::isDevelopmentMode()) {

      if(empty($this->logger)) {

        // Create the logger
        $this->logger = new Logger('rotas_executadas');
          
        // Now add some handlers
        $this->logger->pushHandler(new StreamHandler(App::getTemporaryPath(). '/rotas_executadas.log', Logger::DEBUG));
      }

      $this->logger->info($msg);
    }
  }
}
