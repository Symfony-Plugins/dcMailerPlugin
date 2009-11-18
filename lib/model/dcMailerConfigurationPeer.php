<?php

class dcMailerConfigurationPeer extends BasedcMailerConfigurationPeer
{
  /**
   * Return the active configuration for dcMailer (if any).
   *
   * @param  PropelPDO $con Propel connection for database query
   *
   * @return dcMailerConfiguration The active configuration or null
   */
  static public function retrieveActive(PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(self::IS_ACTIVE, true);

    return self::doSelectOne($criteria, $con);
  }
}
