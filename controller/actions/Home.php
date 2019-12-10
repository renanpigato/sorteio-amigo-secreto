<?php
namespace Actions;

use System\App;
use System\BaseAction;

use Zend\Session\Container as SessionContainer;

/**
* 
*/
Class Home extends BaseAction
{
  public function execute()
  {
    try {
      
      $sessionContainer = new SessionContainer(App::getName());
      
      if((!App::getEnabledLogin() || $sessionContainer->loggedUser) && $sessionContainer->loggedUser->NumeroAcesso > 1) {
        $this->setSuccessRedirect('inicio');
        return true;
      }
      
      $this->setTemplate('BaseTemplateLayoutWithoutMenu.php');

    } catch (\Exception $e) {

      $this->setErrorMessage($e->getMessage());
      return false;
    }

    return true;
  }
}
