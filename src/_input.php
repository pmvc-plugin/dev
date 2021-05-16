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
        $uri = \PMVC\get(\PMVC\passByRef(\PMVC\plug('url')));
        unset($uri['this']);
        $uri['path'] = \PMVC\plug('url')->getPath();
        $result = [
            'request'=> \PMVC\get($req),
            'action'=> $c->getAppAction(),
            'app'=> [
              'pass' => $c->getApp(),
              'real' => $c[_REAL_APP],
              'help' => 'You could check alias info with folders->search->app->alias',
            ],
            'template' => [
              'dir' => $c[_TEMPLATE_DIR],
              'engine' => $c[_VIEW_ENGINE],
            ],
            'uri' => $uri,
            'router' => $c[_ROUTER],
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
