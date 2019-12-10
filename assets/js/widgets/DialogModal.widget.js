var DialogModal = function (button, id) {

  this.id                          = id;
  this.button                      = button;
  this.beforeCallbacksShowDialog   = [];
  this.afterCallbacksShowDialog    = [];
  this.argumentsCallbackAbrirModal = null;
  this.title                       = null;
  this.content                     = null;
  this.actions                     = null;
  this.sourceContent               = null;
  this.sourceActionsButtons        = null;
  this.wrapperContent              = null;
  this.wrapperActionsButtons       = null;
  this.dialog                      = document.querySelector('dialog');
  this.widthPercentual             = 0.7;

  if(navigator.userAgent.match(/(android|iphone)/i)) {
    this.widthPercentual           = 0.85;
  }

  this.init();
};

DialogModal.prototype.init = function () {

  if (! this.dialog.showModal) {
    dialogPolyfill.registerDialog(this.dialog);
  }

  if(typeof this.button == 'object') {

    this.button.addEventListener('click', function() {
      this.show();
    }.bind(this));
  }

  this.dialog.querySelector('.close').addEventListener('click', function() {
    this.dialog.close();
  }.bind(this));
}

DialogModal.prototype.setTitle = function (title) {
  this.title = title;
};

DialogModal.prototype.setContent = function (content) {
  this.content = content;
};

DialogModal.prototype.setActions = function (actions) {
  this.actions = actions;
};
  
DialogModal.prototype.setSourceContent = function (sourceContent) {
  this.sourceContent = sourceContent;
};

DialogModal.prototype.setSourceActionsButtons = function (sourceActionsButtons) {
  this.sourceActionsButtons = sourceActionsButtons;
};

DialogModal.prototype.setWidthPercentual = function (widthPercentual) {
  this.widthPercentual = widthPercentual;
};

DialogModal.prototype.setButton = function (button) {

  this.button = button;
  
  if(typeof this.button == 'object') {

    this.button.addEventListener('click', function() {
      this.show();
    }.bind(this));
  }
};

DialogModal.prototype.__loadHTML = function (source) {

  var html = '';

  $.get({url:source, async:false}, function (data) {
    html = data;
  })

  return html;
};

DialogModal.prototype.__loadTitle = function () {
  this.dialog.querySelector('#dialogTitle').innerHTML = this.title;
};

DialogModal.prototype.__loadContent = function () {

  if(this.content == null) {
    if(this.sourceContent != null) {
      this.content = this.__loadHTML(this.sourceContent);
    }
  }
  
  if(this.content != null) {
    this.wrapperContent = this.dialog.querySelector('.mdl-dialog__content');
    this.wrapperContent.innerHTML = this.content;
  }
};

DialogModal.prototype.__loadActionsButtons = function () {

  if(this.actions == null) {
    if(this.sourceActionsButtons != null) {
      this.actions = this.__loadHTML(this.sourceActionsButtons);
    }
  }

  if(this.actions != null) {
    this.wrapperActionsButtons = this.dialog.querySelector('.mdl-dialog__actions');
    this.wrapperActionsButtons.innerHTML = this.actions;
  }
};

DialogModal.prototype.addCallbackShowDialog = function (when, fnCallback) {
  
  if(typeof fnCallback == 'function') {

    switch(when) {
      case 'before':
        this.beforeCallbacksShowDialog.push(fnCallback);
        break;

      default:
        this.afterCallbacksShowDialog.push(fnCallback);
        break;
    }
  }
};

/**
 * Abre uma caixa de diálogo
 */
DialogModal.prototype.show = function () {

  this.argumentsCallbackAbrirModal = arguments;
  this.__loadTitle();
  this.__loadContent();
  this.__loadActionsButtons();
  
  for(var callback of this.beforeCallbacksShowDialog) {
    callback();
  }
  
  this.dialog.showModal();
  this.dialog.style.width = (screen.width * this.widthPercentual).toFixed(2) + 'px';

  if(this.content != null) {
    componentHandler.upgradeElements(this.wrapperContent.children);
  }

  if(this.actions != null) {
    componentHandler.upgradeElements(this.wrapperActionsButtons.children);
  }

  var forms = document.getElementsByTagName('form');
  for (var i = 0; i < forms.length; i++) {
    forms[i].toJSON = function(){
      return formToJSON(this.elements)
    }.bind(forms[i]);
  }

  callback = null;
  for(var callback of this.afterCallbacksShowDialog) {
    callback();
  }
};

DialogModal.prototype.close = function () {
  this.dialog.close();
};

DialogModal.create = function(button, id) {
  return new DialogModal(button, id);
};