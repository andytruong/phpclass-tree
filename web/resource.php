<?php

use AndyTruong\PHPClassTree\PHPClassTreeReader;
use Symfony\Component\ClassLoader\UniversalClassLoader;

/* @var $loader UniversalClassLoader */
$loader = require_once dirname(__DIR__) . '/bootstrap.php';

function url_class($class, $name) {
    return '<a href="./index.php?class='. $class .'">'. $name .'</a>';
}

function print_details($info, $prefix = '(root)', $debug = false) {
    $output = '';
    $debug = '';

    $output .= '<li><strong>'. $prefix .'</strong> <span class="class shortname">'. $info['short_name'] .'</span> <span class="class file">('. $info['file'] .')</span></li>';

    if (!empty($info['parent'])) {
        $output .= print_details($info['parent'], '(parent)', false);
    }

    // Print methods
    $output .= '<ul>';
    foreach ($info['methods'] as $method) {
        $output .= '<li>';
        $output .= '<em class="method scope">' . $method['scope'] . '</em>';
        $output .= ' <span class="method name">' . $method['name'] . '</span>';
        $output .= '(';
        if (!empty($method['params'])) {
            $params = [];
            foreach ($method['params'] as $param) {
                $params[] = implode(' ', [
                    (isset($param['class']) ? '<span class="param hint">' . url_class($param['class'], $param['class']) . '</span>' : ''),
                    '<span class="param name">$' .$param['name'] . '</span>'
                ]);
            }
            $output .= trim(implode(', ', $params));
        }
        $output .= ')';
        $output .= '    ‹ <em class="class name">('. url_class($method['class'], $method['class']) .')</em>';
        $output .= '</li>';
    }
    $output .= '</ul>';

    if ($debug) {
        $debug = '<pre>' . json_encode($info, JSON_PRETTY_PRINT) . '</pre>';
    }

    return '<ul>'. $output .'</ul>' . $debug;
}

function print_namespace($namespace, $paths) {
    $output = '';

    foreach ($paths as $path) {
        $dir = $path . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
        if (is_dir($dir)) {
            foreach (glob("$dir/*.php") as $file) {
                $file = \substr(basename($file), 0, -4);
                if (class_exists($namespace . '\\' . $file)) {
                    $class = $namespace . '\\' . $file;
                    $output .= '<li>'. \url_class($class, $class) .'</li>';
                }
            }
        }
    }

    return '<ul>' .$output . '</ul>';
}

$reader = new PHPClassTreeReader();

if (!empty($_GET['namespace'])) {
    $namespaces = $loader->getNamespaces();
    $namespace = explode('\\', $_GET['namespace']);

    while ($namespace) {
        $_namespace = \implode('\\', $namespace);
        if (isset($namespaces[$_namespace])) {
            echo print_namespace($_GET['namespace'], $namespaces[$_namespace]);
            break;
        }
        array_pop($namespace);
    }
}
elseif (!empty($_GET['class'])) {
    $class = isset($_GET['class']) ? $_GET['class'] : 'Drupal\\Core\\TypedData\\DataReferenceDefinition';
    $info = $reader->getInfo($class);
    echo print_details($info, $prefix = '(root)', $debug = true);
}
