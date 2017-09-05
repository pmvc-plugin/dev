<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\HTTP';

class HTTP 
{
    private $_continue = true;

    public function __invoke()
    {
        \PMVC\dev(
        /**
         * @help return HTTP headers only
         */
        function () {
            $this->_continue = false;
            return [
                'get'=>\PMVC\callPlugin(
                    'http',
                    'getallheaders'
                ),
                'send'=>headers_list()
            ];
        }, 'http-headers');

        \PMVC\dev(
        /**
         * @help return $_GET only
         */
        function () {
            $this->_continue = false;
            return $_GET;
        }, 'http-get');

        \PMVC\dev(
        /**
         * @help return $_POST only
         */
        function () {
            $this->_continue = false;
            return $_POST;
        }, 'http-post');

        \PMVC\dev(
        /**
         * @help return $_COOKIE only
         */
        function () {
            $this->_continue = false;
            return $_COOKIE;
        }, 'http-cookie');

        \PMVC\dev(
        /**
         * @help return $_REQUEST only
         */
        function () {
            $this->_continue = false;
            return $_REQUEST;
        }, 'http-request');

        \PMVC\dev(
        /**
         * @help return $_FILES only
         */
        function () {
            $this->_continue = false;
            return $_FILES;
        }, 'http-files');
        
        if (!$this->_continue) {
            return;
        }

        return [
            'headers'=> [
                'get'=>\PMVC\callPlugin(
                    'http',
                    'getallheaders'
                    ),
                'send'=>headers_list()
            ],
            'get'    => $_GET,
            'post'   => $_POST,
            'cookie' => $_COOKIE,
            'request'=> $_REQUEST,
            'files'  => $_FILES
        ];
    }
}
