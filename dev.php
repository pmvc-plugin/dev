<?php

namespace PMVC\PlugIn\dev;

use PMVC\Event;
use PMVC\PlugIn;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dev';

class dev extends PlugIn
{
    private $_levels;
    private $_output;
    public function init()
    {
        $this['dump'] = [$this, 'generalDump'];
        // 1. should have alert here, if dispatcher not plug
        // 2. need locate after $this['dump'] xxx else will trigger dump method not found error.
        \PMVC\plug('dispatcher')->attach($this, 'resetDebugLevel');
        if (\PMVC\callPlugin('debug', 'getLevels')) {
            $this->onResetDebugLevel();
        }
    }

    public function onResetDebugLevel()
    {
        \PMVC\callPlugin(
            'dispatcher',
            /**
             * Should not use attachAfter, Because will miss view_json
             */
            'attach',
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
            $this->_levels['dump'] = true;
            $this['dump'] = [$this->help(), 'store'];
        }
    }

    public function generalDump(callable $callback, $type)
    {
        if (!$this->isDev($type)) {
            return;
        }
        $s = call_user_func($callback);
        if (!is_null($s)) {
            $this->_getOutput()->dump($s, $type);
            return $s;
        }
    }

    private function _getOutput()
    {
        if (!$this->_output) {
            $d = \PMVC\plug('debug');
            $o = $d->getOutput();
            \PMVC\unplug('cache_header');
            $this->_output = $o;
            $d->httpResponseCode();
        }
        return $this->_output;
    }

    public function isDev($type)
    {
        if (empty($type)) {
            return false;
        }
        return isset($this->_levels[$type]);
    }
}
