<?php

/**
 * dcMailerMailLoggingStrategyBlindCarbonCopy
 *
 * Blind carbon copy (bcc)-based mail logging strategy.
 * This strategy automatically adds one or more mail addresses as bcc
 * to the mail it processes.
 *
 * This strategy uses pre-processing only.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcMailerMailLoggingStrategyBlindCarbonCopy extends dcMailerMailLoggingStrategy
{
  // Declare this strategy's processing techniques
  protected
    $uses_pre_processing  = true,
    $uses_post_processing = false;

  public function preProcess(dcMail $mail)
  {
    foreach ($this->getBccs() as $address)
    {
      $mail->addBcc($address);
    }

    return $mail;
  }

  /**
   *
   * @return array The array of addresses that ought to be added as bccs.
   */
  protected function getBccs()
  {
    if (!isset($this->params['send_to']))
    {
      return array();
    }
    elseif (!is_array($this->params['send_to']))
    {
      return array($this->params['send_to']);
    }
    else
    {
      return $this->params['send_to'];
    }
  }
}