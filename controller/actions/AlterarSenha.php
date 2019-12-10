<?php
namespace Actions;

use AmigoSecreto\Amigo;
use AmigoSecreto\AmigoQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use System\App;
use System\BaseAction;
use Zend\Session\Container as SessionContainer;

use \Exception;

class AlterarSenha extends BaseAction {

  public function execute() {
        
    try {

      $senha = $this->getParams('senha');
      if(empty($senha)) {
        throw new Exception("Informe a senha atual");
      }

      $nova_senha1 = $this->getParams('nova_senha1');
      if(empty($nova_senha1)) {
        throw new Exception("Informe a nova senha");
      }

      $nova_senha2 = $this->getParams('nova_senha2');
      if(empty($nova_senha2)) {
        throw new Exception("Repita a nova senha");
      }

      if($nova_senha1 != $nova_senha2) {
        throw new Exception("Informe corretamente a nova senha");
      }

      $sessionContainer = new SessionContainer(App::getName());
      $idAmigo = $sessionContainer->loggedUser->Id;
      $amigo   = AmigoQuery::create()
                            ->filterById($idAmigo)
                            ->findOne();

      $this->alterar($amigo, $senha, $nova_senha1, $nova_senha2);

    } catch (Exception $e) {
      $this->setErrorMessage($e->getMessage());
      return false;
    }

    return true;
  }

  protected function alterar($amigo, $senha, $nova_senha1, $nova_senha2) {

    if(!$amigo instanceof Amigo){
      throw new Exception("Verifique o telefone e/ou senha informada!");
    }

    if (md5($senha) !== $amigo->getSenha()) {
      throw new Exception("Verifique a senha atual informada!");
    }

    $amigo->setSenha(md5($nova_senha1));
    $numeroAcesso = $amigo->getNumeroAcesso();

    if(empty($numeroAcesso) || $numeroAcesso == 1) {
        $numeroAcesso++;
        $amigo->setNumeroAcesso($numeroAcesso);
    }

    if(!$amigo->save()) {
      throw new Exception("Ocorreu um erro ao salvar a nova senha.");
    }

    $this->setSuccessMessage("Senha alterada com sucesso");
  }
}
