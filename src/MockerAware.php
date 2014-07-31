<?php

namespace Rezzza\MockExtension;

interface MockerAware
{
    public function setMocker(Mocker $mocker);
}
