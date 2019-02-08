<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\PhpInfo';

class PhpInfo
{
    public function __invoke()
    {
        $isForceArray = false;
        \PMVC\dev(
            /**
             * @help Force phpinfo to array.
             */
            function () use (&$isForceArray) {
                $isForceArray = true;
            }, 'phpinfo-to-array'
        );
        if ($isForceArray || \PMVC\getOption(_VIEW_ENGINE)==='json') {
            return $this->toArray();    
        } else {
            $this->toHtml();
        }
    }

    public function toHtml()
    {
        phpinfo();
    }

    public function toArray()
    {
        ob_start();
        $this->toHtml();
        $info_arr = array();
        $info_lines = explode("\n", strip_tags(ob_get_clean(), "<tr><td><h2>"));
        $cat = "General";
        foreach($info_lines as $line)
        {
            // new cat?
            preg_match("~<h2>(.*)</h2>~", $line, $title) ? $cat = $title[1] : null;
            if(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val)) {
                $info_arr[$cat][$val[1]] = $val[2];
            }
            elseif(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val)) {
                $info_arr[$cat][$val[1]] = array("local" => $val[2], "master" => $val[3]);
            }
        }
        return $info_arr;
    }
}
