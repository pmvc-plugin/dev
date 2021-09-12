<?php
namespace PMVC\PlugIn\dev;

use PMVC\TestCase;

class GetRequestTest extends TestCase
{
  private $_plug = 'dev';

  public function pmvc_teardown()
  {
      \PMVC\unplug("dev");
      \PMVC\unplug("controller");
      unset($_REQUEST);
  }

  public function testCreqNotSet()
  {
      $_REQUEST = ['foo'=>'bar'];
      $c = \PMVC\plug("controller");
      $creq = $c->getRequest();
      $p = \PMVC\plug($this->_plug);
      $actual = $p->request();
      $this->assertEquals($_REQUEST, $actual);
  }

  public function testCreqNotPlug()
  {
      $_REQUEST = ['foo'=>'bar'];
      $p = \PMVC\plug($this->_plug);
      $actual = $p->request();
      $this->assertEquals($_REQUEST, $actual);
  }

  public function testCreqSet()
  {
      $_REQUEST = ['foo'=>'bar'];
      $c = \PMVC\plug("controller");
      $creq = $c->getRequest();
      $creq['coo'] = 'car';
      $p = \PMVC\plug($this->_plug);
      $actual = $p->request();
      $this->assertEquals(['coo'=>'car'], \PMVC\get($actual));
  }
}
