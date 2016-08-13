<?php
/**
 * Entry point of the unit tests.
 */
$rootPath = dirname(__DIR__);
$loader = require "$rootPath/vendor/autoload.php";
$loader->addPsr4('phing\\', "$rootPath/lib/");
