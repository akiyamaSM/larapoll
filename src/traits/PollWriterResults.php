<?php
namespace Inani\Larapoll\Traits;


trait PollWriterResults
{
    /**
     * Draw the results of voting
     *
     * @param $poll
     */
    public function drawResult($poll)
    {
        $total = $poll->votes->count();
        $results = $poll->results()->grab();

        $this->drawResultHeader($poll->question);
        foreach($results as $result){
            $this->drawResultOption($result, $total);
        }
    }


    /**
     * The header text
     *
     * @param $question
     */
    public function drawResultHeader($question)
    {
        echo "<h5>Poll: {$question}</h5>";
    }

    /**
     * Draw each option result
     *
     * @param $result
     * @param $total
     */
    public function drawResultOption($result, $total)
    {
        $votes = $result['votes'];
        if($total == 0){
            $percent = 0;
        }else{
            $percent = ($votes * 100) /($total);
        }
        echo "<div class='result-option-id'>
                <strong>{$result['option']->name}</strong><span class='pull-right'>{$percent}%</span>
                <div class='progress'>
                    <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='{$percent}' aria-valuemin='0' aria-valuemax='100' style='width: {$percent}%'>
                        <span class='sr-only'>{$percent}% Complete</span>
                    </div>
                </div>
            </div>";
    }
}