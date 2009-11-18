<?php

/**
 * dcTransportEncryptionSwiftMailerSMTP
 *
 * @author mtorres
 */

class dcTransportEncryptionSwiftMailerSMTP extends dcTransportEncryption
{
  protected
    $_swiftValues = array(
      dcTransportEncryption::NONE  => null,
      dcTransportEncryption::SSL   => 'ssl',
      dcTransportEncryption::TLS   => 'tls',
    );

  public function getTransportEncryption($code)
  {
    return isset($this->_swiftValues[$code])? $this->_swiftValues[$code] : null;
  }
}
