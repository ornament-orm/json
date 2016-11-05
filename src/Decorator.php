<?php

namespace Ornament\Json;

trait Decorator
{
    /**
     * @Decorate Json
     */
    private function decorateJson($value)
    {
        return new Property($value);
    }
}

