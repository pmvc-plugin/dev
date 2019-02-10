<?php

$path = __DIR__.'/../vendor/autoload.php';
include $path;

if (!class_exists('PHPUnit_Framework_TestCase')) {
    class PHPUnit_Framework_TestCase extends
        \PHPUnit\Framework\TestCase
    {
    }
    class PHPUnit_Framework_Error extends
        \PHPUnit\Framework\Error\Notice
    {
    }
}

\PMVC\Load::plug(['debug'=>null, 'dispatcher'=>null]);
\PMVC\addPlugInFolders([__DIR__.'/../../']);
