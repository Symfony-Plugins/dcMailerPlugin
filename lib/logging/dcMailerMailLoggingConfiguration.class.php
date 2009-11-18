<?php

/**
 * dcMailerMailLoggingConfiguration
 *
 * Configuration handler for mail logging feature.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcMailerMailLoggingConfiguration
{
  protected
    $is_enabled         = false,
    $enabled_strategies = array();

  /**
   * Constructor
   */
  public function __construct($configuration = null, $throw_exception_on_empty_configuration = false)
  {
    if (is_null($configuration))
    {
      $configuration = sfConfig::get('app_dc_mailer_plugin_mail_logging', array());
    }
    
    if (!$this->load($configuration) && $throw_exception_on_empty_configuration)
    {
      throw new LogicException('Unable to load mail logging configuration.');
    }
  }

  /**
   * Answer every enabled strategy.
   * 
   * @return array The array of enabled strategies
   */
  public function getEnabledStrategies()
  {
    return array_values($this->enabled_strategies);
  }

  /**
   * Pre-process $mail with each of the enabled strategies
   * that use mail pre-processing.
   * 
   * @param  dcMail $mail The mail to be pre-processed
   *
   * @return dcMail The pre-processed mail
   */
  public function preProcessMail(dcMail $mail)
  {
    if ($this->is_enabled)
    {
      foreach ($this->getEnabledStrategies() as $strategy)
      {
        if ($strategy->usesPreProcessing())
        {
          $mail = $strategy->preProcess($mail);
        }
      }
    }

    return $mail;
  }

  /**
   * Post-process $mail with each of the enabled strategies
   * that use mail post-processing.
   *
   * @param  dcMail $mail     The mail to be post-processed
   * @param  mixed  $raw_mail The raw output of the sent mail
   */
  public function postProcessMail(dcMail $mail, $raw_mail)
  {
    if ($this->is_enabled)
    {
      foreach ($this->getEnabledStrategies() as $strategy)
      {
        if ($strategy->usesPostProcessing())
        {
          $strategy->postProcess($mail, $raw_mail);
        }
      }
    }
  }

  /**
   * Load configuration parameters from $configuration.
   * This method will return true of $configuration is correct or false
   * otherwise.
   *
   * @param  array   $configuration Global configuration parameters
   *
   * @return Boolean True if $configuration was loaded.
   */
  protected function load($configuration = array())
  {
    if (empty($configuration))
    {
      // Unable to load from configuration, keep defaults.
      return false;
    }

    if (isset($configuration['enabled']) && false !== $configuration['enabled'] && isset($configuration['strategies']))
    {
      // Mail logging is enabled, load the specified strategies
      $this->is_enabled = $this->loadStrategies($configuration['strategies']);
    }

    return true;
  }

  /**
   * Load strategies specified by $strategies_configuration.
   * This method returns true if strategies could be loaded or false
   * otherwise.
   * 
   * @param  array   $strategies_configuration Configuration parameters
   *
   * @return Boolean True if strategies were successfully loaded
   *                 from $strategies_configuration
   */
  protected function loadStrategies($strategies_configuration = array())
  {
    if (empty($strategies_configuration))
    {
      // Strategies configuration is empty, nothing to do.
      $this->enabled_strategies = array();

      return false;
    }

    foreach ($strategies_configuration as $strategy_name => $configuration)
    {
      if (isset($configuration['enabled']) && false !== $configuration['enabled'])
      {
        $this->enableStrategy($strategy_name, isset($configuration['params']) ? $configuration['params'] : array());
      }
      else
      {
        $this->disableStrategy($strategy_name);
      }
    }

    return true;
  }

  /**
   * Answer whether $strategy_name logging strategy is enabled.
   *
   * @param  string  $strategy_name Name of the strategy
   *
   * @return Boolean True if strategy $strategy_name is enabled
   */
  protected function isStrategyEnabled($strategy_name)
  {
    return in_array($strategy_name, array_keys($this->enabled_strategies));
  }

  /**
   * Disable $strategy_name logging strategy.
   * This method will return true if the strategy was disabled or false
   * otherwise.
   * 
   * @param  string  $strategy_name Name of the strategy
   *
   * @return Boolean True if strategy $strategy_name could be disabled
   */
  protected function disableStrategy($strategy_name)
  {
    if ($this->isStrategyEnabled($strategy_name))
    {
      unset($this->enabled_strategies[$strategy_name]);

      return true;
    }

    return false;
  }

  /**
   * Enable $strategy_name logging strategy.
   * This method will return true if the strategy was enabled or false
   * otherwise.
   * 
   * @param  string  $strategy_name Name of the strategy
   * @param  array   $params        Optional parameters for the strategy
   *
   * @return Boolean True if $strategy_name could be enabled
   */
  protected function enableStrategy($strategy_name, $params = array())
  {
    $this->disableStrategy($strategy_name);

    if ($strategy = $this->getStrategy($strategy_name))
    {
      $strategy->setParams($params);
      $this->enabled_strategies[$strategy_name] = $strategy;

      return true;
    }

    return false;
  }

  /**
   * Return a new instance of the mail logging strategy specified by
   * $strategy_name.
   * Mail logging strategies extend dcMailerMailLoggingStrategy class
   * and follow the naming convention defined in this class' instance method
   * getStrategyClassName().
   * If the class for $strategy_name is not found, a LogicException is thrown.
   *
   * @see    dcMailerMailLoggingConfiguration::getStrategyClassName()
   * 
   * @param  string  $strategy_name  Name of the strategy
   *
   * @return dcMailerMailLoggingStrategy The strategy object
   */
  protected function getStrategy($strategy_name)
  {
    $strategy_class = $this->getStrategyClassName($strategy_name);

    if (!class_exists($strategy_class))
    {
      throw new LogicException('Mail logging strategy "'.$strategy_name.'" could not be loaded. Class "'.$strategy_class.'" not found.');
    }

    return new $strategy_class();
  }

  /**
   * Return the class name for mail logging strategy $strategy_name.
   * The naming convention for dcMailerMailLoggingConfiguration subclasses is:
   *
   *   Assuming that $strategy_name is 'my_strategy_name', the class should be
   *   named:
   *     dcMailerMailLoggingConfigurationMyStrategyName
   *   where 'dcMailerMailLoggingConfiguration' is fixed, and 'MyStrategyName'
   *   is the camelCase version of $strategy_name.
   *
   * @param  string $strategy_name The name of the strategy
   *
   * @return string The name of the class for $strategy_name
   */
  protected function getStrategyClassName($strategy_name)
  {
    return 'dcMailerMailLoggingStrategy'.sfInflector::classify($strategy_name);
  }
}