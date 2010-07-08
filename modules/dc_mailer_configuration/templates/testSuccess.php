<?php include_partial('dc_mailer_configuration/assets', array('form' => $form)) ?>

<div id="sf_admin_container">
  <h1><?php echo __('Test configuration "%%configuration%%"', array('%%configuration%%' => $dc_mailer_configuration->getName())) ?></h1>

  <div id="sf_admin_content">
    <form action="<?php echo url_for(array('sf_route' => 'dc_mailer_configuration_collection', 'action' => 'doTest', 'sf_method' => 'post')) ?>" method="post">
      <?php echo $form->renderHiddenFields() ?>

      <fieldset>
        <?php foreach ($form as $name => $field): ?>
          <?php if ($field->isHidden()) continue ?>

          <div class="sf_admin_form_row">
            <?php $field->hasError() and print $field->renderError() ?>

            <?php echo $field->renderLabel() ?>
            <div>
              <?php echo $field ?>
            </div>
          </div>

        <?php endforeach; ?>
      </fieldset>
      
      <ul class="sf_admin_actions">
        <li><?php echo link_to(__('Cancel'), '@dc_mailer_configuration', array('class' => 'sf_admin_action_list')) ?></li>
        <li><input type="submit" value="<?php echo __('Test configuration') ?>" name="_save" /></li>
      </ul>
    </form>
  </div>
</div>
