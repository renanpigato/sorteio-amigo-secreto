<?php use System\App; ?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo App::getTitle()?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="<?php echo App::getBaseUrl() ?>assets/img/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="<?php echo App::getBaseUrl() ?>assets/img/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) 
    <meta name="msapplication-TileImage" content="<?php echo App::getBaseUrl() ?>assets/img/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">
    -->

    <link rel="shortcut icon" href="<?php echo App::getBaseUrl() ?>assets/img/favicon.png">

    <!-- CSS to material design -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.light_green-amber.min.css">

    <!-- CSS of JSGrid -->
    <link rel="stylesheet" href="<?php echo App::getBaseUrl(); ?>assets/css/jsgrid.min.css"></link>
    <link rel="stylesheet" href="<?php echo App::getBaseUrl(); ?>assets/css/jsgrid-theme.min.css"></link>

    <!-- CSS of Dialog Polyfill -->
    <link rel="stylesheet" type="text/css" href="<?php echo App::getBaseUrl(); ?>assets/js/polyfill/dialog-polyfill/dialog-polyfill.css" />

    <!-- CSS of jQueryUI version v1.11.4 -->
    <link rel="stylesheet" href="<?php echo App::getBaseUrl(); ?>assets/css/jquery-ui.min.css">
    
    <!-- CSS of project -->
    <link rel="stylesheet" href="<?php echo App::getBaseUrl(); ?>assets/css/stylesheet.css">

    <!-- JavaScript to jQuery version v2.2.201 -->
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/jquery-2.2.2.min.js"></script>
    
    <!-- JavaScript to jQueryUI version v1.11.4 -->
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/plugins/jquery-ui.min.js"></script>

    <!-- JavaScript to jQuery form-validator version -->
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/plugins/jquery.form-validator.min.js"></script>
    
    <!-- JavaScript to jQuery mask version v1.14.0 -->
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/plugins/jquery.mask.min.js"></script>

    <!-- JavaScript to jQuery form version v3.50.0-->
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/plugins/jquery-form.js"></script>

    <!-- JavaScript to jsGrid version v3.50.0 plugin of jquery to render grids -->
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/plugins/jsgrid.min.js"></script>

    <!-- JavaScript to material design -->
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>

    <!-- JavaScript to dialog polyfill -->
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/polyfill/dialog-polyfill/dialog-polyfill.js"></script>

    <!-- JS of project
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/widgets/ViewPesquisa.js"></script>
     -->
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/base.js"></script>
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/AjaxRequest.js"></script>
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/widgets/Collection.widget.js"></script>
    <script src="<?php echo App::getBaseUrl(); ?>assets/js/widgets/DialogModal.widget.js"></script>
  </head>
  <body>
    <!-- Elements to modal -->
    <dialog class="mdl-dialog">
      <div class="mdl-dialog__title">
        <h4 id="dialogTitle" class="no-margin">Titulo?</h4>
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent close md-18"><i class="material-icons">close</i></button>
      </div>
      <div class="mdl-dialog__content">
        <p>
          Conteudo.
        </p>
      </div>
      <div class="mdl-dialog__actions">
      </div>
    </dialog>
    <div class="layout mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">
            <button id="btnHome" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">HOME</button>
          </span>
          <div class="mdl-layout-spacer"></div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <li class="mdl-menu__item">Sobre</li>
            <li class="mdl-menu__item">Contato</li>
            <li class="mdl-menu__item">Informações Legais</li>
          </ul>
        </div>
      </header>
      <main id="conteudo" class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid content">
          <div id="message" class="message mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <div id="error"><?php echo $this->getErrorMessage(); ?></div>
            <div id="success"><?php echo $this->getSuccessMessage(); ?></div>
          </div>
        </div>
        <?php 
          if ($this->getPage() != "")
            require_once 'views/pages/' . $this->getPage();
          else 
            require_once 'views/pages/' . $this->getPageError(); 
        ?>
      </main>
    </div>
    <script type="text/javascript">
    var forms = document.getElementsByTagName('form');
    for (var i = 0; i < forms.length; i++) {
      forms[i].toJSON = function(){
        return formToJSON(this.elements)
      }.bind(forms[i]);
    }
    $('#btnHome').on('click', function(){
      location.href='<?php echo App::getBaseUrl()?>home';
    });
    </script>
  </body>
</html>
