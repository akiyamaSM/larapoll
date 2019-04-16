<?php

namespace Inani\Larapoll\Helpers;

use Inani\Larapoll\Poll;
use Inani\Larapoll\Traits\PollWriterResults;
use Inani\Larapoll\Traits\PollWriterVoting;

class PollWriter
{
    use PollWriterResults,
        PollWriterVoting;

    /**
     * Draw a Poll
     *
     * @param $poll_id
     * @return string|void
     */
    public function draw(Poll $poll)
    {
        if ($poll->isComingSoon()) {
            return 'To start soon';
        }

        $voter = auth(config('larapoll_config.admin_guard'))->user();


        if (is_null($voter) || $voter->hasVoted($poll_id) || $poll->isLocked()) {
            return $this->drawResult($poll);
        }

        if ($poll->isRadio()) {
            return $this->drawRadio($poll);
        }
        return $this->drawCheckbox($poll);
    }
}
