<?php

/**
 * dcMailerMailLoggingStrategy
 *
 * Base class for MailLoggingStrategies.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcMailerMailLoggingStrategy
{
  protected
    $params = array(),
    $uses_pre_processing,
    $uses_post_processing;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->performInitialChecks();
  }

  /**
   * Set this strategy's additional parameters.
   *
   * @param array $params The additional parameters
   */
  public function setParams($params = array())
  {
    $this->params = $params;
  }

  /**
   * Answer whether this strategy uses pre-processing.
   * 
   * @return Boolean True if this strategy uses pre-processing.
   */
  public function usesPreProcessing()
  {
    return $this->uses_pre_processing;
  }

  /**
   * Answer whether this strategy uses post-processing.
   *
   * @return Boolean True if this strategy uses post-processing.
   */
  public function usesPostProcessing()
  {
    return $this->uses_post_processing;
  }

  /**
   * Perform initial checks on this object's required attributes:
   * dcMailerMailLoggingStrategy subclasses must:
   *   - declare whether they use pre-processing, post-processing or both
   *
   * If any of this requirements isn't met, a LogicException will be thrown.
   */
  protected function performInitialChecks()
  {
    if (is_null($this->uses_pre_processing) && is_null($this->uses_post_processing))
    {
      throw new LogicException('Mail logging strategies must declare whether they use pre-processing, post-processing or both.');
    }
  }

  /**
   * This stub method should be used by pre-processing strategies to perform
   * their pre-processing on $mail and $raw_mail.
   * Hence, it must be overridden by such strategies.
   *
   * @param  dcMail $mail The mail to pre-process
   *
   * @return dcMail The pre-processed mail
   */
  public function preProcess(dcMail $mail)
  {
    return $mail;
  }

  /**
   * This stub method should be used by post-processing strategies to perform
   * their post-processing on $mail and $raw_mail.
   * Hence, it must be overridden by such strategies.
   *
   * @param dcMail $mail    The mail to post-process
   * @param mixed $raw_mail The raw mail obtained from sending $mail
   */
  public function postProcess(dcMail $mail, $raw_mail) {}
}