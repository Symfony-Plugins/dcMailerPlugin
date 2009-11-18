<?php

/**
 * dcTransportEncryption
 *
 * @author mtorres
 */

abstract class dcTransportEncryption
{
  const
    NONE = 0,
    SSL  = 1,
    TLS  = 2;

  static protected
    $_strRepresentation = array(
      dcTransportEncryption::NONE => 'None',
      dcTransportEncryption::SSL  => 'SSL - Secure Socket Layer',
      dcTransportEncryption::TLS  => 'TLS - Transport Layer Security'
    );

  static public function getTranslatedEncryptionString($code)
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
      return __(dcTransportEncryption::getEncryptionString($code));
    }
    return dcTransportEncryption::getEncryptionString($code);
  }

  static public function getEncryptionString($code)
  {
    return isset(dcTransportEncryption::$_strRepresentation[$code])? dcTransportEncryption::$_strRepresentation[$code] : null;
  }

  static public function getEncryptions()
  {
    return dcTransportEncryption::$_strRepresentation;
  }

  static public function getTranslatedEncryptions()
  {
    $options = array();
    foreach (dcTransportEncryption::$_strRepresentation as $key => $name)
    {
      $options[$key] = dcTransportEncryption::getTranslatedEncryptionString($key);
    }
    return $options;
  }

  abstract public function getTransportEncryption($code);
}
