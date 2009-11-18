<?php

/**
 * Description of dcTransportSwiftMailerMail
 *
 * Mail transport adapter for SwiftMailer library.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcTransportSwiftMailerMail extends dcTransportSwiftMailer
{
  /**
   * Return this classes underlying transport.
   *
   * @return Swift_MailTransport The transport
   */
  protected function getTransport()
  {
    return Swift_MailTransport::newInstance();
  }
}