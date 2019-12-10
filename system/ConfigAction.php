<?php
namespace System;

class ConfigAction{
    
    private $neededClass;
    private $archive;
    private $needSSL;
    private $needLogin;
    private $isAJAX;
    private $baseTemplate;
    private $menu;
    private $errorTemplate;
    private $includePage;
    private $error;
    private $permissao;
    private $successRedirect;
    private static $instance;


    public function __construct($configAction) {
        
        $this->populateActions($configAction);
    }

    public function populateActions(Array $array){
        
        $this->setNeededClass($array['NeededClass']);
        if(empty($array['NeededClass'])) {
            $this->setNeededClass(App::getActionDefault());
        }

        $this->setArchive($array['Archive']);
        if(empty($array['Archive'])) {
            $this->setArchive($this->getNeededClass());
        }
        if(preg_match('/(.*?)[\\.ph]*$/', $this->getArchive())) {
            $this->setArchive(preg_replace('/(.*?)[\\.ph]*$/', "$1.php", $this->getArchive(), 1));
        }

        $this->setNeedSSL($array['NeedSSL']);
        $this->setNeedLogin($array['NeedLogin']);
        $this->setIsAJAX($array['IsAJAX']);
        
        $this->setBaseTemplate($array['BaseTemplate']);
        if(empty($array['BaseTemplate'])) {
            
            $this->setBaseTemplate(App::getTemplateDefault());

            if($this->getIsAJAX()) {
                $this->setBaseTemplate(App::getTemplateAJAXDefault());
            }
        }
        if(preg_match('/(.*?)[\\.ph]*$/', $this->getBaseTemplate())) {
            $this->setBaseTemplate(preg_replace('/(.*?)[\\.ph]*$/', "$1.php", $this->getBaseTemplate(), 1));
        }

        $this->setMenu($array['Menu']);
        if(empty($array['Menu'])) {
            $this->setMenu(App::getMenuDefault());
        }
        if(preg_match('/(.*?)[\\.ph]*$/', $this->getMenu())) {
            $this->setMenu(preg_replace('/(.*?)[\\.ph]*$/', "$1.php", $this->getMenu(), 1));
        }

        $this->setErrorTemplate($array['ErrorTemplate']);
        if(empty($array['ErrorTemplate'])) {
            
            $this->setErrorTemplate(App::getTemplateErrorDefault());
            
            if($this->getIsAJAX()) {
                $this->setErrorTemplate(App::getTemplateAJAXDefault());
            }
        }
        if(preg_match('/(.*?)[\\.ph]*$/', $this->getErrorTemplate())) {
            $this->setErrorTemplate(preg_replace('/(.*?)[\\.ph]*$/', "$1.php", $this->getErrorTemplate(), 1));
        }

        $this->setIncludePage($array['IncludePage']);
        if(preg_match('/(.*?)[\\.ph]*$/', $this->getIncludePage())) {
            $this->setIncludePage(preg_replace('/(.*?)[\\.ph]*$/', "$1.php", $this->getIncludePage(), 1));
        }

        $this->setError($array['Error']);
        if(empty($array['Error'])) {
            $this->setError(App::getPageErrorDefault());
        }
        if(preg_match('/(.*?)[\\.ph]*$/', $this->getError())) {
            $this->setError(preg_replace('/(.*?)[\\.ph]*$/', "$1.php", $this->getError(), 1));
        }
        
        $this->setPermissao($array['Permission']);
        $this->setSuccessRedirect($array['SuccessRedirect']);
    }
    
    public static function getInstance(){

        if (!isset(self::$instance)){
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }
    
    public function getNeededClass() {
        return $this->neededClass;
    }

    public function getArchive() {
        return $this->archive;
    }

    public function getNeedSSL() {
        return $this->needSSL;
    }

    public function getNeedLogin() {
        return $this->needLogin;
    }
    
    public function getIsAJAX() {
        return $this->isAJAX;
    }

    public function getBaseTemplate() {
        return $this->baseTemplate;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function getErrorTemplate() {
        return $this->errorTemplate;
    }

    public function getIncludePage() {
        return $this->includePage;
    }

    public function getError() {
        return $this->error;
    }
    
    public function getPermissao() {
        return $this->permissao;
    }
    
    public function getSuccessRedirect() {
        return $this->successRedirect;
    }

    public function setNeededClass($neededClass) {
        $this->neededClass = $neededClass;
    }

    public function setArchive($archive) {
        $this->archive = $archive;
    }

    public function setNeedSSL($needSSL) {
        $this->needSSL = $needSSL;
    }

    public function setNeedLogin($needLogin) {
        $this->needLogin = $needLogin;
    }
    
    public function setIsAJAX($isAJAX) {
        $this->isAJAX = $isAJAX;
    }

    public function setBaseTemplate($baseTemplate) {
        $this->baseTemplate = $baseTemplate;
    }
    
    public function setMenu($menu) {
        $this->menu = $menu;
    }

    public function setErrorTemplate($errorTemplate) {
        $this->errorTemplate = $errorTemplate;
    }

    public function setIncludePage($includePage) {
        $this->includePage = $includePage;
    }
    
    public function setError($error) {
        $this->error = $error;
    }
    
    public function setPermissao($permissao) {
        $this->permissao = $permissao;
    }
    
    public function setSuccessRedirect($successRedirect) {
        $this->successRedirect = $successRedirect;
    }
}