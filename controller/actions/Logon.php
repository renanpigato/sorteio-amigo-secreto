<?php
namespace Actions;

use System\BaseAction;
use System\App;
use AmigoSecreto\Amigo;
use AmigoSecreto\AmigoQuery;
use AmigoSecreto\Map\AmigoTableMap;

use Propel\Runtime\ActiveQuery\Criteria;
use Zend\Session\Container as SessionContainer;

class Logon extends BaseAction {

  public function execute() {
        
    try {
            
      $telefone = $this->getParams('telefone');
      if(empty($telefone)) {
        throw new \Exception("Informe o telefone.");
      }

      $senha = $this->getParams('senha');
      if(empty($senha)) {
        throw new \Exception("Informe uma senha válida");
      }

      $this->autenticar($telefone, $senha);

    } catch (\Exception $e) {
      $this->setErrorMessage($e->getMessage());
      return false;
    }

    return true;
  }

  protected function autenticar($telefone, $senha) {

    $amigo = AmigoQuery::create()->add(AmigoTableMap::COL_TELEFONE, $telefone, Criteria::EQUAL)
                                ->findOne();

    if(!$amigo instanceof Amigo){
      throw new \Exception("Verifique o telefone e/ou senha informada!");
    }

    if (md5($senha) !== $amigo->getSenha()) {
      throw new \Exception("Verifique o telefone e/ou senha informada!");
    }

    $numeroAcesso = $amigo->getNumeroAcesso();

    if(empty($numeroAcesso)) {
      $numeroAcesso = 1;
    } else if($numeroAcesso > 1) {
      $numeroAcesso++;
    }

    $amigo->setNumeroAcesso($numeroAcesso);
    $amigo->save();

    if($numeroAcesso == 1) {
        $this->setSuccessRedirect('alteracaoSenha');
        $this->setSuccessMessage("Você deve alterar sua senha");
    }

    $objectAmigo = (object)$amigo->toArray();
    unset($objectAmigo->Password);

    $sessionContainer = new SessionContainer(App::getName());
    $sessionContainer->loggedUser = $objectAmigo;
    $sessionContainer->loggedUser->Nome          = $amigo->getNome();
    $sessionContainer->loggedUser->Telefon       = $amigo->getTelefone();
    $sessionContainer->loggedUser->IdRole        = $amigo->getId();
    $sessionContainer->loggedUser->NumeroAcesso  = $amigo->getNumeroAcesso();
    $sessionContainer->loggedUser->RoleList = [];
  }
}
