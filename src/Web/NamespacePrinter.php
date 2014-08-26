<?php

namespace AndyTruong\PHPClassTree\Web;

class NamespacePrinter extends Helper
{

    function printNamespace($namespace, $paths)
    {
        $output = '';

        foreach ($paths as $path) {
            $dir = $path; // . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $namespace);

            if (!is_dir($dir)) {
                continue;
            }

            foreach ($this->rglob("{$dir}/*.php") as $file) {
                $className = substr(substr($file, strlen($dir) + 1), 0, -4);
                $className = $namespace . '\\' . str_replace(DIRECTORY_SEPARATOR, '\\', $className);
                if (class_exists($className)) {
                    $output .= '<li class="list-group-item"><i class="glyphicon glyphicon-asterisk"></i> ' . $this->urlClass($className, $className) . '</li>';
                }
            }
        }
        
        return '<ul class="list-group">' . $output . '</ul>';
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
