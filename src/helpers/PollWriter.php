<?php

namespace Inani\Larapoll\Helpers;

use Illuminate\Support\Facades\Session;
use Inani\Larapoll\Poll;

class PollWriter {

    /**
     * Draw a Poll
     *
     * @param $poll_id
     * @param $voter
     */
    public static function draw($poll_id, $voter)
    {
        $poll = Poll::findOrFail($poll_id);

        if($voter->hasVoted()){
            // Print result
        }

        if($poll->isRadio()){
            return static::drawRadio($poll);
        }
        return static::drawCheckbox($poll);
    }


    public static function drawCheckbox(Poll $poll)
    {
        $options = $poll->options;
        dd($options);
    }

    public static function drawRadio(Poll $poll)
    {
        $options = $poll->options->pluck('name', 'id');
        static::showFeedBack();
        static::startForm($poll->id);
            static::drawStartHeaderPanel();
                static::drawHeader($poll->question);
            static::drawEndHeaderPanel();

            static::drawStartOptionsPanel();
                foreach($options as $id => $name){
                    static::drawOption($id, $name);
                }
            static::drawEndOptionsPanel();
        static::endForm();
    }

    public static function showFeedBack()
    {
        if(Session::has('errors')){
            echo '<div class="alert alert-success">';
                echo session('errors');
            echo '</div>';
        }
        if(Session::has('success')){
            echo '<div class="alert alert-success">';
                echo session('success');
            echo '</div>';
        }
    }


    public static function startForm($id)
    {
        echo '<form method="POST" action="'. route('poll.vote', $id).'" >';
    }
    
    public static function endForm()
    {
        echo '<div class="panel-footer">
                    <input type="submit" class="btn btn-primary btn-sm" value="Vote" />
                </div>
        </form>';
    }

    public static function drawStartHeaderPanel()
    {
        echo '<div class="panel panel-primary">';
    }
    public static function drawEndHeaderPanel()
    {
        echo '</div>';
    }

    public static function drawHeader($question)
    {
        echo '
        <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-arrow-right"></span>'.$question.'
                </h3>
        </div>';
    }

    public static function drawStartOptionsPanel()
    {
        echo '
        <div class="panel-body">
                    <ul class="list-group">';
    }

    public static function drawEndOptionsPanel()
    {
        echo '                    </ul>
                </div>';
    }
    public static function drawOption($id, $name)
    {
        echo '
            <li class="list-group-item">
                <div class="radio">
                    <label>
                        <input value='.$id.' type="radio" name="options">
                        '. $name .'
                    </label>
                </div>
            </li>
        ';
    }
}