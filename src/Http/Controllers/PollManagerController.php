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
        return view('larapoll::dashboard.home');
    }
    /**
     * Show all the Polls in the database
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $polls = Poll::withCount('options', 'votes')->latest()->paginate(
            config('larapoll_config.pagination')
        );
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
        return view('larapoll::dashboard.edit', compact('poll', 'options'));
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

        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been deleted successfully');
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
        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been locked successfully');
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
        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been unlocked successfully');
    }
}
