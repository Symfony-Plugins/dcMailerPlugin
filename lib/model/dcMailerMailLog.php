<?php

class dcMailerMailLog extends BasedcMailerMailLog
{
  public function getPrintableRawMail()
  {
    $raw_mail = stream_get_contents($this->getRawMail());

    $raw_mail = preg_replace('/[\n\r]/', '<br />', $raw_mail);

    return preg_replace('/<([\w\d_.]+)@([\w\d_.]+)>/', '&lt;$1@$2&gt;', $raw_mail);
  }
}
