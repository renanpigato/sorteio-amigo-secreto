<?php
namespace System;

class App {

  /*
   * Define uma instância da classe de aplicação com as configurações
   **/
  public static $instance;

  /**
   * Construtor da classe
   */
  public function __construct(){
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
   * Retorna o diretório configurado para salvar o chace de rotas
   */
  public static function getCacheActionsDir() {
    return AppConfiguration::getInstance()->getCacheActionsDir();
  }

  /**
   * Retorna o arquivo configurado para salvar o chace de rotas
   */
  public static function getCacheActionsName() {
    return AppConfiguration::getInstance()->getCacheActionsName();
  }

  /**
   * Retorna o nome da aplicação
   * @return String
   */
  public static function getCacheActions () {
    return AppConfiguration::getInstance()->getCacheActions();
  }

  /**
   * Retorna a página de erro padrão do sistema
   */
  public static function getPageErrorDefault() {
    return AppConfiguration::getInstance()->getPageErrorDefault();
  }

  /**
   * Retorna o template de erro padrão do sistema
   */
  public static function getTemplateErrorDefault() {
    return AppConfiguration::getInstance()->getTemplateErrorDefault();
  }

  /**
   * Retorna o template padrão do sistema
   */
  public static function getTemplateDefault() {
    return AppConfiguration::getInstance()->getTemplateDefault();
  }

  /**
   * Retorna o template padrão para requisições AJAX do sistema
   */
  public static function getTemplateAJAXDefault() {
    return AppConfiguration::getInstance()->getTemplateAJAXDefault();
  }
  
  /**
   * Retorna o menu padrão do sistema
   */
  public static function getMenuDefault() {
    return AppConfiguration::getInstance()->getMenuDefault();
  }

  /**
   * Retorna a ação padrão do sistema
   */
  public static function getActionDefault() {
    return AppConfiguration::getInstance()->getActionDefault();
  }

  /**
   * Retorna o nome da aplicação
   * @return String
   */
  public static function getName () {
    return AppConfiguration::getInstance()->getName();
  }

  /**
   * Retorna o título da aplicação
   * @return String
   */
  public static function getTitle () {
    return AppConfiguration::getInstance()->getTitle();
  }

  /**
   * Retorna o logo da empresa
   * @return String
   */
  public static function getLogo() {
    return AppConfiguration::getInstance()->getLogo();
  }

  /**
   * Retorna se necessita login para executar a aplicação, util para desenvolvimento
   * @return Boolean
   */
  public static function getEnabledLogin () {
    return AppConfiguration::getInstance()->getLogin();
  }

  /**
   * Retorna se a aplicação utiliza SSL
   * @return Boolean
   */
  public static function getSSL () {
    return AppConfiguration::getInstance()->getSSL();
  }

  /**
   * Retorna se a aplicação utiliza url amigável
   * @return Boolean
   */
  public static function getFriendlyUrl () {
    return AppConfiguration::getInstance()->getFriendlyUrl();
  }

  /**
   * Retorna o domínio configurado para a aplicação
   * @return String
   */
  public static function getDominio() {
    return AppConfiguration::getInstance()->getDominio();
  }
  
  /**
   * Retorna a pasta atual onde está localizado a aplicação
   * @return String
   */
  public static function getPath() {
    return AppConfiguration::getInstance()->getPath();
  }

  /**
   * Retorna o caminho da aplicação
   */
  public static function getBaseUrl($useAppName = false){

    $baseUrl  = AppConfiguration::getInstance()->getDominio() . DIRECTORY_SEPARATOR;

    if(!empty(AppConfiguration::getInstance()->getPath()))
      $baseUrl .=  AppConfiguration::getInstance()->getPath() . DIRECTORY_SEPARATOR;

    if($useAppName)
      $baseUrl .= AppConfiguration::getInstance()->getName() . DIRECTORY_SEPARATOR;

    return $baseUrl;
  }

  /**
   * Retorna o path temporário
   */
  public static function getTemporaryPath() {
    return AppConfiguration::getInstance()->getTemporaryPath();
  }

  /**
   * Retorna o path dos anexos
   */
  public static function getAttachPath() {
    return AppConfiguration::getInstance()->getAttachPath();
  }

  /**
   * Retorna o ost da base de dados
   */
  public static function getDbHost() {
    return AppConfiguration::getInstance()->getDbHost();
  }

  /**
   * Retorna a porta da base de dados
   */
  public static function getDbPort() {
    return AppConfiguration::getInstance()->getDbPort();
  }

  /**
   * Retorna o nome da base de dados
   */
  public static function getDbName() {
    return AppConfiguration::getInstance()->getDbName();
  }

  /**
   * Retorna o usuario da base de dados
   */
  public static function getDbUser() {
    return AppConfiguration::getInstance()->getDbUser();
  }

  /**
   * Retorna o nome do remetente de e-mail configurado
   */
  public static function getMailFromName() {
    return AppConfiguration::getInstance()->getMailFromName();
  }

  /**
   * Retorna o e-mail do remetente configurado
   */
  public static function getMailFromEmail() {
    return AppConfiguration::getInstance()->getMailFromEmail();
  }

  /**
   * Retorna o nome do e-mail de responda para configurado
   */
  public static function getMailReplyToName() {
    return AppConfiguration::getInstance()->getMailReplyToName();
  }

  /**
   * Retorna o e-mail de responda para configurado
   */
  public static function getMailReplyToEmail() {
    return AppConfiguration::getInstance()->getMailReplyToEmail();
  }

  /**
   * Retorna o Host de e-mail configurado
   */
  public static function getMailHost() {
    return AppConfiguration::getInstance()->getMailHost();
  }

  /**
   * Retorna o Username de e-mail configurado
   */
  public static function getMailUsername() {
    return AppConfiguration::getInstance()->getMailUsername();
  }

  /**
   * Retorna o Password de e-mail configurado
   */
  public static function getMailPassword() {
    return AppConfiguration::getInstance()->getMailPassword();
  }

  /**
   * Retorna se utiliza SMTPSecure para e-mail
   */
  public static function getMailSMTPSecure() {
    return AppConfiguration::getInstance()->getMailSMTPSecure();
  }

  /**
   * Retorna a Porta de e-mail configurado
   */
  public static function getMailPort() {
    return AppConfiguration::getInstance()->getMailPort();
  }

  /**
   * Retorna as configurações de sessão
   */
  public static function getSessionConfig() {
    return AppConfiguration::getInstance()->getSessionConfig();
  }

  /**
   * Retorna o tamanho limite de arquivos anexos
   */
  public static function getLimiteTamanhoAnexo() {
    return AppConfiguration::getInstance()->getLimiteTamanhoAnexo();
  }

  /**
   * Informa se está desabilitado o envio de e-mails, utilizado para desenvolvimento
   */
  public static function isSendMailDisabled() {
    return AppConfiguration::getInstance()->isSendMailDisabled();
  }

  /**
   * Informa se está com o modo de desenvolvimento habilitado
   */
  public static function isDevelopmentMode() {
    return AppConfiguration::getInstance()->isDevelopmentMode();
  }
}
