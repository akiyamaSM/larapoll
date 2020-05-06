<?php
namespace Inani\Larapoll\Traits;

use Illuminate\Support\Facades\Session;
use Inani\Larapoll\Poll;

trait PollWriterVoting
{
    /**
     * Drawing the poll for checkbox case
     *
     * @param Poll $poll
     */
    public function drawCheckbox(Poll $poll)
    {
        $options = $poll->options->pluck('name', 'id');

        echo view(config('larapoll_config.checkbox') ? config('larapoll_config.checkbox') :  'larapoll::stubs.checkbox', [
            'id' => $poll->id,
            'question' => $poll->question,
            'options' => $options
        ]);
    }

    /**
     * Drawing the poll for the radio case
     *
     * @param Poll $poll
     */
    public function drawRadio(Poll $poll)
    {
        $options = $poll->options->pluck('name', 'id');

        echo view(config('larapoll_config.radio') ? config('larapoll_config.radio') :'larapoll::stubs.radio', [
            'id' => $poll->id,
            'question' => $poll->question,
            'options' => $options
        ]);
    }
}
