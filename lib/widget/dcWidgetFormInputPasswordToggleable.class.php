<?php

/**
 * dcWidgetFormInputPasswordToggleable
 *
 * Password input widget whose content may be seen by a toggle link.
 *
 * @author ncuesta
 */
class dcWidgetFormInputPasswordToggleable extends sfWidgetFormInputPassword
{
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   *  * toggle_label: a string to be used as the toggle label. Defaults  to 'Show/hide text'.
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormInputPassword
   */
  public function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('toggle_label', 'Show/hide text');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $toggler = $this->renderContentTag('a', $this->getOption('toggle_label'), array('href' => '#'.$this->generateId($name, $value), 'onclick' => $this->getToggleJS($name, $value)));

    return parent::render($name, $value, $attributes, $errors).' '.$toggler;
  }

  protected function getToggleJS($name, $value)
  {
    return sprintf("document.getElementById('%s').type = (document.getElementById('%s').type == 'password' ? 'text' : 'password'); return false",
        $this->generateId($name, $value),
        $this->generateId($name, $value)
      );
  }
}