<?php include_partial('dc_mailer_configuration/assets', array('form' => $form)) ?>

<div id="sf_admin_container">
  <h1><?php echo __('Test configuration "%%configuration%%"', array('%%configuration%%' => $dc_mailer_configuration->getName())) ?></h1>

  <?php include_partial('dc_mailer_configuration/flashes') ?>

  <div id="sf_admin_content">
    <fieldset>
      <pre style="margin: 6px; padding: 6px"><?php echo $raw_mail ?></pre>
    </fieldset>
    
    <ul class="sf_admin_actions">
      <li><?php echo link_to(__('Done'), '@dc_mailer_configuration', array('class' => 'sf_admin_action_list')) ?></li>
    </ul>
  </div>
</div>
