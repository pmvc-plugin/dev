<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\GlobalInfo';

class GlobalInfo
{
    public function __invoke()
    {
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

        return [
          'variables' => (object)$vars,
          'functions' => $funcs,
          'classes'   => get_declared_classes(),
          'constants' => (object)$constants,
          'test'      => [
            'class' => $this->_getTestClass(),
            'func'  => $this->_getTestFunc(),
            'var'   => $this->_getTestVar(),
            'const' => $this->_getTestConst(),
            'help'=> [
              'class'=> '?&--class=your_class',
              'func'=> '?&--func=your_function',
              'var'=> '?&--var=your_global_variable',
              'const'=> '?&--const=your_const',
            ],
          ],
        ];
    }

    private function _getTestClass()
    {
        $tClass = \PMVC\get($_REQUEST, '--class');
        $tClassInfo = null;
        if ($tClass) {
            $annot = \PMVC\plug('annotation');
            $doc = $annot->get($tClass);
            if ($doc) {
                $tClassInfo = [
                'name' => $tClass,
                'file' => $doc->getFile(),
                'line' => $doc->getStartLine()
                ];
            } else {
                $tClassInfo = '['.$tClass.'] not found.';
            }
        } 
        return $tClassInfo;
    }

    private function _getTestFunc()
    {
        $tFunc = \PMVC\get($_REQUEST, '--func');
        $tFuncInfo = null;
        if ($tFunc) {
            $annot = \PMVC\plug('annotation');
            $doc = $annot->get($tFunc);
            if ($doc) {
                $tFuncInfo = [
                'name' => $tFunc,
                'file' => $doc->getFile(),
                'line' => $doc->getStartLine()
                ];
            } else {
                $tFuncInfo = '['.$tFunc.'] not found.';
            }
        }
        return $tFuncInfo;
    }

    private function _getTestVar()
    {
        $tVar = \PMVC\get($_REQUEST, '--var');
        $tVarInfo = null;
        if ($tVar) {
            $tVarInfo = [
            'name' => $tVar,
            'test' => $GLOBALS[$tVar],
            ];
        }
        return $tVarInfo;
    }

    private function _getTestConst()
    {
        $tConst = \PMVC\get($_REQUEST, '--const');
        $tConstInfo = null;
        if ($tConst) {
            $tConstInfo = [
            'name' => $tConst, 
            'test' => constant($tConst),
            ];
        }
        return $tConstInfo;
    }
}
