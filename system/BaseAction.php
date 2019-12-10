<?php
namespace System;

class BaseAction{
    
    protected $mapSpecialChars = array(
        'á' => 'a',
        'à' => 'a',
        'ã' => 'a',
        'â' => 'a',
        'é' => 'e',
        'ê' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'ç' => 'c',
        'Á' => 'A',
        'À' => 'A',
        'Ã' => 'A',
        'Â' => 'A',
        'É' => 'E',
        'Ê' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ú' => 'U',
        'Ü' => 'U',
        'Ç' => 'C'
    );
    
    private $template;
    private $errorTemplate;
    private $pageError;
    private $page;
    private $menu;
    private $successMessage;
    private $errorMessage;
    private $params;
    private $isAJAX;
    private $permissao;
    private $needLogin;
    private $needSSL;
    private $disabledLogin = false;
    private $successRedirect;
    public  $model;
    public  $listOfModel;
    public  $dao;

    public function __construct() {
        $this->successMessage = '';
    }

    public static function getInstance(){

        if (!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }
            
    public function execute(){
        return true;
    }
    
    public function includePage($page = null){
        
        if($page != null)
            $this->setPage($page);
        
        include_once 'views/bases/'.$this->template;
    }

    public function error($pageError = null){
        
        if($pageError != null){
            $this->setPageError($pageError);
        }
        
        include_once 'views/bases/'.$this->errorTemplate;
    }
    
    public function getTemplate() {
        return $this->template;
    }

    public function getErrorTemplate() {
        return $this->errorTemplate;
    }

    public function getPageError() {
        return $this->pageError;
    }

    public function getPage() {
        return $this->page;
    }
    
    public function getMenu() {
        return $this->menu;
    }

    public function getSuccessMessage() {
        return $this->successMessage;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }
    
    public function getParams($param = null) {

        if(!empty($param)) {
            return isset($this->params[$param]) ? $this->params[$param] : null;
        }
        return $this->params;
    }
    
    public function getIsAJAX() {
        return $this->isAJAX;
    }
    
    public function getPermissao() {
        return $this->permissao;
    }
    
    public function getNeedLogin() {
        return $this->needLogin;
    }

    public function getNeedSSL() {
        return $this->needSSL;
    }
    
    public function getDisabledLogin() {
        return $this->disabledLogin;
    }
    
    public function getSuccessRedirect() {
        return $this->successRedirect;
    }

    public function setTemplate($template) {
        $this->template = $template;
    }
    
    public function setErrorTemplate($errorTemplate) {
        $this->errorTemplate = $errorTemplate;
    }
    
    public function setPageError($pageError) {
        $this->pageError = $pageError;
    }

    public function setPage($page) {
        $this->page = $page;
    }
    
    public function setMenu($menu) {
        $this->menu = $menu;
    }

    public function setSuccessMessage($successMessage) {
        $this->successMessage = $successMessage;
    }

    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }     
    
    public function setParams($params) {
        $this->params = $params;
    }
    
    public function setIsAJAX($isAJAX) {
        $this->isAJAX = $isAJAX;
    }
    
    public function setPermissao($permissao) {
        $this->permissao = $permissao;
    }
    
    public function setNeedLogin($needLogin) {
        $this->needLogin = $needLogin;
    }
    
    public function setNeedSSL($needSSL) {
        $this->needSSL = $needSSL;
    }
    
    public function setDisabledLogin($disabledLogin) {
        $this->disabledLogin = $disabledLogin;
    }
    
    public function setSuccessRedirect($successRedirect) {
        $this->successRedirect = $successRedirect;
    }

    public function addParam($paramKey, $paramValue)
    {
        $this->params[$paramKey] = $paramValue;
    }
}
