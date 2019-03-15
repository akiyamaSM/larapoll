<?php
namespace Inani\Larapoll\Traits;


use Inani\Larapoll\Poll;

trait PollWriterResults
{
    /**
     * Draw the results of voting
     *
     * @param Poll $poll
     */
    public function drawResult(Poll $poll)
    {
        $total = $poll->votes->count();
        $results = $poll->results()->grab();
        $options = collect($results)->map(function ($result) use ($total){
                return (object) [
                   'percent' => $total === 0 ? 0 : $result['votes'] / $total,
                    'name' => $result['option']->name
                ];
        });
        $question = $poll->question;
        // Should override here the view
        echo view(config('larapoll_config.results') ? config('larapoll_config.results') : 'larapoll::stubs.results', compact('options', 'question'));
    }
}
