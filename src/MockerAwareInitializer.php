<?php

namespace Rezzza\MockExtension;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;

class MockerAwareInitializer implements ContextInitializer
{
    private $mocker;

    public function __construct(Mocker $mocker)
    {
        $this->mocker = $mocker;
    }

    public function initializeContext(Context $context)
    {
        if (!$context instanceof MockerAware) {
            return;
        }

        $context->setMocker($this->mocker);
    }
}
