<?php

/**
 * dcMailerConfiguration form.
 *
 * @package    dcMailerPlugin
 * @subpackage form
 * @author     ncuesta <ncuesta@cespi.unlp.edu.ar>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class dcMailerConfigurationForm extends BasedcMailerConfigurationForm
{
  public function configure()
  {
    $this->configureWidgets();
    $this->configureValidators();
    $this->setLabels();
    $this->unsetFields();
  }

  protected function configureWidgets()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));

    $this->setWidget('transport', new dcWidgetFormChoiceTransport(array(
        'add_empty' => true,
        'form_name' => $this->getName()
      )));

    $this->setWidget('encryption', new dcWidgetFormChoiceTransportEncryption(array(
        'add_empty'   => true,
      )));

    $this->setWidget('password', new dcWidgetFormInputPasswordToggleable(array(
        'toggle_label' => __('Show/hide text')
      )));

    $this->getWidget('is_secure')->setAttribute('onchange', $this->getIsSecureOnChangeJS());
  }

  protected function configureValidators()
  {
    $this->setValidator('transport', new sfValidatorChoice(array(
        'choices'  => array_keys(dcTransport::$transports),
        'required' => false
      )));

    $this->setValidator('encryption', new sfValidatorChoice(array(
        'choices'  => array_keys(dcTransportEncryption::getEncryptions()),
        'required' => false
      )));

    $this->getValidator('port')->setOption('min', 1);
    $this->getValidator('port')->setOption('max', 65535);

    $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'postValidate'))));
  }

  protected function setLabels()
  {
    $this->getWidgetSchema()->setHelp('port', 'Tip: the common value for this field is 25.');
  }

  protected function unsetFields()
  {
    unset($this['is_active']);
  }

  public function getJavascripts()
  {
    return array_merge(parent::getJavascripts(), array('/dcMailerPlugin/js/dc_mailer_configuration.js'));
  }

  public function postValidate(sfValidatorBase $validator, $values)
  {
    if (is_null($values))
    {
      $values = array();
    }

    if (!is_array($values))
    {
      throw new InvalidArgumentException('You must pass an array parameter to the clean() method');
    }

    $errors = array();
    if (isset($values['transport']) && $values['transport'] == dcTransport::DC_TRANSPORT_SMTP)
    {
      foreach (array('server', 'port') as $field)
      {
        if (!isset($values[$field]) || '' == trim($values[$field]))
        {
          $errors[$field] = new sfValidatorError($validator, 'required');
        }
      }

      if (isset($values['is_secure']) && $values['is_secure'])
      {
        foreach (array('username') as $field)
        {
          if (!isset($values[$field]) || '' == trim($values[$field]))
          {
            $errors[$field] = new sfValidatorError($validator, 'required');
          }
        }
      }
    }

    if (!empty($errors))
    {
      throw new sfValidatorErrorSchema($validator, $errors);
    }

    return $values;
  }

  public function getIsSecureOnChangeJS()
  {
    $js = "var disable = (this.checked ? '' : 'disabled');";
    foreach (array('username', 'password', 'encryption') as $field)
    {
      $js .= " document.getElementById('".$this->getName()."_".$field."').disabled = disable;";
    }

    return $js;
  }
}
