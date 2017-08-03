<?php

namespace PMVC\PlugIn\dev;

use PMVC\Event;
use PMVC\PlugIn;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dev';

class dev extends PlugIn
{
    private $_levels;
    public function init()
    {
        \PMVC\callPlugin(
            'dispatcher',
            'attachAfter',
            [
                $this,
                Event\FINISH
            ]
        );
        $this->_levels = array_flip(
            \PMVC\plug('debug')->getLevels()
        );
        // Need put after $this->_levels
        if ($this->isDev('help')) {
            $this['dump'] = [$this->help(), 'store'];
        } else {
            $this['dump'] = [$this, 'generalDump'];
        }
    }

    public function generalDump(callable $callback, $type)
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
        return isset($this->_levels[$type]);
    }
}
