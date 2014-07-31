<?php

namespace Rezzza\MockExtension;

use Symfony\Component\DependencyInjection\Container;

class MockContainer extends Container
{
     private $mockedServices = array();

    public function overrideService($id, $mock)
    {
        $this->mockedServices[$id] = $mock;
    }

    public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE)
    {
        if (array_key_exists($id, $this->mockedServices)) {
            return $this->mockedServices[$id];
        }

        return parent::get($id, $invalidBehavior);
    }

    public function has($id)
    {
        if (array_key_exists($id, $this->mockedServices)) {
            return true;
        }

        return parent::has($id);
    }
}
