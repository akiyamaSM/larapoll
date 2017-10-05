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
        $options = $poll->options;
    }

    /**
     * Drawing the poll for the radio case
     *
     * @param Poll $poll
     */
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

    /**
     * Print errors/success messages
     */
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

    /**
     * Draw the start form tag
     *
     * @param $id
     */
    public function startForm($id)
    {
        echo '<form method="POST" action="'. route('poll.vote', $id).'" >';
    }

    /**
     *  Close the form tag
     */
    public function endForm()
    {
        echo '<div class="panel-footer">
                    <input type="submit" class="btn btn-primary btn-sm" value="Vote" />
                </div>
        </form>';
    }

    /**
     *  Start Header Panel
     */
    public function drawStartHeaderPanel()
    {
        echo '<div class="panel panel-primary">';
    }

    /**
     *  End of header Panel
     */
    public function drawEndHeaderPanel()
    {
        echo '</div>';
    }

    /**
     * Draw the header block
     *
     * @param $question
     */
    public function drawHeader($question)
    {
        echo '
        <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-arrow-right"></span>'.$question.'
                </h3>
        </div>';
    }

    /**
     *  Start of the list Panel
     */
    public function drawStartOptionsPanel()
    {
        echo '
        <div class="panel-body">
                    <ul class="list-group">';
    }

    /**
     *  End of the list Panel
     */
    public function drawEndOptionsPanel()
    {
        echo '                    </ul>
                </div>';
    }

    /**
     * Draw the radio of option
     *
     * @param $id
     * @param $name
     */
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