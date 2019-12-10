<?php
namespace Actions;

use System\BaseAction;
use System\App;
use Butler\User;
use Butler\UserQuery;
use BUtler\Map\PersonTableMap;

use Propel\Runtime\ActiveQuery\Criteria;
use Zend\Session\Container as SessionContainer;

class Logout extends BaseAction {

  public function execute() {

    $sessionContainer = new SessionContainer(App::getName());
    $sessionContainer->getManager()->destroy();

    return true;
  }
}