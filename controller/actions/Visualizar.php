<?php
namespace Actions;

use AmigoSecreto\AmigoQuery;
use AmigoSecreto\SorteioAmigoQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use System\App;
use System\BaseAction;
use Zend\Session\Container as SessionContainer;

class Visualizar extends BaseAction {

    private $amigos = array();

    public function execute() {
        
        try {

            $sessionContainer = new SessionContainer(App::getName());
            $idSorteio = $this->getParams('idSorteio');
            
            $idAmigo   = $sessionContainer->loggedUser->Id;

            if(!empty($idSorteio)) {
                $sorteioAmigos = SorteioAmigoQuery::create()
                                                  ->filterByAmigo($idAmigo)
                                                  ->filterBySorteio($idSorteio)
                                                  ->orderBy('SorteioAmigo.Id', Criteria::DESC);
            } else {
                $sorteioAmigos = SorteioAmigoQuery::create()
                                                  ->filterByAmigo($idAmigo)
                                                  ->orderBy('SorteioAmigo.Id', Criteria::DESC)
                                                  ->find()
                                                  ->getData();
            }

            foreach ($sorteioAmigos as $sorteioAmigo) {

                $amigo        = AmigoQuery::create()->findPk($sorteioAmigo->getAmigo());
                $amigoSecreto = AmigoQuery::create()->findPk($sorteioAmigo->getAmigoSecreto());
              
                $this->amigos[] = (object)array(
                    'amigo'        => $amigo->getNome(),
                    'amigoSecreto' => $amigoSecreto->getNome(),
                    'sorteio'      => $sorteioAmigo->getSorteio()
                );
            }

        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }

        return true;
    }

    public function getAmigos()
    {
        return $this->amigos;
    }
}
