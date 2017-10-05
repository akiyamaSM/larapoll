<?php
namespace Inani\Larapoll\Traits;

use Illuminate\Support\Facades\Session;
use Inani\Larapoll\Poll;

trait PollWriterVoting
{

    public function drawCheckbox(Poll $poll)
    {
        $options = $poll->options;
    }

    public function drawRadio(Poll $poll)
    {
        $options = $poll->options->pluck('name', 'id');
        $this->showFeedBack();
        $this->startForm($poll->id);
        $this->drawStartHeaderPanel();
        $this->drawHeader($poll->question);
        $this->drawEndHeaderPanel();

        $this->drawStartOptionsPanel();
        foreach($options as $id => $name){
            $this->drawOption($id, $name);
        }
        $this->drawEndOptionsPanel();
        $this->endForm();
    }

    public function showFeedBack()
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

    public function startForm($id)
    {
        echo '<form method="POST" action="'. route('poll.vote', $id).'" >';
    }

    public function endForm()
    {
        echo '<div class="panel-footer">
                    <input type="submit" class="btn btn-primary btn-sm" value="Vote" />
                </div>
        </form>';
    }

    public function drawStartHeaderPanel()
    {
        echo '<div class="panel panel-primary">';
    }
    public function drawEndHeaderPanel()
    {
        echo '</div>';
    }

    public function drawHeader($question)
    {
        echo '
        <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-arrow-right"></span>'.$question.'
                </h3>
        </div>';
    }

    public function drawStartOptionsPanel()
    {
        echo '
        <div class="panel-body">
                    <ul class="list-group">';
    }

    public function drawEndOptionsPanel()
    {
        echo '                    </ul>
                </div>';
    }
    public function drawOption($id, $name)
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