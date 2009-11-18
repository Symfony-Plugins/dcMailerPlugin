<?php

/**
 * dcMailer
 *
 * Factory for dcMailerPlugin.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcMailer
{
  /**
   * Return a new dcTransport instance as specified either by $configuration
   * or the active configuration from database.
   * 
   * @param  dcMailerConfiguration $configuration Optional configuration. If it
   *                                              isn't provided, the active
   *                                              configuration from database
   *                                              is used.
   * 
   * @return dcTransport
   */
  static public function getTransport(dcMailerConfiguration $configuration = null)
  {
    if (is_null($configuration))
    {
      $configuration = dcMailerConfigurationPeer::retrieveActive();
      if (is_null($configuration))
      {
        throw new LogicException('There is no active configuration for dcMailerPlugin');
      }
    }

    return self::getDcTransport($configuration);
  }

  /**
   * Return a new dcMail object with the transport loaded from
   * the active configuration in the database.
   * 
   * @return dcMail A new mail
   */
  static public function getMail(dcMailerConfiguration $configuration = null)
  {
    return new dcMail(self::getTransport($configuration));
  }

  /**
   * Return a new dcTransport instance according to $configuration.
   *
   * @param  dcMailerConfiguration $configuration The configuration
   *
   * @return dcTransport The transport
   */
  static public function getDcTransport(dcMailerConfiguration $configuration)
  {
    return $configuration->getDcTransport();
  }
}