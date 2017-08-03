<?php

namespace PMVC\PlugIn\dev;

use PMVC\HashMap;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Help';

class Help
{
    private $_help;
    public function __construct($caller)
    {
        $this->_help = new HashMap();
    }

    public function __invoke()
    {
        return $this;
    }

    public function dump()
    {
        \PMVC\dev(
        /**
        * @help Get help definition. 
        */
        function(){
            return \PMVC\get($this->_help);
        }, 'help-where');

        \PMVC\plug('debug')->
            getOutput()->
            dump(
                array_map([$this, 'docOnly'], \PMVC\get($this->_help)),
                'Dev Parameters Help'
            );
    }

    public function docOnly($a)
    {
        return $a[0];
    }

    public function store(callable $callback, $type)
    {
        if (empty($this->_help[$type])) {
            $annot = \PMVC\plug('annotation');
            $doc = $annot->get($callback);
            $this->_help[$type] = [
                $doc['help'],
                'file'=>$doc->getFile(),
                'startLine'=>$doc->getStartLine()
            ];
        }
        $this->caller->generalDump($callback, $type);
    }
}
