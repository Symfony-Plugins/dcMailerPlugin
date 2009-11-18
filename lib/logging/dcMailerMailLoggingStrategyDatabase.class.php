<?php

/**
 * dcMailerMailLoggingStrategyDatabase
 *
 * Database-based mail logging strategy.
 * This strategy stores the raw output of the mail that has been sent
 * on the database using the provided model (see schema.yml file).
 *
 * This strategy uses post-processing only.
 *
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
class dcMailerMailLoggingStrategyDatabase extends dcMailerMailLoggingStrategy
{
  // Declare this strategy's processing techniques
  protected
    $uses_pre_processing  = false,
    $uses_post_processing = true;

  public function postProcess(dcMail $mail, $raw_mail)
  {
    $log_entry = new dcMailerMailLog();
    $log_entry->setRawMail($raw_mail);
    $log_entry->save();
  }
}