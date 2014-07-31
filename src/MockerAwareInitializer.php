<?php

namespace Rezzza\MockExtension;

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Context\Initializer\InitializerInterface;

class MockerAwareInitializer implements InitializerInterface
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
}
