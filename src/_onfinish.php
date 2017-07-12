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
            $arr = \PMVC\getOption(); 
            unset($arr['PW']);
            return $arr;
        }, 'options');

        \PMVC\dev(function(){
            $objs = \PMVC\getOption(\PMVC\PLUGIN_INSTANCE);
            return $objs->keyset();
        }, 'plugins');

        \PMVC\dev(function(){
            if (!empty($_SESSION)) {
                return $_SESSION;
            } else {
                return null;
            }
        }, 'session');
    }
}
