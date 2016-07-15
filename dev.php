<?php
namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\dev';

class dev extends \PMVC\PlugIn
{
    private $_d;
    public function init()
    {
       $this->_d = \PMVC\plug('debug'); 
    }

    public function getAllApps()
    {
        $parent = \PMVC\getOption(); 
    }

    public function dump($s, $type)
    {
        if (!$this->isDev($type)) {
            return;
        }
        $d = $this->_d;
        $o = $d->getOutput();
        $o->dump($s,$type);
    }

    public function isDev($type)
    {
        $d = $this->_d;
        $level = \PMVC\value($d,['level']);
        $level = explode(',',$level);
        return in_array($type, $level);
    }
}
