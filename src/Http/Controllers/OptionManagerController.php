<?php

namespace Inani\Larapoll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inani\Larapoll\Http\Request\AddOptionsRequest;
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
     * @param AddOptionsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Poll $poll, AddOptionsRequest $request)
    {
        $poll->attach($request->get('options'));

        return redirect(route('poll.index'))
            ->with('success', 'New poll options have been added successfully');
    }

    /**
     * Remove the Selected Option
     *
     * @param Poll $poll
     * @param Request $request
     */
    public function remove(Poll $poll, Request $request)
    {
        try{
            $poll->detach($request->get('options'));
        }catch (\Exception $e){
        }
    }

    public function push(Poll $poll)
    {
        return view('larapoll::dashboard.options.push', compact('poll'));
    }
}