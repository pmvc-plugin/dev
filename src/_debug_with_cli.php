<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\DebugWithCli';

class DebugWithCli
{
    private $_bInit;

    public function __invoke($level = 'trace')
    {
        if (!$this->_bInit) {
            $this->resetPlugIn($level);
            $this->_bInit = true;
        }
        return $this;
    }

    public function resetPlugIn($level)
    {
        $pluginArr = ['error', 'debug', 'debug_cli'];
        foreach ($pluginArr as $p) {
            \PMVC\unplug($p);
        }
        \PMVC\initPlugin([
            'error' => ['all'],
            'debug' => [
                'output' => 'debug_cli',
                'level' => $level,
            ],
        ]);
    }
}
