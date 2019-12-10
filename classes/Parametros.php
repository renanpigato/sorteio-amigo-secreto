<?php
namespace Classes;

use AmigoSecreto\ActionsQuery;

class Parametros {

	const FORMATO_BR = 'BR';
	const FORMATO_EN = 'EN';

	private static $instance;

	public static function create()
	{
    if (!isset(self::$instance)){
      $class = __CLASS__;
      self::$instance = new $class;
    }

    return self::$instance;
  }

	public static function getRotas()
	{
		$rotas = ActionsQuery::create()->find()->getData();
		$acoes = array();

		foreach ($rotas as $rota) {

			if($rota->getPermission() != 'ALL' && !empty($rota->getPermission())) {
			// if(preg_match("/(\d*?)[\,]/", $rota->getPermission(), $permissaoEncontrada)) {
				$rota->setPermission($permissaoEncontrada);
			}

			$acoes[$rota->getName()] = (object)$rota->toArray();
		}

		return $acoes;
	}

  public function getLocalidade()
  {
    return 'Viamão';
  }
  
  public function getEmpresa()
  {
    return null;
  }
}
