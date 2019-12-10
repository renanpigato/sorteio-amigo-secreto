<?php 
use System\App;
use Zend\Session\Container as SessionContainer;

$sessionContainer = new SessionContainer(App::getName());
?>
<?php if(!App::getEnabledLogin() || (App::getEnabledLogin() && $sessionContainer->loggedUser)): ?>
<div class="drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
  <nav class="navigation mdl-navigation mdl-color--blue-grey-800">
    <a class="mdl-navigation__link" href="<?php echo App::getBaseUrl()?>home"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
    <?php if($sessionContainer->loggedUser && $sessionContainer->loggedUser->Id == 1): ?>
        <a class="mdl-navigation__link" href="<?php echo App::getBaseUrl()?>sortear"><i class="material-icons">people</i>Sortear</a>
    <?php else : ?>
    <?php endif; ?>
    <a class="mdl-navigation__link" href="<?php echo App::getBaseUrl()?>visualizar"><i class="material-icons">people</i>Visualizar</a>
    <div class="mdl-layout-spacer"></div>
    <a class="mdl-navigation__link" href="<?php echo App::getBaseUrl()?>alteracaoSenha"><i class="material-icons">people</i>Alterar senha</a>
    <a class="mdl-navigation__link" href="<?php echo App::getBaseUrl()?>logout"><i class="material-icons">people</i>Sair</a>
  </nav>
</div>
<script type="text/javascript">
(function () {
  $('#logout').on('click', function () {
    location.href = '<?php echo App::getBaseUrl()?>logout';
  });
})()
</script>
<?php endif; ?>