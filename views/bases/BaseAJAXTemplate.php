<?php 
$retorno            = new \stdClass();
$retorno->erro      = null;
$retorno->message   = '';
$retorno->errorCode = null;

  if ($this->getPageError() != "") {
    $retorno->erro    = true;
    $retorno->message = $this->getErrorMessage();

    if(empty($retorno->errorCode)) {
      $retorno->errorCode = 500;
    }

    http_response_code($retorno->errorCode);
  }

  else if ($this->getPage() != "") {
    $retorno->erro    = false;
    $retorno->message = $this->getSuccessMessage();
    require_once 'views/pages/ajax/' . $this->getPage();
  }

$retorno->message = urlencode($retorno->message);

header("Content-Type: application/json");
echo json_encode($retorno);
