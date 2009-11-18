<?php

/**
 * dcMailerConfiguration filter form.
 *
 * @package    dcMailerPlugin
 * @subpackage filter
 * @author     ncuesta <ncuesta@cespi.unlp.edu.ar>
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class dcMailerConfigurationFormFilter extends BasedcMailerConfigurationFormFilter
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
    $this->getWidget('name')->setOption('with_empty', false);
    $this->setWidget('transport', new sfWidgetFormChoice(array(
        'choices' => array('' => '') + dcTransport::$transports
      )));
  }

  protected function configureValidators()
  {
    $this->setValidator('transport', new sfValidatorChoice(array(
        'choices'  => array_keys(dcTransport::$transports),
        'required' => false
      )));
  }

  protected function setLabels()
  {
    $this->getWidgetSchema()->setLabels(array(
        'name'      => 'Name',
        'transport' => 'Transport'
      ));
  }

  protected function unsetFields()
  {
    unset(
        $this['server'],
        $this['port'],
        $this['is_secure'],
        $this['username'],
        $this['password'],
        $this['is_active']
      );
  }
}