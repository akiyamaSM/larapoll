<?php

namespace Inani\Larapoll;


use Inani\Larapoll\Traits\Voter;
use Illuminate\Http\Request;


class Guest
{
    use Voter;

    public $user_id;

    public function __construct(Request $request)
    {
            $this->user_id = $request->ip();
    }
}
