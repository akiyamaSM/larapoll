<?php

namespace Inani\Larapoll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inani\Larapoll\Poll;

class OptionManagerController extends Controller
{

    /**
     *  Constructor
     *
     */
    public function __construct()
    {
        $this->middleware( config('larapoll_config.admin_auth') );
    }

    /**
     * Add new options to the poll
     *
     * @param Poll $poll
     * @param Request $request
     */
    public function add(Poll $poll, Request $request)
    {
        $poll->attach($request->get('options'));
    }

}