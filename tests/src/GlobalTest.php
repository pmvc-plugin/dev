<?php
namespace PMVC\PlugIn\dev;

use PHPUnit_Framework_TestCase;

class GlobalTest extends PHPUnit_Framework_TestCase
{
  private $_plug = 'dev';
  public function testGlobal()
  {
    $p = \PMVC\plug($this->_plug);
    $acture = $p->global();
    $this->assertTrue(!empty($acture));
  }
}
