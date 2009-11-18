<?php

/**
 * dcWidgetFormChoiceTransport
 *
 * Transport choice widget.
 *
 * @author mtorres
 */
class dcWidgetFormChoiceTransportEncryption extends sfWidgetFormChoice
{
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   *  * add_empty: Whether or not an empty option should be added to the choices.
   *  * form_name: The name of the form. Defaults to 'dc_mailer_configuration'.
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormChoice
   */
  public function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('add_empty', false);
    $this->addOption('encryptions', dcTransportEncryption::getTranslatedEncryptions());
    
    $options = $this->getOption('add_empty') ? array('' => '') + $this->getOption('encryptions') : $this->getOption('encryptions');

    $this->setOption('choices', $options);
  }
}
