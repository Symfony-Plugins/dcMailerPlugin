<?php

/**
 * dcMailerMailLog filter form.
 *
 * @package    dcMailerPlugin
 * @subpackage filter
 * @author     ncuesta <ncuesta@cespi.unlp.edu.ar>
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class dcMailerMailLogFormFilter extends BasedcMailerMailLogFormFilter
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));

    unset($this['raw_mail']);

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormI18nDate(array('culture' => sfContext::getInstance()->getUser()->getCulture())), 'to_date' => new sfWidgetFormI18nDate(array('culture' => sfContext::getInstance()->getUser()->getCulture())), 'with_empty' => false, 'template' => '<div><span style="float:left;width:4em;margin-top:3px;">'.__('From').'</span> %from_date%</div><div><span style="float:left;width:4em;margin-top:3px;">'.__('to').'</span> %to_date%</div>')));
  }
}
