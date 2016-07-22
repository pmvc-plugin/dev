<?php
namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dev';

class dev extends \PMVC\PlugIn
{
    public function getAllApps()
    {
        $parent = \PMVC\getOption(); 
    }

    public function dump($s, $type)
    {
        if (!$this->isDev($type)) {
            return;
        }
        $d = \PMVC\plug('debug');
        $o = $d->getOutput();
        $o->dump($s,$type);
    }

    public function isDev($type)
    {
        $d = \PMVC\plug('debug');
        $level = \PMVC\value($d,['level']);
        $level = explode(',',$level);
        return in_array($type, $level);
    }
}
