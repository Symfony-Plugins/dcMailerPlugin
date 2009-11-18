<?php

/**
 * dcTransport
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
abstract class dcTransport
{
  const
    DC_TRANSPORT_SMTP     = 1,
    DC_TRANSPORT_MAIL     = 2,
    DC_TRANSPORT_SENDMAIL = 3;

  static public
    $transports = array(
        self::DC_TRANSPORT_SMTP     => 'SMTP',
        self::DC_TRANSPORT_MAIL     => 'Mail',
        self::DC_TRANSPORT_SENDMAIL => 'Sendmail'
      );

  protected
    $is_configured = false,
    $mail_logging_configuration,
    $mail_adapter_class,
    $server,
    $port,
    $secure,
    $username,
    $encryption,
    $password;

  /**
   * Constructor
   */
  public function __construct($server = 'localhost', $port = 25, $mail_logging_configuration = null)
  {
    $this->setServer($server);
    $this->setPort($port);
    $this->mail_logging_configuration = new dcMailerMailLoggingConfiguration($mail_logging_configuration);
  }

  /**
   * Set the address of the server used for sending mails.
   *
   * @param  string $server The server address
   *
   * @return dcTransport
   */
  public function setServer($server)
  {
    $this->server = $server;

    return $this;
  }

  /**
   * Return the address of the server used for sending mails.
   * 
   * @return string The address of the server
   */
  public function getServer()
  {
    return $this->server;
  }

  /**
   * Set the port on the server used for sending mails.
   * 
   * @param  string $port The port on the server
   *
   * @return dcTransport
   */
  public function setPort($port)
  {
    $this->port = $port;

    return $this;
  }

  /**
   * Return the port on the server used for sending mails.
   *
   * @return string The port on the server
   */
  public function getPort()
  {
    return $this->port;
  }

  /**
   * Set whether the server requires authentication for sending mails.
   * 
   * @param  Boolean $secure True if the server requires authentication
   *
   * @return dcTransport
   */
  public function setSecure($secure)
  {
    $this->secure = ($secure ? true : false);

    return $this;
  }

  /**
   * Return whether the server used for sending mails requires authentication.
   *
   * @return Boolean True if the server requires authentication
   */
  public function getSecure()
  {
    return $this->secure;
  }

  /**
   * Set the encryption parameter for this transport
   *
   * @param String $encryption 
   */
  public function setEncryption($encryption)
  {
    $this->encryption = $encryption;
  }

  /**
   * Gets the encryption parameter for this transport
   * 
   * @return String
   */
  public function getEncryption()
  {
    return $this->encryption;
  }

  /**
   * Set the username used on the server when sending mails.
   * 
   * @param  string $username
   *
   * @return dcTransport
   */
  public function setUsername($username)
  {
    $this->username = $username;

    return $this;
  }

  /**
   * Return the username on the server used for sending mails.
   *
   * @return string The username on the server
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * Set the password on the server when sending mails.
   *
   * @param  string $password The password on the server
   *
   * @return dcTransport
   */
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Return the password on the server used for sending mails.
   *
   * @return string The password on the server
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Convenience method that sets this transport as secure, and
   * sets the username and password (account information) for the server.
   *
   * @param  string $username The username on the server
   * @param  string $password The password on the server
   *
   * @return dcTransport
   */
  public function setAccount($username, $password)
  {
    return $this->setSecure(true)
        ->setUsername($username)
        ->setPassword($password);
  }

  /**
   * Answer whether this transport has been configured.
   * 
   * @return Boolean true if this transport has been configured
   */
  public function isConfigured()
  {
    return $this->is_configured;
  }

  /**
   * Perform configuration (if needed) on this transport.
   * This method relies on abstract method doConfigure() the actual
   * configuration.
   * 
   * @see dcTransport::doConfigure()
   *
   * @return dcTransport
   */
  public function configure()
  {
    if (!$this->isConfigured())
    {
      $this->is_configured = $this->doConfigure();
    }
    
    return $this;
  }

  /**
   * Return the mail logging configuration.
   *
   * @return dcMailerMailLoggingConfiguration
   */
  public function getMailLoggingConfiguration()
  {
    return $this->mail_logging_configuration;
  }

  /**
   * Send $mail.
   * This method uses the abstract doSend() method
   * to leave up to subclasses the actual sending of the mail.
   * In this method is where $mail gets pre-/post-processed by
   * mail logging strategies.
   *
   * @param  dcMail $mail The mail to be sent
   *
   * @return Boolean True if the email could be sent
   */
  public function send(dcMail $mail)
  {
    $this->configure();
    
    if ($this->isConfigured())
    {
      $mail = $this->getMailLoggingConfiguration()->preProcessMail($mail);

      $raw_mail = $this->doSend($mail);

      $this->getMailLoggingConfiguration()->postProcessMail($mail, $raw_mail);

      return $raw_mail;
    }

    return false;
  }

  /**
   * Return a new mail adapter object.
   * This method requires 'mail_adapter_class' attribute to be set on
   * subclasses.
   *
   * @return dcMailAdapter
   */
  public function getMailAdapter()
  {
    if (!isset($this->mail_adapter_class) || is_null($this->mail_adapter_class))
    {
      throw new LogicException('dcTransport subclasses must declare a mail_adapter_class attribute.');
    }

    return $this->newMailAdapterInstance();
  }

  /**
   * Return a new instance of this transport's mail adapter class.
   * 
   * @return dcMailAdapter
   */
  protected function newMailAdapterInstance()
  {
    $klass = $this->mail_adapter_class;

    return new $klass();
  }

  /**
   * Perform actual configuration of this transport.
   * 
   * @return Boolean True if the configuration could be performed.
   */
  abstract protected function doConfigure();

  /**
   * Perform actual sending of $mail.
   * 
   * @param dcMail $mail The mail to be sent
   *
   * @return mixed The raw mail after it has been sent
   */
  abstract protected function doSend(dcMail $mail);
}
