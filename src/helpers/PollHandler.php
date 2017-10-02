<?php

namespace Inani\Larapoll\Helpers;

use Inani\Larapoll\Exceptions\CheckedOptionsException;
use Inani\Larapoll\Exceptions\OptionsInvalidNumberProvidedException;
use Inani\Larapoll\Exceptions\OptionsNotProvidedException;
use Inani\Larapoll\Exceptions\RemoveVotedOptionException;
use Inani\Larapoll\Poll;
use Psy\Exception\Exception;

class PollHandler {

    /**
     * Create a Poll from Request
     *
     * @param $request
     * @return Poll
     */
    public static function createFromRequest($request)
    {
        $poll = new Poll([
            'question' => $request['question']
        ]);
        $poll->addOptions($request['options']);

        if(array_key_exists('maxCheck', $request)){
            $poll->maxSelection($request['maxCheck']);
        }

        $poll->generate();

        return $poll;
    }

    public static function modify(Poll $poll, $data)
    {
        if(array_key_exists('count_check', $data)){
            $poll->canSelect($data['count_check']);
        }

        if(array_key_exists('close', $data)){
            if(isset($data['close']) && $data['close']){
                $poll->lock();
            }else{
                $poll->unLock();
            }
        }else{
            $poll->unLock();
        }
    }

    public static function getMessage(\Exception $e)
    {
        if($e instanceof OptionsInvalidNumberProvidedException || $e instanceof OptionsNotProvidedException)
            return 'A poll should have two options at least';
        if($e instanceof RemoveVotedOptionException)
            return 'You can not remove an option that has a vote';
        if($e instanceof CheckedOptionsException)
            return 'You should edit the number of checkable options first.';
    }
}