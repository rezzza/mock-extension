<?php

namespace Rezzza\MockExtension\Adapter;

use Rezzza\MockExtension\MockEngine;

class AtoumAdapter implements MockEngine
{
    private $className;

    private $config;

    private $mockGenerator;

    public function __construct($className, $config = null)
    {
        $mockGenerator = new \mageekguy\atoum\mock\generator;

        $this->className = $mockGenerator->getDefaultNamespace().$className;
        $this->config = $config;

        $mockNamespacePattern = '/^' . preg_quote($mockGenerator->getDefaultNamespace()) . '\\\/i';

        $mockAutoloader = function ($class) use ($mockGenerator, $mockNamespacePattern) {
            $mockedClass = preg_replace($mockNamespacePattern, '', $class);

            if ($mockedClass !== $class) {
                $mockGenerator->generate($mockedClass);
            }
        };

        if (false === spl_autoload_register($mockAutoloader, true, true)) {
            throw new \RuntimeException('Unable to register mock autoloader');
        }

        $this->mockGenerator = $mockGenerator;
    }

    public function createMock()
    {
        if ($this->hasConfig()) {
            call_user_func($this->config, $this->mockGenerator);
        }

        return new $this->className;
    }

    private function hasConfig()
    {
        return null !== $this->config;
    }

}
