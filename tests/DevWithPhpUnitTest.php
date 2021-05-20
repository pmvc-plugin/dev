<?php

namespace PMVC\PlugIn\dev;

use PMVC\TestCase;

class DevWithPhpUnitTest extends TestCase
{
    public function testDevTip()
    {
        // 1. pre config
        $oPHPUnit = \PMVC\plug('dev')->phpunit('foo');

        // 2. prepare dev tip
        \PMVC\dev(function () {
            return 'bar';
        }, 'foo');

        // 3. result
        $actural = $oPHPUnit->toArray();

        // should dump
        $expected = [
            'debugs' => [['foo', 'bar']],
        ];

        // phpunit verify
        $this->assertEquals($expected, $actural);
    }

    public function testHandleError()
    {
        // 1. pre config
        $oPHPUnit = \PMVC\plug('dev')->phpunit('trace');

        // 2. trigger error
        trigger_error('foo');

        // 3. result
        $actural = $oPHPUnit->toArray();

        // should dump
        $expected = ['error', 'foo'];

        // phpunit verify
        $this->assertEquals($expected, \PMVC\value($actural, ['debugs', 0]));
    }
}
