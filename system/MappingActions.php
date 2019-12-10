<?php
namespace System;

use Classes\Parametros;

class MappingActions{
    
    protected static $instance;
    private $listOfActions;
    
    public function __construct($listOfActions = null) {
        
        if(!empty($listOfActions)) {
            foreach ($listOfActions as $key => $value) {
                
                $this->listOfActions[$key] = new ConfigAction($value);
            }
        }
    }

    public static function getInstance() {

        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }
    
    public function getListOfActions() {
        return $this->listOfActions;
    }

    public function setListOfActions($listOfActions) {
        $this->listOfActions = $listOfActions;
    }

    public function transformActionsJSONToArray($fileName = 'actions.cache.json') {

        $cacheFile  = App::getCacheActionsDir();
        $cacheFile .= DIRECTORY_SEPARATOR;
        $cacheFile .= $fileName;

        if(!file_exists($cacheFile)) {
           $this->buildCacheActions($cacheFile);
        }

        $itens           = json_decode(file_get_contents($cacheFile));
        $itensModificado = array();
        
        foreach ($itens as $item) {
          $itensModificado[key($item)] = (array)$item->{key($item)};        
        }

        return $itensModificado;
    }

    private function buildCacheActions($fileName) {

        $rotas      = Parametros::getRotas();
        end($rotas);
        $ultimaRota = key($rotas);
        reset($rotas);

        file_put_contents($fileName, '[');

        foreach ($rotas as $nomeRota => $rota) {
            
            $acao  = '{"'. $nomeRota . '":';
            $acao .= json_encode($rota);
            $acao .= '}';

            if($ultimaRota != $nomeRota) {
                $acao .= ',';
            }

            file_put_contents($fileName, $acao, FILE_APPEND);
        }

        file_put_contents($fileName, ']', FILE_APPEND);
    }
}
