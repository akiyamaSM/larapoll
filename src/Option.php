<?php

namespace Inani\Larapoll;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name'];
    /**
     * An option belongs to one poll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

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
        return $this->belongsToMany(User::class, 'votes')->withTimestamps();
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
     * @return bool
     */
    public function updateTotalVotes()
    {
        $this->votes = $this->countVotes();
        return $this->save();
    }

    /**
     * Check if the option is Closed
     *
     * @return bool
     */
    public function isPollClosed()
    {
        return $this->poll->isLocked();
    }
}
