<?php

/**
 * dcMailAdapterSwitfMailer
 *
 * Mail adapter for SwiftMailer library.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcMailAdapterSwitfMailer extends dcMailAdapter
{
  /**
   * Create a new mail instance using Swift_Message.
   * 
   * @return Swift_Message The mail
   */
  protected function createMail()
  {
    return Swift_Message::newInstance();
  }

  /**
   * Create and load a mail from $dc_mail.
   * 
   * @param  dcMail $dc_mail The reference dcMail
   * 
   * @return Swift_Message The actual mail
   */
  public function fromDcMail(dcMail $dc_mail)
  {
    // Create mail instance
    $mail = $this->createMail();

    // Set subject
    $mail->setSubject($dc_mail->getSubject())
      // Set body and content_type for it
      ->setBody($dc_mail->getBody(), $dc_mail->getBodyFormat())
      // Set sender
      ->setSender($dc_mail->getSender())
      // Set from
      ->setFrom($dc_mail->getFrom())
      // Set reply-to
      ->setReplyTo($dc_mail->getReplyTo())
      // Set to
      ->setTo($dc_mail->getTo())
      // Set cc
      ->setCc($dc_mail->getCc())
      // Set Bcc
      ->setBcc($dc_mail->getBcc());

    // If attachments have been added, attach them to $mail
    if ($dc_mail->hasAttachments())
    {
      foreach ($dc_mail->getAttachments() as $attachment_path)
      {
        $mail->attach(Swift_Attachment::fromPath($attachment_path));
      }
    }

    return $mail;
  }
}