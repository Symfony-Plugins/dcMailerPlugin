<?php

/**
 * dcMail
 *
 * Wrapper for mail objects. Provides basic operations for setting
 *   - from
 *   - to
 *   - cc
 *   - bcc
 *   - subject
 *   - body
 *   - attachments
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcMail
{
  protected
    $transport,
    $adapter;

  private
    $from        = array(),
    $reply_to    = array(),
    $to          = array(),
    $cc          = array(),
    $bcc         = array(),
    $attachments = array(),
    $sender,
    $subject,
    $body,
    $body_format;

  /**
   * Constructor
   */
  public function __construct(dcTransport $transport)
  {
    $this->transport = $transport;
    $this->adapter   = $transport->getMailAdapter();
  }

  /**
   * Set the address of the sender for this mail.
   * 
   * @param string $address The address of the sender
   *
   * @return dcMail
   */
  public function setSender($address)
  {
    $this->sender = $address;

    return $this;
  }

  /**
   * Return the mail address of the sender.
   *
   * @return string The address of this mail's sender
   */
  public function getSender()
  {
    return $this->sender;
  }

  /**
   * Set either an array of addresses or a single address to the 'from'
   * field of this mail.
   * 
   * @param  mixed $addresses An array of addresses or a single address
   * @param  string $name     (Used when $addresses is a single address) The
   *                          name of the owner of the mailbox
   *
   * @return dcMail
   */
  public function setFrom($addresses, $name = null)
  {
    if (!is_array($addresses))
    {
      $addresses = array($addresses => $name);
    }

    $this->setPropertyFromArray($addresses, 'from');

    return $this;
  }

  /**
   * Add a new address to the already set to the 'from' field of
   * this mail.
   * If no name is supplied, $address will be used instead.
   *
   * @param string $address The address to add
   * @param string $name    The name for the address
   *
   * @return dcMail
   */
  public function addFrom($address, $name = null)
  {
    $this->from[$address] = ($name ? $name : $address);

    return $this;
  }

  /**
   * Return the array of addresses (keys) and names (values) of this
   * mail's 'from' field.
   * 
   * @return array The array of addresses
   */
  public function getFrom()
  {
    return $this->from;
  }

  /**
   * Set either an array of addresses or a single address to the 'reply-to'
   * field of this mail.
   *
   * @param  mixed $addresses An array of addresses or a single address
   * @param  string $name     (Used when $addresses is a single address) The
   *                          name of the owner of the mailbox
   *
   * @return dcMail
   */
  public function setReplyTo($addresses, $name = null)
  {
    if (!is_array($addresses))
    {
      $addresses = array($addresses => $name);
    }

    $this->setPropertyFromArray($addresses, 'reply_to');

    return $this;
  }

  /**
   * Add a new address to the already set to the 'reply-to' field of
   * this mail.
   * If no name is supplied, $address will be used instead.
   *
   * @param string $address The address to add
   * @param string $name    The name for the address
   *
   * @return dcMail
   */
  public function addReplyTo($address, $name = null)
  {
    $this->reply_to[$address] = ($name ? $name : $address);

    return $this;
  }

  /**
   * Return the array of addresses (keys) and names (values) of this
   * mail's 'reply-to' field.
   *
   * @return array The array of addresses
   */
  public function getReplyTo()
  {
    return $this->reply_to;
  }

  /**
   * Set either an array of addresses or a single address to the 'to'
   * field of this mail.
   *
   * @param  mixed $addresses An array of addresses or a single address
   * @param  string $name     (Used when $addresses is a single address) The
   *                          name of the owner of the mailbox
   *
   * @return dcMail
   */
  public function setTo($addresses, $name = null)
  {
    if (!is_array($addresses))
    {
      $addresses = array($addresses => $name);
    }

    $this->setPropertyFromArray($addresses, 'to');

    return $this;
  }

  /**
   * Add a new address to the already set to the 'to' field of
   * this mail.
   * If no name is supplied, $address will be used instead.
   *
   * @param string $address The address to add
   * @param string $name    The name for the address
   *
   * @return dcMail
   */
  public function addTo($address, $name = null)
  {
    $this->to[$address] = ($name ? $name : $address);

    return $this;
  }

  /**
   * Return the array of addresses (keys) and names (values) of this
   * mail's 'to' field.
   *
   * @return array The array of addresses
   */
  public function getTo()
  {
    return $this->to;
  }

  /**
   * Set either an array of addresses or a single address to the 'cc'
   * field of this mail.
   *
   * @param  mixed $addresses An array of addresses or a single address
   * @param  string $name     (Used when $addresses is a single address) The
   *                          name of the owner of the mailbox
   *
   * @return dcMail
   */
  public function setCc($addresses, $name = null)
  {
    if (!is_array($addresses))
    {
      $addresses = array($addresses => $name);
    }

    $this->setPropertyFromArray($addresses, 'cc');

    return $this;
  }

  /**
   * Add a new address to the already set to the 'cc' field of
   * this mail.
   * If no name is supplied, $address will be used instead.
   *
   * @param string $address The address to add
   * @param string $name    The name for the address
   *
   * @return dcMail
   */
  public function addCc($address, $name = null)
  {
    $this->cc[$address] = ($name ? $name : $address);

    return $this;
  }

  /**
   * Return the array of addresses (keys) and names (values) of this
   * mail's 'cc' field.
   *
   * @return array The array of addresses
   */
  public function getCc()
  {
    return $this->cc;
  }

  /**
   * Set either an array of addresses or a single address to the 'bcc'
   * field of this mail.
   *
   * @param  mixed $addresses An array of addresses or a single address
   * @param  string $name     (Used when $addresses is a single address) The
   *                          name of the owner of the mailbox
   *
   * @return dcMail
   */
  public function setBcc($addresses, $name = null)
  {
    if (!is_array($addresses))
    {
      $addresses = array($addresses => $name);
    }

    $this->setPropertyFromArray($addresses, 'bcc');

    return $this;
  }

  /**
   * Add a new address to the already set to the 'bcc' field of
   * this mail.
   * If no name is supplied, $address will be used instead.
   *
   * @param string $address The address to add
   * @param string $name    The name for the address
   *
   * @return dcMail
   */
  public function addBcc($address, $name = null)
  {
    $this->bcc[$address] = ($name ? $name : $address);

    return $this;
  }

  /**
   * Return the array of addresses (keys) and names (values) of this
   * mail's 'bcc' field.
   *
   * @return array The array of addresses
   */
  public function getBcc()
  {
    return $this->bcc;
  }

  /**
   * Attach $file_path to this mail.
   *
   * @param  string $file_path The file path for the attachment
   *
   * @return dcMail
   */
  public function attach($file_path)
  {
    $this->attachments[] = $file_path;

    return $this;
  }

  /**
   * Return this mails attachments.
   *
   * @return array The attachments
   */
  public function getAttachments()
  {
    return $this->attachments;
  }

  /**
   * Answer whether this mail has attachments.
   * 
   * @return Boolean True if this mail has attachments.
   */
  public function hasAttachments()
  {
    return (!empty($this->attachments));
  }

  /**
   * Set this mail's subject.
   *
   * @param  string $subject The subject for this mail
   * 
   * @return dcMail
   */
  public function setSubject($subject)
  {
    $this->subject = $subject;

    return $this;
  }

  /**
   * Return this mail's subject.
   *
   * @return string This mail's subject
   */
  public function getSubject()
  {
    return $this->subject;
  }

  /**
   * Set this mail's body and body format.
   * 
   * @param  string $body   The body
   * @param  string $format The body format
   *
   * @return dcMail
   */
  public function setBody($body, $format = 'text/plain')
  {
    $this->body = $body;
    $this->setBodyFormat($format);

    return $this;
  }

  /**
   * Return this mail's body.
   *
   * @return string This mail's body
   */
  public function getBody()
  {
    return $this->body;
  }

  /**
   * Set this mail's body format.
   *
   * @param  string $format The format of the body
   * 
   * @return dcMail
   */
  public function setBodyFormat($format)
  {
    $this->body_format = $format;
    
    return $this;
  }

  /**
   * Return this mail's body format.
   *
   * @return string The body format
   */
  public function getBodyFormat()
  {
    return $this->body_format;
  }

  /**
   * Answer whether this mail has been correctly configured and is
   * ready to be sent.
   * 
   * @return Boolean True if this mail can be sent
   */
  protected function canBeSent()
  {
    return !(empty($this->from) && (empty($this->to) || empty($this->cc) || empty($this->bcc)));
  }

  /**
   * Set $property field from $array.
   * 
   * @param array $array
   * @param string $property
   */
  protected function setPropertyFromArray($array, $property)
  {
    foreach ($array as $address => $name)
    {
      $this->$property = array_merge($this->$property, array($address => ($name ? $name : $address)));
    }
  }

  /**
   * Send this mail and return the raw output of its sending.
   *
   * @return mixed The raw mail after it has been sent.
   */
  public function send()
  {
    return $this->transport->send($this);
  }

  /**
   * Return a mail instance of the actual underlying library.
   * 
   * @return mixed
   */
  public function getMail()
  {
    return $this->transport->getMailAdapter()->fromDcMail($this);
  }
}