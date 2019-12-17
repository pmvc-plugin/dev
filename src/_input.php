<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG
}[_CLASS] = __NAMESPACE__.'\Input';

class Input
{
    public function __invoke()
    {
        $c = \PMVC\plug('controller');
        $req = $c->getRequest();
        $result = [
            'request'=> \PMVC\get($req),
            'action'=> $c->getAppAction(),
            'app'=> $c->getApp(),
            'app-real' => $c[_REAL_APP],
            'folders' => [
              'apps' => $c[_RUN_APPS],
              'site' => $c->getAppsParent(),
              'search' => [
                'app'=> \PMVC\folders(_RUN_APP),
                'plugin'=> \PMVC\folders(_PLUGIN),
              ]
            ]
        ];
        return $result;
    }
}
