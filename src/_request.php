<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG
}[_CLASS] = __NAMESPACE__.'\Request';

class Request 
{
    public function __invoke()
    {
      $creq = \PMVC\callPlugin('controller', 'getRequest');
      return $creq && count($creq) ? $creq : $_REQUEST;
    }
}
