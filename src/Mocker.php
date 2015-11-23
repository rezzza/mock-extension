<?php

namespace Rezzza\MockExtension;

use Behat\Mink\Mink;
use Behat\Symfony2Extension\Driver\KernelDriver;
use Symfony\Component\HttpKernel\KernelInterface;

class Mocker
{
    private $container;

    private $mink;

    private $bypassingContainer;

    public function __construct(KernelInterface $kernel, Mink $mink)
    {
        $this->container = $kernel->getContainer();
        $this->mink = $mink;
        $this->bypassingContainer = $this->isContainerBypassing();
    }

    public function mockService($serviceId, MockEngine $adapter)
    {
        $this->guardAgainstContainerNotOverrided();
        $this->guardAgainstKernelDriverNotUsed();

        $mock = $adapter->createMock();
        $this->container->overrideService($serviceId, $mock);

        return $mock;
    }

    public function unmockService($serviceId)
    {
        $this->container->removeMock($serviceId);
    }

    public function getMockedService($serviceId)
    {
        return $this->container->get($serviceId);
    }

    private function isContainerBypassing()
    {
        return $this->container instanceof MockContainer;
    }

    private function isKernelDriverUsed()
    {
        return $this->mink->getSession()->getDriver() instanceof KernelDriver;
    }

    private function guardAgainstContainerNotOverrided()
    {
        if (false === $this->bypassingContainer) {
            throw new \LogicException('Container is not able to store mocked services. You should override AppKernel::getContainerBaseClass with "Rezzza\MockExtension\MockContainer"');
        }
    }

    private function guardAgainstKernelDriverNotUsed()
    {
        if (!$this->isKernelDriverUsed()) {
            throw new \LogicException('We can mock services only with symfony2 driver. Please use "@mink:symfony2" tag on scenario you want to be able to mock services');
        }
    }
}
