<?php

use AndyTruong\PHPClassTree\PHPClassTreeReader;
use Composer\Autoload\ClassLoader;

/* @var $loader ClassLoader */
$loader = require_once dirname(__DIR__) . '/bootstrap.php';

class Helper
{

    /** @var ClassLoader */
    protected $loader;

    public function __construct($loader)
    {
        $this->loader = $loader;
    }

    function urlNamespace($namespace, $name)
    {
        return '<a href="./index.php?namespace=' . $namespace . '">' . $name . '</a>';
    }

    function urlClass($class, $name)
    {
        return '<a href="./index.php?class=' . $class . '">' . $name . '</a>';
    }

    function rglob($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, $this->rglob($dir . '/' . basename($pattern), $flags));
        }
        return $files;
    }

}

class ClassPrinter extends Helper
{

    function printDetails($info, $prefix = '(root)', $hide_private = false, $debug = false)
    {
        $output = '';
        $debug = '';

        if (!empty($info['namespace'])) {
            $output .= '<li><strong class="class namespace">(namespace)</strong> ' . urlNamespace($info['namespace'], basename($info['namespace'])) . '</li>';
        }

        $output .= '<li><strong>' . $prefix . '</strong> <span class="class shortname">' . urlClass($info['name'], $info['short_name']) . '</span> <span class="class file">(' . $info['file'] . ')</span></li>';

        if (!empty($info['parent'])) {
            $output .= printDetails($info['parent'], '(parent)', true, false);
        }

        // Print methods
        if (!empty($info['methods'])) {
            foreach ($info['methods'] as $method) {
                if ($method['class'] !== $info['name']) {
                    continue;
                }

                if ('private' === $method['scope']) {
                    continue;
                }

                $output .= '<li class="scope-' . $method['scope'] . '">';
                $output .= ' <span class="method name" title="Scope: ' . $method['scope'] . '">' . $method['name'] . '</span>';
                $output .= '(';
                if (!empty($method['params'])) {
                    $params = [];
                    foreach ($method['params'] as $param) {
                        $params[] = implode(' ', [
                            (isset($param['class']) ? '<span class="param hint">' . urlClass($param['class'], $param['class']) . '</span>' : ''),
                            '<span class="param name">$' . $param['name'] . '</span>'
                        ]);
                    }
                    $output .= trim(implode(', ', $params));
                }
                $output .= ')';
                $output .= '    ‹ <em class="class name">(' . urlClass($method['class'], $method['class']) . ')</em>';
                $output .= '</li>';
            }
        }

        if ($debug) {
            $debug = '<pre>' . json_encode($info, JSON_PRETTY_PRINT) . '</pre>';
        }

        return '<ul>' . $output . '</ul>' . $debug;
    }

    public function handle($input)
    {
        $info = $reader->getInfo($input);
        return ['Class › ' . $input, $this->printDetails($info, $prefix = '(root)', $hide_private = false, $debug = true)];
    }

}

class NamespacePrinter extends ClassPrinter
{

    function printNamespace($namespace, $paths)
    {
        $output = '';

        foreach ($paths as $path) {
            $dir = $path; // . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $namespace);

            if (is_dir($dir)) {
                foreach ($this->rglob("{$dir}/*.php") as $file) {
                    $className = substr(substr($file, strlen($dir) + 1), 0, -4);
                    $className = $namespace . '\\' . str_replace(DIRECTORY_SEPARATOR, '\\', $className);
                    if (class_exists($className)) {
                        $class = $namespace . '\\' . $file;
                        $output .= '<li>' . $this->urlClass($class, $class) . '</li>';
                    }
                }
            }
        }

        return '<ul>' . $output . '</ul>';
    }

    public function handle($input)
    {
        $namespaces = $this->loader->getPrefixes() + $this->loader->getPrefixesPsr4();
        $namespace = explode('\\', $input);

        while ($namespace) {
            $_namespace = implode('\\', $namespace);
            if (isset($namespaces[$_namespace]) || isset($namespaces[$_namespace . '\\'])) {
                $paths = isset($namespaces[$_namespace]) ? $namespaces[$_namespace] : $namespaces[$_namespace . '\\'];
                return ['Namespace › ' . $input, $this->printNamespace($input, $paths)];
            }
            array_pop($namespace);
        }
    }

}

$reader = new PHPClassTreeReader();

if (!empty($_GET['namespace'])) {
    $printer = new NamespacePrinter($loader);
    return $printer->handle($_GET['namespace']);
}
elseif (!empty($_GET['class'])) {
    $printer = new ClassPrinter($loader);
    $className = isset($_GET['class']) ? $_GET['class'] : 'Drupal\\Core\\TypedData\\DataReferenceDefinition';
    return $printer->handle($className);
}
