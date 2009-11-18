<?php

require_once dirname(__FILE__).'/../lib/dc_mailer_mail_logGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dc_mailer_mail_logGeneratorHelper.class.php';

/**
 * dc_mailer_mail_log actions.
 *
 * @package    dcMailerPlugin
 * @subpackage dc_mailer_mail_log
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class dc_mailer_mail_logActions extends autoDc_mailer_mail_logActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->dc_mailer_mail_log = $this->getRoute()->getObject();
  }

  // Restrictions
  public function executeNew(sfWebRequest $request)
  {
    $this->getUser()->setFlash('error', 'Mail log creation via user interface is disabled.');
    $this->redirect($this->getModuleName().'/index');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->getUser()->setFlash('error', 'Mail log creation via user interface is disabled.');
    $this->redirect($this->getModuleName().'/index');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->getUser()->setFlash('error', 'Mail log edition via user interface is disabled.');
    $this->redirect($this->getModuleName().'/index');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->getUser()->setFlash('error', 'Mail log edition via user interface is disabled.');
    $this->redirect($this->getModuleName().'/index');
  }
}
