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

        $results = $oPHPUnit->toArray();

        $unUsed = null;
        foreach($results['debugs'] as $res) {
            if ($res[0] === 'unused') {
                $unUsed = $res;
                break;
            }
        }
        $expected = [
          0 => 'unused',
          1 => [ 'bar' ]
        ];
        $this->assertEquals($expected, $unUsed);
    }
}
