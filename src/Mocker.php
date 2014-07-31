<?php

namespace Rezzza\MockExtension;

use Symfony\Component\HttpKernel\KernelInterface;

class Mocker
{
    private $container;

    private $bypassingContainer;

    private $kernelDriverUsed;

    public function __construct(KernelInterface $kernel, $mink)
    {
        $this->container = $kernel->getContainer();

        $this->bypassingContainer = $this->isContainerBypassing();
        $this->kernelDriverUsed = $this->isKernelDriverUsed($mink);
    }

    public function mockService($serviceId, MockEngine $adapter)
    {
        $mock = $adapter->createMock();
        $this->container->overrideService($serviceId, $mock);

        return $mock;
    }

    public function getMockedService($serviceId)
    {
        return $this->container->get($serviceId);
    }

    private function isContainerBypassing()
    {
        return $this->container instanceof MockContainer;
    }

    private function isKernelDriverUsed($mink)
    {
        return 'symfony2' === $mink->getDefaultSessionName();
    }

    private function guardAgainstContainerNotOverrided()
    {
        if (false === $this->bypassingContainer) {
            throw new \LogicException('Container is not able to store mocked services. You should override AppKernel::getContainerBaseClass with "Rezzza\MockExtension\MockContainer"');
        }
    }

    private function guardAgainstKernelDriverNotUsed()
    {
        if (false === $this->kernelDriverUsed) {
            throw new \LogicException('We can mock services only with symfony2 driver. Please use @mink:symfony tag on scenario you want to can mock services');
        }
    }
}
