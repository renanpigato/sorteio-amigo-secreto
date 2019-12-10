<?php
use System\App;
$sorteios = $this->getSorteios();
?>

<div class="mdl-grid content">
  <div class="mdl-cell mdl-cell--12-col">
    <?php foreach ($sorteios as $sorteio) : ?>
        <a href="<?php echo App::getBaseUrl()?>visualizar/idSorteio=<?php echo $sorteio->getId(); ?>">
            <?php echo $sorteio->getId(); ?> - <?php echo $sorteio->getData()->format('d/m/Y'); ?><br />
        </a>
    <?php endforeach; ?>        
  </div>
</div>
