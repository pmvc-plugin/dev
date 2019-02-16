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
                $tFuncInfo = '['.$tFunc.'] not found.'
            }
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
    }
}
