<?php

namespace PMVC\PlugIn\dev;

use PMVC\PlugIn\debug\DebugDumpInterface;

class FakeDebugOutput extends \PMVC\PlugIn implements DebugDumpInterface
{
    function escape($s, $type = null)
    {
    }
    function dump($p, $type = '')
    {
        \PMVC\option('set', 'test', [$p, $type]);
    }
}

\PMVC\plug('debug_fake', [
    _CLASS => __NAMESPACE__ . '\FakeDebugOutput',
]);
