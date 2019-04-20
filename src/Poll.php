<?php

namespace Inani\Larapoll;

use Illuminate\Database\Eloquent\Model;
use Inani\Larapoll\Traits\PollCreator;
use Inani\Larapoll\Traits\PollAccessor;
use Inani\Larapoll\Traits\PollManipulator;
use Inani\Larapoll\Traits\PollQueries;

class Poll extends Model
{
    use PollCreator, PollAccessor, PollManipulator, PollQueries;

    protected $fillable = ['question', 'canVisitorsVote', 'canVoterSeeResult'];

    protected $table = 'larapoll_polls';

    protected $guarded = [''];

    /**
     * A poll has many options related to
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Boot Method
     *
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($poll) {
            $poll->options->each(function ($option) {
                Vote::where('option_id', $option->id)->delete();
            });
            $poll->options()->delete();
        });
    }

    /**
     * Get all of the votes for the poll.
     */
    public function votes()
    {
        return $this->hasManyThrough(Vote::class, Option::class);
    }

    /**
     * Check if the Guest has the right to vote
     *
     * @return bool
     */
    public function canGuestVote()
    {
        return $this->canVisitorsVote === 1;
    }
}
