<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG
}[_CLASS] = __NAMESPACE__.'\GlobalInfo';

class GlobalInfo
{
    public function __invoke()
    {
        $this->request = $this->caller->request();
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

        $testClass = $this->_getTestClass();
        $testFunc = $this->_getTestFunc();
        $testVar = $this->_getTestVar();
        $testConst = $this->_getTestConst();

        $result = []; 
        if (!$testClass && !$testFunc && !$testVar && !$testConst) {
          $result['variables'] = (object)$vars;
          $result['functions'] = $funcs;
          $result['classes'] = get_declared_classes();
          $result['constants'] = (object)$constants;
          $result['test'] = []; //for put test in last order
        } else {
          $result['test'] = []; //for put test in last order
          if ($testClass) {
            $result['test']['class'] = $testClass;
          }
          if ($testFunc) {
            $result['test']['func'] = $testFunc;
          }
          if ($testVar) {
            $result['test']['var'] = $testVar;
          }
          if ($testConst) {
            $result['test']['const'] = $testConst;
          }
        }
        $result['test']['help'] = [
          'class'=> '?&--class=your_class',
          'func'=> '?&--func=your_function',
          'var'=> '?&--var=your_global_variable',
          'const'=> '?&--const=your_const',
        ];

        return $result;
    }

    private function _getTestClass()
    {
        $tClass = \PMVC\get($this->request, '--class');
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
        $tFunc = \PMVC\get($this->request, '--func');
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
        $tVar = \PMVC\get($this->request, '--var');
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
        $tConst = \PMVC\get($this->request, '--const');
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
