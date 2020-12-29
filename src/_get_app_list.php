<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG
}[_CLASS] = __NAMESPACE__.'\GetAppList';

class GetAppList
{
    public function __invoke()
    {
        $appFolders = \PMVC\folders(_RUN_APP);
    }
}
