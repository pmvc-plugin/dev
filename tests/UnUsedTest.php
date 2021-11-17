<?php

namespace PMVC\PlugIn\dev;

use PMVC\TestCase;

class UnUsedTest extends TestCase
{
    public function testUnUsed()
    {
        $oPHPUnit = \PMVC\plug('dev')->phpunit('foo,bar,help');

        \PMVC\dev(function () {
            return 'bar';
        }, 'foo');

        $debugRes = $oPHPUnit->toArray();
        $results = \PMVC\get($debugRes, 'debugs', []);

        $unUsed = null;
        foreach ($results as $res) {
            if ($res[0] === 'unused-help') {
                $unUsed = $res;
                break;
            }
        }
        $expected = [
            0 => 'unused-help',
            1 => ['unused' => ['bar']],
        ];
        $this->assertEquals($expected, $unUsed);
    }
}
