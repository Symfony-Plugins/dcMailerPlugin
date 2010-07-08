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

  public function executeTest(sfWebRequest $request)
  {
    $this->dc_mailer_configuration = $this->getRoute()->getObject();

    $this->form = new dcMailerConfigurationTestForm();

    $this->form->setDefaults(array(
      'dc_mailer_configuration_id' => $this->dc_mailer_configuration->getPrimaryKey()
    ));
  }

  public function executeDoTest(sfWebRequest $request)
  {
    $this->form = new dcMailerConfigurationTestForm();

    $this->dc_mailer_configuration = dcMailerConfigurationPeer::retrieveByPK($request->getParameter($this->form->getName().'[dc_mailer_configuration_id]'));

    $this->redirectUnless($this->dc_mailer_configuration, 'dc_mailer_configuration');

    $this->form->bind($request->getParameter($this->form->getName()));

    if ($this->form->isValid())
    {
      $dc_mail = dcMailer::getMail($this->dc_mailer_configuration);

      $dc_mail
        ->setFrom($this->form->getValue('from'))
        ->addTo($this->form->getValue('to'))
        ->setSubject($this->form->getValue('subject'))
        ->setBody($this->form->getValue('body'));

      try
      {
        $this->raw_mail = $dc_mail->send();

        $this->getUser()->setFlash('notice', 'The test worked just fine. See raw e-mail for details on the server response.');
      }
      catch (Exception $e)
      {
        $this->getUser()->setFlash('error', 'The test failed. See error description below for more information.');

        $this->error = $e->getMessage();

        return sfView::ERROR;
      }
    }
    else
    {
      $this->setTemplate('test');
    }
  }

}
