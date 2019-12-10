<?php
$amigos = $this->getAmigos();
?>

<div class="mdl-grid content">
  <div class="mdl-cell mdl-cell--12-col">
    <?php foreach ($amigos as $amigo) : ?>
        Sorteio: <?php echo $amigo->sorteio; ?> - Amigo  : <?php echo $amigo->amigo; ?>,   Tirou: <?php echo $amigo->amigoSecreto; ?><br />
    <?php endforeach; ?>        
  </div>
</div>
