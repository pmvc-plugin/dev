<?php
namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dev';

class dev extends \PMVC\PlugIn
{
    public function getAllApps()
    {
        $parent = \PMVC\getOption(); 
    }

    public function dump(callable $callback, $type)
    {
        if (!$this->isDev($type)) {
            return;
        }
        $s = call_user_func($callback);
        if (!is_null($s)) {
            $d = \PMVC\plug('debug');
            $o = $d->getOutput();
            $o->dump($s, $type);
            \PMVC\unplug('cache_header');
        }
    }

    public function isDev($type)
    {
        if (empty($type)) {
            return false;
        }
        $d = \PMVC\plug('debug');
        $level = \PMVC\value($d,['level']);
        $level = explode(',',$level);
        return in_array($type, $level);
    }
}
