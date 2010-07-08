<?php

class dcMailerConfigurationTestForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'dc_mailer_configuration_id' => new sfWidgetFormInputHidden(),
      'to'                         => new sfWidgetFormInput(),
      'from'                       => new sfWidgetFormInput(),
      'subject'                    => new sfWidgetFormInput(),
      'body'                       => new sfWidgetFormTextarea()
    ));

    $this->setValidators(array(
      'dc_mailer_configuration_id' => new sfValidatorPropelChoice(array('model' => 'dcMailerConfiguration', 'required' => true)),
      'to'                         => new sfValidatorEmail(array('required' => true), array('invalid' => 'This value is expected to be a valid e-mail address.')),
      'from'                       => new sfValidatorEmail(array('required' => true), array('invalid' => 'This value is expected to be a valid e-mail address.')),
      'subject'                    => new sfValidatorString(array('required' => false)),
      'body'                       => new sfValidatorString(array('required' => true))
    ));

    $this->getWidgetSchema()->setLabels(array(
      'to'      => 'Send to',
      'from'    => 'Send from',
      'subject' => 'Subject',
      'body'    => 'Body'
    ));

    $this->getWidgetSchema()->setNameFormat('dc_mailer_configuration_test[%s]');
  }

  public function getDcMailerConfiguration()
  {
    return dcMailerConfigurationPeer::retrieveByPK($this->getValue('dc_mailer_configuration_id'));
  }
}
