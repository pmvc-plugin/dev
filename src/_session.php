<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\Session';

class Session
{
    public function __invoke()
    {
        if (!empty($_SESSION)) {
            $session = $_SESSION;
            array_walk(
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

    public function cookSession(&$session)
    {
        if (\PMVC\isArrayAccess($session)) {
            $arr = \PMVC\get($session);
            array_walk(
                $arr,
                [
                    $this,
                    'cookSession'
                ]
            );
            $session = $arr;
        }
    }
}
