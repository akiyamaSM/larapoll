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

    protected $fillable = ['question'];

    /**
     * A poll has many options related to
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
