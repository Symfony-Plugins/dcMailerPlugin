<?php use_stylesheet('/sfPropelPlugin/css/global.css') ?>
<?php use_stylesheet('/sfPropelPlugin/css/default.css') ?>

<?php use_helper('I18N', 'Date') ?>

<div id="sf_admin_container">
  <div id="sf_admin_content">
    <h1><?php echo __('Mail log entry details') ?></h1>

    <fieldset>
      <h2><?php echo __('Entry information') ?></h2>

      <div class="sf_admin_form_row">
        <div>
          <label for="created_at"><?php echo __('Sent at') ?></label>
          <?php echo false !== strtotime($dc_mailer_mail_log->getCreatedAt()) ? format_date($dc_mailer_mail_log->getCreatedAt(), "f") : '&nbsp;' ?>
        </div>
        <div style="clear:both; height: 1px; font-size: 1px;">
        </div>
      </div>

      <div class="sf_admin_form_row">
        <div>
          <label for="raw_mail"><?php echo __('Raw mail') ?></label>
          <?php echo $dc_mailer_mail_log->getPrintableRawMail() ?>
        </div>
        <div style="clear:both; height: 1px; font-size: 1px;">
        </div>
      </div>

    </fieldset>

    <ul class="sf_admin_actions">
      <li class="sf_admin_action_list"><?php echo link_to(__('Go back'), '@dc_mailer_mail_log') ?></li>
    </ul>
  </div>
</div>