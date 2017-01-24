<?php

namespace Inani\Larapoll\Exceptions;

use Exception;

class RemoveVotedOptionException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('You can not remove an option that has got some votes');
    }
}