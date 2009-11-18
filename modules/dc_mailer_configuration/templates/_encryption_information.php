<?php if (true === sfConfig::get('sf_escaping_strategy')): ?>
  <?php echo sfOutputEscaper::unescape($dc_mailer_configuration->getEncryptionInformation()) ?>
<?php else: ?>
  <?php echo $dc_mailer_configuration->getEncryptionInformation() ?>
<?php endif ?>
