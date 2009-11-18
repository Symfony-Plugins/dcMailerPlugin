<?php

require_once dirname(__FILE__).'/../lib/dc_mailer_configurationGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dc_mailer_configurationGeneratorHelper.class.php';

/**
 * dc_mailer_configuration actions.
 *
 * @package    sumarios
 * @subpackage dc_mailer_configuration
 * @author     ncuesta <ncuesta@cespi.unlp.edu.ar>
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_mailer_configurationActions extends autoDc_mailer_configurationActions
{
  public function executeMakeActive(sfWebRequest $request)
  {
    $this->dc_mailer_configuration = $this->getRoute()->getObject();
    if ($this->dc_mailer_configuration->getIsActive())
    {
      $this->getUser()->setFlash('error', 'The selected configuration is already the active one');
      $this->redirect('@dc_mailer_configuration');
    }

    $this->dc_mailer_configuration->setIsActive(true);
    $this->dc_mailer_configuration->save();

    $this->getUser()->setFlash('notice', 'The selected configuration has been successfully made active');
    $this->redirect('@dc_mailer_configuration');
  }
}
