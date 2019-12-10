<?php use System\App; ?>
<div class="mdl-grid content">
  <div class="mdl-cell mdl-cell--4-col"></div>
  <div class="mdl-cell mdl-cell--4-col">
    <!-- Event card -->
    <style>
    .card-event.mdl-card {
      height: 256px;
    }
    .card-event > .mdl-card__title {
      align-items: flex-start;
    }
    .card-event > .mdl-card__actions {
      display: flex;
      box-sizing:border-box;
      align-items: center;
    }
    .card-event > .mdl-card__actions > input[type="submit"] {
      margin-left: auto
    }
    </style>
    <form method="post" action="<?php echo App::getBaseUrl()?>alterarSenha">
    <div class="card-event mdl-card mdl-shadow--2dp">
      <div class="mdl-card__title mdl-card--expand">
        <div class="mdl-grid">
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell--12-col">
            <input class="mdl-textfield__input" type="password" name="senha" id="senha" />
            <label class="mdl-textfield__label" for="senha">Senha atual:</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell--12-col">
            <input class="mdl-textfield__input" type="password" name="nova_senha1" id="nova_senha1" />
            <label class="mdl-textfield__label" for="nova_senha1">Nova senha:</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell--12-col">
            <input class="mdl-textfield__input" type="password" name="nova_senha2" id="nova_senha2" />
            <label class="mdl-textfield__label" for="nova_senha2">Repita a nova senha:</label>
          </div>
        </div>
      </div>
      <div class="mdl-card__actions mdl-card--border">
        <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" value="Alterar" />
      </div>
    </div>
    </form>
  </div>
  <div class="mdl-cell mdl-cell--4-col"></div>
</div>
