<?php

namespace PMVC\PlugIn\dev;

use PHPUnit_Framework_TestCase;

class DevTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'dev';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testIsDevForUnPlug()
    {
        \PMVC\unplug($this->_plug);
        $this->assertFalse(\PMVC\isDev('trace'));
    }

    function testIsDevForHidden()
    {
        \PMVC\plug($this->_plug);
        $d = \PMVC\plug('debug');
        $d->setLevel('debug', true);
        $this->assertFalse(\PMVC\isDev('trace'));
    }

    function testIsDevForShow()
    {
        \PMVC\plug($this->_plug);
        $d = \PMVC\plug('debug');
        $d->setLevel('trace', true);
        $this->assertTrue(\PMVC\isDev('trace'));
    }

    function testIsDevAutoAppendToHtmlWithHelp()
    {
        \PMVC\plug($this->_plug);
        $d = \PMVC\plug('debug');
        $d->setLevel('help', true);
        $this->assertTrue(\PMVC\isDev('dump'));
    }

    function testDump()
    {
        $d = \PMVC\plug('debug',['output'=>'debug_fake']);
        $d->setLevel('hihi');
        \PMVC\plug($this->_plug);
        \PMVC\dev(function(){return 'req';},'hihi');
        $actual = \PMVC\getOption('test');
        $expected = [
            'req',
            'hihi'
        ];
        $this->assertEquals($expected, $actual);
    }
}

