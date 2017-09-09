<?php

namespace PMVC\PlugIn\dev;


${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Help';

class Help
{
    private $_help;
    private $_hash;
    public function __construct($caller)
    {
        $this->_help = [];
    }

    public function __invoke()
    {
        return $this;
    }

    public function dump()
    {
        \PMVC\dev(
        /**
        * @help Dump phpinfo
        */
        function(){
            phpinfo();
        }, 'phpinfo()');

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
        return $a[0][0];
    }

    public function store(callable $callback, $type)
    {
        $annot = \PMVC\plug('annotation');
        $doc = $annot->get($callback);
        $file = $doc->getFile();
        $line = $doc->getStartLine();
        $hash = $file.$line;
        if (!isset($this->_hash[$hash])) {
            $this->_hash[$hash] = true;
            $arrType =& \PMVC\get($this->_help, $type, []);
            $arrType[] = [
                $doc['help'],
                'file'=>$file,
                'startLine'=>$line
            ];
            $this->_help[$type] =& $arrType;
        }
        $this->caller->generalDump($callback, $type);
    }
}
