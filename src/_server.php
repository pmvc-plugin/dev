<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\SERVER';

class SERVER
{
    public function __invoke()
    {
        $arr = $_SERVER;
        if (isset($_GET['getenv'])) {
            $keys = explode(',', $_GET['getenv']); 
            $pEnv= \PMVC\plug('getenv');
            foreach ($keys as $key) {
                $arr[$key] = $pEnv->get($key); 
            }
        }
        return $arr;
    }
}
