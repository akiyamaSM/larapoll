<?php
namespace Inani\Larapoll;

use Illuminate\Support\Facades\Facade;
use Inani\Larapoll\Helpers\PollWriter;

class PollWriterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PollWriter::class;
    }
}
