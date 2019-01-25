<?php

namespace Inani\Larapoll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inani\Larapoll\Poll;

class VoteManagerController extends Controller
{
    /**
     * Make a Vote
     *
     * @param Poll $poll
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function vote(Poll $poll, Request $request)
    {
        try{
            $vote = $request->user(config('admin_guard'))
                ->poll($poll)
                ->vote($request->get('options'));
            if($vote){
                return back()->with('success', 'Vote Done');
            }
        }catch (\Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }
}