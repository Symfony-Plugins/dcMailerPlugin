<?php

/**
 * Description of dcTransportSwiftMailerSMTP
 *
 * SMTP transport adapter for SwiftMailer library.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcTransportSwiftMailerSMTP extends dcTransportSwiftMailer
{
  /**
   * Return this classes underlying transport.
   * 
   * @return Swift_SmtpTransport The transport
   */
  protected function getTransport()
  {
    return Swift_SmtpTransport::newInstance($this->server, $this->port, $this->getEncryption());
  }
}
