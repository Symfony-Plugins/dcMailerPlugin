<?php

/**
 * Description of dcTransportSwiftMailerSendmail
 *
 * Sendmail transport adapter for SwiftMailer library.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcTransportSwiftMailerSendmail extends dcTransportSwiftMailer
{
  /**
   * Return this classes underlying transport.
   *
   * @return Swift_SendmailTransport The transport
   */
  protected function getTransport()
  {
    return Swift_SendmailTransport::newInstance();
  }
}