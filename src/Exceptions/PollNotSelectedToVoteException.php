<?php

namespace Inani\Larapoll\Exceptions;

use Exception;

class PollNotSelectedToVoteException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('Poll not specified to vote in');
    }
}