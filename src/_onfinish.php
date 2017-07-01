<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\OnFinish';

class OnFinish
{
    public function __invoke()
    {
        \PMVC\dev(function(){
            return getallheaders(); 
        }, 'header');

        \PMVC\dev(function(){
            return \PMVC\getOption(); 
        }, 'options');
    }
}
