<?php

namespace Inani\Larapoll\Helpers;

use Inani\Larapoll\Poll;

class PollCreator {

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
        $poll->addOptions($request['options'])
            ->maxSelection($request['maxCheck'])
            ->generate();

        return $poll;
    }
}