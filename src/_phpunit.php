<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\PHPUnit';

class PHPUnit
{
    public $caller;

    public function __invoke($level)
    {
        $this->resetPlugIn($level);
        return $this;
    }

    public function resetPlugIn($level)
    {
        $pluginArr = ['dev', 'error', 'debug', 'debug_store'];
        foreach ($pluginArr as $p) {
            \PMVC\unplug($p);
        }
        \PMVC\initPlugin([
            'dev' => null,
            'error' => ['all'],
            'debug' => [
                'output' => 'debug_store',
                'level' => $level,
            ],
        ]);
    }

    public function toArray()
    {
        $this->caller->onFinish();
        return \PMVC\plug('debug_store')
          ->toArray();
    }
}
