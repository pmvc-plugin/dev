<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG
}[_CLASS] = __NAMESPACE__.'\OnFinish';

class OnFinish
{
    public function __construct($caller)
    {
        $caller[FINISH] = 1;
    }

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
            * @help Show my real ip. 
            */
            function () {
                return $this->caller->getAppList();
            }, 'app-list'
        );

        \PMVC\dev(
            /**
            * @help Show my real ip. 
            */
            function () {
                return $this->caller->getActionList();
            }, 'action-list'
        );

        \PMVC\dev(
            /**
            * @help Get all configs ?&--option=dump-one-option
            */
            function () {
                $request = $this->caller->request();
                $one = \PMVC\get($request, '--option');
                $arr = \PMVC\getOption(); 
                unset($arr['PW']);
                if (empty($one)) {
                  return $arr;
                } else {
                  return [$one => \PMVC\get($arr, $one)];
                }
            }, 'options'
        );

        \PMVC\dev(
            /**
            * @help Get plugin list
            */
            function () {
                return \PMVC\plugInStore();
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
                ->finish();
        }
    }
}
