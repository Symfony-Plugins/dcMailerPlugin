<?php

/**
 * dcMailAdapter
 *
 * Mail adapter base class.
 * 
 * @author ncuesta <ncuesta@cespi.unlp.edu.ar>
 */
abstract class dcMailAdapter
{
  /**
   * Load the actual mail object from $mail and return it.
   * 
   * @param dcMail $mail The reference dcMail
   *
   * @return mixed The mail (depends on the underlying library)
   */
  abstract public function fromDcMail(dcMail $mail);
}