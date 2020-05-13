<?php

namespace Inani\Larapoll\Helpers;

use Exception;
use Inani\Larapoll\Exceptions\CheckedOptionsException;
use Inani\Larapoll\Exceptions\OptionsInvalidNumberProvidedException;
use Inani\Larapoll\Exceptions\OptionsNotProvidedException;
use Inani\Larapoll\Exceptions\RemoveVotedOptionException;
use Inani\Larapoll\Poll;
use InvalidArgumentException;

class PollHandler
{

    /**
     * Create a Poll from Request
     *
     * @param $request
     * @return Poll
     * @throws CheckedOptionsException
     * @throws OptionsInvalidNumberProvidedException
     * @throws OptionsNotProvidedException
     */
    public static function createFromRequest($request)
    {

        $poll = new Poll([
            'question' => $request['question'],
            'canVisitorsVote' => $request['canVisitorsVote']
        ]);

        $poll->addOptions($request['options']);

        if (array_key_exists('maxCheck', $request)) {
            $poll->maxSelection($request['maxCheck']);
        }

        $poll->startsAt($request['starts_at']);

        if(isset($request['ends_at'])){
            $poll->endsAt($request['ends_at']);
        }

        $poll->generate();

        return $poll;
    }

    /**
     * Modify The poll
     *
     * @param Poll $poll
     * @param $data
     */
    public static function modify(Poll $poll, $data)
    {
        if (isset($data['count_check'])) {
            if ($data['count_check'] < $poll->options()->count()) {
                $poll->canSelect($data['count_check']);
            }
        }

        // change the ability to vote by the guests
        if (isset($data['canVisitorsVote'])) {
            $poll->canVisitorsVote = $data['canVisitorsVote'];
        }

        // change see result value
        if (isset($data['canVoterSeeResult'])) {
            $poll->canVoterSeeResult = $data['canVoterSeeResult'];
        }

        $poll->question = $data['question'];

        if(isset($data['ends_at'])){
            $poll->endsAt($data['ends_at']);
        }

        $poll->startsAt($data['starts_at'])
            ->save();
    }

    /**
     * Get Messages
     *
     * @param Exception $e
     * @return string
     */
    public static function getMessage(Exception $e)
    {
        if ($e instanceof OptionsInvalidNumberProvidedException || $e instanceof OptionsNotProvidedException)
            return 'A poll should have two options at least';
        if ($e instanceof RemoveVotedOptionException)
            return 'You can not remove an option that has a vote';
        if ($e instanceof CheckedOptionsException)
            return 'You should edit the number of checkable options first.';

        if ($e instanceof  InvalidArgumentException) {
            return $e->getMessage();
        }
    }
}
