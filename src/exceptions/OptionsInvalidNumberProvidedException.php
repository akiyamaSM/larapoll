<?php

namespace Inani\Larapoll\Exceptions;

use Exception;

class OptionsInvalidNumberProvidedException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('A poll must be composed of two options at least');
    }
}