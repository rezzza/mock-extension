<?php

namespace Rezzza\MockExtension;

use Symfony\Component\DependencyInjection\Container;

class MockContainer extends Container
{
    private static $mockedServices = array();

    public function overrideService($id, $mock)
    {
        self::$mockedServices[$id] = $mock;
    }

    public function removeMock($id)
    {
        if ($this->hasMockedService($id)) {
            unset(self::$mockedServices[$id]);
        }
    }

    public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE)
    {
        if ($this->hasMockedService($id)) {
            return self::$mockedServices[$id];
        }

        return parent::get($id, $invalidBehavior);
    }

    public function hasMockedService($id)
    {
        return array_key_exists($id, self::$mockedServices);
    }
}
