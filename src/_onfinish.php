<?php

namespace PMVC\PlugIn\dev;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\OnFinish';

class OnFinish
{
    public $caller;

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
            },
            'http'
        );

        \PMVC\dev(
            /**
             * @help Get PMVC input information
             */
            function () {
                return $this->caller->input();
            },
            'input'
        );

        \PMVC\dev(
            /**
             * @help Show my real ip.
             */
            function () {
                return $this->caller->myip();
            },
            'myip'
        );

        \PMVC\dev(
            /**
             * @help Show app list.
             */
            function () {
                return $this->caller->get_app_list();
            },
            'app-list'
        );

        \PMVC\dev(
            /**
             * @help Show action list.
             */
            function () {
                return $this->caller->get_action_list();
            },
            'action-list'
        );

        \PMVC\dev(
            /**
             * @help Get all configs ?&--option=dump-one-option
             */
            function () {
                $request = $this->caller->request();
                $one = \PMVC\get($request, '--option');
                $arr = \PMVC\getOption();
                $arr['PW'] = '*secret*';
                unset($arr[\PMVC\THIS]);
                if (empty($one)) {
                    return array_map(function ($i) {
                        return \PMVC\get($i);
                    }, $arr);
                } else {
                    return [$one => \PMVC\get($arr, $one)];
                }
            },
            'options'
        );

        \PMVC\dev(
            /**
             * @help Get plugin list
             */
            function () {
                return \PMVC\InternalUtility::getPlugInNameList();
            },
            'plugins'
        );

        \PMVC\dev(
            /**
             * @help Get session data
             */
            function () {
                return $this->caller->session();
            },
            'session'
        );

        \PMVC\dev(
            /**
             * @help Get server information
             */
            function () {
                return $this->caller->server();
            },
            'server'
        );

        \PMVC\dev(
            /**
             * @help Get bucket information
             */
            function () {
                return \PMVC\plug('getenv')->get('HTTP_X_BUCKET_TESTS');
            },
            'buckets'
        );

        \PMVC\dev(
            /**
             * @help Get Debug plugin information
             */
            function () {
                $pDebug = \PMVC\callPlugin('debug');
                $pError = \PMVC\callPlugin('error');
                $pDump = empty($pDebug) ? null : $pDebug->getOutput();
                return [
                    'plugin' => [
                        'debug' => \PMVC\get($pDebug),
                        'debug-dump' => \PMVC\get($pDump),
                        'error' => \PMVC\get($pError),
                    ],
                    'levels' => empty($pDebug) ? null : $pDebug->getLevels(),
                ];
            },
            'debug-info'
        );

        \PMVC\dev(
            /**
             * @help Get global defined.
             */
            function () {
                return $this->caller->global();
            },
            'global'
        );

        if ($this->caller->isDev('help')) {
            $this->caller->help()->finish();
        }
    }
}
