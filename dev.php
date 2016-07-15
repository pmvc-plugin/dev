<?php
namespace PMVC\PlugIn\dev;

// \PMVC\l(__DIR__.'/xxx.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dev';

class dev extends \PMVC\PlugIn
{
    public function getAllApps()
    {
        $parent = \PMVC\getOption(); 
    }

    public function dump($k, $v, $level='')
    {
        $d = \PMVC\plug('debug');
        $o = $d->getOutput();
        $o->dump([$k,$v],$level);
    }

    public function isDev($type)
    {
        $d = \PMVC\plug('debug');
        return $d->isShow($type, $d['level']);
    }
}
