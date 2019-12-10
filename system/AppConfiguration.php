<?php
namespace System;

class AppConfiguration {

  /*
   * Define uma instância da classe de aplicação com as configurações
   **/
  public static $instance;

  /**
   * Diretório do cache das rotas
   **/
  private $cacheActionsDir;

  /**
   * Nome do fonte de cache das rotas
   **/
  private $cacheActionsName;

  /**
   * Local do cache das rotas
   **/
  private $cacheActions;

  /**
   * Página de erro padrão do sistema
   */
  private $pageErrorDefault;
  
  /**
   * Template de erro padrão do sistema
   */
  private $templateErrorDefault;

  /**
   * Template padrão do sistema
   */
  private $templateDefault;

  /**
   * Template padrão do sistema para requisições AJAX
   */
  private $templateAJAXDefault;
  
  /**
   * Menu padrão do sistema
   */
  private $menuDefault;

  /**
   * Ação padrão do sistema
   */
  private $actionDefault;

  /**
   * Nome da aplicação
   **/
  private $name;

  /**
   * Título da aplicação
   **/
  private $title;

  /**
   * Logo da empresa
   */
  private $logo;

  /**
   * Necessita login para executar a aplicação
   **/
  private $login;

  /**
   * Aplicação utiliza SSL
   **/
  private $ssl;

  /**
   * Aplicação utiliza url amigável
   **/
  private $frindlyUrl;

  /**
   * Domínio da aplicação
   **/
  private $dominio;
  
  /**
   * Path onde está instalado o sistema
   */
  private $path = null;

  /**
   * Path temporário
   */
  private $temporaryPath = '/tmp/';

  /**
   * Path dos anexos de envio de e-mail
   */
  private $attachPath = '';

  /**
   * Host da Base de dados
   */
  private $dbHost;

  /**
   * Porta da Base de dados
   */
  private $dbPort;

  /**
   * Nome da Base de dados
   */
  private $dbName;

  /**
   * Usuario da Base de dados
   */
  private $dbUser;

  /**
   * Senha do usuário da base
   */
  private $dbPass;

  /**
   *
   */
  private $mailFromName;

  /**
   *
   */
  private $mailFromEmail;

  /**
   *
   */
  private $mailReplyToName;

  /**
   *
   */
  private $mailReplyToEmail;

  /**
   *
   */
  private $mailHost;

  /**
   *
   */
  private $mailUsername;

  /**
   *
   */
  private $mailPassword;

  /**
   *
   */
  private $mailSMTPSecure;

  /**
   *
   */
  private $mailPort;

  /**
   *
   */
  private $sessionName;

  /**
   *
   */
  private $rememberMeSeconds;

  /**
   *
   */
  private $useCookies;

  /**
   *
   */
  private $cookieHttponly;

  /**
   *
   */
  private $cacheExpire;

  /**
   *
   */
  private $cookieDomain;

  /**
   *
   */
  private $cookieLifetime;

  /**
   * 
   */
  private $developmentMode;

