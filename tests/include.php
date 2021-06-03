<?php

$path = __DIR__ . '/../vendor/autoload.php';
include $path;

\PMVC\Load::plug(
  [
      'unit' => null,
      'debug'=>false
  ],
  [__DIR__ . '/../../']
);

\PMVC\l(__DIR__ . '/resources/FakeDebugOutput');
