<?php

namespace AndyTruong\PHPClassTree\Web;

class ClassPrinter extends Helper
{

    function printDetails($info, $prefix = '(root)', $hide_private = false, $debug = false)
    {
        $output = '';

        if (!empty($info['namespace'])) {
            $output .= '<li class="list-group-item list-group-item-info">'
                . '<span class="glyphicon glyphicon-home"></span> '
                . $this->urlNamespace($info['namespace'], basename($info['namespace']))
                . '\\<span class="class shortname">' . $this->urlClass($info['name'], $info['short_name']) . '</span>'
                . '</li>';
        }

        if (!empty($info['parent'])) {
            $output .= printDetails($info['parent'], '(parent)', true, false);
        }

        if (!empty($info['properties'])) {
            $this->propertyDetails($info, $output);
        }

        if (!empty($info['methods'])) {
            $this->methodDetails($info, $output);
        }

        return '<ul class="list-group">' . $output . '</ul>';
    }

    private function propertyDetails($info, &$output)
    {
        foreach ($info['properties'] as $property) {
            $output .= '<li class="list-group-item">';
            $output .= '<i class="glyphicon glyphicon-stop"></i> $' . $property['name'];
            $output .= '</li>';
        }
    }

    private function methodDetails($info, &$output)
    {
        foreach ($info['methods'] as $method) {
            if ($method['class'] !== $info['name']) {
                continue;
            }

            if ('private' === $method['scope']) {
                continue;
            }

            $output .= '<li class="scope-' . $method['scope'] . ' list-group-item">';
            $output .= ' <i class="glyphicon glyphicon-chevron-right"></i>  <span class="method name" title="Scope: ' . $method['scope'] . '">' . $method['name'] . '</span>';
            $output .= '(';
            if (!empty($method['params'])) {
                $params = [];
                foreach ($method['params'] as $param) {
                    $params[] = implode(' ', [
                        (isset($param['class']) ? '<span class="param hint">' . $this->urlClass($param['class'], $param['class']) . '</span>' : ''),
                        '<span class="param name">$' . $param['name'] . '</span>'
                    ]);
                }
                $output .= trim(implode(', ', $params));
            }
            $output .= ')';
            $output .= '    <br />&nbsp;&nbsp;&nbsp;&nbsp; <em class="class name">' . $this->urlClass($method['class'], $method['class']) . '</em>';
            $output .= '</li>';
        }
    }

    public function handle($input)
    {
        $info = $this->reader->getInfo($input);
        return ['Class › ' . $input, $this->printDetails($info, $prefix = '(root)', $hide_private = false, $debug = true)];
    }

}
