<?php

/**
 * dcWidgetFormChoiceTransport
 *
 * Transport choice widget.
 *
 * @author ncuesta
 */
class dcWidgetFormChoiceTransport extends sfWidgetFormChoice
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
    $this->addOption('form_name', 'dc_mailer_configuration');
    
    $options = $this->getOption('add_empty') ? array('' => '') + dcTransport::$transports : dcTransport::$transports;

    $this->setOption('choices', $options);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $attributes['onchange'] = isset($attributes['onchange']) ? $attributes['onchange'].$this->getOnChangeJS() : $this->getOnChangeJS();
    
    return parent::render($name, $value, $attributes, $errors);
  }

  protected function getOnChangeJS()
  {
    $js = "var disable = (this.value != '".dcTransport::DC_TRANSPORT_SMTP."') ? 'disabled' : '';";
    foreach (array('server', 'port', 'is_secure', 'username', 'password', 'encryption') as $field)
    {
      $js .= " document.getElementById('".$this->getOption('form_name')."_".$field."').disabled = disable;";
    }

    return $js;
  }
}
