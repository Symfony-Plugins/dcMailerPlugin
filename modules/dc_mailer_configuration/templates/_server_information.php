<?php if (true === sfConfig::get('sf_escaping_strategy')): ?>
  <?php echo sfOutputEscaper::unescape($dc_mailer_configuration->getServerInformation()) ?>
<?php else: ?>
  <?php echo $dc_mailer_configuration->getServerInformation() ?>
<?php endif ?>
