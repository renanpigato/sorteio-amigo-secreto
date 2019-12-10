var AjaxRequest = function (url, dados, message, callbackSuccess, callbackError) {

  if (typeof url == 'undefined' || url == null) {
    console.error('Informe a URL para requisição.');
    return false;
  }

  this.url             = url;
  this.dados           = dados;
  this.type            = 'POST';
  this.callbackSuccess = callbackSuccess || null;
  this.callbackError   = callbackError || null;
  this.message         = message;
  this.cache           = true;
  this.contentType     = 'application/x-www-form-urlencoded; charset=UTF-8';
  this.processData     = true;
  
  return this;
};

AjaxRequest.prototype.setURL = function(url) {
  this.url = url;
  return this;
};

AjaxRequest.prototype.setData = function(dados) {
  this.dados = dados;
  return this;
};

AjaxRequest.prototype.setType = function(type) {
  this.type = type;
  return this;
};

AjaxRequest.prototype.setCallbackSuccess = function(callbackSuccess) {
  this.callbackSuccess = callbackSuccess;
  return this;
};

AjaxRequest.prototype.setCallbackError = function(callbackError) {
  this.callbackError = callbackError;
  return this;
};

AjaxRequest.prototype.setMessage = function(message) {
  this.message = message;
  return this;
};

AjaxRequest.prototype.getURL = function() {
  return this.url;
};

AjaxRequest.prototype.getData = function() {
  return this.dados;
};

AjaxRequest.prototype.getData = function(dados) {
  this.dados = dados;
  return this;
};

AjaxRequest.prototype.getCallbackSuccess = function() {
  return this.callbackSuccess;
};

AjaxRequest.prototype.getCallbackError = function() {
  return this.callbackError;
};

AjaxRequest.prototype.getMessage = function() {
  return this.message;
};

AjaxRequest.prototype.enableUploadFile = function() {
  this.cache       = false;
  this.contentType = 'multipart/form-data';
  this.processData = false;
  return this;
};

/**
 * Executa a requisição AJAX
 *
 * @param no params
 */
AjaxRequest.prototype.execute = function () {

  var me = this;

  $.ajax({
    url       : me.url,
    data      : me.dados,
    type      : me.type,
    cache      : me.cache,
    contentType: me.contentType,
    processData: me.processData,
    beforeSend: function() {
      me.enableModalRequest();
    },
    success   : function (response) {

      try {

        if(response.message) {
          response.message = response.message.urlDecode();
        }

        if(typeof me.callbackSuccess == 'function') {
          me.callbackSuccess(response);
        }
      } catch (e) {
        console.error(e);
      }
    },
    error     : function (response) {

      response = response.responseJSON;

      if(typeof me.callbackError == 'function') {
        me.callbackError(response);
        return;
      }
      
      if(response) {
        if(response.message) {
          response.message = response.message.urlDecode();
          alert(response.message);
        }
      }
    },
    complete  : function() {;
      me.disableModalRequest();
    }
  });

  return me;
};

/**
 * Abre uma view para pesquisar itens
 *
 */
AjaxRequest.prototype.enableModalRequest = function () {

  var message = 'Carregando...';

  $('#main-overlay-ajax-request').show(150);
  if(this.message) {
    message = this.message;
  }
  $("#msg-message-ajax-request").html(message);
};

AjaxRequest.prototype.disableModalRequest = function () {
  $('#main-overlay-ajax-request').hide();
};

/**
 * Função que que cria um objeto para requisição AJAX
 *
 * @param {string}  url    URL para requisição
 * @param {object}  dados  Dados passados para processamento
 *
 * @return {object} AjaxRequest  Retorna o proprio objeto request
 */
AjaxRequest.create = function(url, dados) {
  return new AjaxRequest(url, dados);
};
