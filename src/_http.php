<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\HTTP';

class HTTP 
{
    public function __invoke()
    {
        $headers = getallheaders();
        $caller = $this->caller;
        if ($caller->isDev('http-headers')) {
            return $headers;
        }
        if ($caller->isDev('http-get')) {
            return $_GET;
        }
        if ($caller->isDev('http-post')) {
            return $_POST;
        }
        if ($caller->isDev('http-cookie')) {
            return $_COOKIE;
        }
        if ($caller->isDev('http-request')) {
            return $_REQUEST;
        }
        if ($caller->isDev('http-files')) {
            return $_FILES;
        }
        return [
            'headers'=> $headers,
            'get'    => $_GET,
            'post'   => $_POST,
            'cookie' => $_COOKIE,
            'request'=> $_REQUEST,
            'files'  => $_FILES
        ];
    }
}
