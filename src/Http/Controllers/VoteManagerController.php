<?php

namespace Inani\Larapoll\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Inani\Guest;
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

            $vote = $this->resolveVoter($request, $poll)
                ->poll($poll)
                ->vote($request->get('options'));

            if($vote){
                return back()->with('success', 'Vote Done');
            }
        }catch (Exception $e){

            dd(
                $e->getMessage()
            );
            return back()->with('errors', $e->getMessage());
        }
    }

    /**
     * Get the instance of the voter
     *
     * @param Request $request
     * @param Poll $poll
     * @return Guest|mixed
     */
    protected function resolveVoter(Request $request, Poll $poll)
    {
        if($poll->canGuestVote()){
            return new Guest($request);
        }
        return $request->user(config('admin_guard'));
    }
}
