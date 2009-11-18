<?php

class dcMailerConfiguration extends BasedcMailerConfiguration
{
  public function __toString()
  {
    return $this->getName();
  }
  
  /**
   * Return the class name for the transport as configured in this object.
   * 
   * @return string The class name for the transport
   */
  public function getTransportClass()
  {
    $klass = 'dcTransport'.sfConfig::get('app_dc_mailer_plugin_vendor', 'SwiftMailer').$this->getTransportName();
    if (!class_exists($klass))
    {
      throw new LogicException('Unable to locate transport class: '.$klass);
    }

    return $klass;
  }


  /**
   * Returns an instance of the class that represents encryption parameters for the configured transport.
   *
   * @return dcTransportEncryption A dcTransportEncryption subclass
   */
  public function getTransportEncryptionClassInstance()
  {
    $klass = 'dcTransportEncryption'.sfConfig::get('app_dc_mailer_plugin_vendor', 'SwiftMailer').$this->getTransportName();
    if (!class_exists($klass))
    {
      throw new LogicException('Unable to locate transport encryption class: '.$klass);
    }

    return new $klass;
  }

  /**
   * Return the string name of this configuration's selected transport,
   * according to dcTransport::$transports.
   * 
   * @see dcTransport
   *
   * @return mixed The name of the transport or null
   */
  public function getTransportName()
  {
    if (in_array($this->getTransport(), array_keys(dcTransport::$transports)))
    {
      return dcTransport::$transports[$this->getTransport()];
    }

    return;
  }

  /**
   * Return the objects encryption type
   *
   * @return String
   */
  public function getTransportEncryption()
  {
    try {
      $klass = $this->getTransportEncryptionClassInstance();
    } catch (LogicException $e) {
      return null;
    }
    return $klass->getTransportEncryption($this->getEncryption());
  }

  /**
   * Return a configured object of the dcTransport subclass specified by this
   * object's attributes.
   * 
   * @return dcTransport
   */
  public function getDcTransport()
  {
    $klass = $this->getTransportClass();

    $dc_transport = new $klass($this->getServer(), $this->getPort());
    if ($this->getIsSecure())
    {
      $dc_transport->setEncryption($this->getTransportEncryption());
      $dc_transport->setAccount($this->getUsername(), $this->getPassword());
    }
    
    return $dc_transport;
  }

  protected function doSave(PropelPDO $con)
  {
    // Prior to saving this object, check so as to have only one active
    // configuration at a time.
    if ($this->getIsActive())
    {
      $active_configuration = dcMailerConfigurationPeer::retrieveActive($con);

      if (!is_null($active_configuration) && $this->getId() != $active_configuration->getId())
      {
        $active_configuration->setIsActive(false);
        $active_configuration->save($con);
      }
    }

    return parent::doSave($con);
  }

  public function getEncryptionInformation()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Tag', 'Asset'));

    if ($this->getEncryption())
    {
      return image_tag('/dcMailerPlugin/images/key.png', array('alt_title' => __('Encryption'))).' '.dcTransportEncryption::getTranslatedEncryptionString($this->getEncryption());
    }
    else
    {
      return image_tag('/dcMailerPlugin/images/plain.png', array('alt_title' => __('No encription required'))).' -';
    }
  }

  public function getAuthenticationInformation()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Tag', 'Asset'));

    if ($this->getIsSecure())
    {
      return image_tag('/dcMailerPlugin/images/lock.png', array('alt_title' => __('Username'))).' '.$this->getUsername();
    }
    else
    {
      return image_tag('/dcMailerPlugin/images/lock-unlock.png', array('alt_title' => __('No authentication required'))).' -';
    }
  }

  public function getServerInformation()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Tag', 'Asset', 'I18N'));

    if ('' == trim($this->getServer()) && '' == trim($this->getPort()))
    {
      return image_tag('/dcMailerPlugin/images/server.png', array('alt_title' => __('Server'))). ' -';
    }

    return image_tag('/dcMailerPlugin/images/server.png', array('alt_title' => __('Server'))).' '.$this->getServer().':'.$this->getPort();
  }
}
