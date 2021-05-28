<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\Help';

class Help
{
    private $_help = [];
    private $_hash = [];

    public function __invoke()
    {
        return $this;
    }

    public function finish()
    {
        \PMVC\dev(
            /**
             * @help Dump phpinfo
             */
            function () {
                return $this->caller->phpinfo();
            },
            'phpinfo'
        );

        \PMVC\dev(
            /**
             * @help Get help definition.
             */
            function () {
                $arr = [];
                foreach ($this->_help as $type => $a1) {
                    $a1Data = [];
                    foreach ($a1 as $a2) {
                        $a1Data[$a2] = $this->_hash[$a2];
                    }
                    $arr[$type] = $a1Data;
                }
                return $arr;
            },
            'help-where'
        );

        $pDebug = \PMVC\plug('debug');
        $pDebug->httpResponseCode();
        $pDebug
            ->getOutput()
            ->dump(
                array_map([$this, 'descOnly'], \PMVC\get($this->_help)),
                'Dev Parameters Help'
            );
    }

    public function descOnly($arrHash)
    {
        foreach ($arrHash as $a) {
            $data = \PMVC\get($this->_hash, $a);
            if (!empty($data[0])) {
                return $data[0];
            }
        }
    }

    /**
     * @see dev::onResetDebugLevel
     * @see https://github.com/pmvc-plugin/dev/blob/master/dev.php#L46
     */
    public function store(callable $callback, $type, $helpArgs = null)
    {
        $annot = \PMVC\plug('annotation');
        $doc = $annot->get($callback);
        $file = $doc->getFile();
        $line = $doc->getStartLine();
        $hash = $file . $line;
        $helpDoc =  $helpArgs ? \PMVC\tpl(
            $doc['help'],
            array_keys($helpArgs),
            function($args) use ($helpArgs) {
                return $helpArgs[$args['replaceKey']];
            }
        ) : $doc['help'];
        if (!isset($this->_hash[$hash])) {
            $this->_hash[$hash] = [
                $helpDoc,
                'file' => $file,
                'startLine' => $line,
            ];
        }
        $arrType = \PMVC\get($this->_help, $type, []);
        $arrType[] = $hash;
        $this->_help[$type] = $arrType;
        $this->caller->generalDump($callback, $type);
        return $hash;
    }
}
