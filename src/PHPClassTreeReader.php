<?php

namespace AndyTruong\PHPClassTree;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionProperty;
use RuntimeException;

class PHPClassTreeReader
{

    public function getInfo($name)
    {
        if (class_exists($name)) {
            return $this->getClassInfo($name);
        }
        elseif (interface_exists($name)) {
            return $this->getInterfaceInfo($name);
        }
        throw new RuntimeException(sprintf('Unknow class/interface: %s', $name));
    }

    public function getInterfaceInfo($name)
    {
        return $this->getClassInfo($name);
    }

    public function getClassInfo($name)
    {
        $ri = new ReflectionClass($name);
        // $ri->getDocComment();
        // $ri->getConstants();

        $info = [
            'namespace'  => $ri->getNamespaceName(),
            'short_name' => $ri->getShortName(),
            'name'       => $ri->getName(),
            'file'       => $ri->getFileName(),
            'final'      => $ri->isFinal(),
            'abstract'   => $ri->isAbstract(),
            'properties' => [],
            'methods'    => [],
        ];

        foreach ($ri->getProperties() as $rp) {
            /* @var $rp ReflectionProperty */
            $info['properties'][] = [
                'scope'   => $rp->isPrivate() ? 'private' : ($rp->isProtected() ? 'protected' : 'public'),
                'class'   => $rp->getDeclaringClass(),
                'name'    => $rp->getName(),
                'comment' => $rp->getDocComment(),
            ];
        }

        if ($parent = $ri->getParentClass()) {
            $info['parent'] = $this->getClassInfo($parent->getName());
        }

        foreach ($ri->getMethods() as $rm) {
            $info['methods'][$rm->getName()] = $this->getClassMethodsInfo($rm);
        }

        return $info;
    }

    private function getClassMethodsInfo(ReflectionMethod $rm)
    {
        $method_info = [
            'name'   => $rm->getName(),
            'final'  => $rm->isFinal(),
            'scope'  => $rm->isPrivate() ? 'private' : ($rm->isProtected() ? 'protected' : 'public'),
            'class'  => $rm->getDeclaringClass()->getName(),
            'params' => [],
        ];

        foreach ($rm->getParameters() as $rp) {
            $method_info['params'][$rp->getName()] = $this->getClassMethodParamasInfo($rp);
        }

        return $method_info;
    }

    private function getClassMethodParamasInfo(ReflectionParameter $rp)
    {
        $param_info = [
            'name'     => $rp->getName(),
            'position' => $rp->getPosition(),
        ];

        if ($rp->getClass()) {
            $param_info['class'] = $rp->getClass()->getName();
        }

        try {
            $param_info['default_value'] = $rp->getDefaultValue();
        }
        catch (Exception $e) {

        }

        return $param_info;
    }

}
