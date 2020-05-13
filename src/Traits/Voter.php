<?php


namespace Inani\Larapoll\Traits;


use Illuminate\Support\Facades\DB;
use Inani\Larapoll\Exceptions\PollNotSelectedToVoteException;
use Inani\Larapoll\Exceptions\VoteInClosedPollException;
use Inani\Larapoll\Guest;
use Inani\Larapoll\Option;
use Inani\Larapoll\Poll;
use Inani\Larapoll\Vote;
use InvalidArgumentException;

trait Voter
{
    protected $poll;

    /**
     * Select poll
     *
     * @param Poll $poll
     * @return $this
     */
    public function poll(Poll $poll)
    {
        $this->poll = $poll;

        return $this;
    }

    /**
     * Vote for an option
     *
     * @param $options
     * @return bool
     * @throws PollNotSelectedToVoteException
     * @throws VoteInClosedPollException
     * @throws \Exception
     */
    public function vote($options)
    {
        $options = is_array($options) ? $options : func_get_args();
        // if poll not selected
        if (is_null($this->poll))
            throw new PollNotSelectedToVoteException();

        if ($this->poll->isLocked())
            throw new VoteInClosedPollException();

        if ($this->hasVoted($this->poll->id))
            throw new \Exception("User can not vote again!");

        // if is Radio and voted for many options
        $countVotes = count($options);

        if ($this->poll->isRadio() && $countVotes > 1)
            throw new InvalidArgumentException("The poll can not accept many votes option");

        if ($this->poll->isCheckable() &&  $countVotes > $this->poll->maxCheck)
            throw new InvalidArgumentException("selected more options {$countVotes} than the limited {$this->poll->maxCheck}");

        array_walk($options, function (&$val) {
            if (!is_numeric($val))
                throw new InvalidArgumentException("Only id are accepted");
        });
        if ($this instanceof Guest) {
            collect($options)->each(function ($option) {
                Vote::create([
                    'user_id' => $this->user_id,
                    'option_id' => $option
                ]);
            });

            return true;
        }
        return !is_null($this->options()->sync($options, false)['attached']);
    }

    /**
     * Check if he can vote
     *
     * @param $poll_id
     * @return bool
     */
    public function hasVoted($poll_id)
    {
        $poll = Poll::findOrFail($poll_id);

        if ($poll->canGuestVote()) {
            $result = DB::table('larapoll_polls')
                ->selectRaw('count(*) As total')
                ->join('larapoll_options', 'larapoll_polls.id', '=', 'larapoll_options.poll_id')
                ->join('larapoll_votes', 'larapoll_votes.option_id', '=', 'larapoll_options.id')
                ->where('larapoll_votes.user_id', request()->ip())
                ->where('larapoll_options.poll_id', $poll_id)->count();
            return $result !== 0;
        }

        return $this->options()->where('poll_id', $poll->id)->count() !== 0;
    }

    /**
     * The options he voted to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function options()
    {
        return $this->belongsToMany(Option::class, 'larapoll_votes')->withTimestamps();
    }
}
