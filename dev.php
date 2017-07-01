<?php

namespace PMVC\PlugIn\dev;

use PMVC\Event;
use PMVC\PlugIn;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dev';

class dev extends PlugIn
{
    public function init()
    {
        \PMVC\callPlugin(
            'dispatcher',
            'attach',
            [
                $this,
                Event\FINISH
            ]
        );
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
            return $s;
        }
    }

    public function isDev($type)
    {
        if (empty($type)) {
            return false;
        }
        $levels = \PMVC\plug('debug')->getLevels();
        return in_array($type, $levels);
    }
}