  /**
   * Construtor da classe, pega as configurações do arquivo application.php
   */
  public function __construct(){

    $configs = require_once 'conf/application.php';

    $this->cacheActionsDir      = $configs['app.cache.actions.dir'];
    $this->cacheActionsName     = $configs['app.cache.actions.name'];
    $this->cacheActions         = $this->cacheActionsDir . DIRECTORY_SEPARATOR . $this->cacheActionsName;
    $this->pageErrorDefault     = $configs['app.error.page.default'];
    $this->templateErrorDefault = $configs['app.error.template.default'];
    $this->templateDefault      = $configs['app.template.default'];
    $this->templateAJAXDefault  = $configs['app.template.ajax.default'];
    $this->menuDefault          = $configs['app.menu.default'];
    $this->actionDefault        = $configs['app.action.default'];

    $this->name           = $configs['app.name'];
    $this->title          = $configs['app.title'];
    $this->logo           = $configs['app.logo'];
    $this->login          = $configs['app.login.enable'];
    $this->ssl            = $configs['app.ssl.enable'];
    $this->frindlyUrl     = $configs['app.frindlyUrl.enable'];
    $this->dominio        = $configs['app.dominio'];
    $this->path           = $configs['app.path'];
    $this->temporaryPath  = $configs['app.temporary.path'];
    $this->attachPath     = $configs['app.attach.path'];
    $this->attachSize     = $configs['app.attach.size'];

    $this->dbHost     = $configs['app.db.host'];
    $this->dbPort     = $configs['app.db.port'];
    $this->dbName     = $configs['app.db.name'];
    $this->dbUser     = $configs['app.db.user'];
    $this->dbPass     = $configs['app.db.pass'];

    $this->mailFromName     =  $configs['app.mail.from.name'];
    $this->mailFromEmail    =  $configs['app.mail.from.email'];
    $this->mailReplyToName  =  $configs['app.mail.replyTo.name'];
    $this->mailReplyToEmail =  $configs['app.mail.replyTo.email'];
    $this->mailHost         =  $configs['app.mail.host'];
    $this->mailUsername     =  $configs['app.mail.username'];
    $this->mailPassword     =  $configs['app.mail.password'];
    $this->mailSMTPSecure   =  $configs['app.mail.SMTPsecure'];
    $this->mailPort         =  $configs['app.mail.port'];
    $this->sendMailDisabled =  $configs['app.mail.send.disabled'];

    $this->sessionName        = $configs['app.session.name'];
    $this->rememberMeSeconds  = $configs['app.session.rememberMeSeconds'];
    $this->useCookies         = $configs['app.session.useCookies'];
    $this->cookieHttponly     = $configs['app.session.cookieHttponly'];
    $this->cacheExpire        = $configs['app.session.cacheExpire'];
    $this->cookieDomain       = $configs['app.session.cookieDomain'];
    $this->cookieLifetime     = $configs['app.session.cookieLifetime'];

    $this->cookieDomain       = !empty($this->cookieDomain) ? $this->cookieDomain : $this->dominio;

    $this->developmentMode    = !empty($configs['app.development.mode']) ? $configs['app.development.mode'] : false;
  }

  /*
   * Retorna uma instância da aplicação para pegar as configuraçãoes
   **/
  public static function getInstance() {

    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    }
    
