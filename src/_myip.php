<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\MyIP';

class MyIP
{
    public function __invoke()
    {
      ob_start();
      readfile('http://ipecho.net/plain'); 
      $ip = ob_get_contents();
      ob_end_clean();
      return $ip;
    }
}
