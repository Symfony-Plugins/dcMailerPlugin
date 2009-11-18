<?php

require_once dirname(__FILE__).'/../vendor/swift-4.0.5/lib/swift_required.php';

/**
 * dcTransportSwiftMailer
 *
 * Generic transport adapter for SwiftMailer library.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
abstract class dcTransportSwiftMailer extends dcTransport
{
  protected
    $mail_adapter_class = 'dcMailAdapterSwitfMailer',
    $swift_mailtransport;

  /**
   * Return the underlying transport.
   *
   * @return Swift_Transport
   */
  abstract protected function getTransport();

  protected function doConfigure()
  {
    $this->swift_mailtransport = $this->getTransport();
    
    if ($this->secure)
    {
      $this->swift_mailtransport
        ->setUsername($this->username)
        ->setPassword($this->password);
    }

    return true;
  }
  
  protected function doSend(dcMail $mail)
  {
    $swift_message = $mail->getMail();
    $swift_mailer  = $this->getMailer();

    if ($swift_mailer->send($swift_message))
    {
      return $swift_message->toString();
    }

    return false;
  }

  /**
   * Return swift mailer.
   * 
   * @return Swift_Mailer
   */
  protected function getMailer()
  {
    if (is_null($this->swift_mailtransport))
    {
      throw new LogicException('Unable to send mails without a proper configuration.');
    }
    
    return Swift_Mailer::newInstance($this->swift_mailtransport);
  }
}