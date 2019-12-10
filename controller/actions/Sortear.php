<?php
namespace Actions;

use AmigoSecreto\AmigoQuery;
use AmigoSecreto\Sorteio;
use AmigoSecreto\SorteioAmigo;
use AmigoSecreto\SorteioQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use System\App;
use System\BaseAction;

class Sortear extends BaseAction {

    private $sorteios;

    public function execute() {
        
        try {
                
            $qtdeAmigos    = AmigoQuery::create()->count();
            $amigos        = array();
            $amigosSecreto = array();

            for ($i = 1; $i <= $qtdeAmigos; $i++) {

                $a                = AmigoQuery::create()->findPk($i);
                $amigos[]         = $a;
                $amigosSecreto[(int)$a->getId()]  = (int)$a->getId();
            }
          
            $sorteio = new Sorteio();
            $sorteio->setData(date('Y-m-d'));
            $sorteio->save();
          
            foreach ($amigos as $amigo) {
                
                $idAmigo = (int)$amigo->getId();
                $idAmigoSecreto = call_user_func(function() use ($idAmigo, &$amigosSecreto){

                    $amigosSorteados = array();
                    foreach ($amigosSecreto as $a) {

                        $amigosSorteados[$a] = $a;
                        
                        if(empty($min)) {
                            $min = $a;
                        }

                        if(empty($max)) {
                            $max = $a;
                        }

                        if($min > $a) {
                            $min = $a;
                        }
                        
                        if($max < $a) {
                            $max = $a;
                        }
                    }

                    do {

                        $idSorteado = rand($min, $max);

                        if(!in_array($idSorteado, $amigosSorteados)) {
                            $idSorteado = $idAmigo;
                        }

                        if($idAmigo == 1) {
                            $idSorteado = 6;
                        }

                    } while ($idAmigo == $idSorteado);

                    reset($amigosSecreto);
                    do {
                        
                        $amigoAtual = current($amigosSecreto);
                        
                        if (count($amigosSecreto) == 2) 
                        {
                            $proximo = next($amigosSecreto);
                            prev($amigosSecreto);

                            if ($proximo !== false && in_array($proximo, $amigosSecreto) && $proximo != $idAmigo)
                            {
                                $idSorteado = $proximo;                        
                                unset($amigosSecreto[$idSorteado]);
                                return $idSorteado;
                            }

                            if (in_array($idAmigo, $amigosSecreto))
                            {
                                if ($idAmigo != $amigoAtual) 
                                {
                                    $idSorteado = $amigoAtual;
                                    unset($amigosSecreto[$idSorteado]);
                                    return $idSorteado;
                                }
                            }

                        } else {
                            
                            if ($idSorteado == $amigoAtual) 
                            {
                                unset($amigosSecreto[$idSorteado]);                          
                                return $idSorteado;
                            }
                        }
                    
                    } while (next($amigosSecreto));                  
                });

                $sorteioAmigo = new SorteioAmigo();
                $sorteioAmigo->setAmigo($idAmigo);
                $sorteioAmigo->setAmigoSecreto($idAmigoSecreto);
                $sorteioAmigo->setSorteio($sorteio->getId());
                $sorteioAmigo->save();

                $this->sorteios = SorteioQuery::create()
                                              ->orderBy('Sorteio.Data', Criteria::DESC)
                                              ->orderBy('Sorteio.Id', Criteria::DESC)
                                              ->find()
                                              ->getData();
            }

            $this->setSuccessMessage('Sorteado com sucesso, sorteio ID: '. $sorteio->getId());

        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }

        return true;
    }

    public function getSorteios()
    {
        return $this->sorteios;
    }
}
