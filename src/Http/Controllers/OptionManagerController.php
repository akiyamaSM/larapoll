<?php

namespace Inani\Larapoll\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Inani\Larapoll\Helpers\PollHandler;
use Inani\Larapoll\Http\Request\AddOptionsRequest;
use Inani\Larapoll\Poll;

class OptionManagerController extends Controller
{
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Poll $poll, Request $request)
    {
        try{
            $poll->detach($request->get('options'));
            return redirect(route('poll.index'))
                ->with('success', 'Poll options have been removed successfully');
        }catch (Exception $e){
            return back()->withErrors(PollHandler::getMessage($e));
        }
    }

    /**
     * Page to add new options
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function push(Poll $poll)
    {
        return view('larapoll::dashboard.options.push', compact('poll'));
    }

    /**
     * Page to delete Options
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Poll $poll)
    {
        return view('larapoll::dashboard.options.remove', compact('poll'));
    }
}