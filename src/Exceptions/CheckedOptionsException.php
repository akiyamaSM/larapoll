<?php


namespace Inani\Larapoll\Exceptions;

use Exception;
class CheckedOptionsException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('You can not create poll with all options checkable');
    }
}