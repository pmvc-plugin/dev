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
            function () {
                return $this->caller->phpinfo();
            }, 'phpinfo()'
        );

        \PMVC\dev(
            /**
            * @help Get help definition. 
            */
            function () {
                return \PMVC\get($this->_help);
            }, 'help-where'
        );

        \PMVC\dev(
            /**
            * @help Get Debug plugin information 
            */
            function () {
                $pDebug = \PMVC\callPlugin('debug');
                $pError = \PMVC\callPlugin('error');
                $pDump = empty($pDebug) ? null : $pDebug->getOutput();
                return [
                  'plugin' => [
                    'debug' => \PMVC\get($pDebug),
                    'debug-dump' => \PMVC\get($pDump),
                    'error' => \PMVC\get($pError)
                  ],
                  'levels' => empty($pDebug) ? null : $pDebug->getLevels() 
                ];
            }, 'debug-info'
        );

        \PMVC\dev(
            /**
            * @help Get global defined.
            */
            function () {
                $funcs = get_defined_functions();
                $funcs['user-global'] = array_filter(
                    $funcs['user'],
                    function ($v) {
                        return false === strpos($v, '\\');
                    }
                );
                sort($funcs['user-global']);
                $funcs['user-global'] = (object)$funcs['user-global'];
                $vars = array_keys($GLOBALS);
                sort($vars);
                $constants = array_keys(get_defined_constants());
                sort($constants);
                $tFunc = \PMVC\get($_REQUEST, '--func');
                $tFuncInfo = null;
                if ($tFunc) {
                    $annot = \PMVC\plug('annotation');
                    $doc = $annot->get($test);
                    $tFuncInfo = [
                    'name' => $test,
                    'file' => $doc->getFile(),
                    'line' => $doc->getStartLine()
                    ];
                }
                $tVar = \PMVC\get($_REQUEST, '--var');
                $tVarInfo = null;
                if ($tVar) {
                    $tVarInfo = [
                    'name' => $tVar,
                    'test' => $GLOBALS[$tVar],
                    ];
                }
                $tConst = \PMVC\get($_REQUEST, '--const');
                $tConstInfo = null;
                if ($tConst) {
                    $tConstInfo = [
                    'name' => $tConst, 
                    'test' => constant($tConst),
                    ];
                }
                return [
                'variables' => (object)$vars,
                'functions' => $funcs,
                'classes'   => get_declared_classes(),
                'constants' => (object)$constants,
                'test'      => [
                  'func'  => $tFuncInfo,
                  'var'   => $tVarInfo,
                  'const' => $tConstInfo,
                ],
                ];
            },
            'global'
        );

        \PMVC\plug('debug')->
            getOutput()
            ->dump(
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
