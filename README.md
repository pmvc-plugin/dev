[![Latest Stable Version](https://poser.pugx.org/pmvc-plugin/dev/v/stable)](https://packagist.org/packages/pmvc-plugin/dev) 
[![Latest Unstable Version](https://poser.pugx.org/pmvc-plugin/dev/v/unstable)](https://packagist.org/packages/pmvc-plugin/dev) 
[![Build Status](https://travis-ci.org/pmvc-plugin/dev.svg?branch=master)](https://travis-ci.org/pmvc-plugin/dev)
[![License](https://poser.pugx.org/pmvc-plugin/dev/license)](https://packagist.org/packages/pmvc-plugin/dev)
[![Total Downloads](https://poser.pugx.org/pmvc-plugin/dev/downloads)](https://packagist.org/packages/pmvc-plugin/dev) 

dev
===============

## Best plug order
   * put dev before debug, you could get most of plug trace
```
\PMVC\Load::plug([
    'controller'=>null
    ,'dispatcher'=>null

    /*dev*/
    ,'error'=>['all']
    ,'dev'=>null
    ,'debug'=>null
]);
```

## Unit test tip
```
        \PMVC\plug('debug',[
            'output'=> '*Output Plugin*'
        ])->setLevel('*Test Level*', true);
        \PMVC\plug('dev')->onResetDebugLevel();
```

## Why help also trigger dump
* https://github.com/pmvc-plugin/dev/blob/master/dev.php#L45

## Install with Composer
### 1. Download composer
   * mkdir test_folder
   * curl -sS https://getcomposer.org/installer | php

### 2. Install by composer.json or use command-line directly
#### 2.1 Install by composer.json
   * vim composer.json
```
{
    "require": {
        "pmvc-plugin/dev": "dev-master"
    }
}
```
   * php composer.phar install

#### 2.2 Or use composer command-line
   * php composer.phar require pmvc-plugin/dev