    return self::$instance;
  }

  /**
   * Define o local do fonte do cache de rotas
   * @param String
   */
  public function setCacheActionsDir ($cacheActionsDir) {
    $this->cacheActionsDir = $cacheActionsDir;
  }
  
  /**
   * Retorna o local do fonte do cache de rotas
   * @return String
   */
  public function getCacheActionsDir () {
    return $this->cacheActionsDir; 
  }

  /**
   * Define o nome do fonte do cache de rotas
   * @param String
   */
  public function setCacheActionsName ($cacheActionsName) {
    $this->cacheActionsName = $cacheActionsName;
  }
  
  /**
   * Retorna o nome do fonte do cache de rotas
   * @return String
   */
  public function getCacheActionsName () {
    return $this->cacheActionsName; 
  }
  

  /**
  * Setter Define/Retorna o local do cache de rotas da aplicação
  * @param String
  */
  public function setCacheActions ($cacheActions) {
    $this->cacheActions = $cacheActions;
  }

  /**
  * Getter Define/Retorna o local do cache de rotas da aplicação
  * @return String
  */
  public function getCacheActions () {
    return $this->cacheActions; 
  }

  /**
   * Define a página de erro padrão do sistema
   * @param String
   */
  public function setPageErrorDefault ($pageErrorDefault) {
    $this->pageErrorDefault = $pageErrorDefault;
  }
  
  /**
   * Retorna a página de erro padrão do sistema
   * @return String
   */
  public function getPageErrorDefault () {
    return $this->pageErrorDefault; 
  }
  
  /**
   * Define o template de erro padrão do sistema
   * @param String
   */
  public function setTemplateErrorDefault ($templateErrorDefault) {
    $this->templateErrorDefault = $templateErrorDefault;
  }
  
  /**
   * Retorna o template de erro padrão do sistema
   * @return String
   */
  public function getTemplateErrorDefault () {
    return $this->templateErrorDefault; 
  }

  /**
   * Define o template padrão do sistema
   * @param String
   */
  public function setTemplateDefault ($templateDefault) {
    $this->templateDefault = $templateDefault;
  }

  /**
   * Define o tempplate padrão para requisições AJAX do sistema
   * @param String
   */
  public function setTemplateAJAXDefault ($templateAJAXDefault) {
    $this->templateAJAXDefault = $templateAJAXDefault;
  }
  
  /**
   * Retorna o tempplate padrão para requisições AJAX do sistema
   * @return String
   */
  public function getTemplateAJAXDefault () {
    return $this->templateAJAXDefault; 
  }
  
  /**
   * Retorna o template padrão do sistema
   * @return String
   */
  public function getTemplateDefault () {
    return $this->templateDefault; 
  }

  /**
   * Define o menu padrão do sistema
   * @param String
   */
  public function setMenuDefault ($menuDefault) {
    $this->menuDefault = $menuDefault;
  }
  
  /**
   * Retorna o menu padrão do sistema
   * @return String
   */
  public function getMenuDefault () {
    return $this->menuDefault; 
  }

  /**
   * Define a ação padrão do sistema
   * @param String
   */
  public function setActionDefault ($actionDefault) {
    $this->actionDefault = $actionDefault;
  }
  
  /**
   * Retorna a ação padrão do sistema
   * @return String
   */
  public function getActionDefault () {
    return $this->actionDefault; 
  }

  /**
   * Define o nome da aplicação
   * @param String
   */
  public function setName ($name) {
    $this->name = $name;
  }
  
  /**
   * Retorna o nome da aplicação
   * @return String
   */
  public function getName () {
    return $this->name;
  }

  /**
   * Define o título da aplicação
   * @param String
   */
  public function setTitle ($title) {
    $this->title = $title;
  }
  
  /**
   * Retorna o título da aplicação
   * @return String
   */
  public function getTitle () {
    return $this->title;
  }

  /**
   * Define o logo da empresa
   */
  public function setLogo($logo) {
    $this->logo = $logo;
  }

  /**
   * Retorna o logo da empresa
   */
  public function getLogo() {
    return $this->logo;
  }

  /**
   * Define se necessita login para executar a aplicação, util para desenvolvimento
   * @param Boolean
   */
  public function setLogin ($login) {
    $this->login = $login;
  }
  
  /**
   * Retorna se necessita login para executar a aplicação, util para desenvolvimento
   * @return Boolean
   */
  public function getLogin () {
    return $this->login; 
  }

  /**
   * Define se a aplicação utiliza SSL
   * @param Boolean
   */
  public function setSSL ($ssl) {
    $this->ssl = $ssl;
  }
  
  /**
   * Retorna se a aplicação utiliza SSL
   * @return Boolean
   */
  public function getSSL () {
    return $this->ssl; 
  }

  /**
   * Define se a aplicação utiliza url amigável
   * @param Boolean
   */
  public function setFriendlyUrl ($frindlyUrl) {
    $this->frindlyUrl = $frindlyUrl;
  }
  
  /**
   * Retorna se a aplicação utiliza url amigável
   * @return Boolean
   */
  public function getFriendlyUrl () {
    return $this->friendlyUrl; 
  }

  /**
   * Define o dominio da aplicação
   * @param String
   */
  public function setDominio ($dominio) {
    $this->dominio = $dominio;
  }
  
  /**
   * Retorna o dominio da aplicação
   * @return String
   */
  public function getDominio () {
    return $this->dominio; 
  }

  /**
   * Define o path do local onde está instalado a aplicação
   */
  public function setPath($path) {
    $this->path = $path;
  }

  /**
   * Retorna o path do local onde está instalado a aplicação
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Define a pasta temporária
   */
  public function setTemporaryPath ($temporaryPath) {
    $this->temporaryPath = $temporaryPath;
  }

  /**
   * Retorna a pasta temporária
   */
  public function getTemporaryPath() {
    return $this->temporaryPath;
  }

  /**
   * Define a pasta dos anexos
   */
  public function setAttachPath($path)
  {
    $this->attachPath = $path;
  }

  /**
   * Retorna a pasta dos anexos
   */
  public function getAttachPath()
  {
    return $this->attachPath;
  }

  /**
   * Define hostname da base de dados
   * @param String
   */
  public function setDbHost ($dbHost) {
    $this->dbHost = $dbHost;
  }
  
  /**
   * Retorna hostname da base de dados
   * @return String
   */
  public function getDbHost () {
    return $this->dbHost; 
  }
  
  /**
   * Define a porta da base de dados
   * @param String
   */
  public function setDbPort ($dbPort) {
    $this->dbPort = $dbPort;
  }
  
  /**
   * Retorna a porta da base de dados
   * @return String
   */
  public function getDbPort () {
    return $this->dbPort; 
  }
  
  /**
   * Define o nome da base de dados
   * @param String
   */
  public function setDbName ($dbName) {
    $this->dbName = $dbName;
  }
  
  /**
   * Retorna o nome da base de dados
   * @return String
   */
  public function getDbName () {
    return $this->dbName; 
  }
  
  /**
   * Define o usuário da base de dados
   * @param String
   */
  public function setDbUser ($dbUser) {
    $this->dbUser = $dbUser;
  }
  
  /**
   * Retorna o usuário da base de dados
   * @return String
   */
  public function getDbUser () {
    return $this->dbUser; 
  }

  /**
   * @param String $dbPass
   */
  public function setDbPass($dbPass) {
    $this->dbPass = $dbPass;
    return $this;
  }

  /**
   * @return String
   */
  public function getDbPass() {
    return $this->dbPass;
  }

  /**
   * Define o nome de remetente e-mail configurado
   * @param String $mailFromName
   */
  public function setMailFromName($mailFromName) {
  	$this->mailFromName = $mailFromName;
  }

  /**
   * Retorna o nome de remetente e-mail configurado
   * @return String
   */
  public function getMailFromName() {
    return $this->mailFromName;
  }

  /**
   * Define o e-mail de remetente configurado
   * @param String $mailFromEmail
   */
  public function setMailFromEmail($mailFromEmail) {
  	$this->mailFromEmail = $mailFromEmail;
  }

  /**
   * Retorna o e-mail de remetente configurado
   * @return String
   */
  public function getMailFromEmail() {
    return $this->mailFromEmail;
  }

  /**
   * Define o nome de e-mail de responda para configurado
   * @param String $mailReplyToName
   */
  public function setMailReplyToName($mailReplyToName) {
  	$this->mailReplyToName = $mailReplyToName;
  }

  /**
   * Retorna o nome de e-mail de responda para configurado
   * @return String
   */
  public function getMailReplyToName() {
    return $this->mailReplyToName;
  }

  /**
   * Define o e-mail de responda para configurado
   * @param String $mailReplyToEmail
   */
  public function setMailReplyToEmail($mailReplyToEmail) {
  	$this->mailReplyToEmail = $mailReplyToEmail;
  }

  /**
   * Retorna o e-mail de responda para configurado
   * @return String
   */
  public function getMailReplyToEmail() {
    return $this->mailReplyToEmail;
  }

  /**
   * Define o Host de e-mail configurado
   * @param String $mailHost
   */
  public function setMailHost($mailHost) {
  	$this->mailHost = $mailHost;
  }

  /**
   * Retorna o Host de e-mail configurado
   * @return String
   */
  public function getMailHost() {
    return $this->mailHost;
  }

  /**
   * Define o Username de e-mail configurado
   * @param String $mailUsername
   */
  public function setMailUsername($mailUsername) {
  	$this->mailUsername = $mailUsername;
  }

  /**
   * Retorna o Username de e-mail configurado
   * @return String
   */
  public function getMailUsername() {
    return $this->mailUsername;
  }

  /**
   * Define o Password de e-mail configurado
   * @param String $mailPassword
   */
  public function setMailPassword($mailPassword) {
  	$this->mailPassword = $mailPassword;
  }

  /**
   * Retorna o Password de e-mail configurado
   * @return String
   */
  public function getMailPassword() {
    return $this->mailPassword;
  }

  /**
   * Define se SMTPSecure para e-mail está habilitado
   * @param String $mailSMTPSecure
   */
  public function setMailSMTPSecure($mailSMTPSecure) {
  	$this->mailSMTPSecure = $mailSMTPSecure;
  }

  /**
   * Retorna se SMTPSecure para e-mail está habilitado
   * @return String
   */
  public function getMailSMTPSecure() {
    return $this->mailSMTPSecure;
  }

  /**
   * Define a Porta de e-mail configurado
   * @param String $mailPort
   */
  public function setMailPort($mailPort) {
  	$this->mailPort = $mailPort;
  }

  /**
   * Retorna a Porta de e-mail configurado
   * @return String
   */
  public function getMailPort() {
    return $this->mailPort;
  }

  /**
   * Retorna as configurações de sessão
   */
  public function getSessionConfig() {
    
    $config = [
      'name'                => $this->sessionName,
      'remember_me_seconds' => $this->rememberMeSeconds,
      'use_cookies'         => $this->useCookies,
      'cookie_httponly'     => $this->cookieHttponly,
      'cache_expire'        => $this->cacheExpire,
      'cookie_domain'       => $this->cookieDomain,
      'cookie_lifetime'     => $this->cookieLifetime,
    ];

    if(empty($config['cookie_domain'])) {
      unset($config['cookie_domain']);
    }
    unset($config['cookie_domain']);

    return $config;
  }

  /**
   * Retorna o tamanho limite de arquivos anexos
   */
  public function getLimiteTamanhoAnexo() {
    return $this->attachSize;
  }

  public function isSendMailDisabled() {
    return $this->sendMailDisabled;
  }

  /**
   * Informa se está com o modo de desenvolvimento habilitado
   */
  public function isDevelopmentMode() {
    return $this->developmentMode;
  }
}
