<?php

namespace Rezzza\MockExtension;

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Context\Initializer\InitializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MockerAwareInitializer implements InitializerInterface, EventSubscriberInterface
{
    private $mocker;

    public function __construct(Mocker $mocker)
    {
        $this->mocker = $mocker;
    }

    public function supports(ContextInterface $context)
    {
        return $context instanceof MockerAware;
    }

    public function initialize(ContextInterface $context)
    {
        $context->setMocker($this->mocker);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'beforeScenario' => array('resetMocker', 0),
        );
    }

    public function resetMocker()
    {
        $this->mocker->unmockAllServices();
    }
}
