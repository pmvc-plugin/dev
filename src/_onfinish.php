<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\OnFinish';

class OnFinish
{
    public function __invoke()
    {
        \PMVC\dev(
            /**
            * @help Get http information
            */
            function () {
                return $this->caller->http();
            }, 'http'
        );

        \PMVC\dev(
            /**
            * @help Get PMVC input information 
            */
            function () {
                return $this->caller->input();
            }, 'input'
        );

        \PMVC\dev(
            /**
            * @help Show my real ip. 
            */
            function () {
                return $this->caller->myip();
            }, 'myip'
        );

        \PMVC\dev(
            /**
            * @help Get all configs 
            */
            function () {
                $arr = \PMVC\getOption(); 
                unset($arr['PW']);
                return $arr;
            }, 'options'
        );

        \PMVC\dev(
            /**
            * @help Get plugin list
            */
            function () {
                $objs = \PMVC\getOption(\PMVC\PLUGIN_INSTANCE);
                return $objs->keyset();
            }, 'plugins'
        );

        \PMVC\dev(
            /**
            * @help Get session data 
            */
            function () {
                return $this->caller->session();
            }, 'session'
        );

        \PMVC\dev(
            /**
            * @help Get server information 
            */
            function () {
                return $this->caller->server();
            }, 'server'
        );

        \PMVC\dev(
            /**
            * @help Get bucket information
            */
            function () {
                return \PMVC\plug('getenv')->
                get('HTTP_X_BUCKET_TESTS');
            }, 'buckets'
        );

        if ($this->caller->isDev('help')) {
            $this->
                caller
                ->help()
                ->dump();
        }
    }
}
