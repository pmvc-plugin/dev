<?php

namespace PMVC\PlugIn\dev;

use PMVC\Event;
use PMVC\PlugIn;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dev';

const FINISH = Event\FINISH;

class dev extends PlugIn
{
    private $_levels;
    private $_output;
    private $_dumped = [];

    public function init()
    {
        $this['dump'] = [$this, 'checkAndDump'];
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
                FINISH
            ]
        );
        $this->_levels = array_flip(
            \PMVC\plug('debug')->getLevels()
        );
        // Need put after $this->_levels
        if ($this->isDev('help')) {
            /**
             * @see https://github.com/pmvc-plugin/file_list/blob/master/src/_dump.php#L43-L47
             */
            $this->_levels['dump'] = true;
            $this['dump'] = [$this->help(), 'store'];
        }
    }

    public function checkAndDump(callable $callback, $type)
    {
        if (!$this->isDev($type)) {
            return;
        }
        $this->generalDump($callback, $type);
    }

    public function generalDump(callable $callback, $type)
    {
        $this->_dumped[$type] = true;
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
            $this->_output = $o;
            // disable cache
            \PMVC\unplug('cache_header');
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

    public function getUnused()
    {
        $dumped = array_keys($this->_dumped);
        $dumped[] = 'dump';
        $unused = array_diff(array_keys($this->_levels), $dumped);
        if (count($unused)) {
            return array_values($unused);
        }
    }

    public function __destruct()
    {
      if (!$this[FINISH]) {
        $this->onFinish();
      }
    }
}
