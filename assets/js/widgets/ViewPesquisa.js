var GridViewPesquisa = function (idModal, buttonModal, targetNode) {

  if ( !(targetNode instanceof HTMLInputElement) ){
    console.log('Alvo onde deve ser prenchido id do registro pesquisado não foi definido');
  }

  this.target                      = targetNode || null;
  this.idModal                     = idModal;
  this.callbacksClick              = [];
  this.callbacksAbrirModal         = [];
  this.argumentsCallbackAbrirModal = null;
  this.modal                       = $('#'+idModal).modal('hide');

  this.initListenersAndCallbacks(buttonModal);
};

GridViewPesquisa.prototype.initListenersAndCallbacks = function (buttonModal) {

  this.modal.on('shown.bs.modal', function (event) {

    if(this.callbacksAbrirModal.length > 0) {

      for (var fnCallbackAbrirModal of this.callbacksAbrirModal) {
        fnCallbackAbrirModal(event, this.argumentsCallbackAbrirModal);
      };
    }
  }.bind(this));

  if(buttonModal) {
    buttonModal.addEventListener('click', function(){
      this.abrir();
    }.bind(this))
  }
}

/**
 * Adiciona callback ao selecionar um item da lista
 *
 * @param {function} fnCallback          Função que deve ser executada após o click para selecionar um item da lista
 */
GridViewPesquisa.prototype.addCallbackClickItem = function (fnCallback) {

  if(typeof fnCallback == 'function') {
    this.callbacksClick.push(fnCallback);
  }
};

GridViewPesquisa.prototype.addCallbackAbrirModal = function (fnCallback) {
  
  if(typeof fnCallback == 'function') {
    this.callbacksAbrirModal.push(fnCallback);
  }
};

GridViewPesquisa.prototype.setModalWidth = function (width) {

  if(width == null || typeof width == 'null') {
    width = this.modal.parent().width();
  }
  
  this.modal.find('.modal-dialog').css({
    'width': function () { 
      return (width * .85) + 'px';  
    }
  });
};

/**
 * Abre uma view para pesquisar itens
 *
 */
GridViewPesquisa.prototype.abrir = function () {
  this.argumentsCallbackAbrirModal = arguments;
  this.modal.modal('show');
  this.setModalWidth();
};

/**
 * Função executada ao selecionar um item da lista
 *
 * @param {integer} idSearchedItem          ID do item selecionado na lista
 * @param {array}   searchedItemProperties  Demais propriedadades que poderão ser retornadas
 */
GridViewPesquisa.prototype.callbackClickItem = function(idSearchedItem, searchedItemProperties) {

  if(this.target) {
    this.target.value = idSearchedItem;
  }

  if(this.callbacksClick.length > 0) {
    for (var i = 0; i < this.callbacksClick.length; i++) {
      var fnCallback = this.callbacksClick[i];
      fnCallback(idSearchedItem, searchedItemProperties);
    };
  }

  this.modal.modal('hide');
};
