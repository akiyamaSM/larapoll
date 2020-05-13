<?php

namespace Inani\Larapoll\Traits;

use Inani\Larapoll\Vote;

trait Votable
{

    /**
     * Check if the option is voted
     *
     * @return bool
     */
    public function isVoted()
    {
        return $this->voters()->count() != 0;
    }

    /**
     * Get the voters who voted to that option
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function voters()
    {
        return $this->belongsToMany(app('config')->get('larapoll_config.user_model'), 'larapoll_votes')->withTimestamps();
    }

    /**
     * Get number of votes to an option
     *
     * @return mixed
     */
    public function countVotes()
    {
        if($this->isPollClosed()){
            return $this->votes;
        }
        return Vote::where('option_id', $this->getKey())->count();
    }

    /**
     * Update the total of
     *
     * @return bool
     */
    public function updateTotalVotes()
    {
        $this->votes = $this->countVotes();
        return $this->save();
    }
}
