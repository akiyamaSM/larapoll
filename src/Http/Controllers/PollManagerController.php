<?php

namespace Inani\Larapoll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inani\Larapoll\Helpers\PollHandler;
use Inani\Larapoll\Http\Request\PollCreationRequest;
use Inani\Larapoll\Poll;
use Inani\Larapoll\Exceptions\DuplicatedOptionsException;

class PollManagerController extends Controller
{
    /**
     * Dashboard Home
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return redirect()->route('poll.index');
    }
    /**
     * Show all the Polls in the database
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $polls = Poll::withCount('options', 'votes')->get()->map(function ($poll){
            $poll->isComingSoon = $poll->isComingSoon();
            $poll->isLocked = $poll->isLocked();
            $poll->isRunning = $poll->isRunning();
            $poll->hasEnded = $poll->hasEnded();
            $poll->edit_link = route('poll.edit', $poll->id);
            $poll->delete_link = route('poll.remove', $poll->id);
            $poll->lock_link = route('poll.lock', $poll->id);
            $poll->unlock_link = route('poll.unlock', $poll->id);
            return $poll;
        })->toArray();
        return view('larapoll::dashboard.index', compact('polls'));
    }

    /**
     * Store the Request
     *
     * @param PollCreationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Inani\Larapoll\Exceptions\CheckedOptionsException
     * @throws \Inani\Larapoll\Exceptions\OptionsInvalidNumberProvidedException
     * @throws \Inani\Larapoll\Exceptions\OptionsNotProvidedException
     */
    public function store(PollCreationRequest $request)
    {
        try {
            PollHandler::createFromRequest($request->all());
        } catch (DuplicatedOptionsException $exception) {
            return redirect(route('poll.create'))
                ->withInput($request->all())
                ->with('danger', $exception->getMessage());
        }

        return response('Your poll has been created successfully', 201);
    }

    /**
     * Show the poll to be prepared to edit
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Poll $poll)
    {
        $options = $poll->options->map(function ($option) {
            return [
                'id' => $option->id,
                'value' => $option->name,
            ];
        })->toArray();

        $canChangeOptions = $poll->votes()->count() === 0;

        return view('larapoll::dashboard.edit', compact('poll', 'options', 'canChangeOptions'));
    }

    /**
     * Update the Poll
     *
     * @param Poll $poll
     * @param PollCreationRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Poll $poll, PollCreationRequest $request)
    {
        PollHandler::modify($poll, $request->all());
        return response('Your poll has been updated successfully', 200);
    }

    /**
     * Delete a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Poll $poll)
    {
        $poll->remove();
        return response('', 200);
    }
    public function create()
    {
        return view('larapoll::dashboard.create');
    }

    /**
     * Lock a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(Poll $poll)
    {
        $poll->lock();

        $poll->isComingSoon = $poll->isComingSoon();
        $poll->isLocked = $poll->isLocked();
        $poll->isRunning = $poll->isRunning();
        $poll->hasEnded = $poll->hasEnded();
        $poll->edit_link = route('poll.edit', $poll->id);
        $poll->delete_link = route('poll.remove', $poll->id);

        return response()->json([
            'poll' => $poll
        ], 200);
    }

    /**
     * Unlock a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlock(Poll $poll)
    {
        $poll->unLock();

        $poll->isComingSoon = $poll->isComingSoon();
        $poll->isLocked = $poll->isLocked();
        $poll->isRunning = $poll->isRunning();
        $poll->edit_link = route('poll.edit', $poll->id);
        $poll->delete_link = route('poll.remove', $poll->id);

        return response()->json([
            'poll' => $poll
        ], 200);
    }
}
