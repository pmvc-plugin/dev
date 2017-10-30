<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Input';

class Input
{
    public function __invoke()
    {
        $c = \PMVC\plug('controller');
        $req = $c->getRequest();
        $result = [
            'request'=> \PMVC\get($req),
            'action'=> $c->getAppAction(),
            'app'=> $c->getApp()
        ];
        return $result;
    }
}
