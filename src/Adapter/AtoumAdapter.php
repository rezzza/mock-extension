<?php

namespace Rezzza\MockExtension\Adapter;

use Rezzza\MockExtension\MockEngine;

class AtoumAdapter implements MockEngine
{
    private $className;

    private $config;

    public function __construct($className, $config = null)
    {
        $this->className = $className;
        $this->config = $config;
    }

    public function createMock()
    {
        $atoum = new \mageekguy\atoum\mock\generator;

        if ($this->hasConfig()) {
            $config($atoum);
        }

        return $this->atoum->generate($className);
    }

    private function hasConfig()
    {
        return null !== $config;
    }
}
