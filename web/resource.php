<?php

use AndyTruong\PHPClassTree\PHPClassTreeReader;
use AndyTruong\PHPClassTree\Web\ClassPrinter;
use AndyTruong\PHPClassTree\Web\NamespacePrinter;
use Composer\Autoload\ClassLoader;

/* @var $loader ClassLoader */
$loader = require_once dirname(__DIR__) . '/bootstrap.php';
$reader = new PHPClassTreeReader();

if (!empty($_GET['namespace'])) {
    $printer = new NamespacePrinter($loader, $reader);
    return $printer->handle($_GET['namespace']);
}

if (!empty($_GET['class'])) {
    $printer = new ClassPrinter($loader, $reader);
    $className = isset($_GET['class']) ? $_GET['class'] : 'Drupal\\Core\\TypedData\\DataReferenceDefinition';
    return $printer->handle($className);
}
