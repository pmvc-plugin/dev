<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\CloneArr';

class CloneArr
{
    public function __invoke($a)
    {
        return \PMVC\fromJson(json_encode(\PMVC\get($a)), true);
    } 
}
