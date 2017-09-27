<?php

namespace Inani\Larapoll\Helpers;

use Inani\Larapoll\Poll;

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
            if($data['close']){
                $poll->lock();
            }else{
                $poll->unLock();
            }
        }
    }
}