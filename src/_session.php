<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG
}[_CLASS] = __NAMESPACE__.'\Session';

class Session
{
    public function __invoke()
    {
        if (!empty($_SESSION)) {
            $session = $_SESSION;
            array_walk_recursive(
                $session,
                [
                    $this,
                    'cookSession'
                ]
            );
            $sec = \PMVC\callplugin('session', 'getLifeTime');
            if (empty($sec)) {
                $sec = 0;
            }
            return [
                'data'     => $session,
                'life-sec' => $sec,
                'life-time'=> date('Y/m/d H:i:s', time()+$sec)
            ];
        } else {
            return null;
        }
    }

    public function cookSession(&$item, $key)
    {
        if (\PMVC\isArrayAccess($item)) {
            $item = \PMVC\get($item);
        }
        $pUtf8 = \PMVC\plug('utf8');
        if (!$pUtf8->detectEncoding($item, 'utf-8', true)) {
            $item = $pUtf8->convertEncoding($item, 'utf-8');
        }
    }
}
