<?php
namespace PMVC\PlugIn\dev;

use PMVC\TestCase;

class GlobalTest extends TestCase
{
  private $_plug = 'dev';
  public function testGlobal()
  {
    $p = \PMVC\plug($this->_plug);
    $acture = $p->global();
    $this->assertTrue(!empty($acture));
  }
}
